<?php
require_once 'session.php';
require_once '../admin/includes/conn.php';
require_once '../admin/includes/dbconfig.php';
?>



<header id="page-topbar">
  <div class="navbar-header bg-success">
    <div class="d-flex">

      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
          <span class="logo-sm">
            <img src="website/sm-logo.png" alt="" height="22">
          </span>
          <span class="logo-lg">
            <img src="website/logo.png" alt="" height="24">
          </span>
        </a>
      </div>

      <!-- Menu Icon -->

      <button type="button" class="btn px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
        <i class="mdi mdi-menu"></i>
      </button>
    </div>



    <!-- User -->
    <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <h4>   <?php
                          $pq = mysqli_query($con, "select * from stuff left join `user` on user.userid=stuff.userid where stuff.userid='" . $_SESSION['id'] . "' ");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
<?php echo $pqrow['stuff_name']; ?>
						  <?php } ?>
	  <img class="rounded-circle header-profile-user" src="website/user.png" alt="Header Avatar">
	  </h4>   
      </button>

      <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item text-primary" href="logout"><i class="mdi mdi-power font-size-16 align-middle me-2 text-primary"></i><span>Logout</span></a>
      </div>
    </div>

  </div>
  </div>
</header>