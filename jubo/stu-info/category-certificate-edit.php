<!doctype html>
<html lang="en">

<head>

  <title>Edit Settings | e-Learning & Earning Ltd.</title>

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
                    <li class="breadcrumb-item active">Edit Settings Information</li>
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


        <?php
error_reporting(~E_NOTICE);

// --- Fetch existing data to edit ---
if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt_edit = $DB_con->prepare('SELECT * FROM certificate_category WHERE c_c_id = :uid');
    $stmt_edit->execute(array(':uid' => $id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
} else {
    header("Location: index.php");
    exit();
}

// --- Handle form update ---
if (isset($_POST['btn_save_updates'])) {
    $BatchId    = $_POST['BatchId'];
    $Duration   = $_POST['Duration'];
    $CourseName = $_POST['CourseName'];

    if (!isset($errMSG)) {
        $stmt = $DB_con->prepare('UPDATE certificate_category 
            SET batch_id = :BatchId, 
                duration = :Duration, 
                course_name = :CourseName 
            WHERE c_c_id = :uid');

        $stmt->bindParam(':BatchId', $BatchId);
        $stmt->bindParam(':Duration', $Duration);
        $stmt->bindParam(':CourseName', $CourseName);
        $stmt->bindParam(':uid', $id);

        if ($stmt->execute()) {
            echo "<script>
                alert('Successfully Updated ...');
                window.location.href = 'category-certificate';
            </script>";
        } else {
            $errMSG = "Sorry, Data Could Not Be Updated!";
        }
    }
}
?>


          <!-- Start Page-content-Wrapper -->
          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Edit Settings Information</h4>
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
    <div class="col-12 mb-3">
      <div class="form-group">
        <label class="control-label">Batch</label>
        <select class="form-select" name="BatchId" required>
          <?php
          $sql = "SELECT * FROM batch_list";
          $result = $con->query($sql);
          while ($row = $result->fetch_array()) {
            $selected = ($batch_id == $row['batch_id']) ? 'selected' : '';
            echo "<option value='{$row['batch_id']}' $selected>{$row['batch_name']}</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <div class="col-12 mb-3">
      <div class="form-group">
        <label class="control-label">Duration</label>
        <input class="form-control" type="text" name="Duration"
          value="<?php echo htmlspecialchars($duration); ?>"
          placeholder="3 Months (01-01-2025 To 31-03-2025)" />
      </div>
    </div>

    <div class="col-12 mb-3">
      <div class="form-group">
        <label class="control-label">Course Name</label>
        <input class="form-control" type="text" name="CourseName"
          value="<?php echo htmlspecialchars($course_name); ?>"
          placeholder="Freelancing Training Course" />
      </div>
    </div>

    <div class="col-12 mb-3">
      <div class="form-group">
        <a href="category-certificate" class="btn btn-danger waves-effect">
          <i class="fa fa-arrow-left me-2"></i>Back Now
        </a>
        <button type="submit" name="btn_save_updates" class="btn btn-success waves-effect">
          <i class="fa fa-save me-2"></i>Update Now
        </button>
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