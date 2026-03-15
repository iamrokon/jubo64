<!doctype html>
<html lang="en">

<head>
  <title>Edit Attendance | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Edit Attendance Record</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="attendance-list">Attendance List</a></li>
                    <li class="breadcrumb-item active">Edit Attendance</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <?php
          $att_id = "";
          $att_date = "";
          $check_in = "";
          $check_out = "";
          $stu_name = "";
          $back_url = isset($_GET['back_url']) ? $_GET['back_url'] : 'attendance-list';

          if(isset($_GET['att_id'])) {
              $att_id = $_GET['att_id'];
              $fetch = mysqli_query($con, "SELECT a.*, s.stu_name FROM attendance a LEFT JOIN student_list s ON a.student_id = s.stu_user_id WHERE a.att_id='$att_id'");
              if(mysqli_num_rows($fetch) > 0) {
                  $row = mysqli_fetch_array($fetch);
                  $att_date = $row['att_date'];
                  $check_in = $row['check_in'];
                  $check_out = $row['check_out'];
                  $stu_name = $row['stu_name'];
              } else {
                  echo "<script>window.location.href='attendance-list';</script>";
              }
          } else {
              echo "<script>window.location.href='attendance-list';</script>";
          }

          if (isset($_POST['update_btn'])) {
              $p_att_date = $_POST['att_date'];
              $p_check_in = $_POST['check_in'];
              $p_check_out = $_POST['check_out'];
              $p_att_id = $_POST['att_id'];
              $p_back_url = $_POST['back_url'] ?? 'attendance-list';

              if (empty($p_att_date) || empty($p_check_in)) {
                  $msg = '<div class="alert alert-danger">Date and Check In are required!</div>';
              } else {
                  $update = mysqli_query($con, "UPDATE attendance SET att_date='$p_att_date', check_in='$p_check_in', check_out='$p_check_out' WHERE att_id='$p_att_id'");
                  if ($update) {
                      echo "<script>window.location.href='$p_back_url';</script>";
                  } else {
                      $msg = '<div class="alert alert-danger">Failed to update!</div>';
                  }
              }
          }
          ?>

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-4">Edit Attendance for <?= $stu_name ?></h4>
                    
                    <?php if(isset($msg)) echo $msg; ?>

                    <form method="post">
                      <input type="hidden" name="att_id" value="<?= $att_id ?>">
                      <input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?? (($_POST['back_url'] ?? '')) ?>">
                      
                      <div class="mb-3">
                        <label class="form-label">Attendance Date</label>
                        <input type="date" class="form-control" name="att_date" value="<?= $att_date ?>" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Check In Time</label>
                        <input type="text" class="form-control" name="check_in" value="<?= $check_in ?>" placeholder="ex: 09:30 AM" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Check Out Time</label>
                        <input type="text" class="form-control" name="check_out" value="<?= $check_out ?>" placeholder="ex: 05:30 PM">
                      </div>

                      <div class="text-center mt-4">
                        <button type="submit" name="update_btn" class="btn btn-primary waves-effect waves-light">Update Attendance Record</button>
                        <a href="<?= $back_url ?>" class="btn btn-secondary waves-effect waves-light ms-2">Cancel</a>
                      </div>
                    </form>

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
