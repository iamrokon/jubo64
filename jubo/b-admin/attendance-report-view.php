<!doctype html>
<html lang="en">

<head>
  <title>Attendance Report View | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-3 text-center">
                    <?php
                      $DistId = isset($_GET['dist_id']) ? intval($_GET['dist_id']) : 0;
                      $BatchId = isset($_GET['batch_id']) ? intval($_GET['batch_id']) : 0;
                      $GroupId = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;
                      $sys_start_date = '2026-02-26';
                      $StartDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
                      $EndDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
                      if(strtotime($StartDate) < strtotime($sys_start_date)) $StartDate = $sys_start_date;

                      // Fetch Names
                      $distName = "Unknown District";
                      $batchName = "Unknown Batch";
                      $groupName = "All Groups";

                      if($DistId){
                          $dq = mysqli_query($con, "SELECT dist_name FROM district WHERE id='$DistId'");
                          if($r = mysqli_fetch_array($dq)) $distName = $r['dist_name'];
                      }
                      if($BatchId){
                          $bq = mysqli_query($con, "SELECT batch_name FROM batch_list WHERE batch_id='$BatchId'");
                          if($r = mysqli_fetch_array($bq)) $batchName = $r['batch_name'];
                      }
                          if($GroupId){
                              $gq = mysqli_query($con, "SELECT group_name FROM group_list WHERE group_id='$GroupId'");
                              if($r = mysqli_fetch_array($gq)) $groupName = $r['group_name'];
                          }

                          // Bangladesh Govt Holidays 2026
                          $bd_holidays = [
                              "2026-02-04", "2026-02-21", // Feb
                              "2026-03-17", "2026-03-19", "2026-03-20", "2026-03-21", "2026-03-22", "2026-03-23", "2026-03-26", // Mar
                              "2026-04-14", // Apr
                              "2026-05-01", "2026-05-26", "2026-05-27", "2026-05-28", "2026-05-29", "2026-05-30", "2026-05-31", // May
                              "2026-06-02", "2026-06-26", // Jun
                              "2026-08-05", "2026-08-26", // Aug
                              "2026-10-21", // Oct
                              "2026-12-16", "2026-12-25" // Dec
                          ];
                        ?>
                    <h3>Attendance Report</h3>
                    <h5 class="text-primary"><?= $distName ?> | <?= $batchName ?> | <?= $groupName ?></h5>
                    <h6>From: <?= date('d M Y', strtotime($StartDate)) ?> To: <?= date('d M Y', strtotime($EndDate)) ?></h6>
                  </div>

                  <div class="card-body">
                    
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-success" onclick="exportTableToExcel('attTable', 'Attendance_Report_<?= $StartDate ?>_to_<?= $EndDate ?>')">
                            <i class="mdi mdi-file-excel"></i> Export Excel
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="attTable" class="table table-bordered table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Student Name</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Device ID</th>
                                    <th>Distance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // 1. Get all students in this criteria
                                $studentQuery = "SELECT * FROM student_list WHERE district='$DistId' AND batch_id='$BatchId'";
                                if($GroupId) $studentQuery .= " AND group_id='$GroupId'";
                                $studentsResult = mysqli_query($con, $studentQuery);
                                
                                // Store students in array to avoid re-querying in loop
                                $students = [];
                                while($row = mysqli_fetch_array($studentsResult)){
                                    $students[] = $row;
                                }

                                if(count($students) > 0){
                                    $i = 1;
                                    
                                    // Loop through Date Range (Starting from system start date)
                                    $currentDate = (strtotime($StartDate) < strtotime($sys_start_date)) ? $sys_start_date : $StartDate;
                                    while (strtotime($currentDate) <= strtotime($EndDate)) {
                                        
                                        foreach($students as $std){
                                            $stuId = $std['stu_user_id']; 
                                            
                                            // 2. Check attendance for this student on this date
                                            $attQ = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$stuId' AND att_date='$currentDate'");
                                            $att = mysqli_fetch_array($attQ); 

                                            $checkIn = '-';
                                            $checkOut = '-';
                                            
                                            if($att){
                                                $status = '<span class="badge bg-success">Present</span>';
                                                $checkIn = $att['check_in'];
                                                $checkOut = $att['check_out'] ?? '-';
                                            } else {
                                                $day_name = date('l', strtotime($currentDate));
                                                $is_weekend = ($day_name == 'Friday');
                                                $is_holiday = in_array($currentDate, $bd_holidays);

                                                if($is_weekend || $is_holiday){
                                                    $status = '<span class="badge bg-info">Holiday</span>';
                                                } else {
                                                    $status = '<span class="badge bg-danger">Absent</span>';
                                                }
                                            }
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= date('d M Y', strtotime($currentDate)) ?></td>
                                    <td>
                                        <?= $std['stu_name'] ?>
                                        <small class="d-block text-muted">ID: <?= $std['student_id'] ?></small>
                                    </td>
                                    <td><?= $std['contact'] ?></td>
                                    <td><?= $status ?></td>
                                    <td><?= $checkIn ?></td>
                                    <td><?= $checkOut ?></td>
                                    <td><?= $att['device_id'] ?></td>
                                    <td>
                                        <?php if(isset($att['lat']) && $att['lat']): ?>
                                        <a href="https://maps.google.com/?q=<?= $att['lat'] ?>,<?= $att['lng'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="mdi mdi-map-marker"></i> Loc</a>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                        }
                                        // Increment Date
                                        $currentDate = date ("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>No Students Found in this Batch/Group</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php include "footer.php" ?>
    </div>
  </div>
  <?php include "script.php" ?>

  <script>
    function exportTableToExcel(tableID, filename = '') {
      var downloadLink;
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
      
      // Specify file name
      filename = filename?filename+'.xls':'excel_data.xls';
      
      // Create download link element
      downloadLink = document.createElement("a");
      
      document.body.appendChild(downloadLink);
      
      if(navigator.msSaveOrOpenBlob){
          var blob = new Blob(['\ufeff', tableHTML], {
              type: dataType
          });
          navigator.msSaveOrOpenBlob( blob, filename);
      } else {
          // Create a link to the file
          downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
      
          // Setting the file name
          downloadLink.download = filename;
          
          //triggering the function
          downloadLink.click();
      }
    }
  </script>
</body>
</html>
