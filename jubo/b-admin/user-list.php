<!doctype html>
<html lang="en">

<head>

  <title>User List | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

  <style>
    .dataTables_wrapper .row:nth-child(2) {
      overflow-x: scroll;
    }

    .dataTables_wrapper .row:nth-child(2) table {
      width: 1560px !important;
    }
  </style>

</head>

<?php

if (isset($_GET['delete_id'])) {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT userPic FROM student_list WHERE student_id =:uid');
  $stmt_select->execute(array(':uid' => $_GET['delete_id']));
  $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
  unlink("user_images/" . $imgRow['userPic']);

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM student_list WHERE student_id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

?>

<body data-topbar="colored">

  <!-- <body data-layout="horizontal" data-topbar="colored"> -->

  <!-- Begin page -->
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
                    <li class="breadcrumb-item active">Welcome to E-Learning & Earning Ltd.</li>
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
                      <h4 class="card-title m-0">User List</h4>
                      <!-- <a href="student-add" class="btn btn-success waves-effect"><i class="fa fa-plus me-2"></i>Add New Student</a> -->
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">

                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>Id No</th>
                          <th>Branch Name</th>
                          <!-- <th>Position</th> -->
                          <th>User Name</th>
                          <th>Password</th>
                          <th>Photo</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php
								$dq=mysqli_query($con,"select * from stuff left join `user` on user.userid=stuff.userid  where stuff.status='1' and user.access_level=2 order by stuff.userid asc");
								while($dqrow=mysqli_fetch_array($dq)){
									$did=$dqrow['userid'];
								?>
								<tr>
									<td><?php echo ucwords($dqrow['userid']); ?> </td>
									<td><?php echo ucwords($dqrow['stuff_name']); ?> </td>
									<!-- <td><?php echo ucwords($dqrow['position']); ?> </td> -->
									<td><?php echo $dqrow['username']; ?></td>
									<td>
										<?php
											$pass=mysqli_query($con,"select * from `password` where mdfive='".$dqrow['password']."'");
											$passrow=mysqli_fetch_array($pass);
												
											echo $passrow['original'];
										?>
									</td>
									
									<td><img src="../<?php if($dqrow['photo']==""){echo "/img/user.jpg";}else{echo $dqrow['photo'];} ?>" height="30px;" width="30px;"></td>
									 
									
								</tr>
								<?php
								}
							?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- End Page-content -->

        </div>
      </div>


      <!-- ========== Footer Start ========== -->
      <?php include "footer.php" ?>
      <!-- ========== Footer End ========== -->
    </div>
    <!-- ========== Main Content End ========== -->

  </div>
  <!-- END layout-wrapper -->



  <?php include "script.php" ?>


  <script>
    $('#datatable').dataTable({
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      // "lengthMenu": [20, 50, 100],
      // "pageLength": 50,
      //"lengthChange": false,
      //"searching": false,
    });
  </script>

</body>

</html>