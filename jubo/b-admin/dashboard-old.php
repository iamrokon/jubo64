<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <div class="page-title">
        <h4 class="mb-0 font-size-18">Dashboard</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Welcome to E-Learning & Earning Ltd.</li>
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

<!-- Start page content-wrapper -->
<div class="page-content-wrapper mt-2">
  <div class="row">
  

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-success mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
            <?php
            $sql = $con->query("SELECT count(`id`) as `total` FROM `trainer` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Trainers</h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-account-tie mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>
	   


	<div class="col-xl-3 col-md-6">
      <div class="card alert alert-primary mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
            <?php
            $sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Students</h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-account-group mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

	
	<div class="col-xl-3 col-md-6">
      <div class="card alert alert-info mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'male' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Male Students</h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-human-male mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>
	


	<div class="col-xl-3 col-md-6">
      <div class="card alert alert-danger mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'female' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Female Students</h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-human-female mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

   

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-danger mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
          <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_dollar`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Dollar Earning</h5>
              <h3 class="text-black">$<?= number_format($row['total'], 2) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-cash-multiple mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-success mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
          <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_bd`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">BD Tk Earning </h5>
              <h3 class="text-black"><strong>৳</strong><?= number_format($row['total'], 2) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-currency-bdt mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-primary mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
          <?php
            $sql = $con->query("SELECT count(`j_id`) as `total` FROM `jobs`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Jobs</h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-tag-multiple mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-info mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
            <?php
            $sql = $con->query("SELECT count(`batch_id`) as `total` FROM `batch_list`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Baches </h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-cube-outline mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-danger mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
          <?php
            $sql = $con->query("SELECT count(`pm_id`) as `total` FROM `payment_method`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Payment Method </h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-contactless-payment mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card alert alert-success mini-stat position-relative shadow p-0">
        <div class="card-body p-3">
          <div class="mini-stat-desc">
          <?php
            $sql = $con->query("SELECT count(`ws_id`) as `total` FROM `work_source`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="mt-2">
              <h5 class="text-uppercase font-size-16 text-black">Work Source </h5>
              <h3 class="text-black"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>
			
            <div class="mini-stat-icon">
              <i class="text-black mdi mdi-check-network mt-2"></i>
            </div>
			
          </div>
        </div>
      </div>
    </div>

    <!-- End Col -->
  </div>
  <!-- End Row -->


  <!-- <hr class="my-5"> -->


  <div class="row d-none">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`id`) as `total` FROM `trainer` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Trainers</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-account-tie display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-account-group display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'male' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Male Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-human-male display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'female' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Female Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-human-female display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_dollar`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Dollar Earning</h5>
              <h3 class="mb-3 text-white">$<?= number_format($row['total'], 2) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-cash-multiple display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_bd`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">BD Tk Earning</h5>
              <h3 class="mb-3 text-white"><strong>৳</strong><?= number_format($row['total'], 2) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-currency-bdt display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`j_id`) as `total` FROM `jobs`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Jobs</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-tag-multiple display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`batch_id`) as `total` FROM `batch_list`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Baches</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-cube-outline display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`pm_id`) as `total` FROM `payment_method`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Payment Method</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-contactless-payment display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`ws_id`) as `total` FROM `work_source`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Work Source</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white">
              <i class="mdi mdi-check-network display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->
  </div>


  <!-- <hr class="my-5"> -->


  <div class="rown d-none">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`id`) as `total` FROM `trainer` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Trainers</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-account-tie display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list` WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-account-group display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'male' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Male Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-human-male display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT COUNT(*) AS total FROM student_list WHERE gender = 'female' AND `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Female Students</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-human-female display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_dollar`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Dollar Earning</h5>
              <h3 class="mb-3 text-white">$<?= number_format($row['total'], 2) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-cash-multiple display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = mysqli_query($con, "SELECT SUM(`earning_bd`) AS total FROM income_info WHERE `user_id`  = " . $_SESSION['id'] . "");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">BD Tk Earning</h5>
              <h3 class="mb-3 text-white"><strong>৳</strong><?= number_format($row['total'], 2) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-currency-bdt display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`j_id`) as `total` FROM `jobs`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Jobs</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-tag-multiple display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`batch_id`) as `total` FROM `batch_list`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Baches</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-cube-outline display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`pm_id`) as `total` FROM `payment_method`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Payment Method</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-contactless-payment display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat position-relative shadow">
        <div class="card-body">
          <div class="mini-stat-desc d-flex align-items-center justify-content-between">

            <?php
            $sql = $con->query("SELECT count(`ws_id`) as `total` FROM `work_source`");
            $row = $sql->fetch_assoc();
            ?>

            <div class="text-white">
              <h5 class="text-uppercase font-size-16 text-white-50">Work Source</h5>
              <h3 class="mb-3 text-white"><?= str_pad($row['total'], 2, 0, STR_PAD_LEFT) ?></h3>
            </div>

            <div class="text-white icon">
              <i class="mdi mdi-check-network display-5 text-white-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Col -->
  </div>



  <div class="row d-none">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-xl-8 border-end">
              <h4 class="card-title mb-4">Sales Report</h4>
              <div id="morris-area-example" class="dashboard-charts morris-charts" data-colors='["--bs-light", "--bs-warning", "--bs-primary"]'>
              </div>
            </div>
            <!-- End Col -->

            <div class="col-xl-4">
              <h4 class="card-title mb-4">Yearly Sales Report</h4>
              <div class="p-3">
                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-first-tab" data-bs-toggle="pill" href="#pills-first" role="tab" aria-controls="pills-first" aria-selected="true">2015</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-second-tab" data-bs-toggle="pill" href="#pills-second" role="tab" aria-controls="pills-second" aria-selected="false">2016</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-third-tab" data-bs-toggle="pill" href="#pills-third" role="tab" aria-controls="pills-third" aria-selected="false">2017</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane show active" id="pills-first" role="tabpanel" aria-labelledby="pills-first-tab">
                    <div class="p-3">
                      <h2>$17562</h2>
                      <p class="text-muted">Maecenas nec odio et ante
                        tincidunt tempus. Donec vitae sapien ut libero
                        venenatis faucibus Nullam quis ante.</p>
                      <a href="#" class="text-primary">Read more...</a>
                    </div>
                  </div>
                  <div class="tab-pane" id="pills-second" role="tabpanel" aria-labelledby="pills-second-tab">
                    <div class="p-3">
                      <h2>$18614</h2>
                      <p class="text-muted">Maecenas nec odio et ante
                        tincidunt tempus. Donec vitae sapien ut libero
                        venenatis faucibus Nullam quis ante.</p>
                      <a href="#" class="text-primary">Read more...</a>
                    </div>
                  </div>
                  <div class="tab-pane" id="pills-third" role="tabpanel" aria-labelledby="pills-third-tab">
                    <div class="p-3">
                      <h2>$19752</h2>
                      <p class="text-muted">Maecenas nec odio et ante
                        tincidunt tempus. Donec vitae sapien ut libero
                        venenatis faucibus Nullam quis ante.</p>
                      <a href="#" class="text-primary">Read more...</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Col -->
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>
  </div>

</div>
<!-- end page-content-wrapper-->