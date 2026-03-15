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
  if (isset($_POST['submit'])) {
    // Get student ID from GET parameter
    $StudentId = isset($_GET['add_id']) && !empty($_GET['add_id']) ? trim($_GET['add_id']) : null;

    if (empty($StudentId)) {
      $errMSG = "Student ID is required.";
    } else {
      $UserId = $_POST['UserId'] ?? null;
      $StudentID = $_POST['StudentID'] ?? null;
      // $EarningDate = $_POST['EarningDate'];
      $EarningDate = date('Y-m-d');
      $WorkSource = $_POST['WorkSource'] ?? null;
      $PaymentMethod = $_POST['PaymentMethod'] ?? null;
      $TotalDollar = $_POST['TotalDollar'] ?? null;
      $TotalBD = $_POST['TotalBD'] ?? null;
      $Job = $_POST['Job'] ?? null;

      // File upload handling
      $upload_dir = 'income_images/'; // upload directory
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
      $images = $_FILES['images'] ?? null;

      $imagePaths = [];

      if (!empty($images['name'][0])) {
        foreach ($images['name'] as $key => $imgFile) {
          if (empty($imgFile))
            continue; // Skip empty file entries
  
          $tmp_dir = $images['tmp_name'][$key];
          $imgSize = $images['size'][$key];
          $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
          $userpic = "e-laeltd-" . rand(9999, 9999999) . $imgFile; // rename uploading image
  
          // Validate image file
          if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 500000000) {
              // Move uploaded file to directory
              if (move_uploaded_file($tmp_dir, $upload_dir . $userpic)) {
                $imagePaths[] = $upload_dir . $userpic; // Collect the image paths
              } else {
                $errMSG = "Error while uploading file: " . htmlspecialchars($imgFile);
                break;
              }
            } else {
              $errMSG = "Sorry, your file is too large: " . htmlspecialchars($imgFile);
              break;
            }
          } else {
            $errMSG = "Invalid file type: " . htmlspecialchars($imgFile);
            break;
          }
        }
      }

      if (empty($errMSG)) {
        // Prepare the SQL query
        $sql = "INSERT INTO income_info (user_id, student_id, studentID, earning_date, work_source, payment_type, earning_dollar, earning_bd, job_id, incomePics, status) 
                VALUES (:UserId, :StudentId, :StudentID, :EarningDate, :WorkSource, :PaymentMethod, :TotalDollar, :TotalBD, :Job, :upic, 1)";

        // Prepare statement
        $stmt = $DB_con->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':UserId', $UserId);
        $stmt->bindParam(':StudentId', $StudentId);
        $stmt->bindParam(':StudentID', $StudentID);
        $stmt->bindParam(':EarningDate', $EarningDate);
        $stmt->bindParam(':WorkSource', $WorkSource);
        $stmt->bindParam(':PaymentMethod', $PaymentMethod);
        $stmt->bindParam(':TotalDollar', $TotalDollar);
        $stmt->bindParam(':TotalBD', $TotalBD);
        $stmt->bindParam(':Job', $Job);
        $upicImploded = implode(",", $imagePaths); // Implode image paths into a string
        $stmt->bindParam(':upic', $upicImploded);

        // Execute the query
        if ($stmt->execute()) {
          echo '<script>alert("Data Successfully Added."); window.location.href = "student-income.php?income_id=' . htmlspecialchars($StudentId) . '";</script>';
          exit; // Exit after redirect
        } else {
          $errMSG = "Error while inserting data.";
        }
      } else {
        echo '<script>alert("' . addslashes($errMSG) . '");</script>';
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
                        $StudentId = isset($_GET['add_id']) && !empty($_GET['add_id']) ? trim($_GET['add_id']) : null;

                        if ($StudentId) {
                          $eq_stmt = $DB_con->prepare("SELECT * FROM student_list WHERE student_id = ?");
                          $eq_stmt->execute([$StudentId]);
                          $eqrow = $eq_stmt->fetch(PDO::FETCH_ASSOC);

                          if ($eqrow) {
                            ?>
                            <img src="../stu-info/user_images/<?= htmlspecialchars($eqrow['userPic'] ?? '') ?>"
                              class="img-fluid img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px;"
                              alt="Student Photo" />
                            <h3 class="m-0"><?= htmlspecialchars($eqrow['stu_name'] ?? 'Unknown') ?></h3>
                            <hr>
                            <p class="font-size-15"><?= htmlspecialchars($eqrow['about'] ?? 'No info') ?></p>
                            <?php
                          } else {
                            echo "<p class='text-danger'>Student not found.</p>";
                          }
                        } else {
                          echo "<p class='text-danger'>Invalid student ID.</p>";
                        }
                        ?>
                      </div>
                      <div class="col-md-5">
                        <form method="post" enctype="multipart/form-data">
                          <?php
                          $pq = mysqli_query($con, "SELECT * FROM stuff LEFT JOIN `user` ON user.userid=stuff.userid WHERE stuff.userid='" . $_SESSION['id'] . "'");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                            ?>
                            <input type="hidden" name="UserId" value="<?= $pqrow['userid'] ?>">
                          <?php } ?>

                          <div class="form-group mb-3 d-none">
                            <label for="StudentID" class="form-label">Student ID</label>
                            <input type="text" class="form-control" name="StudentID" id="StudentID"
                              placeholder="Enter student ID number"
                              value="<?php echo htmlspecialchars($StudentId ?? ''); ?>" required>
                          </div>

                          <div class="form-group mb-3" style="display: none;">
                            <label for="EarningDate" class="form-label">Earning Date</label>
                            <input type="date" class="form-control" name="EarningDate" id="EarningDate">
                          </div>

                          <div class="form-group mb-3">
                            <label for="WorkSource" class="form-label">Earning Platform</label>
                            <select name="WorkSource" id="WorkSource" class="form-control select2">
                              <option disabled selected>-- Selected Earning Platform --</option>
                              <?php
                              $eq = mysqli_query($con, "SELECT * FROM work_source ORDER BY ws_id DESC");
                              while ($eqrow = mysqli_fetch_array($eq)) {
                                ?>
                                <option value="<?= $eqrow['ws_id'] ?>"> <?= $eqrow['work_name'] ?> </option>
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
                                <option value="<?= $eqrow['pm_id'] ?>"> <?= $eqrow['payment_name'] ?> </option>
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
                                <option value="<?= $eqrow['j_id'] ?>"> <?= $eqrow['job_name'] ?> </option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TotalDollar" class="form-label">Total Earning Dollar ($)</label>
                            <input type="number" class="form-control" name="TotalDollar" id="TotalDollar"
                              placeholder="Enter total earning Dollar ($)" value='0'>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TotalBD" class="form-label">Total Earning (BD.TK)</label>
                            <input type="number" class="form-control" name="TotalBD" id="TotalBD"
                              placeholder="Enter total earning BD.TK" value='0'>
                          </div>

                          <div class="form-group mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple
                              accept="image/*" onchange="previewImages(event)">
                          </div>

                          <a href="student-income.php?income_id=<?php echo htmlspecialchars($StudentId); ?>"
                            class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                          <button type="submit" name="submit" class="btn btn-success waves-effect"><i
                              class="fa fa-save me-2"></i>Save Now</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ========== Footer Start ========== -->
      <?php include "footer.php" ?>
      <!-- ========== Footer End ========== -->
    </div>
  </div>
  <?php include "script.php" ?>
</body>

</html>