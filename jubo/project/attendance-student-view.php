<?php include('session.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Student Attendance View | E-Learning & Earning LTD</title>
  
  <?php include('link.php'); ?>

    <style>
        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .table thead tr>th {
            padding: 12px 8px !important;
        }

        .table tbody tr>td {
            padding: 8px 8px !important;
        }
    </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>
  
  <main id="main">

  <section id="about-us" class="about-us mt-5">
      <div class="container" data-aos="fade-left">
        <div class="row content">

          <div class="col-12 mt-3">
            <div class="card shadow rounded">
              <div class="card-header bg-white py-3">
                <?php
                  $student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
                  $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
                  $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
                  
                  // Fetch Student Details
                  $stuName = "Unknown Student";
                  $stuBatch = "Unknown";
                  $stuContact = "";
                  $stuDistrict = "Unknown";
                  $stuGroup = "Unknown";
                  $stuImg = "assets/images/users/avatar-1.jpg";
                  $found = false;

                  if($student_id){
                      // Determine query based on available tables/columns. 
                      // Using student_list linked to district, batch_list, group_list
                      // Note: student_list primary key is 'student_id' (auto inc) but 'stu_user_id' is used in attendance
                      // Or 'student_id' is the user id? 
                      // In attendance-report-view.php we used: $viewId = $std['student_id'];
                      // but attendance query used: WHERE student_id='$stuId' (where $stuId = $std['stu_user_id'])
                      // Let's assume $_GET['student_id'] passed is the one to look up in student_list
                      
                      // Let's try to find by student_id or stu_user_id
                      $sq = mysqli_query($con, "SELECT student_list.*, batch_list.batch_name, district.dist_name, group_list.group_name 
                            FROM student_list 
                            LEFT JOIN batch_list ON student_list.batch_id = batch_list.batch_id
                            LEFT JOIN district ON student_list.district = district.id
                            LEFT JOIN group_list ON student_list.group_id = group_list.group_id
                            WHERE student_list.student_id='$student_id'");
                      
                      if($r = mysqli_fetch_array($sq)){
                          $stuName = $r['stu_name'];
                          $stuBatch = $r['batch_name'];
                          $stuContact = $r['contact'];
                          $stuDistrict = $r['dist_name'];
                          $stuGroup = $r['group_name'] ?? '-';
                          $stuUserId = $r['stu_user_id']; // This is likely used in attendance table
                          $found = true;
                      }
                  }
                ?>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title my-1 text-primary"><?= $stuName ?></h4>
                        <p class="text-muted mb-0">Batch: <?= $stuBatch ?> | District: <?= $stuDistrict ?> | Group: <?= $stuGroup ?></p>
                        <p class="text-muted mb-0">Contact: <?= $stuContact ?></p>
                        
                        <?php
                        if ($found) {
                            $start = strtotime($start_date);
                            $end = strtotime($end_date);
                            $total_days = round(($end - $start) / (60 * 60 * 24)) + 1;
                            
                            // Get present count
                            $attMap = [];
                            // Query based on student_id used in attendance table (likely stu_user_id)
                            $attQuery = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$stuUserId' AND att_date BETWEEN '$start_date' AND '$end_date'");
                            while($row = mysqli_fetch_array($attQuery)){
                                $attMap[$row['att_date']] = $row;
                            }
                            
                            $total_present = count($attMap);
                            $total_absent = $total_days - $total_present;
                        } else {
                            $total_days = 0;
                            $total_present = 0;
                            $total_absent = 0;
                            $attMap = [];
                        }
                        ?>
                        <div class="mt-2">
                            <span class="badge bg-primary text-white font-size-12">Total: <?= $total_days ?> Days</span>
                            <span class="badge bg-success text-white font-size-12">Present: <?= $total_present ?> Days</span>
                            <span class="badge bg-danger text-white font-size-12">Absent: <?= $total_absent ?> Days</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="">
                            <input type="hidden" name="student_id" value="<?= $student_id ?>">
                            <div class="row mt-2">
                                <div class="col-4 form-group">
                                    <label class="form-label sm-0">Start Date</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm" value="<?= $start_date ?>">
                                </div>
                                <div class="col-4 form-group">
                                    <label class="form-label sm-0">End Date</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm" value="<?= $end_date ?>">
                                </div>
                                <div class="col-4 form-group d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
              </div>

              <div class="card-body">
                
                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <h5 class="mb-0">Attendance History (<?= date('d M', strtotime($start_date)) ?> - <?= date('d M', strtotime($end_date)) ?>)</h5>
                    <button class="btn btn-success btn-sm" onclick="exportTableToExcel('stuAttTable', '<?= str_replace(' ', '_', $stuName) ?>_Attendance_<?= $start_date ?>_<?= $end_date ?>')">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="stuAttTable" class="table table-bordered table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Branch</th>
                                <th>Batch</th>
                                <th>Group</th>
                                <th>Student Name</th>
                                <th>Status</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($found) {
                                    $i = 1;
                                    $currentDate = $start_date;
                                    
                                    while (strtotime($currentDate) <= strtotime($end_date)) {
                                        $att = isset($attMap[$currentDate]) ? $attMap[$currentDate] : null;
                                        
                                        $status = '<span class="badge bg-danger text-white">Absent</span>';
                                        $checkIn = '-';
                                        $checkOut = '-';
                                        $location = '-';

                                        if($att){
                                            $status = '<span class="badge bg-success text-white">Present</span>';
                                            $checkIn = date('h:i A', strtotime($att['check_in']));
                                            $checkOut = isset($att['check_out']) && $att['check_out'] ? date('h:i A', strtotime($att['check_out'])) : '-';
                                            if(isset($att['lat']) && $att['lat']){
                                                $location = '<a href="https://maps.google.com/?q='.$att['lat'].','.$att['lng'].'" target="_blank" class="btn btn-sm btn-info text-white"><i class="fa fa-map-marker"></i> Loc</a>';
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d M Y', strtotime($currentDate)) ?></td>
                                        <td><?= $stuDistrict ?></td>
                                        <td><?= $stuBatch ?></td>
                                        <td><?= $stuGroup ?></td>
                                        <td><?= $stuName ?></td>
                                        <td><?= $status ?></td>
                                        <td><?= $checkIn ?></td>
                                        <td><?= $checkOut ?></td>
                                        <td><?= $location ?></td>
                                    </tr>
                                    <?php
                                        $currentDate = date ("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                                    }
                                } else {
                                    echo "<tr><td colspan='10' class='text-center'>No Student Found</td></tr>";
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
  </section>

  </main>
  
  <?php include('footer.php'); ?>

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
