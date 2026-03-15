<!doctype html>
<html lang="en">

<head>

    <title>User Students | e-Learning & Earning Ltd.</title>

    <?php include "header-link.php" ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="css/table_data_center.css"> -->

    <style>
        .dataTables_wrapper .row:nth-child(2) {
            overflow-x: scroll;
        }

        .dataTables_wrapper .row:nth-child(2) table {
            width: 1560px !important;
        }
    </style>

</head>

<body data-topbar="colored">
    <div id="layout-wrapper">

        <!-- ========== Header Start ========== -->
        <?php include "header.php" ?>
        <!-- ========== Header End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include "sidebar.php" ?>
        <!-- ========== Left Sidebar End ========== -->
        <!-- ========== Main Content Start ========== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <div class="page-title">
                                    <h4 class="mb-0 font-size-18">Dashboard</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">All User Student Lists</li>
                                    </ol>
                                </div>
                                <div class="state-information d-none d-sm-block">
                                    <div class="state-graph">
                                        <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                                    </div>
                                    <div class="state-graph">
                                        <div id="header-chart-2" data-colors='["--bs-danger"]'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Start Page-content-Wrapper -->
                    <div class="page-content-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header border-bottom py-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="card-title m-0">All User Student Lists</h4>
                                            <div>
                                                <div class="gap-5">
                                                    <!-- Old Student Modal Trigger -->
                                                    <!-- <button class="btn btn-danger btn-sm oldadd" data-bs-toggle="modal" data-bs-target="#oldadddealer">
                                                        <i class="fa fa-plus-circle"></i> Add Student User
                                                    </button> -->

                                                    <!-- New Student Modal Trigger -->
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adddealer">
                                                        <i class="fa fa-plus-circle"></i> Add New User Student
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                

                                    <div class="row mb-4 mt-3">
                                        <div class="col-xl-8 mx-auto">
                                            <form action="" method="get">
                                                <div class="row align-items-center justify-content-center">
                                                    <div class="col-md-12 text-center mb-3">
                                                        <h3 class="m-0"> Batch & Group Wise Reports </h3>
                                                    </div>

                                                    <div class="col-md-6 col-lg-3 my-2">
                                                        <select id="Batch" name="batch_id" class="form-control form-select">
                                                            <option value="">Select Batch</option>
                                                            <?php
                                                            $sql = "SELECT * FROM batch_list ORDER BY batch_id DESC";
                                                            $result = $con->query($sql);
                                                            while ($row = $result->fetch_assoc()) {
                                                                $selected = (isset($_GET['batch_id']) && $_GET['batch_id'] == $row['batch_id']) ? 'selected' : '';
                                                                echo "<option value='" . $row['batch_id'] . "' $selected>" . $row['batch_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 col-lg-3 my-2">
                                                        <select id="Group" name="group_id" class="form-control form-select">
                                                            <option value="">Select Group</option>
                                                            <?php
                                                            $sql = "SELECT * FROM group_list";
                                                            $result = $con->query($sql);
                                                            while ($row = $result->fetch_assoc()) {
                                                                $selected = (isset($_GET['group_id']) && $_GET['group_id'] == $row['group_id']) ? 'selected' : '';
                                                                echo "<option value='" . $row['group_id'] . "' $selected>" . $row['group_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 col-lg-3 my-2">
                                                        <button type="submit" class="btn btn-primary w-100 waves-effect">Filter List</button>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-lg-3 my-2 d-none">
                                                        <a id="reportLink" target="_blank" class="btn btn-success w-100 waves-effect">Open Report</a>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-lg-3 my-2">
                                                        <button type="button" class="btn btn-info w-100 waves-effect text-white" onclick="exportTableToExcel('datatable', 'Student_User_List')">
                                                            <i class="fa fa-file-excel"></i> Export Excel
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>

                                            <?php
                                            // Summary Logic
                                            $summary_where = "WHERE student_list.district = " . $_SESSION['id'];
                                            if (!empty($_GET['batch_id'])) {
                                                $summary_where .= " AND student_list.batch_id = " . mysqli_real_escape_string($con, $_GET['batch_id']);
                                            }
                                            if (!empty($_GET['group_id'])) {
                                                $summary_where .= " AND student_list.group_id = " . mysqli_real_escape_string($con, $_GET['group_id']);
                                            }

                                            $sum_q = mysqli_query($con, "
                                                SELECT 
                                                    COUNT(student_list.student_id) as total,
                                                    SUM(CASE WHEN student_user.status = 1 THEN 1 ELSE 0 END) as active,
                                                    SUM(CASE WHEN student_user.status = 2 THEN 1 ELSE 0 END) as dropout,
                                                    SUM(CASE WHEN student_user.status = 3 THEN 1 ELSE 0 END) as block
                                                FROM student_list 
                                                LEFT JOIN student_user ON student_user.userid = student_list.stu_user_id
                                                $summary_where
                                            ");
                                            $summary = mysqli_fetch_assoc($sum_q);
                                            ?>

                                            <div class="row mt-4 justify-content-center">
                                                <div class="col-md-3">
                                                    <div class="card bg-primary text-white text-center p-3 mb-2 rounded shadow-sm">
                                                        <h6 class="m-0">Total Students</h6>
                                                        <h3 class="m-0"><?= (int)$summary['total'] ?></h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white text-center p-3 mb-2 rounded shadow-sm">
                                                        <h6 class="m-0">Active Students</h6>
                                                        <h3 class="m-0"><?= (int)$summary['active'] ?></h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white text-center p-3 mb-2 rounded shadow-sm">
                                                        <h6 class="m-0">Drop Out</h6>
                                                        <h3 class="m-0"><?= (int)$summary['dropout'] ?></h3>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white text-center p-3 mb-2 rounded shadow-sm">
                                                        <h6 class="m-0">Block</h6>
                                                        <h3 class="m-0"><?= (int)$summary['block'] ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                    <div class="row mt-3">
                                        <div class="col-12">

                                            <table id="datatable" class="table table-bordered table-hover align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>ID</th>
                                                        <th>Batch</th>
                                                        <th>Group</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <!-- <th>Password</th> -->
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $where_clause = "WHERE student_list.district = " . $_SESSION['id'];
                                                    
                                                    if (!empty($_GET['batch_id'])) {
                                                        $where_clause .= " AND student_list.batch_id = " . mysqli_real_escape_string($con, $_GET['batch_id']);
                                                    }
                                                    if (!empty($_GET['group_id'])) {
                                                        $where_clause .= " AND student_list.group_id = " . mysqli_real_escape_string($con, $_GET['group_id']);
                                                    }

                                                    $dq = mysqli_query($con, "
                                                                             SELECT 
                                                                                 student_list.student_id,
                                                                                 student_list.stu_user_id,
                                                                                 student_list.district,
                                                                                 student_list.batch_id, 
                                                                                 student_list.group_id, 
                                                                                 student_list.stu_name, 
                                                                                 student_list.contact, 
                                                                                 student_list.email,
                                                                                 student_user.password,
                                                                                 student_user.status,
                                                                                 batch_list.batch_name,
                                                                                 group_list.group_name,
                                                                                 student_password.mdfive
                                                                             FROM student_list 
                                                                             LEFT JOIN student_user ON student_user.userid = student_list.stu_user_id
                                                                             LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                                                                             LEFT JOIN group_list ON group_list.group_id = student_list.group_id
                                                                             LEFT JOIN student_password ON student_password.passwordid = student_list.stu_user_id
                                                                             $where_clause
                                                                             ORDER BY student_list.student_id DESC
                                                                             ");

                                                    $i = 1;

                                                    while ($dqrow = mysqli_fetch_array($dq)) {
                                                        $did = $dqrow['student_id'];
                                                    ?>
                                                        <tr>

                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo ucwords($dqrow['student_id']); ?> </td>
                                                            <td><?php echo ucwords($dqrow['batch_name']); ?> </td>
                                                            <td><?php echo ucwords($dqrow['group_name']); ?> </td>
                                                            <td><?php echo ucwords($dqrow['stu_name']); ?> </td>
                                                            <td><?php echo $dqrow['contact']; ?> </td>
                                                            <td><?php echo $dqrow['email']; ?> </td>
                                                            <!-- <td>
                                                                 <?php
                                                                 $pass = mysqli_query($con, "select * from `student_password` where mdfive='" . $dqrow['password'] . "'");
                                                                 $passrow = mysqli_fetch_array($pass);
                                                                 echo $passrow['original'];

                                                                 ?>
                                                             </td> -->
                                                            <td>
                                                                <select class="form-select form-select-sm status-dropdown" data-id="<?php echo $dqrow['stu_user_id']; ?>" style="width: 120px;">
                                                                    <option value="1" <?php if ($dqrow['status'] == 1) echo 'selected'; ?>>Active</option>
                                                                    <option value="2" <?php if ($dqrow['status'] == 2) echo 'selected'; ?>>Drop Out</option>
                                                                    <option value="3" <?php if ($dqrow['status'] == 3) echo 'selected'; ?>>Block</option>
                                                                </select>
                                                            </td>

                                                        </tr>
                                                    <?php
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
            <?php include('stu_modal.php'); ?>
            <?php include('user_old_stu_add_modal.php'); ?>
            <?php include('user_stu_add_modal.php'); ?>
            <!-- ========== Footer Start ========== -->
            <?php include "footer.php" ?>
            <!-- ========== Footer End ========== -->
        </div>
        <!-- ========== Main Content End ========== -->

    </div>
    <!-- END layout-wrapper -->

    <?php include "script.php" ?>
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            $('#datatable').dataTable({
                "destroy": true,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
            });
        });

        $(document).on('change', '.status-dropdown', function() {
            var status = $(this).val();
            var stu_user_id = $(this).data('id');
            var selector = $(this);

            $.ajax({
                url: 'update_user_status.php',
                type: 'POST',
                data: {
                    status: status,
                    stu_user_id: stu_user_id
                },
                success: function(response) {
                    if (response.trim() == 'success') {
                        alert('Status updated successfully!');
                    } else {
                        alert('Failed to update status: ' + response);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        document.getElementById("reportLink").addEventListener('click', function(event) {
            var distId = "<?= $_SESSION['id'] ?>";
            var batchId = document.getElementById("Batch").value;
            var groupId = document.getElementById("Group").value;

            if (distId && batchId && groupId) {
                this.href = "student-information-report-by-students?dist_id=" + distId + "&batch_id=" + batchId + "&group_id=" + groupId;
            } else if (distId && batchId) {
                this.href = "student-information-report-by-students?dist_id=" + distId + "&batch_id=" + batchId;
            } else {
                alert("Please select at least a Batch to open the report.");
                event.preventDefault();
            }
        });

        function exportTableToExcel(tableID, filename = '') {
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
            filename = filename ? filename + '.xls' : 'excel_data.xls';
            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            
            if (navigator.msSaveOrOpenBlob) {
                var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
            }
        }
    </script>
</body>

</html>