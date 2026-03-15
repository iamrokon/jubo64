<!doctype html>
<html lang="en">

<head>

  <title>Settings Certificate | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<?php
if (isset($_GET['delete_id'])) {

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM certificate_category WHERE  c_c_id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();

  //header("Location:customer.php");
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
          <div class="page-content-wrapper" style="margin-top: -0px !important;">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <h4 class="card-title m-0">All Settings Lists</h4>
                      <a href="category-certificate-add" class="btn btn-success waves-effect"><i class="fa fa-plus me-2"></i>Add New Settings</a>
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">
                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Batch</th>
                          <th>Duration</th>
                          <th>Course Name </th>
                          <th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        $sl = 0;
                      $sql = mysqli_query($con, "
                            SELECT certificate_category.*, batch_list.batch_name 
                            FROM certificate_category 
                            LEFT JOIN batch_list ON certificate_category.batch_id = batch_list.batch_id 
                            WHERE certificate_category.user_id = '" . $_SESSION['id'] . "' 
                            ORDER BY certificate_category.c_c_id DESC
                        ");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                          <tr>

                            <td><?= ++$sl ?></td>
                            <td><?= $row['batch_name'] ?></td>
                            <td><?= $row['duration'] ?></td>
                            <td><?= $row['course_name'] ?></td>
                            <td>
                              <a class="btn btn-success waves-effect" href="category-certificate-edit?edit_id=<?= $row['c_c_id'] ?>" title="click for edit"><i class="fa fa-edit me-1"></i> Edit</a>
                              <a class="btn btn-danger waves-effect d-none" href="?delete_id=<?= $row['c_c_id'] ?>" title="click for delete" onclick="return confirm('Are You Sure To Delete ?')"><i class="fa fa-trash me-1"></i> Delete</a>
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
</body>

</html>