<!doctype html>
<html lang="en">

<head>
  <title>Attendance Reports | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
  <style>
    .summary-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .summary-card .card-body {
        padding: 1.5rem;
        position: relative;
        z-index: 1;
    }
    .summary-icon {
        position: absolute;
        right: 15px;
        bottom: -10px;
        font-size: 4rem;
        opacity: 0.2;
        transform: rotate(-10deg);
        color: #fff;
    }
    .count-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0;
        line-height: 1;
    }
    .summary-label {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
        opacity: 0.9 !important;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important; }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important; }
    .bg-gradient-danger { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%) !important; }
    .text-white-80 { color: rgba(255, 255, 255, 0.82) !important; }
  </style>
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
                                $dist_id = $_SESSION['id'];
                                $batch_id = isset($_GET['Batch']) ? $_GET['Batch'] : '';
                                $group_id = isset($_GET['Group']) ? $_GET['Group'] : '';
                                
                                $sys_start_date = '2026-02-26';
                                $start_date = isset($_GET['StartDate']) ? $_GET['StartDate'] : date('Y-m-d');
                                $end_date = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');

                                // Force date not before system start
                                if(strtotime($start_date) < strtotime($sys_start_date)) $start_date = $sys_start_date;
                            ?>
                            
                            <div class="col-md-6 col-lg-3 my-2 d-none">
                              <select id="DistId" name="DistId" class="form-control form-select" required readonly>
                                <?php
                                $user_dist_id = $_SESSION['id'];
                                $sql = "SELECT * FROM district WHERE id = '$user_dist_id'";
                                $result = $con->query($sql);
                                if ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['id'] . "' selected>" . $row['dist_name'] . "</option>";
                                } else {
                                  // Fallback if session ID doesn't match any district (though it should in this panel)
                                  echo "<option value='" . $user_dist_id . "' selected>" . $user . "</option>";
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

                              // --- CALCULATE SUMMARY DATA ---
                              // 1. Get all students
                              $studentQuery = "SELECT student_list.*, group_list.group_name FROM student_list 
                                               LEFT JOIN group_list ON student_list.group_id = group_list.group_id
                                               WHERE student_list.status = 1 AND district='$dist_id' AND batch_id='$batch_id'";
                              if($group_id) $studentQuery .= " AND student_list.group_id='$group_id'";
                              $studentsResult = mysqli_query($con, $studentQuery);
                              
                              $students = [];
                              while($row = mysqli_fetch_array($studentsResult)){
                                  $students[] = $row;
                              }

                              $total_students = count($students);
                              $total_present_instances = 0;
                              $total_absent_instances = 0;
                              $total_working_days = 0;

                              if ($total_students > 0) {
                                  // Calculate working days in range
                                  $tmp_date = (strtotime($start_date) < strtotime($sys_start_date)) ? $sys_start_date : $start_date;
                                  while (strtotime($tmp_date) <= strtotime($end_date)) {
                                      $day_name = date('l', strtotime($tmp_date));
                                      $is_weekend = ($day_name == 'Friday' || $day_name == 'Saturday');
                                      $is_holiday = in_array($tmp_date, $bd_holidays);
                                      if (!$is_weekend && !$is_holiday) {
                                          $total_working_days++;
                                      }
                                      $tmp_date = date("Y-m-d", strtotime("+1 day", strtotime($tmp_date)));
                                  }

                                  // Get present count (Unique student per day)
                                  $presentQuery = "SELECT COUNT(DISTINCT a.student_id, a.att_date) as count FROM attendance a 
                                                   JOIN student_list s ON a.student_id = s.stu_user_id 
                                                   WHERE s.status = 1 AND s.district='$dist_id' AND s.batch_id='$batch_id' 
                                                   AND a.att_date BETWEEN '$start_date' AND '$end_date'";
                                  if($group_id) $presentQuery .= " AND s.group_id='$group_id'";
                                  $presentRes = mysqli_query($con, $presentQuery);
                                  if($presentRes) {
                                      $presentRow = mysqli_fetch_assoc($presentRes);
                                      $total_present_instances = $presentRow['count'];
                                  }

                                  // Get checkout count
                                  $total_checkout_instances = 0;
                                  $checkoutQuery = "SELECT COUNT(DISTINCT a.student_id, a.att_date) as count FROM attendance a 
                                                   JOIN student_list s ON a.student_id = s.stu_user_id 
                                                   WHERE s.status = 1 AND s.district='$dist_id' AND s.batch_id='$batch_id' 
                                                   AND a.att_date BETWEEN '$start_date' AND '$end_date'
                                                   AND a.check_out IS NOT NULL AND a.check_out != '' AND a.check_out != '00:00:00'";
                                  if($group_id) $checkoutQuery .= " AND s.group_id='$group_id'";
                                  $checkoutRes = mysqli_query($con, $checkoutQuery);
                                  if($checkoutRes) {
                                      $checkoutRow = mysqli_fetch_assoc($checkoutRes);
                                      $total_checkout_instances = $checkoutRow['count'];
                                  }
                                  
                                  $total_absent_instances = ($total_working_days * $total_students) - $total_present_instances;
                                  if($total_absent_instances < 0) $total_absent_instances = 0;
                              }
                            ?>
                            <h3>Attendance Report</h3>
                            <h5 class="text-primary"><?= $distName ?> | <?= $batchName ?> | <?= $groupName ?></h5>
                            <h6>From: <?= date('d M Y', strtotime($start_date)) ?> To: <?= date('d M Y', strtotime($end_date)) ?></h6>
                        </div>
                        <div class="card-body">
                             <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="m-0 text-muted"><i class="mdi mdi-chart-box-outline me-1"></i> Summary Overview</h5>
                                <button class="btn btn-success" onclick="exportTableToExcel('attTable', 'Attendance_Report_<?= $start_date ?>_to_<?= $end_date ?>')">
                                    <i class="mdi mdi-file-excel"></i> Export Excel
                                </button>
                            </div>

                             <!-- Summary Cards -->
                            <div class="row">
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card summary-card bg-gradient-primary">
                                        <div class="card-body p-3 text-center">
                                            <div class="summary-label text-white-80">Total Students</div>
                                            <h2 class="count-number text-white"><?= str_pad($total_students, 2, '0', STR_PAD_LEFT) ?></h2>
                                            <i class="mdi mdi-account-group summary-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card summary-card bg-gradient-success">
                                        <div class="card-body p-3 text-center">
                                            <div class="summary-label text-white-80">Total Present</div>
                                            <h2 class="count-number text-white"><?= str_pad($total_present_instances, 2, '0', STR_PAD_LEFT) ?></h2>
                                            <i class="mdi mdi-account-check summary-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card summary-card bg-gradient-danger">
                                        <div class="card-body p-3 text-center">
                                            <div class="summary-label text-white-80">Total Absent</div>
                                            <h2 class="count-number text-white"><?= str_pad($total_absent_instances, 2, '0', STR_PAD_LEFT) ?></h2>
                                            <i class="mdi mdi-account-remove summary-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card summary-card bg-info bg-soft border-info" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%) !important;">
                                        <div class="card-body p-3 text-center">
                                            <div class="summary-label text-white-80">Check In</div>
                                            <h2 class="count-number text-white"><?= str_pad($total_present_instances, 2, '0', STR_PAD_LEFT) ?></h2>
                                            <i class="mdi mdi-login summary-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5ths col-lg-5ths col-sm-6 mb-2">
                                    <div class="card summary-card bg-warning bg-soft border-warning" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%) !important;">
                                        <div class="card-body p-3 text-center">
                                            <div class="summary-label text-white-80">Check Out</div>
                                            <h2 class="count-number text-white"><?= str_pad($total_checkout_instances, 2, '0', STR_PAD_LEFT) ?></h2>
                                            <i class="mdi mdi-logout summary-icon"></i>
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
                                            <th>Student Name</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Distance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(count($students) > 0){
                                            $i = 1;
                                            
                                            // Loop through Date Range (Starting from system start date)
                                            $currentDate = (strtotime($start_date) < strtotime($sys_start_date)) ? $sys_start_date : $start_date;
                                            while (strtotime($currentDate) <= strtotime($end_date)) {
                                                
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
                                                <!-- <small class="d-block text-muted">ID: <?= $std['student_id'] ?></small> -->
                                            </td>
                                            <td><?= $std['contact'] ?></td>
                                            <td><?= $status ?></td>
                                            <td><?= $checkIn ?></td>
                                            <td><?= $checkOut ?></td>
                                            <td>
                                                <?php if(isset($att['lat']) && $att['lat']): ?>
                                                <a href="https://maps.google.com/?q=<?= $att['lat'] ?>,<?= $att['lng'] ?>" target="_blank" class="btn btn-sm btn-info"><i class="mdi mdi-map-marker"></i> Loc</a>
                                                <?php else: ?>
                                                -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="attendance-student-view?student_id=<?= $stuId ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                                <?php if($att): ?>
                                                <a href="attendance-edit?att_id=<?= $att['att_id'] ?>" class="btn btn-sm btn-success d-none"><i class="mdi mdi-pencil"></i></a>
                                                <a href="<?= $base_link ?>delete_id=<?= $att['att_id'] ?>" class="btn btn-sm btn-danger d-none" onclick="return confirm('Are you sure?')"><i class="mdi mdi-trash-can"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                                // Increment Date
                                                $currentDate = date ("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                                            }
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
                        <div class="card-header border-bottom py-3">
                            <h4 class="card-title">Recent Attendance Logs</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="recentAttTable" class="table table-bordered table-striped dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>Student Name</th>
                                            <th>Branch</th>
                                            <th>Batch</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query recent attendance records (individual)
                                        $listQuery = "SELECT a.*, s.stu_name, s.district, s.batch_id, s.group_id, d.dist_name, b.batch_name, g.group_name 
                                                      FROM attendance a 
                                                      LEFT JOIN student_list s ON a.student_id = s.stu_user_id 
                                                      LEFT JOIN district d ON s.district = d.id
                                                      LEFT JOIN batch_list b ON s.batch_id = b.batch_id
                                                      LEFT JOIN group_list g ON s.group_id = g.group_id
                                                      WHERE s.status != 3 AND s.district = '" . $_SESSION['id'] . "'
                                                      ORDER BY a.att_date DESC, a.check_in DESC LIMIT 100";
                                        
                                        $listResult = mysqli_query($con, $listQuery);
                                        
                                        if($listResult && mysqli_num_rows($listResult) > 0){
                                            $i = 1;
                                            while($row = mysqli_fetch_array($listResult)){
                                                $viewUrl = "attendance-student-view?student_id=".$row['student_id'];
                                        ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d M Y', strtotime($row['att_date'])) ?></td>
                                            <td>
                                                <?= $row['stu_name'] ?? 'Unknown Student' ?>
                                                <!-- <small class="d-block text-muted">ID: <?= $row['student_id'] ?></small> -->
                                            </td>
                                            <td><?= $row['dist_name'] ?? '-' ?></td>
                                            <td><?= $row['batch_name'] ?? '-' ?></td>
                                            <td><?= date('h:i A', strtotime($row['check_in'])) ?></td>
                                            <td><?= $row['check_out'] ? date('h:i A', strtotime($row['check_out'])) : '-' ?></td>
                                            <td>
                                                <a href="<?= $viewUrl ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-eye"></i></a>
                                                <!-- <a href="attendance-edit?att_id=<?= $row['att_id'] ?>&back_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a> -->
                                                <!-- <a href="?delete_id=<?= $row['att_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="mdi mdi-trash-can"></i></a> -->
                                            </td>
                                        </tr>
                                        <?php
                                            }
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
            // General DataTable for search results
            var attTable = $('#attTable').DataTable({
                "pageLength": 50,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [[ 4, 'asc' ]] // Default sort by Date
            });

            // Automatic visual serial number for attTable
            attTable.on('order.dt search.dt', function () {
                attTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            // General DataTable for recent logs
            var recentAttTable = $('#recentAttTable').DataTable({
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[ 1, "desc" ]], // Default sort by Date
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }]
            });

            // Automatic visual serial number for recentAttTable
            recentAttTable.on('order.dt search.dt', function () {
                recentAttTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
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
