<!doctype html>
<html lang="en">

<head>

  <title>Job Placement Information | e-Learning & Earning Ltd.</title>

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
  $deleteId = $_GET['delete_id'];

  // Get image(s) from database

  // Delete record from database
  $stmt_delete = $DB_con->prepare('DELETE FROM job_placement_dyd_48 WHERE jobp_id = :uid');
  $stmt_delete->execute([':uid' => $deleteId]);

  // Redirect to avoid accidental resubmission
  // header("Location: certificate-dyd-48.php");
  // exit;
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
                    <li class="breadcrumb-item active">All Job Placement Information</li>
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
                    <h4 class="card-title m-0">All Job Placement Lists</h4>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">


                    <div class="row mb-4 mt-3 d-none">
                      <div class="col-xl-8 mx-auto">
                        <form action="earning-information-report" method="post" target="_blank">
                          <div class="row align-items-center justify-content-center">
                            <div class="col-md-12 text-center mb-3">
                              <h3 class="m-0">Job Placement Reports </h3>
                            </div>


                            <div class="col-md-6 col-lg-2 my-2 d-none">
                              <select id="DistId" name="DistId" class="form-control form-select" required>
                                <option value="<?= $_SESSION['id'] ?>"><?= $user ?></option>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Batch" name="Batch" class="form-control form-select" required>
                                <option disabled>Select Batch</option>
                                <?php
                                $sql = "SELECT * FROM batch_list ORDER BY batch_id ASC";
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
                                var distId = document.getElementById("DistId").value;
                                var batchId = document.getElementById("Batch").value;
                                var groupId = document.getElementById("Group").value;


                                if (distId && batchId && groupId) {
                                  // Update href attribute of report link
                                  this.href = "job-placement-dyd-48-information-report?dist_id=" + distId + "&batch_id=" + batchId + "&group_id=" + groupId;
                                }

                              });
                            </script>


                          </div>
                        </form>
                      </div>
                    </div>

                    <!-- <hr> -->

                    <h3 class="text-center">Job Placement List</h3>


                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Name</th>
                          <th>Branch</th>
                          <!-- <th>Father Name</th>
                          <th>Mother Name</th> -->
                          <th>Designation</th>
                          <th>Company Name</th>
                          <th>Salary</th>
                          <th style="width: 5%;">Batch</th>
                          <th style="width: 5%;">Group</th>
                          <th>Course</th>
                          <th>Duration</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                      </thead>




                      <tbody>
                        <?php
                        $sl = 1;
                        $sql = mysqli_query($con, "
                          SELECT 
                            job_placement_dyd_48.*, 
                            user.username,
                            student_list.stu_name,
                            student_list.father_name,
                            student_list.mother_name,
                            student_list.userPic,
                            batch_list.batch_name,
                            group_list.group_name,
                            certificate_category.duration,
                          certificate_category.course_name
                          FROM job_placement_dyd_48 
                          LEFT JOIN user ON user.userid = job_placement_dyd_48.user_id
                          LEFT JOIN student_list ON student_list.student_id = job_placement_dyd_48.student_id
                          LEFT JOIN batch_list ON batch_list.batch_id = job_placement_dyd_48.batch_id 
                          LEFT JOIN group_list ON group_list.group_id = job_placement_dyd_48.group_id
                          LEFT JOIN certificate_category ON certificate_category.batch_id = student_list.batch_id
                          
                          ORDER BY job_placement_dyd_48.jobp_id DESC
                        ");

                        while ($eqrow = mysqli_fetch_array($sql)) {
                        ?>
                          <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $eqrow['username']; ?></td>
                            <td><?= $eqrow['stu_name']; ?></td>
                            <!-- <td><?= $eqrow['father_name']; ?></td>
                            <td><?= $eqrow['mother_name']; ?></td> -->
                            <td><?= $eqrow['designation']; ?>
                            </td>
                            <td><?= $eqrow['company_name']; ?></td>
                            <td><?= $eqrow['salary']; ?></td>
                            <td><?= $eqrow['batch_name'] ?? '-'; ?></td>
                            <td><?= $eqrow['group_name'] ?? '-'; ?></td>
                            <td><?= $eqrow['course_name'] ?? '-'; ?></td>
                            <td><?= $eqrow['duration'] ?? '-'; ?></td>
                            <td> <img src="../stu-info/user_images/<?= $eqrow['userPic']; ?>" class="img-fluid img-thumbnail rounded-circle" style="width:40px; height: 40px;" /></td>
                            <td>
                              <a href="job-placement-dyd-48-profile?profile=<?= $eqrow['jobp_id'] ?>" class="btn btn-info waves-effect" title="click for view"><i class="fa fa-eye me-1"></i> View</a>
                              <!-- <a class="btn btn-success waves-effect" href="job-placement-dyd-48-info-edit?edit_id=<?= $eqrow['jobp_id'] ?>"><i class="fa fa-edit me-2"></i>Edit</a>
                              <a class="btn btn-danger waves-effect" href="?delete_id=<?= $eqrow['jobp_id']; ?>" onclick="return confirm('Are You Sure....?')"><i class="fa fa-trash me-2"></i>Delete</a> -->
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