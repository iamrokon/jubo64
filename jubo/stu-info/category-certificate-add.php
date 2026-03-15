<!doctype html>
<html lang="en">

<head>

  <title>Add New Settings | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

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
                    <li class="breadcrumb-item active">Add New Settings</li>
                  </ol>
                </div>

                <div class="state-information d-none d-sm-block">
                  <div class="state-graph">
                    <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                    <div class="info">Balance $ 2,317</div>
                  </div>
                  <div class="state-graph">
                    <div id="header-chart-2" data-colors='["--bs-danger"]'></div>
                    <div class="info">Item Sold 1230</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->


          <?php

          error_reporting(~E_NOTICE); // avoid notice

          if (isset($_POST['btnsave'])) {
            $user_id = $_POST['user_id'];

            $BatchId = $_POST['BatchId'];
            $Duration = $_POST['Duration'];
            $CourseName = $_POST['CourseName'];

           


            if (empty($Duration)) {
              $errMSG = "Please Enter  Duration.";
            } else


            // if no error occured, continue ....
            if (!isset($errMSG)) {
              $stmt = $DB_con->prepare('INSERT INTO certificate_category (user_id, batch_id, duration, course_name) 
															VALUES(:user_id, :BatchId, :Duration, :CourseName)');

              $stmt->bindParam(':user_id', $user_id);

              $stmt->bindParam(':BatchId', $BatchId);
              $stmt->bindParam(':Duration', $Duration);
              $stmt->bindParam(':CourseName', $CourseName);


              if ($stmt->execute()) {
          ?>
                <script>
                  alert('Data Successfully Add ...');
                  window.location.href = 'category-certificate';
                </script>
          <?php
              } else {
                $errMSG = "error while inserting....";
              }
            }
          }
          ?>

          <!-- Start Page-content-Wrapper -->
          <div class="page-content-wrapper" style="margin-top: -0px !important;">
            <div class="row">
              <div class="col-6">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Add New Settings</h4>
                  </div>
                  <div class="card-body">

                    <?php
                    if (isset($errMSG)) {
                      echo '<div class="alert alert-danger">' . $errMSG . '</div>';
                    } else if (isset($successMSG)) {
                      echo '<div class="alert alert-success">' . $successMSG . '</div>';
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data">

                      <div class="row">
                        <div class="col-md-6 mb-3">
						  <?php
                          $pq = mysqli_query($con, "select * from user where userid='" . $_SESSION['id'] . "' ");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
                          <input class="form-control" type="hidden" name="user_id" value="<?php echo $pqrow['userid']; ?>" />
						  <?php } ?>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">Batch</label>
                         <select class="form-select" name="BatchId" required>
                              <?php
                              $sql = "SELECT * FROM batch_list";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row['batch_id'] . "'>" . $row['batch_name'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">Duration</label>
                            <input class="form-control" type="text" name="Duration" value="3 Months ( 01-01-2025 To 31-03-2025)" placeholder="3 Months ( 01-01-2025 To 31-03-2025)" />
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">Course Name</label>
                            <input class="form-control" type="text" name="CourseName" value="Freelancing Training Course" placeholder="Freelancing Training Course" />
                          </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                            <a href="category-certificate" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                            <button type="submit" name="btnsave" class="btn btn-success waves-effect"><i class="fa fa-save me-2"></i>Add Now</button>
                          </div>
                        </div>

                     
                      </div>

                    </form>



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