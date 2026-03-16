<!doctype html>
<html lang="en">

<head>

  <title>Work Source | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<?php
if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM work_source WHERE ws_id = :uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

// Initialize variables
$WorkName = '';
$EditMode = false;

if (isset($_POST['submit'])) {
  $UserId = $_POST['UserId'];
  $WorkName = $_POST['work_name'];

  if (isset($_POST['edit_id'])) {
    // Editing existing work source
    $edit_id = $_POST['edit_id'];
    $sql = "UPDATE work_source SET work_name = :WorkName WHERE ws_id = :edit_id";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':WorkName', $WorkName);
    $stmt->bindParam(':edit_id', $edit_id);
    if ($stmt->execute()) {
      echo '<script>alert("Data Successfully Updated."); window.location.href = window.location.href;</script>';
      exit; // Exit after redirect
    } else {
      $errMSG = "Error while updating data.";
    }
  } else {
    // Adding new work source
    $sql = "INSERT INTO work_source (user_id, work_name) VALUES (:UserId, :WorkName)";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':UserId', $UserId);
    $stmt->bindParam(':WorkName', $WorkName);
    if ($stmt->execute()) {
      echo '<script>alert("Data Successfully Added."); window.location.href = window.location.href;</script>';
      exit; // Exit after redirect
    } else {
      $errMSG = "Error while inserting data.";
    }
  }
}

if (isset($_GET['edit_id'])) {
  // Fetch data for editing
  $edit_id = $_GET['edit_id'];
  $sql = "SELECT * FROM work_source WHERE ws_id = :edit_id";
  $stmt = $DB_con->prepare($sql);
  $stmt->bindParam(':edit_id', $edit_id);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    $WorkName = $row['work_name'];
    $EditMode = true;
  }
}
?>

<body data-topbar="colored">

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
                    <li class="breadcrumb-item active">All Work Source</li>
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
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">All Work Source Lists</h4>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-6">
                        <!-- Display Work Sources -->
                        <table id="datatable" class="table table-bordered table-hover align-middle">
                          <thead>
                            <tr>
                              <th>SL</th>
                              <th>Source</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $sl = 0;
                            $eq = mysqli_query($con, "SELECT * FROM work_source ORDER BY ws_id DESC");
                            while ($eqrow = mysqli_fetch_array($eq)) {
                              $sl++;
                            ?>
                              <tr>
                                <td><?= $sl; ?></td>
                                <td><?= $eqrow['work_name']; ?></td>
                                <td>
                                  <a class="btn btn-success waves-effect" href="?edit_id=<?= $eqrow['ws_id']; ?>" title="click for edit"><i class="fa fa-edit me-2"></i>Edit </a>
                                  <a class="btn btn-danger waves-effect" href="?delete_id=<?= $eqrow['ws_id']; ?>" title="click for delete" onclick="return confirm('Are You Sure....?')"> <i class="fa fa-trash me-2"></i>Delete </a>
                                </td>
                              </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-6">
                        <a href="work-sources" class="btn btn-success mb-2 waves-effect"><i class="fa fa-sync me-2"></i>Reload</a>
                        <!-- Form for Adding or Editing Work Sources -->
                        <div class="card">
                          <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                              <?php if ($EditMode) : ?>
                                <input type="hidden" name="edit_id" value="<?= $edit_id; ?>">
                              <?php else : ?>
                                <?php
                                $pq = mysqli_query($con, "SELECT * FROM stuff LEFT JOIN `user` ON user.userid=stuff.userid WHERE stuff.userid='" . $_SESSION['id'] . "'");
                                while ($pqrow = mysqli_fetch_array($pq)) {
                                ?>
                                  <input type="hidden" name="UserId" value="<?= $pqrow['userid']; ?>">
                                <?php } ?>
                              <?php endif; ?>

                              <div class="form-group mb-3">
                                <label for="work_name" class="form-label">Work Source</label>
                                <input type="text" class="form-control" name="work_name" id="work_name" required placeholder="Enter work source" value="<?= $WorkName; ?>">
                              </div>

                              <button type="submit" name="submit" class="btn btn-<?= $EditMode ? 'info' : 'success'; ?> waves-effect">
                                <?= $EditMode ? '<i class="fa fa-upload me-2"></i>Update Now' : '<i class="fa fa-save me-2"></i>Save Now'; ?>
                              </button>
                            </form>
                          </div>
                        </div>
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