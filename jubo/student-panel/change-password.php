<!doctype html>
<html lang="en">

<head>

  <title>Change Password | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<body data-topbar="colored">
  <?php
  $sql = mysqli_query($con, "SELECT * FROM student_user WHERE userid = '" . $_SESSION['id'] . "'");
  $surow = mysqli_fetch_array($sql);
  $UserId = $surow['userid'];

  if (isset($_POST['btn_save_updates'])) {
    $Password = $_POST['Password'];


    $hashedPassword = md5($Password);

    if (!isset($errMSG)) {
      $stmt = $DB_con->prepare('UPDATE student_user 
                              SET  password = :Hashed 
                                  WHERE userid = :uid');
      $stmt->bindParam(':Hashed', $hashedPassword);
      $stmt->bindParam(':uid', $UserId);

      if ($stmt->execute()) {
        $stmt = $DB_con->prepare('UPDATE student_password 
                                SET original = :Password, 
                                    mdfive = :Hashed 
                                WHERE passwordid = :uid');
        $stmt->bindParam(':Password', $Password);
        $stmt->bindParam(':Hashed', $hashedPassword);
        $stmt->bindParam(':uid', $UserId);
        $stmt->execute();
  ?>
        <script>
          alert('Update Successfully Done...');
          window.location.href = window.location.href;
        </script>
  <?php
      } else {
        $errMSG = "Sorry Data Could Not Be Updated!";
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
                    <li class="breadcrumb-item active">Change Password</li>
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
          <div class="page-content-wrapper mt-5">
            <div class="row justify-content-center">
              <div class="col-6">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Change Your Password</h4>
                  </div>
                  <div class="card-body">

                    <?php
                    if (isset($errMSG)) {
                      echo '<div class="alert alert-danger">' . $errMSG . '</div>';
                    } else if (isset($successMSG)) {
                      echo '<div class="alert alert-success">' . $successMSG . '</div>';
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                      <div class="row">

                        <?php

                        $sql = mysqli_query($con, "SELECT * FROM student_password
                    WHERE passwordid  = '" . $_SESSION['id'] . "'");
                        $surow = mysqli_fetch_array($sql);
                        ?>
                     
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">Old Password</label>
                            <div style="position: relative;">
                              <input style="width: 100%;" type="text" class="form-control" name="Password" value="<?php echo $surow['original']; ?>" id="passwordField" readonly  placeholder="New Password">
                              <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i id="eyeIcon" class="fa fa-eye"></i>
                              </span>
                            </div>

                            <!-- FontAwesome আইকনের জন্য -->
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

                            <script>
                              function togglePassword() {
                                const passwordInput = document.getElementById("passwordField");
                                const eyeIcon = document.getElementById("eyeIcon");
                                if (passwordInput.type === "password") {
                                  passwordInput.type = "text";
                                  eyeIcon.classList.remove("fa-eye");
                                  eyeIcon.classList.add("fa-eye-slash");
                                } else {
                                  passwordInput.type = "password";
                                  eyeIcon.classList.remove("fa-eye-slash");
                                  eyeIcon.classList.add("fa-eye");
                                }
                              }
                            </script>

                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <!-- <label class="control-label">New Password</label> -->
                            <!-- <input style="width: 100%;" type="password" class="form-control" name="Password" placeholder="New Password"> -->
                            <!-- <div style="position: relative;">
                              <input style="width: 100%;" type="password" class="form-control" name="Password" id="passwordField" placeholder="New Password">
                              <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i id="eyeIcon" class="fa fa-eye"></i>
                              </span>
                            </div> -->

                             <label class="control-label">New Password</label>
    <div style="position: relative;">
        <input 
            style="width: 100%;" 
            type="password" 
            class="form-control" 
            name="Password" 
            id="passwordField2" 
            placeholder="New Password"
            minlength="4" 
            required
        >
        <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
            <i id="eyeIcon" class="fa fa-eye"></i>
        </span>
    </div>
    <small id="passwordHelp" class="form-text text-muted">Password must be at least 4 characters long.</small>

                            <!-- FontAwesome আইকনের জন্য -->
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

                            

                            <script>
                              function togglePassword() {
                                const passwordInput = document.getElementById("passwordField2");
                                const eyeIcon = document.getElementById("eyeIcon");
                                if (passwordInput.type === "password") {
                                  passwordInput.type = "text";
                                  eyeIcon.classList.remove("fa-eye");
                                  eyeIcon.classList.add("fa-eye-slash");
                                } else {
                                  passwordInput.type = "password";
                                  eyeIcon.classList.remove("fa-eye-slash");
                                  eyeIcon.classList.add("fa-eye");
                                }
                              }
                            </script>

                          </div>
                        </div>

                        <div class="col-12 mb-3">
                          <div class="form-group text-center">
                            <a class="btn btn-danger waves-effect" href="student-profile"><i class="fa fa-arrow-left me-2"></i> Back Now</a>
                            <button type="submit" name="btn_save_updates" class="btn btn-primary waves-effect"> <i class="fa fa-upload me-2"></i> Update Now</button>
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