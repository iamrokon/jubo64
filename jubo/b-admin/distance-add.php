<!doctype html>
<html lang="en">

<head>
  <title>Add/Edit Distance | e-Learning & Earning Ltd.</title>
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
                  <h4 class="mb-0 font-size-18"><?= isset($_GET['edit_id']) ? 'Edit' : 'Add New' ?> Distance</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="distance-list">Distance List</a></li>
                    <li class="breadcrumb-item active"><?= isset($_GET['edit_id']) ? 'Edit' : 'Add New' ?> Distance</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <?php
          // Auto-create table if not exists
          $checkTable = mysqli_query($con, "SHOW TABLES LIKE 'branch_distances'");
          if(mysqli_num_rows($checkTable) == 0) {
              mysqli_query($con, "CREATE TABLE `branch_distances` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `branch_id` int(11) NOT NULL,
                `location_name` varchar(255) DEFAULT 'Main Center',
                `lat` varchar(100) NOT NULL,
                `lng` varchar(100) NOT NULL,
                `radius` int(11) NOT NULL DEFAULT 500,
                `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
          } else {
              // Add location_name column if it doesn't exist
              $checkCol = mysqli_query($con, "SHOW COLUMNS FROM `branch_distances` LIKE 'location_name'");
              if(mysqli_num_rows($checkCol) == 0){
                  mysqli_query($con, "ALTER TABLE `branch_distances` ADD COLUMN `location_name` varchar(255) DEFAULT 'Main Center' AFTER `branch_id`");
              }
          }

          $branch_id = "";
          $location_name = "Main Center";
          $lat = "";
          $lng = "";
          $radius = "500";
          $edit_id = "";

          // Fetch data if editing
          if(isset($_GET['edit_id'])) {
              $edit_id = $_GET['edit_id'];
              $fetch = mysqli_query($con, "SELECT * FROM branch_distances WHERE id='$edit_id'");
              if(mysqli_num_rows($fetch) > 0) {
                  $row = mysqli_fetch_array($fetch);
                  $branch_id = $row['branch_id'];
                  $location_name = $row['location_name'];
                  $lat = $row['lat'];
                  $lng = $row['lng'];
                  $radius = $row['radius'];
              }
          }

          if (isset($_POST['save_btn'])) {
              $p_branch_id = $_POST['branch_id'];
              $p_location_name = $_POST['location_name'];
              $p_lat = $_POST['lat'];
              $p_lng = $_POST['lng'];
              $p_radius = $_POST['radius'];
              $p_edit_id = $_POST['edit_id'];

              if (empty($p_branch_id) || empty($p_lat) || empty($p_lng) || empty($p_radius)) {
                  $msg = '<div class="alert alert-danger">All fields are required!</div>';
              } else {
                  if(!empty($p_edit_id)) {
                      // Update
                      $update = mysqli_query($con, "UPDATE branch_distances SET branch_id='$p_branch_id', location_name='$p_location_name', lat='$p_lat', lng='$p_lng', radius='$p_radius' WHERE id='$p_edit_id'");
                      if ($update) {
                          echo "<script>window.location.href='distance-list';</script>";
                      } else {
                          $msg = '<div class="alert alert-danger">Failed to update!</div>';
                      }
                  } else {
                      // Insert
                      // Restriction removed to allow multiple locations (Multipole)
                      $insert = mysqli_query($con, "INSERT INTO branch_distances (branch_id, location_name, lat, lng, radius) VALUES ('$p_branch_id', '$p_location_name', '$p_lat', '$p_lng', '$p_radius')");
                      if ($insert) {
                          echo "<script>window.location.href='distance-list';</script>";
                      } else {
                          $msg = '<div class="alert alert-danger">Something went wrong!</div>';
                      }
                  }
              }
          }
          ?>

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title mb-4"><?= isset($_GET['edit_id']) ? 'Edit' : 'Add' ?> Distance Settings</h4>
                    
                    <?php if(isset($msg)) echo $msg; ?>

                    <form method="post">
                      <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
                      
                      <div class="mb-3">
                        <label class="form-label">Select Branch</label>
                        <select class="form-select" name="branch_id" required>
                          <option value="">Select Branch</option>
                          <?php
                          $sql = "SELECT id, dist_name FROM district";
                          $result = $con->query($sql);
                          while ($row = $result->fetch_array()) {
                              $selected = ($row['id'] == $branch_id) ? "selected" : "";
                              echo "<option value='" . $row['id'] . "' $selected>" . $row['dist_name'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Location Name (Pole Name)</label>
                        <input type="text" class="form-control" name="location_name" value="<?= $location_name ?>" placeholder="ex: Main Center or South Building" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="lat" value="<?= $lat ?>" placeholder="ex: 23.7777018" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="lng" value="<?= $lng ?>" placeholder="ex: 90.3610806" required>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Allowed Radius (meters)</label>
                        <input type="number" class="form-control" name="radius" value="<?= $radius ?>" required>
                      </div>

                      <div class="text-center">
                        <button type="submit" name="save_btn" class="btn btn-primary waves-effect waves-light"><?= isset($_GET['edit_id']) ? 'Update' : 'Save' ?> Settings</button>
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
