<?php include('session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Attendance Report - E-Learning & Earning LTD</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

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
    <!-- End Header -->

    <main id="main">

        <!-- ======= About Us Section ======= -->
        <section id="about-us" class="about-us mt-5">
            <div class="container" data-aos="fade-left">

                <div class="row content">
                   
                    <div class="col-lg-12 mt-3" data-aos="fade-left">
                        <div class="shadow rounded p-2">
                             <?php  include('attendance-report.php'); ?>
                        </div>
                    </div>


                    <div class="col-lg-12 mt-3" data-aos="fade-left">
                        <div class="card shadow rounded">
                            <div class="card-header bg-white py-3">
                                <?php
                                $dist_id = isset($_GET['DistId']) ? $_GET['DistId'] : '';
                                $batch_id = isset($_GET['Batch']) ? $_GET['Batch'] : '';
                                $group_id = isset($_GET['Group']) ? $_GET['Group'] : '';
                                $sys_start_date = '2026-02-26';
                                $start_date = isset($_GET['StartDate']) ? $_GET['StartDate'] : date('Y-m-d');
                                $end_date = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');
                                if(strtotime($start_date) < strtotime($sys_start_date)) $start_date = $sys_start_date;


                                // Fetch Names
                                $distName = "Unknown District";
                                $batchName = "Unknown Batch";
                                $groupName = "All Groups";

                                if ($dist_id) {
                                    $dq = mysqli_query($con, "SELECT dist_name FROM district WHERE id='$dist_id'");
                                    if ($r = mysqli_fetch_array($dq)) $distName = $r['dist_name'];
                                }
                                if ($batch_id) {
                                    $bq = mysqli_query($con, "SELECT batch_name FROM batch_list WHERE batch_id='$batch_id'");
                                    if ($r = mysqli_fetch_array($bq)) $batchName = $r['batch_name'];
                                }
                                if ($group_id) {
                                    $gq = mysqli_query($con, "SELECT group_name FROM group_list WHERE group_id='$group_id'");
                                    if ($r = mysqli_fetch_array($gq)) $groupName = $r['group_name'];
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
                                
                                <div class="text-center">
                                    <h3 class="mb-2">Attendance Report Result</h3>
                                    <h5 class="text-primary"><?= $distName ?> | <?= $batchName ?> | <?= $groupName ?></h5>
                                    <h6>From: <?= date('d M Y', strtotime($start_date)) ?> To: <?= date('d M Y', strtotime($end_date)) ?></h6>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                
                                <?php if($dist_id && $batch_id): ?>

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
                                                <th>Distance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // 1. Get all students in this criteria
                                            $studentQuery = "SELECT student_list.*, group_list.group_name FROM student_list 
                                                             LEFT JOIN group_list ON student_list.group_id = group_list.group_id
                                                             WHERE district='$dist_id' AND batch_id='$batch_id'";
                                            if ($group_id) $studentQuery .= " AND student_list.group_id='$group_id'";
                                            $studentsResult = mysqli_query($con, $studentQuery);

                                            // Store students in array
                                            $students = [];
                                            while ($row = mysqli_fetch_array($studentsResult)) {
                                                $students[] = $row;
                                            }

                                            if (count($students) > 0) {
                                                $i = 1;

                                                // Loop through Date Range (Starting from system start date)
                                                $currentDate = (strtotime($start_date) < strtotime($sys_start_date)) ? $sys_start_date : $start_date;
                                                while (strtotime($currentDate) <= strtotime($end_date)) {

                                                    foreach ($students as $std) {
                                                        $stuId = $std['stu_user_id'];
                                                        // Use student_id (numeric) for view link if needed, or stu_user_id
                                                        $viewId = $std['student_id'];

                                                        // 2. Check attendance for this student on this date
                                                        $attQ = mysqli_query($con, "SELECT * FROM attendance WHERE student_id='$stuId' AND att_date='$currentDate'");
                                                        $att = mysqli_fetch_array($attQ);

                                                        if ($att) {
                                                            $status = '<span class="badge bg-success text-white">Present</span>';
                                                            $checkIn = date('h:i A', strtotime($att['check_in']));
                                                            $checkOut = isset($att['check_out']) && $att['check_out'] ? date('h:i A', strtotime($att['check_out'])) : '-';
                                                        } else {
                                                            $day_name = date('l', strtotime($currentDate));
                                                            $is_weekend = ($day_name == 'Friday' || $day_name == 'Saturday');
                                                            $is_holiday = in_array($currentDate, $bd_holidays);

                                                            if($is_weekend || $is_holiday){
                                                                $status = '<span class="badge bg-info text-white">Holiday</span>';
                                                            } else {
                                                                $status = '<span class="badge bg-danger text-white">Absent</span>';
                                                            }
                                                            $checkIn = '-';
                                                            $checkOut = '-';
                                                        }
                                            ?>
                                                        <tr>
                                                            <td><?= $i++ ?></td>
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
                                                                <?php if (isset($att['lat']) && $att['lat']): ?>
                                                                    <a href="https://maps.google.com/?q=<?= $att['lat'] ?>,<?= $att['lng'] ?>" target="_blank" class="btn btn-sm btn-info text-white"><i class="fa fa-map-marker"></i> Loc</a>
                                                                <?php else: ?>
                                                                    -
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <a href="attendance-student-view?student_id=<?= $viewId ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                    // Increment Date
                                                    $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>No Students Found in this Batch/Group</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php else: ?>
                                    <h4 class="text-center text-danger">Please select District and Batch to view the report.</h4>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <?php include('footer.php'); ?>
    
    <script>
        // Simple export to excel if needed, or DataTables
        function exportTableToExcel(tableID, filename = '') {
           // ... (same as admin if needed)
        }
    </script>
</body>

</html>
