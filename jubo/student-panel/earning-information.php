<!doctype html>
<html lang="en">

<head>

  <title>Earning Information | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

  <style>
    .dataTables_wrapper .row:nth-child(2) {
      overflow-x: scroll;
    }

    .dataTables_wrapper .row:nth-child(2) table {
      width: 1560px !important;
    }
  </style>

</head>

<?php
if (isset($_GET['delete_id'])) {
  $stmt_select = $DB_con->prepare('SELECT incomePics FROM income_info WHERE in_id = :uid');
  $stmt_select->execute(array(':uid' => $_GET['delete_id']));
  $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
  if ($imgRow && isset($imgRow['incomePics'])) {
    $images = explode(',', $imgRow['incomePics']);
    foreach ($images as $image) {
      if (file_exists($image)) {
        unlink($image);
      }
    }
  }

  $stmt_delete = $DB_con->prepare('DELETE FROM income_info WHERE in_id  =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

?>

<body data-topbar="colored">

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
                    <li class="breadcrumb-item active">All Earning Information</li>
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
                  <div class="card-header border-bottom py-4 d-flex align-items-center justify-content-between">
                    <h4 class="card-title m-0">All Earning Lists</h4>
                    <a href="earning-add-with-student" class="btn btn-primary">Add New</a>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">
                    <hr>
                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Student ID</th>
                          <th>Batch</th>
                          <th>Dollar</th>
                          <th>BD.TK</th>
                          <th>Payment</th>
                          <th>Platform</th>
                          <th>Job</th>
                          <th>Photo</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sl = 0;
                        // Assuming $con is your database connection object
                        $eq = mysqli_query($con, "SELECT * FROM income_info 
                              LEFT JOIN student_list ON income_info.student_id = student_list.student_id
                              LEFT JOIN district ON student_list.district = district.id
                              LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                              LEFT JOIN payment_method ON income_info.payment_type = payment_method.pm_id
                              LEFT JOIN work_source ON income_info.work_source = work_source.ws_id
                              LEFT JOIN jobs ON income_info.job_id = jobs.j_id where income_info.stu_user_id = '" . $_SESSION['id'] . "' 
                              ORDER BY income_info.in_id DESC ");
                        while ($eqrow = mysqli_fetch_array($eq)) {
                          $sl++;
                        ?>
                          <tr>
                            <td><?= $sl; ?></td>
                            <td width="14%"><?= $eqrow['stu_name']; ?></td>
                            <td width="13%"><?= $eqrow['studentID'] ?></td>
                            <td><?= $eqrow['batch_name']; ?></td>
                            <td>
                              <?php
                              if ($eqrow['earning_dollar'] == null || $eqrow['earning_dollar'] == 0) {
                                echo '-';
                              } else {
                                echo '$' . number_format($eqrow['earning_dollar'], 2);
                              }
                              ?>
                            </td>

                            <td>
                              <?php
                              if ($eqrow['earning_bd'] == null || $eqrow['earning_bd'] == 0) {
                                echo '-';
                              } else {
                                echo '৳' . number_format($eqrow['earning_bd'], 2);
                              }
                              ?>
                            </td>
                            <td><?= $eqrow['payment_name'] ?? '-' ?></td>
                            <td><?= $eqrow['work_name'] ?? '-' ?></td>
                            <td><?= $eqrow['job_name'] ?? '-' ?></td>
                            <td width="8%">
                              <div class="text-center d-flex align-items-center">
                                <?php
                                  $images = explode(",", $eqrow['incomePics']);
                                  foreach ($images as $image) {
                                    if ($image == null) {
                                      echo "<img src='website/favicon.png' alt='Image' class='img-fluid img-thumbnail m-1' style='width:30px;height:30px;'>";
                                    } else {
                                      echo "<img src='$image' alt='Image' class='img-fluid img-thumbnail m-1' style='width:30px;height:30px;'>";
                                    }
                                  }
                                  ?>
                              </div>
                            </td>
                            <td width="12.2%">
                              <a class="btn btn-success waves-effect" href="earning-information-edit?edit_id=<?= $eqrow['in_id'] ?>"><i class="fa fa-edit me-2"></i>Edit</a>
                              <a class="btn btn-danger waves-effect" href="?delete_id=<?= $eqrow['in_id']; ?>" title="click for delete" onclick="return confirm('Are You Sure....?')"><i class="fa fa-trash me-2"></i>Delete</a>
                            </td>
                          </tr>
                        <?php
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

  <script>
    $('#datatable').dataTable({
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      // "lengthMenu": [20, 50, 100],
      // "pageLength": 50,
    });
  </script>


</body>

</html>