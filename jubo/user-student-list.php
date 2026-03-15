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
                                                    <button class="btn btn-danger btn-sm oldadd" data-bs-toggle="modal" data-bs-target="#oldadddealer">
                                                        <i class="fa fa-plus-circle"></i> Add Old Student User
                                                    </button>

                                                    <!-- New Student Modal Trigger -->
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adddealer">
                                                        <i class="fa fa-plus-circle"></i> Add New User Student
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="m-0">

                                    <!-- /.row -->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            
                                            <table id="datatable" class="table table-bordered table-hover align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>SLs</th>
                                                        <th>Batch</th>
                                                        <th>Group</th>
                                                        <th>Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>Password</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                   $dq = mysqli_query($con, "
                                                                            SELECT DISTINCT 
                                                                                student_list.student_id,
                                                                                student_list.stu_user_id,
                                                                                student_list.district,
                                                                                student_list.batch_id, 
                                                                                student_list.group_id, 
                                                                                student_list.stu_name, 
                                                                                student_list.contact, 
                                                                                student_list.email,
                                                                                student_user.password,
                                                                                batch_list.batch_name,
                                                                                group_list.group_name,
                                                                                student_password.original
                                                                            FROM student_list 
                                                                            LEFT JOIN student_user ON student_user.userid = student_list.stu_user_id
                                                                            LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                                                                            LEFT JOIN group_list ON group_list.group_id = student_list.group_id
                                                                            LEFT JOIN student_password ON student_password.passwordid  = student_list.stu_user_id
                                                                            WHERE student_list.district = " . $_SESSION['id'] . "
                                                                            ORDER BY student_list.student_id DESC
                                                                            ");

                                                    $i = 1;

                                                    while ($dqrow = mysqli_fetch_array($dq)) {
                                                        $did = $dqrow['student_id'];
                                                    ?>
                                                        <tr>
                                                         
                                                             <td><?php echo $i++; ?></td>
                                                            <td><?php echo ucwords($dqrow['batch_name']); ?> </td>
                                                            <td><?php echo ucwords($dqrow['group_name']); ?> </td>
                                                            <td><?php echo ucwords($dqrow['stu_name']); ?> </td>
                                                            <td><?php echo $dqrow['contact']; ?> </td>
                                                            <td><?php echo $dqrow['email']; ?> </td>
                                                            <td><?php echo $dqrow['original']; ?> </td>
                                                           
                                                          
                                                            <td>
                                                                <a href="#update<?php echo $did; ?>" data-bs-toggle="modal" class="btn btn-success btn-sm">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delemp_<?php echo $did; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <?php include('user_stu_edit_modal.php'); ?>
                                                                <?php include('user_stu_delete_modal.php'); ?>
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
</body>

</html>

  <script>
    $('#datatable').dataTable({
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      // "lengthMenu": [20, 50, 100],
      // "pageLength": 50,
    });
  </script>