<?php
/**
 * SimpleXLSX php class v1.0.0
 * MS Excel 2007 workbook reader
 * 
 * Example: $xlsx = SimpleXLSX::parse('book.xlsx'); print_r($xlsx->rows());
 */
class SimpleXLSX {
  public $success = false;
  public $data = array();
  
  public static function parse($filename) {
    $xlsx = new self();
    return $xlsx->_parse($filename);
  }
  
  private function _parse($filename) {
    if (!file_exists($filename)) {
      $this->error("File not found: $filename");
      return $this;
    }
    
    $zip = new ZipArchive;
    if ($zip->open($filename) !== TRUE) {
      $this->error("Unable to open zip archive");
      return $this;
    }
    
    // Read shared strings
    $sharedStrings = array();
    if (($xml = $zip->getFromName('xl/sharedStrings.xml'))) {
      $xml = simplexml_load_string($xml);
      foreach ($xml->si as $si) {
        $sharedStrings[] = (string)$si->t;
      }
    }
    
    // Read worksheet
    $worksheetXML = $zip->getFromName('xl/worksheets/sheet1.xml');
    if (!$worksheetXML) {
      $this->error("Unable to read worksheet");
      $zip->close();
      return $this;
    }
    
    $xml = simplexml_load_string($worksheetXML);
    $rows = array();
    
    foreach ($xml->sheetData->row as $row) {
      $rowData = array();
      $colIndex = 0;
      
      foreach ($row->c as $cell) {
        $cellRef = (string)$cell['r'];
        $col = preg_replace('/[0-9]+/', '', $cellRef);
        $colNum = $this->columnIndex($col);
        
        // Fill empty columns
        while ($colIndex < $colNum) {
          $rowData[] = '';
          $colIndex++;
        }
        
        $value = '';
        if (isset($cell->v)) {
          $value = (string)$cell->v;
          
          // Check if this is a shared string
          if (isset($cell['t']) && (string)$cell['t'] == 's') {
            $value = isset($sharedStrings[$value]) ? $sharedStrings[$value] : '';
          }
        }
        
        $rowData[] = $value;
        $colIndex++;
      }
      
      $rows[] = $rowData;
    }
    
    $zip->close();
    $this->data = $rows;
    $this->success = true;
    
    return $this;
  }
  
  public function rows() {
    return $this->data;
  }
  
  private function columnIndex($col) {
    $col = strtoupper($col);
    $len = strlen($col);
    $index = 0;
    
    for ($i = 0; $i < $len; $i++) {
      $index = $index * 26 + (ord($col[$i]) - ord('A') + 1);
    }
    
    return $index - 1;
  }
  
  private function error($msg) {
    $this->success = false;
    $this->errorMessage = $msg;
  }
}
?>

