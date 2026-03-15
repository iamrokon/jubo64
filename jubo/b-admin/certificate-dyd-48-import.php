<?php
//Database connection
$con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
if ($con->connect_error) {
  die("Database connection failed: " . $con->connect_error);
}

// $con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
// if ($con->connect_error) {
//   die("Database connection failed: " . $con->connect_error);
// }

// Check if form is submitted
if (isset($_POST['import_excel']) && isset($_FILES['import_file'])) {
  
  // Include SimpleXLSX library
  require_once 'SimpleXLSX.php';
  
  $file = $_FILES['import_file']['tmp_name'];
  $fileName = $_FILES['import_file']['name'];
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  
  // Validate file extension
  if ($fileExtension != 'xlsx') {
    header("Location: certificate-dyd-48-view.php?error=Invalid file format. Please upload .xlsx file only.");
    exit();
  }
  
  // Validate file upload
  if ($_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
    header("Location: certificate-dyd-48-view.php?error=File upload failed.");
    exit();
  }
  
  try {
    // Parse the Excel file
    $xlsx = SimpleXLSX::parse($file);
    
    if (!$xlsx || !$xlsx->success) {
      header("Location: certificate-dyd-48-view.php?error=Failed to read Excel file. Make sure it's a valid .xlsx file.");
      exit();
    }
    
    $rows = $xlsx->rows();
    $imported = 0;
    $skipped = 0;
    $errors = array();
    
    // Skip header row (first row)
    for ($i = 1; $i < count($rows); $i++) {
      $row = $rows[$i];
      
      // Skip empty rows
      if (empty($row[0]) && empty($row[1]) && empty($row[2]) && empty($row[3])) {
        continue;
      }
      
      // Extract data from Excel columns
      // Expected format: District, Group, Batch, Student ID, Student Name, Gender, NID, Father Name, Mother Name, Duration
      $district = isset($row[0]) ? trim($row[0]) : '';
      $group = isset($row[1]) ? trim($row[1]) : '';
      $batch = isset($row[2]) ? trim($row[2]) : '';
      $stu_id = isset($row[3]) ? trim($row[3]) : '';
      $stu_name = isset($row[4]) ? trim($row[4]) : '';
      $gender = isset($row[5]) ? trim($row[5]) : '';
      $nid = isset($row[6]) ? trim($row[6]) : '';
      $father = isset($row[7]) ? trim($row[7]) : '';
      $mother = isset($row[8]) ? trim($row[8]) : '';
      $duration = isset($row[9]) ? trim($row[9]) : '';
      
      // Validate required fields
      if (empty($stu_id)) {
        $errors[] = "Row " . ($i + 1) . ": Student ID is required";
        continue;
      }
      
      // Check if student ID already exists to avoid duplicates
      $checkStmt = $con->prepare("SELECT id FROM dyd_certificate WHERE stu_id = ?");
      $checkStmt->bind_param("s", $stu_id);
      $checkStmt->execute();
      $checkResult = $checkStmt->get_result();
      
      if ($checkResult->num_rows > 0) {
        $skipped++;
        $checkStmt->close();
        continue; // Skip duplicate
      }
      $checkStmt->close();
      
      // Insert new record
      $insertStmt = $con->prepare("INSERT INTO dyd_certificate (district, `group`, batch, stu_id, stu_name, gender, nid, father, mother, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insertStmt->bind_param("ssssssssss", $district, $group, $batch, $stu_id, $stu_name, $gender, $nid, $father, $mother, $duration);
      
      if ($insertStmt->execute()) {
        $imported++;
      } else {
        $errors[] = "Row " . ($i + 1) . ": Database error";
      }
      $insertStmt->close();
    }
    
    // Redirect with success message
    if (count($errors) > 0) {
      $errorMsg = implode(", ", array_slice($errors, 0, 3));
      header("Location: certificate-dyd-48-view.php?imported=$imported&skipped=$skipped&error=" . urlencode($errorMsg));
    } else {
      header("Location: certificate-dyd-48-view.php?imported=$imported&skipped=$skipped");
    }
    exit();
    
  } catch (Exception $e) {
    header("Location: certificate-dyd-48-view.php?error=" . urlencode("Error: " . $e->getMessage()));
    exit();
  }
  
} else {
  header("Location: certificate-dyd-48-view.php?error=No file uploaded. Please select an Excel file.");
  exit();
}

$con->close();
?>


