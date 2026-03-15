<!doctype html>
<html lang="en">

<head>

  <title>Student Details | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<?php
if (isset($_GET['view_id']) && !empty($_GET['view_id'])) {
  $student_id = $_GET['view_id'];
  $stmt_edit = $DB_con->prepare('SELECT * FROM student_list
      LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
      LEFT JOIN district ON district.id = student_list.district
      LEFT JOIN group_list ON group_list.group_id = student_list.group_id WHERE student_list.student_id =:uid');
  $stmt_edit->execute(array(':uid' => $student_id));
  $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
  extract($edit_row);
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
                    <li class="breadcrumb-item active">Student Details</li>
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
                    <div class="d-flex align-items-center justify-content-between">
                      <h4 class="card-title m-0">Student Details</h4>
                      <a href="students" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">District</label>
                          <p><?= $dist_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Group</label>
                          <p><?= $group_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Batch</label>
                          <p><?= $batch_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Student Name</label>
                          <p><?= $stu_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Gender</label>
                          <p><?= $gender ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Father Name</label>
                          <p><?= $father_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Mother Name</label>
                          <p><?= $mother_name ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Age</label>
                          <p><?= $age ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Contact</label>
                          <p><?= $contact ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">E-mail</label>
                          <p><?= $email ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">NID/Birth Certificate No</label>
                          <p><?= $nid_no ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Blood Group</label>
                          <p><?= $blood_grp ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Have a Computer</label>
                          <p><?= $computer ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Profession</label>
                          <p><?= $profession ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Religion</label>
                          <p><?= $religion ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Disabilities</label>
                          <p><?= $disabilities ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Address</label>
                          <p><?= $address ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Permanent Address</label>
                          <p><?= $perma_address ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Last Academic Qualification</label>
                          <p><?= $edu_qual ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Passing Year</label>
                          <p><?= $pass_year ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">LinkedIn</label>
                          <p><?= $linked_in ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Upwork</label>
                          <p><?= $upwork ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Fiverr</label>
                          <p><?= $fiver ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Freelancing Link 3</label>
                          <p><?= $link_three ?></p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Freelancing Link 4</label>
                          <p><?= $link_four ?></p>
                        </div>
                      </div>

                      <div class="col-md-6" style="display: none;">
                        <div class="form-group">
                          <label class="control-label">Active/In-Active</label>
                          <p>
                            <select style="width: 100%;" class="form-control" name="status">
                              <option value="1" <?php if ($status == 1) echo 'selected' ?>>Active</option>
                              <option value="0" <?php if ($status == 0) echo 'selected' ?>>In-Active</option>
                            </select>
                          </p>
                        </div>
                      </div>

                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Photo</label>
                          <p><img src="user_images/<?= $userPic ?>" height="150" width="150" /></p>
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