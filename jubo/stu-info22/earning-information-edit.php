<!doctype html>
<html lang="en">

<head>

  <title>Earning Report | e-Learning & Earning Ltd.</title>

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
  // Check if edit_id is set and not empty
  if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $evidence_id = $_GET['edit_id'];

    // Assuming $DB_con is your PDO database connection
    $stmt_edit = $DB_con->prepare('SELECT * FROM income_info WHERE in_id = :uid');
    $stmt_edit->execute(array(':uid' => $evidence_id));

    // Fetch the row
    if ($edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC)) {
      // Extracting variables from the fetched row
      extract($edit_row);
    } else {
      // Redirect if no record found
      header("Location: index.php");
      exit(); // Exit after redirect
    }
  } else {
    // Redirect if edit_id is not set
    header("Location: index.php");
    exit(); // Exit after redirect
  }

  // Check if form is submitted
  if (isset($_POST['submit'])) {
    // Now handle other form fields
    $UserId = $_POST['UserId'];
    $StudentID = $_POST['StudentID'];
    $EarningDate = $_POST['EarningDate'];
    $WorkSource = $_POST['WorkSource'] ?? null;
    $PaymentMethod = $_POST['PaymentMethod'] ?? null;
    $TotalDollar = $_POST['TotalDollar'] ?? null;
    $TotalBD = $_POST['TotalBD'] ?? null;
    $Job = $_POST['Job'] ?? null;

    // Prepare the SQL query for updating other fields
    $sql = "UPDATE income_info SET user_id = :UserId, studentID = :StudentID, earning_date = :EarningDate,
      work_source = :WorkSource, payment_type = :PaymentMethod, earning_dollar = :TotalDollar, earning_bd = :TotalBD, job_id = :Job, 
      status = 1 WHERE in_id = :IncomeId";

    // Prepare statement
    $stmt = $DB_con->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':UserId', $UserId);
    $stmt->bindParam(':StudentID', $StudentID);
    $stmt->bindParam(':EarningDate', $EarningDate);
    $stmt->bindParam(':WorkSource', $WorkSource);
    $stmt->bindParam(':PaymentMethod', $PaymentMethod);
    $stmt->bindParam(':TotalDollar', $TotalDollar);
    $stmt->bindParam(':TotalBD', $TotalBD);
    $stmt->bindParam(':Job', $Job);
    $stmt->bindParam(':IncomeId', $evidence_id);

    // Execute the query for updating other fields
    if ($stmt->execute()) {
      // File upload handling
      if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = 'income_images/'; // upload directory
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // Unlink old images associated with the record
        $old_images = explode(",", $incomePics);
        foreach ($old_images as $old_image) {
          if (!empty($old_image)) {
            unlink($old_image);
          }
        }

        $imagePaths = [];

        foreach ($_FILES['images']['name'] as $key => $imgFile) {
          $tmp_dir = $_FILES['images']['tmp_name'][$key];
          $imgSize = $_FILES['images']['size'][$key];
          $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
          $userpic = "e-laeltd-" . rand(9999, 9999999) . $imgFile; // rename uploading image

          // Validate image file
          if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {
              // Move uploaded file to directory
              if (move_uploaded_file($tmp_dir, $upload_dir . $userpic)) {
                $imagePaths[] = $upload_dir . $userpic; // Collect the image paths
              } else {
                $errMSG = "Error while uploading file: " . $imgFile;
                break;
              }
            } else {
              $errMSG = "Sorry, your file is too large: " . $imgFile;
              break;
            }
          }
        }

        // If new images were uploaded, update image paths in the database
        if (!empty($imagePaths)) {
          $upicImploded = implode(",", $imagePaths); // Implode image paths into a string

          // Prepare SQL query for updating image paths
          $sql_img = "UPDATE income_info SET incomePics = :upic WHERE in_id = :IncomeId";

          // Prepare statement for updating image paths
          $stmt_img = $DB_con->prepare($sql_img);

          // Bind parameters for image paths update
          $stmt_img->bindParam(':upic', $upicImploded);
          $stmt_img->bindParam(':IncomeId', $evidence_id);

          // Execute the query for updating image paths
          $stmt_img->execute();
        }
      }

      // Redirect after successful update
      echo '<script>alert("Data Successfully Update."); window.location.href = window.location.href;</script>';
      exit; // Exit after redirect
    } else {
      $errMSG = "Error while updating data.";
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
                    <li class="breadcrumb-item active">All Trainers</li>
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

                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-4 text-center">
                        <?php
                        $StudentId = $edit_row['student_id'];
                        $eq = mysqli_query($con, "SELECT * FROM student_list WHERE student_id= $StudentId");
                        while ($eqrow = mysqli_fetch_array($eq)) {
                        ?>
                          <img src="user_images/<?= $eqrow['userPic'] ?>" class="img-fluid img-thumbnail rounded-circle mb-3" height="120px;" width="120px;" />
                          <h3 class="m-0"> <?= $eqrow['stu_name'] ?></h3>
                          <hr>
                          <p class="font-size-15"> <?= $eqrow['about'] ?></p>
                        <?php } ?>
                      </div>

                      <div class="col-md-5">
                        <form method="post" enctype="multipart/form-data">
                          <?php
                          $pq = mysqli_query($con, "SELECT * FROM stuff LEFT JOIN `user` ON user.userid=stuff.userid WHERE stuff.userid='" . $_SESSION['id'] . "'");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
                            <input type="hidden" name="UserId" value="<?php echo $pqrow['userid']; ?>">
                          <?php } ?>

                          <div class="form-group mb-3">
                            <label for="StudentID" class="form-label">Student ID</label>
                            <input type="text" class="form-control" name="StudentID" id="StudentID" value="<?= $edit_row['studentID'] ?>" placeholder="Enter student ID number" required>
                          </div>

                          <div class="form-group" style="display: none;">
                            <label for="EarningDate" class="form-label">Earning Date</label>
                            <input type="date" class="form-control" name="EarningDate" id="EarningDate" value="<?= $edit_row['earning_date'] ?>">
                          </div>


                          <div class="form-group mb-3">
                            <label for="WorkSource" class="form-label">Earning Platform</label>
                            <select name="WorkSource" id="WorkSource" class="form-control select2">
                              <option disabled selected>-- Selected Earning Platform --</option>
                              <?php
                              $eq = mysqli_query($con, "SELECT * FROM work_source ORDER BY ws_id DESC");
                              while ($eqrow = mysqli_fetch_array($eq)) {
                              ?>
                                <option value="<?= $eqrow['ws_id'] ?>" <?= $edit_row['work_source'] == $eqrow['ws_id'] ? 'selected' : '' ?>> <?= $eqrow['work_name'] ?> </option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group mb-3">
                            <label for="PaymentMethod" class="form-label">Payment Method</label>
                            <select name="PaymentMethod" id="PaymentMethod" class="form-control select2">
                              <option disabled selected>-- Selected Payment Meathod --</option>
                              <?php
                              $eq = mysqli_query($con, "SELECT * FROM payment_method ORDER BY pm_id DESC");
                              while ($eqrow = mysqli_fetch_array($eq)) {
                              ?>
                                <option value="<?= $eqrow['pm_id'] ?>" <?= $edit_row['payment_type'] == $eqrow['pm_id'] ? 'selected' : '' ?>> <?= $eqrow['payment_name'] ?> </option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>


                          <div class="form-group mb-3">
                            <label for="Job" class="form-label">Jobs</label>
                            <select name="Job" id="Job" class="form-control select2">
                              <option disabled selected>-- Selected Job --</option>
                              <?php
                              $eq = mysqli_query($con, "SELECT * FROM jobs ORDER BY j_id DESC");
                              while ($eqrow = mysqli_fetch_array($eq)) {
                              ?>
                                <option value="<?= $eqrow['j_id'] ?>" <?= $edit_row['job_id'] == $eqrow['j_id'] ? 'selected' : '' ?>> <?= $eqrow['job_name'] ?> </option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TotalDollar" class="form-label">Total Earning Dollar ($)</label>
                            <input type="number" class="form-control" name="TotalDollar" id="TotalDollar" placeholder="Enter total earning Dollar ($)" value="<?= $edit_row['earning_dollar'] ?>">
                          </div>

                          <div class="form-group mb-3">
                            <label for="TotalBD" class="form-label">Total Earning (BD.TK)</label>
                            <input type="number" class="form-control" name="TotalBD" id="TotalBD" placeholder="Enter total earning BD.TK" value="<?= $edit_row['earning_bd'] ?>">
                          </div>

                          <div class="form-group mb-3 text-left">
                            <label for="image" class="form-label">Image</label>
                            <div class="d-flex" style="margin-bottom: 8px;">
                              <?php
                              $images = explode(",", $edit_row['incomePics']);
                              foreach ($images as $image) {
                                echo "<img src='$image' alt='Image' class='img-fluid img-thumbnail m-2' style='width:60px;height:60px;'>";
                              }
                              ?>
                            </div>
                            <input type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">
                          </div>

                          <a class="btn btn-danger waves-effect" href="earning-information"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                          <button type="submit" name="submit" class="btn btn-success waves-effect"><i class="fa fa-upload me-2"></i>Update Now</button>
                        </form>
                      </div>
                    </div>

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