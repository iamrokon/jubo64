
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
  // Prepare and execute statement to select image paths from the database
  $stmt_select = $DB_con->prepare('SELECT incomePics FROM income_info WHERE in_id = :uid');
  $stmt_select->execute(array(':uid' => $_GET['delete_id']));
  $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  // Check if the 'incomePics' column contains any data
  if ($imgRow && isset($imgRow['incomePics'])) {
    // Convert the fetched string of image paths into an array
    $images = explode(',', $imgRow['incomePics']);

    // Loop through each image path and delete the file from the server if it exists
    foreach ($images as $image) {
      if (file_exists($image)) {
        unlink($image); // Delete the file
      }
    }
  }

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM income_info WHERE in_id  =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

?>

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
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">All Earning Lists</h4>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">


                    <div class="row mb-4 mt-3">
                      <div class="col-xl-8 mx-auto">
                        <form action="earning-information-report" method="post" target="_blank">
                          <div class="row align-items-center justify-content-center">
                            <div class="col-md-12 text-center mb-3">
                              <h3 class="m-0"> District Wise Reports </h3>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Type" name="Type" class="form-control form-select">
                                <option value="details">Student Income</option>
                                <option value="income">Income Report</option>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="DistId" name="DistId" class="form-control form-select" required>
                                <option value="<?= $_SESSION['id'] ?>"><?= $user ?></option>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Batch" name="Batch" class="form-control form-select" required>
                                <option disabled>Select Batch</option>
                                <?php
                                $sql = "SELECT * FROM batch_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['batch_id'] . "'>" . $row['batch_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Group" name="Group" class="form-control form-select">
                                <option value="">Select Group</option>
                                <?php
                                $sql = "SELECT * FROM group_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-3 col-xxl-2 my-2">
                              <a id="reportLink" name="submit" target="_blank" class="btn btn-success w-100 waves-effect">Open Report</a>
                            </div>

                            <script>
                              document.getElementById("reportLink").addEventListener('click', function() {
                                var type = document.getElementById("Type").value;
                                var distId = document.getElementById("DistId").value;
                                var batchId = document.getElementById("Batch").value;
                                var groupId = document.getElementById("Group").value;

                                if (type == 'details') {
                                  if (distId && batchId && groupId) {
                                    // Update href attribute of report link
                                    this.href = "earning-information-report?dist_id=" + distId + "&batch_id=" + batchId + "&group_id=" + groupId;
                                  } else if (distId && batchId) {
                                    // Update href attribute of report link
                                    this.href = "earning-information-report?dist_id=" + distId + "&batch_id=" + batchId;
                                  }
                                } else {
                                  if (distId && batchId && groupId) {
                                    this.href = "earning-information-report-by-students?dist_id=" + distId + "&batch_id=" + batchId + "&group_id=" + groupId;
                                  } else if (distId && batchId) {
                                    this.href = "earning-information-report-by-students?dist_id=" + distId + "&batch_id=" + batchId;
                                  }
                                }
                              });
                            </script>


                          </div>
                        </form>
                      </div>
                    </div>

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
                              LEFT JOIN jobs ON income_info.job_id = jobs.j_id 
                              ORDER BY income_info.in_id DESC ");
                        while ($eqrow = mysqli_fetch_array($eq)) {
                          $eidm = $eqrow['user_id'];
                          if ($_SESSION['id'] == $eqrow['id']) {
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
                        }
                        ?>
                      </tbody>

                    </table>

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