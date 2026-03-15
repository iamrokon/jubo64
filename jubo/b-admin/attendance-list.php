<!doctype html>
<html lang="en">

<head>
  <title>Attendance Reports | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $con->prepare("DELETE FROM attendance WHERE att_id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Attendance record deleted successfully!</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error deleting record!</div>';
    }
}
?>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Attendance Report</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Branch Wise Attendance Report</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="page-content-wrapper">
            <?= isset($msg) ? $msg : '' ?>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Generate Attendance Report</h4>
                  </div>
                  <div class="card-body">

                    <div class="row mb-4 mt-3">
                      <div class="col-xl-10 mx-auto">
                        <form method="GET" action="">
                          <div class="row align-items-center justify-content-center">
                            <?php
                                $dist_id = isset($_GET['DistId']) ? $_GET['DistId'] : '';
                                $batch_id = isset($_GET['Batch']) ? $_GET['Batch'] : '';
                                $group_id = isset($_GET['Group']) ? $_GET['Group'] : '';
                                
                                $sys_start_date = '2026-02-26';
                                $start_date = isset($_GET['StartDate']) ? $_GET['StartDate'] : date('Y-m-d');
                                $end_date = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');

                                // Force date not before system start
                                if(strtotime($start_date) < strtotime($sys_start_date)) $start_date = $sys_start_date;
                            ?>
                            
                            <div class="col-md-6 col-lg-3 my-2">
                              <select id="DistId" name="DistId" class="form-control form-select" required>
                                <option value="" disabled selected>Select Branch (District)</option>
                                <?php
                                $sql = "SELECT * FROM district";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  $selected = ($row['id'] == $dist_id) ? 'selected' : '';
                                  echo "<option value='" . $row['id'] . "' $selected>" . $row['dist_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-3 my-2">
                              <select id="Batch" name="Batch" class="form-control form-select" required>
                                <option value="" disabled selected>Select Batch</option>
                                <?php
                                $sql = "SELECT * FROM batch_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  $selected = ($row['batch_id'] == $batch_id) ? 'selected' : '';
                                  echo "<option value='" . $row['batch_id'] . "' $selected>" . $row['batch_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-3 my-2">
                              <select id="Group" name="Group" class="form-control form-select">
                                <option value="">Select Group</option>
                                <?php
                                $sql = "SELECT * FROM group_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  $selected = ($row['group_id'] == $group_id) ? 'selected' : '';
                                  echo "<option value='" . $row['group_id'] . "' $selected>" . $row['group_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-3 my-2">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="StartDate" id="StartDate" class="form-control" value="<?= $start_date ?>">
                            </div>
                            
                            <div class="col-md-6 col-lg-3 my-2">
                                <label class="form-label">End Date</label>
                                <input type="date" name="EndDate" id="EndDate" class="form-control" value="<?= $end_date ?>">
                            </div>

                            <div class="col-md-6 col-lg-3 my-2 mt-4">
                              <button type="submit" class="btn btn-primary w-100 waves-effect">Generate Report</button>
                            </div>

                          </div>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Report Section -->
            <?php if (!empty($dist_id) && !empty($batch_id)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card" id="reportCard">
                        <div class="card-header border-bottom py-3 text-center">
                            <?php
                              // Construct current query string for links
                              $params = $_GET;
                              unset($params['delete_id']);
                              $q_str = http_build_query($params);
                              $base_link = "?" . $q_str . ($q_str ? "&" : "");

                              // Fetch Names
                              $distName = "Unknown District";
                              $batchName = "Unknown Batch";
                              $groupName = "All Groups";

                              if($dist_id){
                                  $dq = mysqli_query($con, "SELECT dist_name FROM district WHERE id='$dist_id'");
                                  if($r = mysqli_fetch_array($dq)) $distName = $r['dist_name'];
                              }
                              if($batch_id){
                                  $bq = mysqli_query($con, "SELECT batch_name FROM batch_list WHERE batch_id='$batch_id'");
                                  if($r = mysqli_fetch_array($bq)) $batchName = $r['batch_name'];
                              }
                              if($group_id){
                                  $gq = mysqli_query($con, "SELECT group_name FROM group_list WHERE group_id='$group_id'");
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
                            <h6>From: <?= date('d M Y', strtotime($start_date)) ?> To: <?= date('d M Y', strtotime($end_date)) ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="m-0 text-muted">Summary Overview</h5>
                                <button class="btn btn-success btn-sm" onclick="exportTableToExcel('attTable', 'Attendance_Report_<?= $start_date ?>_to_<?= $end_date ?>')">
                                    <i class="mdi mdi-file-excel"></i> Export Excel
                                </button>
                            </div>

                            <?php
                            // 1. Get all students in this criteria
                            $studentQuery = "SELECT student_list.*, group_list.group_name FROM student_list 
                                             LEFT JOIN group_list ON student_list.group_id = group_list.group_id
                                             WHERE student_list.status = 1 AND district='$dist_id' AND batch_id='$batch_id'";
                            if($group_id) $studentQuery .= " AND student_list.group_id='$group_id'";
                            $studentsResult = mysqli_query($con, $studentQuery);
                            
                            $students = [];
                            $student_ids = [];
                            while($row = mysqli_fetch_array($studentsResult)){
                                $students[] = $row;
                                $student_ids[] = "'" . $row['stu_user_id'] . "'";
                            }

                            // 2. Fetch all attendance records
                            $attendance_data = [];
                            $total_present_instances = 0;
                            $total_checkout_instances = 0;
                            if(!empty($student_ids)){
                                $ids_str = implode(',', $student_ids);
                                $att_all_q = mysqli_query($con, "SELECT * FROM attendance WHERE student_id IN ($ids_str) AND att_date BETWEEN '$start_date' AND '$end_date' ORDER BY att_id ASC");
                                while($a_row = mysqli_fetch_array($att_all_q)){
                                    // Count only unique student-date pairs to avoid overcounting duplicates
                                    if(!isset($attendance_data[$a_row['student_id']][$a_row['att_date']])){
                                        $total_present_instances++;
                                        // Count as Check Out if check_out is not null/empty
                                        if(!empty($a_row['check_out']) && $a_row['check_out'] != '-' && $a_row['check_out'] != '00:00:00'){
                                            $total_checkout_instances++;
                                        }
                                    }
                                    $attendance_data[$a_row['student_id']][$a_row['att_date']] = $a_row;
                                }
                            }

                            // 3. Stats for Summary Cards
                            $total_students = count($students);
                            $working_days = 0;
                            $tempDate = $start_date;
                            while(strtotime($tempDate) <= strtotime($end_date)){
                                $day_name = date('l', strtotime($tempDate));
                                if($day_name != 'Friday' && !in_array($tempDate, $bd_holidays)) $working_days++;
                                $tempDate = date("Y-m-d", strtotime("+1 day", strtotime($tempDate)));
                            }
                            $total_expected = $total_students * $working_days;
                            $total_absent_instances = max(0, $total_expected - $total_present_instances);
                            ?>

                             <!-- Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card bg-primary bg-soft border-primary h-100 m-0">
                                        <div class="card-body text-center p-3">
                                            <h6 class="text-white mt-0">Total Students</h6>
                                            <h3 class="mb-0 text-white"><?= $total_students ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card bg-success bg-soft border-success h-100 m-0">
                                        <div class="card-body text-center p-3">
                                            <h6 class="text-white mt-0">Total Present</h6>
                                            <h3 class="mb-0 text-white"><?= $total_present_instances ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card bg-danger bg-soft border-danger h-100 m-0">
                                        <div class="card-body text-center p-3">
                                            <h6 class="text-white mt-0">Total Absent</h6>
                                            <h3 class="mb-0 text-white"><?= $total_absent_instances ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card bg-info bg-soft border-info h-100 m-0">
                                        <div class="card-body text-center p-3">
                                            <h6 class="text-white mt-0">Check In</h6>
                                            <h3 class="mb-0 text-white"><?= $total_present_instances ?></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card bg-warning bg-soft border-warning h-100 m-0">
                                        <div class="card-body text-center p-3">
                                            <h6 class="text-white mt-0">Check Out</h6>
                                            <h3 class="mb-0 text-white"><?= $total_checkout_instances ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                @media (min-width: 992px) {
                                    .col-md-5ths {
                                        width: 20%;
                                        float: left;
                                    }
                                }
                            </style>

                            <div class="table-responsive">
                                <table id="attTable" class="table table-bordered table-striped dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Branch</th>
                                            <th>Batch</th>
                                            <th>Group</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Device ID</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($total_students > 0){
                                            $i = 1;
                                            // Loop through Date Range
                                            $currentDate = $start_date;
                                            while (strtotime($currentDate) <= strtotime($end_date)) {
                                                foreach($students as $std){
                                                    $stuId = $std['stu_user_id']; 
                                                    $att = $attendance_data[$stuId][$currentDate] ?? null; 

                                                    $checkIn = '-';
                                                    $checkOut = '-';
                                                    
                                                    if($att){
                                                        $status = '<span class="badge bg-success">Present</span>';
                                                        $checkIn = $att['check_in'];
                                                        $checkOut = $att['check_out'] ?? '-';
                                                    } else {
                                                        $day_name = date('l', strtotime($currentDate));
                                                        $is_weekend = ($day_name == 'Friday' || $day_name == 'Saturday');
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
                                            <td><?= $distName ?></td>
                                            <td><?= $batchName ?></td>
                                            <td><?= $std['group_name'] ?? '-' ?></td>
                                            <td><?= date('d M Y', strtotime($currentDate)) ?></td>
                                            <td>
                                                <?= $std['stu_name'] ?>
                                            </td>
                                            <td>
                                                <?= $std['contact'] ?>
                                            </td>
                                            <td>
                                                <?= $std['email'] ?>
                                            </td>
                                            <td><?= $status ?></td>
                                            <td><?= $checkIn ?></td>
                                            <td><?= $checkOut ?></td>
                                            <td><?= $att['device_id'] ?? '-' ?></td>
                                            <!-- <td>
                                                <?php if(isset($att['lat']) && $att['lat']): ?>
                                                <a href="https://maps.google.com/?q=<?= $att['lat'] ?>,<?= $att['lng'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="mdi mdi-map-marker"></i> Loc</a>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td> -->
                                            <td>
                                                <a href="attendance-student-view?student_id=<?= $stuId ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                                <?php if($att): ?>
                                                <a href="attendance-edit?att_id=<?= $att['att_id'] ?>&back_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                <a href="<?= $base_link ?>delete_id=<?= $att['att_id'] ?>" class="btn btn-sm btn-danger d-none" onclick="return confirm('Are you sure?')"><i class="mdi mdi-trash-can"></i></a>
                                                <?php else: ?>
                                                <a href="attendance-edit?student_id=<?= $stuId ?>&date=<?= $currentDate ?>&back_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                                // Increment Date
                                                $currentDate = date ("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                                            }
                                        } else {
                                            echo "<tr><td colspan='13' class='text-center'>No Students Found in this Batch/Group</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Default List View (Recent Attendance) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom py-3 d-flex align-items-center justify-content-between">
                            <h4 class="card-title m-0">Today's Attendance Status (<?= date('d M Y') ?>)</h4>
                            <div class="d-flex gap-2">
                                 <?php
                                    $today_date = date('Y-m-d');
                                    $batch_target = '18';
                                    
                                    // Total Students in Batch 18 (Excluding Blocked)
                                    $total_q = mysqli_query($con, "SELECT COUNT(student_id) as total FROM student_list WHERE status != 3 AND batch_id = '$batch_target'");
                                    $total_count = mysqli_fetch_assoc($total_q)['total'];
                                    
                                    // Today's Check-ins in Batch 18
                                    $checkin_q = mysqli_query($con, "SELECT COUNT(DISTINCT a.student_id) as total FROM attendance a JOIN student_list s ON a.student_id = s.stu_user_id WHERE s.status != 3 AND s.batch_id = '$batch_target' AND a.att_date = '$today_date' AND a.check_in IS NOT NULL");
                                    $present_count = mysqli_fetch_assoc($checkin_q)['total'];
                                    
                                    // Today's Check-outs in Batch 18
                                    $checkout_q = mysqli_query($con, "SELECT COUNT(DISTINCT a.student_id) as total FROM attendance a JOIN student_list s ON a.student_id = s.stu_user_id WHERE s.status != 3 AND s.batch_id = '$batch_target' AND a.att_date = '$today_date' AND a.check_out IS NOT NULL AND a.check_out != '' AND a.check_out != '00:00:00'");
                                    $checkout_today_count = mysqli_fetch_assoc($checkout_q)['total'];
                                    
                                    $absent_count = $total_count - $present_count;
                                ?>
                                <h5 class="bg-primary text-white px-2 py-1 rounded mb-0">Total: <?= $total_count ?></h5>
                                <h5 class="bg-success text-white px-2 py-1 rounded mb-0">Present: <?= $present_count ?></h5>
                                <h5 class="bg-danger text-white px-2 py-1 rounded mb-0">Absent: <?= $absent_count ?></h5>
                                <h5 class="bg-info text-white px-2 py-1 rounded mb-0">Check In: <?= $present_count ?></h5>
                                <h5 class="bg-warning text-white px-2 py-1 rounded mb-0">Check Out: <?= $checkout_today_count ?></h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="recentAttTable" class="table table-bordered table-striped dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Student Name</th>
                                            <th>Branch</th>
                                            <th>Batch</th>
                                            <th>Status</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query Today's Status (Optimized for speed)
                                        $today = date('Y-m-d');
                                        $listQuery = "SELECT s.stu_user_id, s.stu_name, d.dist_name, b.batch_name, MAX(a.att_id) as att_id, MIN(a.check_in) as check_in, MAX(a.check_out) as check_out
                                                      FROM student_list s 
                                                      LEFT JOIN attendance a ON s.stu_user_id = a.student_id AND a.att_date = '$today'
                                                      LEFT JOIN district d ON s.district = d.id
                                                      LEFT JOIN batch_list b ON s.batch_id = b.batch_id
                                                      WHERE s.status != 3 AND s.batch_id = '18'
                                                      GROUP BY s.stu_user_id
                                                      ORDER BY (MIN(a.check_in) IS NULL), MIN(a.check_in) DESC, s.stu_name ASC
                                                      LIMIT 4000";
                                        
                                        $listResult = mysqli_query($con, $listQuery);
                                        
                                        if($listResult && mysqli_num_rows($listResult) > 0){
                                            $i = 1;
                                            while($row = mysqli_fetch_array($listResult)){
                                                $student_id = $row['stu_user_id'];
                                                $viewUrl = "attendance-student-view.php?student_id=".$student_id;
                                                $isPresent = !empty($row['check_in']);
                                        ?>
                                        <tr class="<?= $isPresent ? '' : 'table-light' ?>">
                                            <td><?= $i++ ?></td>
                                            <td>
                                                <?= $row['stu_name'] ?? 'Unknown Student' ?>
                                            </td>
                                            <td><?= $row['dist_name'] ?? '-' ?></td>
                                            <td><?= $row['batch_name'] ?? '-' ?></td>
                                            <td>
                                                <?php if($isPresent): ?>
                                                    <span class="badge bg-success">Present</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Absent</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $isPresent ? date('h:i A', strtotime($row['check_in'])) : '-' ?></td>
                                            <td><?= (!empty($row['check_out'])) ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
                                            <td>
                                                <a href="<?= $viewUrl ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                                <?php if($isPresent): ?>
                                                    <a href="attendance-edit?att_id=<?= $row['att_id'] ?>&back_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="?delete_id=<?= $row['att_id'] ?>" class="btn btn-sm btn-danger d-none" onclick="return confirm('Are you sure?')"><i class="mdi mdi-trash-can"></i></a>
                                                <?php else: ?>
                                                    <a href="attendance-edit?student_id=<?= $student_id ?>&date=<?= $today ?>&back_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-outline-success"><i class="mdi mdi-plus"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No Recent Attendance Records Found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

          </div>

        </div>
      </div>
      <?php include "footer.php" ?>
    </div>
  </div>
  <?php include "script.php" ?>

  <script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#attTable').DataTable({
                "pageLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
            $('#recentAttTable').DataTable({
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "order": [],
                "deferRender": true 
            });
        }
    });

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
