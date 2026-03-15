<!doctype html>
<html lang="en">

<head>
  <title>Distance List | e-Learning & Earning Ltd.</title>
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
                  <h4 class="mb-0 font-size-18">Distance List</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All Distance Settings</li>
                  </ol>
                </div>
                <div class="page-title-right">
                    <a href="distance-add" class="btn btn-primary waves-effect waves-light">Add New Distance</a>
                </div>
              </div>
            </div>
          </div>

          <?php
          if(isset($_GET['del_id'])){
              $del_id = $_GET['del_id'];
              $del = mysqli_query($con, "DELETE FROM branch_distances WHERE id='$del_id'");
              if($del){
                  echo '<script>alert("Deleted Successfully!"); window.location.href="distance-list";</script>';
              } else {
                  echo '<script>alert("Failed to delete!");</script>';
              }
          }
          ?>

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Branch Distance Settings</h4>
                    
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Branch</th>
                          <th>Location (Pole)</th>
                          <th>Latitude</th>
                          <th>Longitude</th>
                          <th>Radius (m)</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Check if table exists first (in case accessed before add page)
                        $checkTable = mysqli_query($con, "SHOW TABLES LIKE 'branch_distances'");
                        if(mysqli_num_rows($checkTable) > 0) {
                            $user_dist_id = $_SESSION['id'];
                            $query = mysqli_query($con, "SELECT branch_distances.*, branch_distances.location_name, district.dist_name FROM branch_distances LEFT JOIN district ON branch_distances.branch_id = district.id WHERE branch_distances.branch_id = '$user_dist_id' ORDER BY branch_distances.id DESC");
                            if(mysqli_num_rows($query) > 0) {
                                $i = 1;
                                while($row = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= $row['dist_name'] ?? 'Unknown Branch (' . $row['branch_id'] . ')' ?></td>
                          <td><?= $row['location_name'] ?></td>
                          <td><?= $row['lat'] ?></td>
                          <td><?= $row['lng'] ?></td>
                          <td><?= $row['radius'] ?></td>
                          <td>
                            <a href="distance-add?edit_id=<?= $row['id'] ?>" class="btn btn-sm btn-info"><i class="mdi mdi-pencil"></i> Edit</a>
                            <!-- <a href="?del_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger"><i class="mdi mdi-trash-can"></i> Delete</a> -->
                          </td>
                        </tr>
                        <?php 
                                }
                            } 
                        }
                        ?>
                      </tbody>
                    </table>

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
