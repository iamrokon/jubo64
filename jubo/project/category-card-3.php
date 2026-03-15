<!-- Font Awesome CDN for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Taking the Card Details from Database -->


<div class="col-lg-12 mt-3" data-aos="fade-left">
<div class="row g-3">
  <!-- Card 1 - Total Trainers -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d4edda;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-chalkboard-teacher fs-2 icon-hover text-success"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Total Trainers</p>
      </div>
    </div>
  </div>

  <!-- Card 2 - Total Students -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #e2e3e5;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-user-graduate fs-2 icon-hover text-secondary"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`stu_name`) as `total` FROM `student_list`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Total Students</p>
      </div>
    </div>
  </div>

  <!-- Card 3 - Male Students -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #cfe2ff;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-male fs-2 icon-hover text-primary"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`stu_name`) as `total` FROM `student_list` WHERE `gender` = 'Male'");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Male Students</p>
      </div>
    </div>
  </div>

  <!-- Card 4 - Female Students -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #fce5cd;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-female fs-2 icon-hover text-danger"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`stu_name`) as `total` FROM `student_list` WHERE `gender` = 'Female'");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Female Students</p>
      </div>
    </div>
  </div>

  <!-- Card 5 - Earnings (Dollar) -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #fff3cd;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-dollar-sign fs-2 icon-hover text-warning"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Earnings (Dollar)</p>
      </div>
    </div>
  </div>

  <!-- Card 6 - Earnings (DDT) -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #f8d7da;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-coins fs-2 icon-hover text-danger"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Earnings (DDT)</p>
      </div>
    </div>
  </div>

  <!-- Card 7 - Job Placements -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d1ecf1;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-briefcase fs-2 icon-hover text-info"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Job Placements</p>
      </div>
    </div>
  </div>

  <!-- Card 8 - Completed Batch -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d4edda;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-check-circle fs-2 icon-hover text-success"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Completed Batch</p>
      </div>
    </div>
  </div>

  <!-- Card 9 - On Going Batch -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #f0f0f0;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-spinner fs-2 icon-hover text-secondary"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">On Going Batch</p>
      </div>
    </div>
  </div>

  <!-- Card 10 - Running Trainers -->
  <div class="col-6 col-md-4 col-lg-2 mb-3">
    <div class="card text-white text-center h-100 shadow-sm" style="background-color: #e2f0d9;">
      <div class="card-body">
        <div class="icon-wrapper mb-2">
          <i class="fas fa-running fs-2 icon-hover text-success"></i>
        </div>
        <h4 class="fw-bold mb-1 text-dark">
          <?php
            $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
            $row = $sql->fetch_assoc();
            echo $row['total'];
          ?>
        </h4>
        <p class="text-muted mb-0">Running Trainers</p>
      </div>
    </div>
  </div>
</div>


  <!-- Hover effect for icons -->
  <style>
    .icon-hover {
      transition: all 0.3s ease-in-out;
    }

    .icon-hover:hover {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      border-radius: 50%;
    }
  </style>
</div>
<!-- End of the card section -->