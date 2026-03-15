<!doctype html>
<html lang="en">

<head>

  <title>Earning Information Add | e-Learning & Earning Ltd.</title>

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
    $UserId = $_POST['UserId'];
    $StuUserID = $_POST['StuUserID'];
    $StudentId = $_POST['StudentId'];
    $StudentID = $_POST['StudentID'];
    // $EarningDate = $_POST['EarningDate'];
    $EarningDate = date('Y-m-d');
    $WorkSource = $_POST['WorkSource'] ?? null;
    $PaymentMethod = $_POST['PaymentMethod'] ?? null;
    $TotalDollar = $_POST['TotalDollar'];
    $TotalBD = $_POST['TotalBD'];
    $Job = $_POST['Job'] ?? null;


    // File upload handling
    $upload_dir = '../stu-info/income_images/';
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
    $images = $_FILES['images'] ?? null;

    $imagePaths = [];

    foreach ($images['name'] as $key => $imgFile) {
      $tmp_dir = $images['tmp_name'][$key];
      $imgSize = $images['size'][$key];
      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
      $userpic = "e-laeltd-" . rand(9999, 9999999) . $imgFile;

      // Validate image file
      if (in_array($imgExt, $valid_extensions)) {
        // Check file size '5MB'
        if ($imgSize < 500000) {
          // Move uploaded file to directory
          if (move_uploaded_file($tmp_dir, $upload_dir . $userpic)) {
            $imagePaths[] = $upload_dir . $userpic;
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

    if (empty($errMSG)) {
      // Prepare the SQL query
      $sql = "INSERT INTO income_info (user_id, stu_user_id, student_id, studentID, earning_date, work_source, payment_type, earning_dollar, earning_bd, job_id, incomePics, status) 
                               VALUES (:UserId, :StuUserID, :StudentId, :StudentID, :EarningDate, :WorkSource, :PaymentMethod, :TotalDollar, :TotalBD, :Job, :upic, 1)";

      $stmt = $DB_con->prepare($sql);

      $stmt->bindParam(':UserId', $UserId);
      $stmt->bindParam(':StuUserID', $StuUserID);
      $stmt->bindParam(':StudentId', $StudentId);
      $stmt->bindParam(':StudentID', $StudentID);
      $stmt->bindParam(':EarningDate', $EarningDate);
      $stmt->bindParam(':WorkSource', $WorkSource);
      $stmt->bindParam(':PaymentMethod', $PaymentMethod);
      $stmt->bindParam(':TotalDollar', $TotalDollar);
      $stmt->bindParam(':TotalBD', $TotalBD);
      $stmt->bindParam(':Job', $Job);
      $upicImploded = implode(",", $imagePaths);
      $stmt->bindParam(':upic', $upicImploded);

      // Execute the query
      if ($stmt->execute()) {
        echo '<script>alert("Data Successfully Added."); window.location.href = window.location.href;</script>';
        exit; // Exit after redirect
      } else {
        $errMSG = "Error while inserting data.";
      }
    } else {
      echo '<script>alert("' . $errMSG . '");</script>';
    }
  }
  ?>

  <!-- Begin page -->
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
                        <h2>Your Earning Information Add</h2>
                        <?php
                        $sql = mysqli_query($con, "SELECT * FROM student_list
                                LEFT JOIN district ON district.id = student_list.district
                                LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                                LEFT JOIN group_list ON group_list.group_id = student_list.group_id 
                                WHERE student_list.stu_user_id = '" . $_SESSION['id'] . "'");
                        $eqrow = mysqli_fetch_array($sql);
                        ?>

                        <img src="../stu-info/user_images/<?= $eqrow['userPic'] ?>" class="img-fluid img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px;" />
                        <h3 class="m-0"> <?= $eqrow['stu_name'] ?></h3>
                        <hr>
                        <p class="font-size-15"> <?= $eqrow['about'] ?></p>

                      </div>
                      <div class="col-md-5">
                        <form method="post" enctype="multipart/form-data">
                          <?php
                          $pq = mysqli_query($con, "SELECT * FROM student_stuff LEFT JOIN `student_user` ON student_user.userid=student_stuff.userid WHERE student_stuff.userid='" . $_SESSION['id'] . "'");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
        
                          <?php } ?>

                          <div class="form-group mb-3">
                            <!-- <label for="StudentID" class="form-label">Student ID</label> -->
                            <input type="hidden" class="form-control" name="UserId" value="<?= $eqrow['district'] ?>" id="StudentID" placeholder="Enter student ID number" required>
                            <input type="hidden" class="form-control" name="StudentID" value="<?= $eqrow['student_id'] ?>" id="StudentID" placeholder="Enter student ID number" required>
                            <input type="hidden" class="form-control" name="StuUserID" value="<?= $eqrow['stu_user_id'] ?>" id="StudentID" placeholder="Enter student ID number" required>
                          </div>

                          <div class="form-group mb-3 d-none">
                            <label for="StudentID" class="form-label">Student ID</label>
                            <input type="text" class="form-control" name="StudentId" value="<?= $eqrow['student_id'] ?>" id="StudentID" readonly placeholder="Enter student ID number" required>
                          </div>


                          <div class="form-group mb-3" style="display: none;">
                            <label for="EarningDate" class="form-label">Earning Date</label>\


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
                            <input type="number" class="form-control" name="TotalDollar" id="TotalDollar" placeholder="Enter total earning Dollar ($)" value='0'>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TotalBD" class="form-label">Total Earning (BD.TK)</label>
                            <input type="number" class="form-control" name="TotalBD" id="TotalBD" placeholder="Enter total earning BD.TK" value='0'>
                          </div>

                          <!-- <div class="form-group mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">
                          </div> -->

                          <div class="form-group mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">
                          </div>

                          <!-- Preview Container -->
                          <div id="image-preview" class="d-flex flex-wrap gap-2"></div>

                          <script>
                            function previewImages(event) {
                              const previewContainer = document.getElementById('image-preview');
                              previewContainer.innerHTML = ''; // Clear previous previews

                              const files = event.target.files;

                              if (files.length === 0) return;

                              Array.from(files).forEach(file => {
                                if (!file.type.startsWith('image/')) return;

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                  const img = document.createElement('img');
                                  img.src = e.target.result;
                                  img.style.maxWidth = '150px';
                                  img.style.maxHeight = '150px';
                                  img.style.objectFit = 'cover';
                                  img.className = 'border rounded p-1 shadow-sm';
                                  previewContainer.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                              });
                            }
                          </script>


                          <a href="earning-information" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                          <button type="submit" name="submit" class="btn btn-success waves-effect"><i class="fa fa-save me-2"></i>Save Now</button>
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

      <?php include "footer.php" ?>

    </div>
  </div>
  <?php include "script.php" ?>
</body>

</html>