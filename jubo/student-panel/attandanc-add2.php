<!doctype html>
<html lang="en">

<head>

  <title>Attendance | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<?php
// ========== CONFIGURATION ==========
// ========== CONFIGURATION ==========
$target_lat = 0; 
$target_lng = 0;
$allowed_radius = 0; 
$config_found = false;
$branch_id = 0;

// Fetch Student Branch (District) and Branch Settings
$student_id = $_SESSION['id']; // This is actually user_id in student_list based on other files
// Get student's district ID
$stuQuery = mysqli_query($con, "SELECT district FROM student_list WHERE stu_user_id='$student_id'");
$branch_poles = [];
if(mysqli_num_rows($stuQuery) > 0){
    $stuRow = mysqli_fetch_array($stuQuery);
    $branch_id = $stuRow['district'];

    // Fetch ALL Distance Settings (Poles) for this branch
    $distQuery = mysqli_query($con, "SELECT * FROM branch_distances WHERE branch_id='$branch_id'");
    while($distRow = mysqli_fetch_array($distQuery)){
        $branch_poles[] = [
            'lat' => $distRow['lat'],
            'lng' => $distRow['lng'],
            'radius' => $distRow['radius'],
            'name' => $distRow['location_name'] ?? 'Main Center'
        ];
        $config_found = true;
    }
    
    // For backward compatibility or single use in PHP check below if we keep it simple, 
    // but better to use the array. We'll set these to the first pole found.
    if(!empty($branch_poles)){
        $target_lat = $branch_poles[0]['lat'];
        $target_lng = $branch_poles[0]['lng'];
        $allowed_radius = $branch_poles[0]['radius'];
    }
}
// ===================================
// ===================================

// Auto-create table if not exists
$checkTable = mysqli_query($con, "SHOW TABLES LIKE 'attendance'");
if(mysqli_num_rows($checkTable) == 0) {
    mysqli_query($con, "CREATE TABLE `attendance` (
      `att_id` int(11) NOT NULL AUTO_INCREMENT,
      `student_id` int(11) NOT NULL,
      `branch_id` int(11) DEFAULT NULL,
      `att_date` date NOT NULL,
      `check_in` varchar(20) DEFAULT NULL,
      `check_out` varchar(20) DEFAULT NULL,
      `lat` varchar(100) DEFAULT NULL,
      `lng` varchar(100) DEFAULT NULL,
      `mp` varchar(20) DEFAULT NULL,
      `yp` varchar(20) DEFAULT NULL,
      PRIMARY KEY (`att_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} else {
    // Check if lat/lng/branch_id columns exist, if not add them
    $checkCol = mysqli_query($con, "SHOW COLUMNS FROM `attendance` LIKE 'lat'");
    if(mysqli_num_rows($checkCol) == 0){
        mysqli_query($con, "ALTER TABLE `attendance` ADD COLUMN `lat` varchar(100) DEFAULT NULL AFTER `check_out`");
        mysqli_query($con, "ALTER TABLE `attendance` ADD COLUMN `lng` varchar(100) DEFAULT NULL AFTER `lat`");
    }
    
    $checkBranch = mysqli_query($con, "SHOW COLUMNS FROM `attendance` LIKE 'branch_id'");
    if(mysqli_num_rows($checkBranch) == 0){
        mysqli_query($con, "ALTER TABLE `attendance` ADD COLUMN `branch_id` int(11) DEFAULT NULL AFTER `student_id`");
    }

    $checkPhotoIn = mysqli_query($con, "SHOW COLUMNS FROM `attendance` LIKE 'photo_in'");
    if(mysqli_num_rows($checkPhotoIn) == 0){
        mysqli_query($con, "ALTER TABLE `attendance` ADD COLUMN `photo_in` varchar(255) DEFAULT NULL");
    }

    $checkPhotoOut = mysqli_query($con, "SHOW COLUMNS FROM `attendance` LIKE 'photo_out'");
    if(mysqli_num_rows($checkPhotoOut) == 0){
        mysqli_query($con, "ALTER TABLE `attendance` ADD COLUMN `photo_out` varchar(255) DEFAULT NULL");
    }
}

$msg = "";
// $student_id = $_SESSION['id']; // Already defined above
$today = date('Y-m-d');
$current_time = date('h:i A');
$current_month = date('F');
$current_year = date('Y');

// Distance Calculation Function
function getDistance($lat1, $lon1, $lat2, $lon2) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  } else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $meters = $miles * 1.609344 * 1000;
    return $meters;
  }
}


// Handle Check In
if(isset($_POST['check_in_btn'])){
    $user_lat = $_POST['lat'];
    $user_lng = $_POST['lng'];

    if(empty($user_lat) || empty($user_lng)){
        $msg = '<div class="alert alert-warning">Location not detected. Please allow location access.</div>';
    } elseif(empty($_FILES['photo']['name'])) {
        $msg = '<div class="alert alert-warning">Please capture your photo first.</div>';
    } else {
        // Check against ALL poles
        $is_in_range = false;
        $min_distance = 9999999;
        $active_radius = 500;
        
        foreach($branch_poles as $pole){
            $d = getDistance($user_lat, $user_lng, $pole['lat'], $pole['lng']);
            if($d < $min_distance) {
                $min_distance = $d;
                $active_radius = $pole['radius'];
            }
            if($d <= $pole['radius']){
                $is_in_range = true;
                break;
            }
        }
        
        if($is_in_range){
            $check_duplicate = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$student_id' AND att_date='$today'");
            if(mysqli_num_rows($check_duplicate) > 0){
                $msg = '<div class="alert alert-warning">You have already checked in today!</div>';
            } else {
                // Handle Photo Upload (Following student-add.php logic)
                if(!isset($_FILES['photo']) || $_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE) {
                    $msg = '<div class="alert alert-danger">Error: No photo captured or received.</div>';
                } else {
                    $imgFile = $_FILES['photo']['name'];
                    $tmp_dir = $_FILES['photo']['tmp_name'];
                    $imgSize = $_FILES['photo']['size'];
                    $upload_dir = __DIR__ . "/attendance_images/";
                    
                    if(!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

                    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
                    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                    $photo_name = "att_in_" . time() . "_" . $_SESSION['id'] . "." . $imgExt;

                    if (in_array($imgExt, $valid_extensions)) {
                        if ($imgSize < 5000000) {
                            if (move_uploaded_file($tmp_dir, $upload_dir . $photo_name)) {
                                $insert = mysqli_query($con, "INSERT INTO attendance (student_id, branch_id, att_date, check_in, lat, lng, photo_in, mp, yp) VALUES ('$student_id', '$branch_id', '$today', '$current_time', '$user_lat', '$user_lng', '$photo_name', '$current_month', '$current_year')");
                                if($insert){
                                    $msg = '<div class="alert alert-success">Check In Successful at '.$current_time.'</div>';
                                } else {
                                    $msg = '<div class="alert alert-danger">Database error: ' . mysqli_error($con) . '</div>';
                                }
                            } else {
                                $msg = '<div class="alert alert-danger">Error: Photo could not be saved to server. Permission issue? Folder: ' . $upload_dir . '</div>';
                            }
                        } else {
                            $msg = '<div class="alert alert-danger">Sorry, your file is too large (Max 5MB).</div>';
                        }
                    } else {
                        $msg = '<div class="alert alert-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed. Format detected: ' . $imgExt . '</div>';
                    }
                }
            }
        } else {
            $msg = '<div class="alert alert-danger">You are too far from the institute! Nearest Pole Distance: '.round($min_distance).'m (Allowed: '.$active_radius.'m)</div>';
        }
    }
}

// Handle Check Out
if(isset($_POST['check_out_btn'])){
    $user_lat = $_POST['lat'];
    $user_lng = $_POST['lng'];

    if(empty($user_lat) || empty($user_lng)){
        $msg = '<div class="alert alert-warning">Location not detected. Please allow location access.</div>';
    } elseif(empty($_FILES['photo']['name'])) {
        $msg = '<div class="alert alert-warning">Please capture your photo for check out.</div>';
    } else {
        // Check against ALL poles
        $is_in_range = false;
        $min_distance = 9999999;
        $active_radius = 500;
        
        foreach($branch_poles as $pole){
            $d = getDistance($user_lat, $user_lng, $pole['lat'], $pole['lng']);
            if($d < $min_distance) {
                $min_distance = $d;
                $active_radius = $pole['radius'];
            }
            if($d <= $pole['radius']){
                $is_in_range = true;
                break;
            }
        }

        if($is_in_range){
            // Handle Photo Upload (Following student-add.php logic)
            if(!isset($_FILES['photo']) || $_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE) {
                $msg = '<div class="alert alert-danger">Error: No photo captured or received.</div>';
            } else {
                $imgFile = $_FILES['photo']['name'];
                $tmp_dir = $_FILES['photo']['tmp_name'];
                $imgSize = $_FILES['photo']['size'];
                $upload_dir = __DIR__ . "/attendance_images/";
                
                if(!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

                $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
                $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                $photo_name = "att_out_" . time() . "_" . $_SESSION['id'] . "." . $imgExt;

                if (in_array($imgExt, $valid_extensions)) {
                    if ($imgSize < 5000000) {
                        if (move_uploaded_file($tmp_dir, $upload_dir . $photo_name)) {
                            $update = mysqli_query($con, "UPDATE attendance SET check_out='$current_time', photo_out='$photo_name' WHERE student_id='$student_id' AND att_date='$today'");
                            if($update){
                                $msg = '<div class="alert alert-success">Check Out Successful at '.$current_time.'</div>';
                            } else {
                                $msg = '<div class="alert alert-danger">Database error: ' . mysqli_error($con) . '</div>';
                            }
                        } else {
                            $msg = '<div class="alert alert-danger">Error: Photo could not be saved to server. Permission issue? Folder: ' . $upload_dir . '</div>';
                        }
                    } else {
                        $msg = '<div class="alert alert-danger">Sorry, your file is too large (Max 5MB).</div>';
                    }
                } else {
                    $msg = '<div class="alert alert-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed. Format detected: ' . $imgExt . '</div>';
                }
            }
        } else {
             $msg = '<div class="alert alert-danger">You are too far from the institute! Nearest Pole Distance: '.round($min_distance).'m (Allowed: '.$active_radius.'m)</div>';
        }
    }
}

$query = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$student_id' AND att_date='$today'");
$attendance = mysqli_fetch_array($query);

// System wide attendance start date
$sys_start_date = '2026-02-26';
?>

<body data-topbar="colored">

  <div id="layout-wrapper">

    <?php include "header.php" ?>

    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Attendance</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Daily Check In/Out (<?= count($branch_poles) ?> Valid Locations)</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <div class="page-content-wrapper">
            <div class="row">
              <!-- Left Column: Todays Attendance Buttons -->
              <div class="col-xl-6">
                <div class="card">
                  <div class="card-body text-center">
                    <h4 class="card-title mb-4">Todays Attendance (<?= date('d M Y') ?>)</h4>
                    
                    <?= $msg ?>
                    
                    <!-- Location Status -->
                    <div id="location-status" class="alert alert-secondary">
                        Creating location detection...
                    </div>


                    <div class="div-buttons">
                        <?php if(mysqli_num_rows($query) == 0): ?>
                            <!-- Show Check In Button -->
                            <form method="post" id="attForm" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="form-label text-primary"><i class="mdi mdi-camera"></i> Capture Selfie for Check-In</label>
                                    <input type="file" name="photo" accept="image/*" capture="user" class="form-control" required>
                                </div>

                                <input type="hidden" name="lat" id="lat_in">
                                <input type="hidden" name="lng" id="lng_in">
                                
                                <button type="submit" name="check_in_btn" id="btn_in" class="btn btn-secondary btn-lg rounded-circle" style="width: 150px; height: 150px; font-size: 24px;" disabled>
                                    Check In <br> <i class="mdi mdi-login"></i>
                                </button>
                            </form>
                        <?php elseif($attendance['check_in'] != '' && $attendance['check_in'] != NULL): ?>
                            <!-- Show Check Out Button (Always allow check out update if checked in) -->
                            <div class="mb-3">
                                <h5>Checked In at: <span class="text-success"><?= $attendance['check_in'] ?></span></h5>
                                <?php if($attendance['photo_in']): ?>
                                    <img src="attendance_images/<?= $attendance['photo_in'] ?>" class="rounded mb-2 shadow-sm" style="width: 100px; height: auto;">
                                <?php endif; ?>
                                
                                <?php if($attendance['check_out']): ?>
                                    <h5>Last Checked Out at: <span class="text-danger"><?= $attendance['check_out'] ?></span></h5>
                                    <?php if($attendance['photo_out']): ?>
                                        <img src="attendance_images/<?= $attendance['photo_out'] ?>" class="rounded mb-2 shadow-sm" style="width: 100px; height: auto;">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <form method="post" id="attForm" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="form-label text-danger"><i class="mdi mdi-camera"></i> Capture Selfie for Check-Out</label>
                                    <input type="file" name="photo" accept="image/*" capture="user" class="form-control" required>
                                </div>

                                <input type="hidden" name="lat" id="lat_out">
                                <input type="hidden" name="lng" id="lng_out">

                                <button type="submit" name="check_out_btn" id="btn_out" class="btn btn-secondary btn-lg rounded-circle" style="width: 150px; height: 150px; font-size: 24px;" disabled>
                                    Check Out <br> <i class="mdi mdi-logout"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Column: Attendance Summary Report -->
              <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Attendance Summary</h4>
                        <?php
                        // Calculate Statistics
                        $total_days = mysqli_num_rows(mysqli_query($con, "SELECT att_id FROM attendance WHERE student_id='$student_id'"));
                        $total_present = mysqli_num_rows(mysqli_query($con, "SELECT att_id FROM attendance WHERE student_id='$student_id' AND check_in IS NOT NULL"));
                        
                        // Get Branch Name
                        $branch_name = "N/A";
                        if($branch_id){
                            $bQuery = mysqli_query($con, "SELECT stuff_name FROM stuff WHERE userid='$branch_id' LIMIT 1");
                            if($bRow = mysqli_fetch_array($bQuery)){
                                $branch_name = $bRow['stuff_name'];
                            }
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Institute Center :</th>
                                        <td><?= $branch_name ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Today's Date :</th>
                                        <td><?= date('d M Y') ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Check In Time :</th>
                                        <td><?= ($attendance['check_in'] ?? 'Not Yet') ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Check Out Time :</th>
                                        <td><?= ($attendance['check_out'] ?? 'Not Yet') ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Attendance Days :</th>
                                        <td><span class="badge bg-primary"><?= $total_days ?> Days</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <!-- Stats row -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Monthly Present</p>
                                    <h4 class="mb-0">
                                        <?php 
                                        $month_present = mysqli_num_rows(mysqli_query($con, "SELECT att_id FROM attendance WHERE student_id='$student_id' AND mp='$current_month' AND yp='$current_year'"));
                                        echo $month_present;
                                        ?>
                                    </h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                    <span class="avatar-title">
                                        <i class="mdi mdi-account-check font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Monthly Absent</p>
                                    <h4 class="mb-0">
                                        <?php 
                                        $today_day_num = (int)date('d');
                                        $working_days_count = 0;
                                        
                                        // Start counting from 1st of month OR system start date (whichever is later)
                                        $month_start = date('Y-m-01');
                                        $calc_start = (strtotime($month_start) < strtotime($sys_start_date)) ? $sys_start_date : $month_start;
                                        
                                        $start_day_num = (int)date('d', strtotime($calc_start));

                                        for($d=$start_day_num; $d<=$today_day_num; $d++){
                                            $date_check = date('Y-m-') . sprintf("%02d", $d);
                                            $day_check = date('l', strtotime($date_check));
                                            
                                            // Bangladesh Govt Holidays (simple check for now/integration later)
                                            if($day_check != 'Friday'){
                                                $working_days_count++;
                                            }
                                        }

                                        $month_absent = $working_days_count - $month_present;
                                        echo max(0, $month_absent);
                                        ?>
                                    </h4>
                                </div>
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center">
                                    <span class="avatar-title">
                                        <i class="mdi mdi-account-remove font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="row mt-4">
                 <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title m-0">Attendance History</h4>
                                <form class="row gx-3 gy-2 align-items-center" method="get">
                                    <div class="col-sm-auto">
                                        <?php 
                                            $default_from = (strtotime(date('Y-m-01')) < strtotime($sys_start_date)) ? $sys_start_date : date('Y-m-01');
                                        ?>
                                        <input type="date" class="form-control form-control-sm" name="from_date" value="<?= $_GET['from_date'] ?? $default_from ?>">
                                    </div>
                                    <div class="col-sm-auto">
                                        <input type="date" class="form-control form-control-sm" name="to_date" value="<?= $_GET['to_date'] ?? date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-sm-auto">
                                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                        <a href="attandanc-add" class="btn btn-light btn-sm">Clear</a>
                                        <button type="button" class="btn btn-success btn-sm ms-2" onclick="exportTableToExcel('attTable', 'Attendance_History_<?= date('d_M_Y') ?>')">
                                            <i class="mdi mdi-file-excel"></i> Export
                                        </button>
                                    </div>
                                </form>
                            </div>

                             <table id="attTable" class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>In Time</th>
                                        <th>Out Time</th>
                                        <th>In Photo</th>
                                        <th>Out Photo</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $default_from = (strtotime(date('Y-m-01')) < strtotime($sys_start_date)) ? $sys_start_date : date('Y-m-01');
                                    $f_date = $_GET['from_date'] ?? $default_from;
                                    $t_date = $_GET['to_date'] ?? date('Y-m-d');

                                    // Ensure f_date is not before system start date
                                    if(strtotime($f_date) < strtotime($sys_start_date)) $f_date = $sys_start_date;

                                    // Create array of attendance records for efficient lookup
                                    $att_records = [];
                                    $hist_query = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$student_id' AND att_date BETWEEN '$f_date' AND '$t_date'");
                                    while($ha = mysqli_fetch_array($hist_query)){
                                        $att_records[$ha['att_date']] = $ha;
                                    }

                                    // Generate dates range from To to From (Descending)
                                    $begin = new DateTime($f_date);
                                    $end = new DateTime($t_date);
                                    $end = $end->modify('+1 day'); 

                                    $interval = new DateInterval('P1D');
                                    $daterange = new DatePeriod($begin, $interval ,$end);

                                    $all_dates = iterator_to_array($daterange);
                                    $all_dates = array_reverse($all_dates);

                                    foreach($all_dates as $date){
                                        $d_str = $date->format("Y-m-d");
                                        $day_name = $date->format("l");
                                        $is_friday = ($day_name == 'Friday');
                                        
                                        if(isset($att_records[$d_str])){
                                            $row = $att_records[$d_str];
                                            $status = '<span class="badge bg-success">Present</span>';
                                            $check_in = $row['check_in'];
                                            $check_out = $row['check_out'] ?? '-';
                                        } else {
                                            $status = $is_friday ? '<span class="badge bg-info">Holiday</span>' : '<span class="badge bg-danger">Absent</span>';
                                            $check_in = '-';
                                            $check_out = '-';
                                        }
                                    ?>
                                    <tr class="<?= $status == '<span class="badge bg-danger">Absent</span>' ? 'table-light' : '' ?>">
                                        <td><?= $date->format("d M Y") ?></td>
                                        <td><?= $day_name ?></td>
                                        <td><?= $check_in ?></td>
                                        <td><?= $check_out ?></td>
                                        <td>
                                            <?php if(isset($row['photo_in'])): ?>
                                                <a href="attendance_images/<?= $row['photo_in'] ?>" target="_blank">
                                                    <img src="attendance_images/<?= $row['photo_in'] ?>" class="rounded" style="width: 50px; height: auto;">
                                                </a>
                                            <?php else: ?> - <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($row['photo_out'])): ?>
                                                <a href="attendance_images/<?= $row['photo_out'] ?>" target="_blank">
                                                    <img src="attendance_images/<?= $row['photo_out'] ?>" class="rounded" style="width: 50px; height: auto;">
                                                </a>
                                            <?php else: ?> - <?php endif; ?>
                                        </td>
                                        <td><?= $status ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                             </table>
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
    const branchPoles = <?= json_encode($branch_poles) ?>;
    const configFound = <?= $config_found ? 'true' : 'false' ?>;

    const statusDiv = document.getElementById("location-status");
    const btnIn = document.getElementById("btn_in");
    const btnOut = document.getElementById("btn_out");
    
    // Inputs
    const latIn = document.getElementById("lat_in");
    const lngIn = document.getElementById("lng_in");
    const latOut = document.getElementById("lat_out");
    const lngOut = document.getElementById("lng_out");

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // metres
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        const d = R * c; // in metres
        return d;
    }

    function checkLocation() {

        if (!configFound) {
            statusDiv.innerHTML = "Attendance configuration not found for your branch. Please contact admin.";
            statusDiv.className = "alert alert-danger";
            return;
        }

        if (!navigator.geolocation) {
            statusDiv.innerHTML = "Result: Geolocation is not supported by your browser";
            return;
        }

        statusDiv.innerHTML = '<i class="mdi mdi-spin mdi-loading"></i> Locating...';

        navigator.geolocation.getCurrentPosition(success, error, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }

    function success(position) {
        const latitude  = position.coords.latitude;
        const longitude = position.coords.longitude;

        // Set hidden fields
        if(latIn) latIn.value = latitude;
        if(lngIn) lngIn.value = longitude;
        if(latOut) latOut.value = latitude;
        if(lngOut) lngOut.value = longitude;

        // Calculate distance against ALL poles
        let isInRange = false;
        let minDistance = Infinity;
        let activeRadius = 500;
        let activePoleName = '';

        branchPoles.forEach(pole => {
            const dist = getDistance(latitude, longitude, parseFloat(pole.lat), parseFloat(pole.lng));
            if(dist < minDistance) {
                minDistance = dist;
                activeRadius = pole.radius;
                activePoleName = pole.name;
            }
            if (dist <= pole.radius) {
                isInRange = true;
            }
        });

        const distInt = Math.round(minDistance);

        if (isInRange) {
            statusDiv.innerHTML = `<span class="text-success"><i class="mdi mdi-check-circle"></i> In Range! (Near: ${activePoleName})</span>`;
            statusDiv.className = "alert alert-success";
            
            // Enable Button
            if(btnIn) {
                btnIn.disabled = false;
                btnIn.classList.remove('btn-secondary');
                btnIn.classList.add('btn-success');
            }
            if(btnOut) {
                btnOut.disabled = false;
                btnOut.classList.remove('btn-secondary');
                btnOut.classList.add('btn-danger'); // Use logic color
            }
        } else {
            statusDiv.innerHTML = `<span class="text-danger"><i class="mdi mdi-close-circle"></i> Too Far! Nearest: ${distInt}m (Max: ${activeRadius}m)</span>`;
            statusDiv.className = "alert alert-danger";
            
            // Disable Button (Keep Check In default secondary, Check Out default danger but disabled)
             if(btnIn) btnIn.disabled = true;
             if(btnOut) btnOut.disabled = true;
        }
    }

    function error() {
        statusDiv.innerHTML = "Unable to retrieve your location. Please enable location access.";
        statusDiv.className = "alert alert-warning";
    }

    // Run on load
    window.onload = checkLocation;

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
