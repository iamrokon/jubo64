<!doctype html>
<html lang="en">

<head>

  <title>Add New Job Placement | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

  <style>
    .select2,
    .select2-container--default .select2-search--dropdown .select2-search__field {
      border: 1px solid rgb(21, 158, 65, 0.4) !important;
      border-radius: .25rem !important;
    }

    .select2-dropdown {
      border: 1px solid rgb(21, 158, 65, 0.4) !important;
      box-shadow: none !important;
    }

    .select2-container--default .select2-selection--single {
      border: none !important;
    }
  </style>

</head>

<body data-topbar="colored">

  <?php
  $errMSG = ""; // Initialize error message variable
  $success = false; // Flag to track success

  if (isset($_POST['submit'])) {
    $UserId = $_POST['UserId'];
    $StudentID = $_POST['StudentID'];
    $DistrictId = $_POST['DistrictId'];
    $BatchId = $_POST['BatchId'];
    $GroupId = $_POST['GroupId'];
    $Designation = $_POST['Designation'];
    $CompanyName = $_POST['CompanyName'];
    $Salary = $_POST['Salary'];
    $EntryDate = date('Y-m-d H:i:s');

    // Validation
    if (empty($CompanyName)) {
      $errMSG = "Please Enter Company Name.";
    } else {
      // Check if StudentID already exists
      $stmt1 = $DB_con->prepare("SELECT COUNT(*) FROM job_placement_dyd_48 WHERE student_id = :StudentID");
      $stmt1->bindParam(':StudentID', $StudentID);
      $stmt1->execute();
      if ($stmt1->fetchColumn() > 0) {
        $errMSG = "This Student Job Placement already exists!";
      }
    }

    // Proceed if no error
    if (empty($errMSG)) {
      $sql = "INSERT INTO job_placement_dyd_48 (user_id, student_id, district_id, group_id, batch_id, designation, company_name, salary, entry_date) 
            VALUES (:UserId, :StudentId, :DistrictId, :GroupId, :BatchId, :Designation, :CompanyName, :Salary, :EntryDate)";

      $stmt = $DB_con->prepare($sql);
      $stmt->bindParam(':UserId', $UserId);
      $stmt->bindParam(':StudentId', $StudentID);
      $stmt->bindParam(':DistrictId', $DistrictId);
      $stmt->bindParam(':GroupId', $GroupId);
      $stmt->bindParam(':BatchId', $BatchId);
      $stmt->bindParam(':Designation', $Designation);
      $stmt->bindParam(':CompanyName', $CompanyName);
      $stmt->bindParam(':Salary', $Salary);
      $stmt->bindParam(':EntryDate', $EntryDate);

      if ($stmt->execute()) {
        $success = true;
       echo '<script>alert("Data Successfully Added."); window.location.href = "job-placement-dyd-48";</script>';
        exit;
      } else {
        $errMSG = "Error while inserting data.";
      }
    }
  }
  ?>

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
                    <li class="breadcrumb-item active">Add Job Placement Information</li>
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
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-md-7 col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">

                      <!-- error message here -->
                      <div class="col-md-12">

                      </div>


                      <!-- Student Profile Column -->
                      <div class="col-md-4 text-center">
                        <?php
                        if (isset($_GET['add_id'])) {
                          $StudentId = (int) $_GET['add_id']; // Sanitize
                          $eq = mysqli_query($con, "
                          SELECT 
                            student_list.*, 
                            batch_list.batch_name, 
                            group_list.group_name, 
                            district.dist_name,
                            certificate_category.duration,
                            certificate_category.course_name
                          FROM student_list 
                          LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id 
                          LEFT JOIN group_list ON group_list.group_id = student_list.group_id
                          LEFT JOIN district ON district.id = student_list.district
                          LEFT JOIN certificate_category ON certificate_category.batch_id = student_list.batch_id
                          WHERE student_list.student_id = $StudentId
                        ");


                          if ($eq && mysqli_num_rows($eq) > 0) {
                            $eqrow = mysqli_fetch_assoc($eq); // fetch single row
                        ?>
                            <img src="user_images/<?= $eqrow['userPic'] ?>" class="img-fluid img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px;" />
                            <h3 class="m-0" style="border-bottom: 2px solid #ccc; padding-bottom: 5px;"><?= $eqrow['stu_name'] ?></h3>
                           <p class="mb-0 mt-2"><strong>Batch:</strong> <?= $eqrow['batch_name'] ?></p>
                            <p class="mb-0"><strong>Group:</strong> <?= $eqrow['group_name'] ?></p>
                            <p class="mb-0"><strong>District:</strong> <?= $eqrow['dist_name'] ?></p>
                            <!-- <p class="mb-0"><strong>Duration:</strong> <?= $eqrow['duration'] ?></p>
                           <p class="mb-0"><strong>Course:</strong> <?= $eqrow['course_name'] ?></p> -->
                        <?php
                          } else {
                            echo "<p class='text-danger'>Student not found.</p>";
                          }
                        } else {
                          echo "<p class='text-danger'>Invalid request.</p>";
                        }
                        ?>
                      </div>

                      <!-- Form Column -->
                      <div class="col-md-5" style="border-left: 2px solid #ccc;">
                        <h4 style="border-bottom: 2px solid #ccc; padding-bottom: 5px;">Job Placement Information</h4>
                        <?php if (!empty($errMSG)): ?>
                          <h4 class="text-danger"><?php echo $errMSG; ?></h4>
                        <?php endif; ?>
                        <form method="post" enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?add_id=<?= $StudentId ?>">
                          <?php
                          if (isset($_SESSION['id'])) {
                            $pq = mysqli_query($con, "SELECT * FROM stuff LEFT JOIN `user` ON user.userid = stuff.userid WHERE stuff.userid = '" . $_SESSION['id'] . "'");
                            if ($pq && mysqli_num_rows($pq) > 0) {
                              $pqrow = mysqli_fetch_assoc($pq);
                          ?>
                              <input type="hidden" name="UserId" value="<?= htmlspecialchars($pqrow['userid']) ?>">
                          <?php
                            }
                          }
                          ?>

                          <div class="form-group mb-3">
                            <!-- <label for="DistrictId" class="form-label"><strong>District:</strong> <?= $eqrow['dist_name'] ?></label> -->
                            <input type="hidden" class="form-control" name="DistrictId" id="DistrictId" value="<?= $eqrow['district'] ?? '' ?>" required>
                          </div>

                          <div class="form-group mb-3">
                            <label for="StudentID" class="form-label"><strong>Student ID:</strong> <?= $eqrow['student_id'] ?> </label>
                            <input type="hidden" class="form-control" name="StudentID" value="<?= $eqrow['student_id'] ?? '' ?>" required>
                          </div>

                          <div class="form-group mb-3">
                            <!-- <label for="BatchId" class="form-label"><strong>Batch:</strong> <?= $eqrow['batch_name'] ?></label> -->
                            <input type="hidden" class="form-control" name="BatchId" value="<?= $eqrow['batch_id'] ?? '' ?>" required>
                          </div>

                          <div class="form-group mb-3">
                            <!-- <label for="GroupId" class="form-label"><strong>Group:</strong> <?= $eqrow['group_name'] ?></label> -->
                            <input type="hidden" class="form-control" name="GroupId" value="<?= $eqrow['group_id'] ?? '' ?>" required>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TrainerId" class="form-label"><strong>Duration:</strong> <?= $eqrow['duration'] ?></label>
                            <!-- <input type="text" class="form-control" name="CategoryId" value="<?= $eqrow['c_c_id'] ?? '' ?>" required> -->
                          </div>

                          <div class="form-group mb-3">
                            <label for="TrainerId" class="form-label"><strong>Course:</strong> <?= $eqrow['course_name'] ?></label>
                            <!-- <input type="text" class="form-control" name="Duration" value="<?= $eqrow['course_name'] ?? '' ?>" required> -->
                          </div>

                          <div class="form-group mb-3">
                            <label for="Designation" class="form-label"><strong>Designation:</strong></label>
                            <input type="text" class="form-control" name="Designation" placeholder="Designation" value="" required>
                          </div>
                          <div class="form-group mb-3">
                            <label for="CompanyName" class="form-label"><strong>Company Name:</strong></label>
                            <input type="text" class="form-control" name="CompanyName" placeholder="Company Name" value="" required>
                          </div>
                          <div class="form-group mb-3">
                            <label for="Salary" class="form-label"><strong>Salary:</strong></label>
                            <input type="number" class="form-control" name="Salary" placeholder="Salary" value="" required>
                          </div>

                          <a href="job-placement-dyd-48" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                          <button type="submit" name="submit" class="btn btn-success waves-effect"><i class="fa fa-save me-2"></i>Save Now</button>
                        </form>
                      </div>

                    </div> <!-- row -->
                  </div> <!-- card-body -->
                </div> <!-- card -->
              </div> <!-- col -->
            </div> <!-- row -->
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