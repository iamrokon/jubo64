<!-- Font Awesome CDN for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Taking the Card Details from Database -->


<div class="col-lg-12 mt-3" data-aos="fade-left">
  <div class="row g-3">
    <!-- Card 1 - Districts -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d4edda;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-map-marker-alt fs-2 icon-hover text-success"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark">
            <?php
              $sql = $con->query("SELECT count(`dist_name`) as `total` FROM `district`");
              $row = $sql->fetch_assoc();
              echo $row['total'];
            ?>
          </h4>
          <p class="text-muted mb-0">Districts</p>
        </div>
      </div>
    </div>

    <!-- Card 2 - Batches -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #f8d7da;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-layer-group fs-2 icon-hover text-danger"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark">
            <?php
              $sql = $con->query("SELECT count(`batch_name`) as `total` FROM `batch_list`");
              $row = $sql->fetch_assoc();
              echo $row['total'];
            ?>
          </h4>
          <p class="text-muted mb-0">Batches</p>
        </div>
      </div>
    </div>

    <!-- Card 3 - Total Students -->
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

    <!-- Card 4 - Male Students -->
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

    <!-- Card 5 - Female Students -->
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

    <!-- Card 6 - Total Earned -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #fff3cd;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-dollar-sign fs-2 icon-hover text-warning"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark">
            <?php
              $sql = $con->query("SELECT SUM(`earning_dollar`) as `total` FROM `income_info`");
              $row = $sql->fetch_assoc();
              echo $row['total'];
            ?>
          </h4>
          <p class="text-muted mb-0">Total Earned</p>
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