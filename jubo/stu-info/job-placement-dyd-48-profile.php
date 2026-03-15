<!doctype html>
<html lang="en">

<head>

  <title>Edit Job Placement | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

  <style>
    .select2,
    .select2-container--default .select2-search--dropdown .select2-search__field {
      border: 1px solid rgb(21, 158, 65, 0.4) !important;
      border-radius: .25rem !important;
    }

    .select2-dropdown {
      border: 1px solid rgb(21, 158, 65, 0.4) !important;
      box-shadow: none !important;
    }

    .select2-container--default .select2-selection--single {
      border: none !important;
    }
  </style>

</head>

<body data-topbar="colored">

  <?php
  error_reporting(~E_NOTICE);

  if (isset($_GET['profile']) && !empty($_GET['profile'])) {
    $id = $_GET['profile'];

    // Fetch existing data
    $stmt_edit = $DB_con->prepare('
        SELECT 
            job_placement_dyd_48.*, 
            student_list.stu_name,
            student_list.userPic,
            district.dist_name,
            batch_list.batch_name,
            group_list.group_name,
            certificate_category.duration,
            certificate_category.course_name
        FROM job_placement_dyd_48 
        LEFT JOIN student_list ON student_list.student_id = job_placement_dyd_48.student_id
        LEFT JOIN district ON district.id = job_placement_dyd_48.district_id
        LEFT JOIN batch_list ON batch_list.batch_id = job_placement_dyd_48.batch_id 
        LEFT JOIN group_list ON group_list.group_id = job_placement_dyd_48.group_id
        LEFT JOIN certificate_category ON certificate_category.batch_id = student_list.batch_id
        WHERE job_placement_dyd_48.jobp_id = :uid
    ');
    $stmt_edit->execute([':uid' => $id]);
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
  } else {
    header("Location: index.php");
    exit();
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
                    <li class="breadcrumb-item active">Edit Certificate Information</li>
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
            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-7">
                <div class="card">
                  <div class="card-body">
                    <div class="row">

                      <!-- error message here -->

                      <!-- Student Profile Column -->
                      <div class="col-md-4 text-center">


                        <img src="user_images/<?php echo $userPic ?>" class="img-fluid img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px;" />
                        <h3 class="m-0" style="border-bottom: 2px solid #ccc; padding-bottom: 5px;"><?php echo $stu_name ?></h3>
                      
                        <p class="mb-0 mt-2"><strong>Batch:</strong> <?php echo $batch_name ?></p>
                        <p class="mb-0"><strong>Group:</strong> <?php echo $group_name ?></p>
                      </div>

                      <div class="col-md-5" style="border-left: 2px solid #ccc;">
                        <h4 style="border-bottom: 2px solid #ccc; padding-bottom: 5px;">Job Placement Information</h4>
                        <?php if (!empty($errMSG)): ?>
                          <h4 class="text-danger"><?php echo $errMSG; ?></h4>
                        <?php endif; ?>
                        <form method="post" enctype="multipart/form-data">

                          <div class="form-group mb-3">
                            <label for="DistrictId" class="form-label"><strong>District:</strong> <?php echo $dist_name ?? '' ?></label>
                          </div>

                          <div class="form-group mb-3">
                            <label for="StudentID" class="form-label"><strong>Student ID:</strong> <?php echo $student_id ?? '' ?> </label>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TrainerId" class="form-label"><strong>Duration:</strong> <?php echo $duration ?? '' ?></label>
                          </div>

                          <div class="form-group mb-3">
                            <label for="TrainerId" class="form-label"><strong>Course:</strong> <?php echo $course_name ?? '' ?></label>
                          </div>

                           <div class="form-group mb-3">
                            <label for="CompanyName" class="form-label"><strong>Company Name:</strong><?php echo $company_name ?? '' ?></label>
                          </div>

                          <div class="form-group mb-3">
                            <label for="Designation" class="form-label"><strong>Designation:</strong><?php echo $designation ?? '' ?></label>
                          </div>

                          <div class="form-group mb-3">
                            <label for="Salary" class="form-label"><strong>Salary:</strong><?php echo $salary ?? '' ?></label>
                          </div>

                        </form>
                      </div>

                    </div> <!-- row -->
                  </div> <!-- card-body -->
                   <div class="d-flex justify-content-end mb-3" style="margin-right: 20px;">
                        <a href="job-placement-dyd-48" class="btn btn-primary waves-effect">
                            <i class="fa fa-arrow-left me-2"></i>Back Now
                        </a>
                        </div>
                </div> <!-- card -->
              </div> <!-- col -->
            </div> <!-- row -->
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