<!doctype html>
<html lang="en">

<head>

  <title>Batches | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<?php
if (isset($_GET['delete_id'])) {
  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM batch_list WHERE batch_id = :uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

// Initialize variables
$BatchName = '';
$EditMode = false;

if (isset($_POST['submit'])) {
  $UserId = $_POST['UserId'];
  $BatchName = $_POST['batch_name'];
  $BatchStatus = $_POST['status'];

  if (isset($_POST['edit_id'])) {
    // Editing existing batch batch
    $edit_id = $_POST['edit_id'];
    $sql = "UPDATE batch_list SET batch_name = :BatchName , status = :BatchStatus WHERE batch_id = :edit_id";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':BatchName', $BatchName);
    $stmt->bindParam(':BatchStatus', $BatchStatus);
    $stmt->bindParam(':edit_id', $edit_id);
    if ($stmt->execute()) {
      echo '<script>alert("Data Successfully Updated."); window.location.href = window.location.href;</script>';
      exit; // Exit after redirect
    } else {
      $errMSG = "Error while updating data.";
    }
  } else {
    // Adding new batch batch
    $sql = "INSERT INTO batch_list (user_id, batch_name, status) VALUES (:UserId, :BatchName, :BatchStatus)";
    $stmt = $DB_con->prepare($sql);
    $stmt->bindParam(':UserId', $UserId);
    $stmt->bindParam(':BatchName', $BatchName);
    $stmt->bindParam(':BatchStatus', $BatchStatus);
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
  $sql = "SELECT * FROM batch_list WHERE batch_id = :edit_id";
  $stmt = $DB_con->prepare($sql);
  $stmt->bindParam(':edit_id', $edit_id);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    $BatchName = $row['batch_name'];
    $BatchStatus = $row['status'];
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
                    <li class="breadcrumb-item active">All Batches</li>
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
                  <div class="card-header border-bottom py-3">
                    <h4 class="card-title m-0">All Batch Lists</h4>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <table id="datatable" class="table table-bordered table-hover align-middle">
                          <thead>
                            <tr>
                              <th>SL</th>
                              <th>Batch</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>


                          <tbody>
                            <?php
                            $sl = 0;
                            $eq = mysqli_query($con, "SELECT * FROM batch_list ORDER BY batch_id DESC");
                            while ($eqrow = mysqli_fetch_array($eq)) {
                              $sl++;
                            ?>
                              <tr>
                                <td><?= $sl; ?></td>
                                <td><?= $eqrow['batch_name'] ?></td>
                                <td>
                                  <?php
                                  if ($eqrow['status']) {
                                    echo '<i class="fa fa-check text-success" style="font-size: 18px"></i>';
                                  } else {
                                    echo '<i class="fa fa-times text-danger" style="font-size: 18px"></i>';
                                  }
                                  ?>
                                </td>
                                <td>
                                  <a class="btn btn-success waves-effect" href="?edit_id=<?= $eqrow['batch_id'] ?>" title="click for edit"> <i class="fa fa-edit me-2"></i>Edit </a>
                                  <button class="btn btn-danger waves-effect" data-bs-toggle="modal" data-bs-target="#batch<?= $eqrow['batch_id'] ?>"> <i class="fa fa-trash me-2"></i>Delete </button>
                                  <!-- <a class="btn btn-danger waves-effect" href="?delete_id=<?= $eqrow['batch_id'] ?>" title="click for delete" onclick="return confirm('Are You Sure....?')"> <i class="fa fa-trash me-2"></i>Delete </a> -->
                                </td>
                              </tr>
                              <!-- Modal -->
                              <div class="modal fade" id="batch<?= $eqrow['batch_id'] ?>" tabindex="-1" aria-labelledby="batchLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="batchLabel">Delete Batch</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      Are You Sure To Deleted <strong><?= $eqrow['batch_name'] ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-success waves-effect" data-bs-dismiss="modal"><i class="fa fa-times me-2"></i>Close</button>
                                      <a href="?delete_id=<?= $eqrow['batch_id'] ?>" class="btn btn-danger waves-effect"><i class="fa fa-trash me-2"></i>Delete Now</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php
                            }
                            ?>
                          </tbody>

                        </table>





                      </div>

                      <div class="col-md-6">
                        <a href="batches" class="btn btn-success waves-effect mb-2"><i class="fa fa-sync me-2"></i>Reload</a>
                        <!-- Form for Adding or Editing Batch Batchs -->
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
                                  <input type="hidden" name="UserId" value="<?= $pqrow['userid'] ?>">
                                <?php } ?>
                              <?php endif; ?>

                              <div class="form-group mb-3">
                                <label for="batch_name" class="form-label">Batch</label>
                                <input type="text" class="form-control" name="batch_name" id="batch_name" required placeholder="Enter batch" value="<?= $BatchName; ?>">
                              </div>

                              <div class="form-group mb-3">
                                <label for="batchStatus" class="form-label">Status</label>
                                <select class="form-control" name="status" id="batchStatus">
                                  <option value="1" <?php if (isset($BatchStatus) && $BatchStatus == 1) echo 'selected'; ?>>Active</option>
                                  <option value="0" <?php if (isset($BatchStatus) && $BatchStatus == 0) echo 'selected'; ?>>Inactive</option>
                                </select>


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