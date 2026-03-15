<!-- Font Awesome CDN for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Taking the Card Details from Database -->

<style>
  p {
    font-size: 18px;
    color: #0ec760 !important;
  }
</style>

<div class="col-lg-12 mt-3" data-aos="fade-left">
  <div class="row g-3 justify-content-center align-items-stretch">
    <!-- Card 1 - Total Trainers -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d4edda;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-chalkboard-teacher h1 icon-hover text-success"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark" id="counter" data-target="432">0</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter = document.getElementById('counter');
              const target = +counter.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100); // adjust step
                if (count < target) {
                  count += increment;
                  counter.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter.innerText = target;
                }
              };

              updateCount();
            });
          </script>


          <p class="mb-0">Total Trainer</p>
        </div>
      </div>
    </div>

    <!-- Card 2 - Total Students -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #e2e3e5;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-user-graduate h1 icon-hover text-secondary"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark" id="counter2"
            data-target="10800">0</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter2 = document.getElementById('counter2');
              const target = +counter2.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100); // adjust step
                if (count < target) {
                  count += increment;
                  counter2.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter2.innerText = target;
                }
              };

              updateCount();
            });
          </script>

          <p class="mb-0">Total Trainee</p>
        </div>
      </div>
    </div>

    <!-- Card 3 - Male Students -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #cfe2ff;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-male h1 icon-hover text-primary"></i>
          </div>

          <h4 class="fw-bold mb-1 text-dark" id="counter3" data-target="6804">0 (63%)</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter3 = document.getElementById('counter3');
              const target = +counter3.getAttribute('data-target');
              const percentageText = ' (63%)';
              let count = 0;

              const speed = 20;

              const updateCount = () => {
                const increment = Math.ceil(target / 100);
                if (count < target) {
                  count += increment;
                  counter3.innerText = (count > target ? target : count) + percentageText;
                  setTimeout(updateCount, speed);
                } else {
                  counter3.innerText = target + percentageText;
                }
              };

              updateCount();
            });
          </script>

          <p class="mb-0">Male Trainee</p>
        </div>
      </div>
    </div>

    <!-- Card 4 - Female Students -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #fce5cd;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-female h1 icon-hover text-danger"></i>
          </div>

          <h4 class="fw-bold mb-1 text-dark" id="counter4" data-target="3996">0 (37%)</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter4 = document.getElementById('counter4');
              const target = +counter4.getAttribute('data-target');
              const percentageText = ' (37%)';
              let count = 0;

              const speed = 20;

              const updateCount = () => {
                const increment = Math.ceil(target / 100);
                if (count < target) {
                  count += increment;
                  counter4.innerText = (count > target ? target : count) + percentageText;
                  setTimeout(updateCount, speed);
                } else {
                  counter4.innerText = target + percentageText; // FIXED LINE
                }
              };

              updateCount();
            });
          </script>

          <p class="mb-0">Female Trainee</p>
        </div>
      </div>
    </div>


    <!-- Card 5 - Earnings (Dollar) -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #fff3cd;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-dollar-sign h1 icon-hover" style="color: #ed0808;"></i>
          </div>
          <!-- <h4 class="fw-bold mb-1 text-dark">
      <i class="fa-solid fa-dollar-sign"></i> 1,52,329
        </h4> -->

          <!-- <h4 class="fw-bold mb-1 text-dark" id="counter5" 
        data-target="<?php
                      // $sql = $con->query("SELECT SUM(`earning_dollar`) as `total` FROM `income_info`");
                      // $row = $sql->fetch_assoc();
                      // echo $row['total'];
                      ?>"> 0</h4> -->
          <div class="d-flex justify-content-center align-items-baseline">
            <h4 class="text-dark">$</h4>
            <h4 class="fw-bold mb-1 pl-1 text-dark" id="counter5" data-target="1353636">

              0</h4>
          </div>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter5 = document.getElementById('counter5');
              const target = +counter5.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100); // adjust step
                if (count < target) {
                  count += increment;
                  counter5.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter5.innerText = target;
                }
              };

              updateCount();
            });
          </script>
          <p class="mb-0">Earning in USD</p>
        </div>
      </div>
    </div>

    <!-- Card 6 - Earnings (DDT) -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #f8d7da;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">

            <i class="fa-solid fa-bangladeshi-taka-sign h1 icon-hover text-danger"></i>
          </div>
          <!-- <h4 class="fw-bold mb-1 text-dark" id="counter6" data-target="<?php
                                                                              // $sql = $con->query("SELECT SUM(`earning_bd`) as `total` FROM `income_info`");
                                                                              // $row = $sql->fetch_assoc();
                                                                              // echo $row['total'];
                                                                              ?>">
    0
</h4> -->
          <div class="d-flex justify-content-center align-items-baseline">
            <h4 class="text-dark fw-bold" style="font-weight: 600 !important; font-size: 22px;">৳</h4>
            <h4 class="fw-bold mb-1 pl-1 text-dark" id="counter6" data-target="60517244">
              0
            </h4>
          </div>



          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter6 = document.getElementById('counter6');
              const target = +counter6.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100);
                if (count < target) {
                  count += increment;
                  counter6.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter6.innerText = target;
                }
              };

              updateCount();
            });
          </script>


          <p class="mb-0">Earning in BDT</p>
        </div>
      </div>
    </div>


    <!-- Card 7 - Job Placements -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d1ecf1;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-briefcase h1 icon-hover text-info"></i>
          </div>
          <!-- <h4 class="fw-bold mb-1 text-dark">
         1512(60%)
        </h4> -->


          <h4 class="fw-bold mb-1 text-dark" id="counter7" data-target="6465">0 (59%)</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter7 = document.getElementById('counter7');
              const target = +counter7.getAttribute('data-target');
              const percentageText = ' (59%)'; // fixed text part
              let count = 0;

              const speed = 20;

              const updateCount = () => {
                const increment = Math.ceil(target / 100);
                if (count < target) {
                  count += increment;
                  counter7.innerText = (count > target ? target : count) + percentageText;
                  setTimeout(updateCount, speed);
                } else {
                  counter7.innerText = target + percentageText;
                }
              };

              updateCount();
            });
          </script>


          <p class="mb-0">Job Placements</p>
        </div>
      </div>
    </div>

    <!-- Card 8 - Completed Batch -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #d4edda;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-check-circle h1 icon-hover text-success"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark">
            04
          </h4>
          <p class="mb-0">Completed Batch</p>
        </div>
      </div>
    </div>

    <!-- Card 9 - On Going Batch -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #f0f0f0;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-spinner h1 icon-hover text-secondary"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark">
            5th
          </h4>
          <p class="mb-0">On Going Batch</p>
        </div>
      </div>
    </div>

    <!-- Card 10 - Running Trainers -->
    <div class="col-6 col-md-4 col-lg-2 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #e2f0d9;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-running h1 icon-hover text-success"></i>
          </div>
          <!-- <h4 class="fw-bold mb-1 text-dark">
         2400
        </h4> -->

          <h4 class="fw-bold mb-1 text-dark" id="counter10"
            data-target="3600">0</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter10 = document.getElementById('counter10');
              const target = +counter10.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100); // adjust step
                if (count < target) {
                  count += increment;
                  counter10.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter10.innerText = target;
                }
              };

              updateCount();
            });
          </script>
          <p class="mb-0">Running Trainee</p>
        </div>
      </div>
    </div>


     <!-- Card 12 - Attendance -->
    <div class="col-6 col-md-4 col-lg-2 mb-3 d-none">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #e2f0d9;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">
            <i class="fas fa-calendar-check h1 icon-hover text-success"></i>
          </div>
          
          <?php
            // Fetch Counts (Latest Batch Only)
            $t_stu = 0;
            $pres = 0;
            
            // 1. Get Latest Batch ID
            $l_b_q = $con->query("SELECT batch_id FROM batch_list WHERE status = 1 ORDER BY batch_id DESC LIMIT 1");
            $latest_batch_id = 0;
            if($l_b_q && $l_b_q->num_rows > 0){
                $latest_batch_id = $l_b_q->fetch_assoc()['batch_id'];
            }

            if($latest_batch_id){
                // Total Students in Latest Batch
                $t_q = $con->query("SELECT COUNT(*) as c FROM student_list WHERE batch_id = '$latest_batch_id'");
                if($t_q) $t_stu = $t_q->fetch_assoc()['c'];

                // Present Today in Latest Batch
                $today = date('Y-m-d');
                // Note: attendance.student_id links to student_list.stu_user_id
                $p_q = $con->query("SELECT COUNT(*) as c FROM attendance a 
                                    JOIN student_list s ON a.student_id = s.stu_user_id 
                                    WHERE a.att_date = '$today' AND s.batch_id = '$latest_batch_id'");
                if($p_q) $pres = $p_q->fetch_assoc()['c'];
            }

            $absent = $t_stu - $pres;
          ?>

          <h4 class="fw-bold mb-1 text-dark" id="counter12" data-target="<?= $pres ?>">0</h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter12 = document.getElementById('counter12');
              const target = +counter12.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100); // adjust step
                if (count < target) {
                  count += increment;
                  counter12.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter12.innerText = target;
                }
              };

              updateCount();
            });
          </script>
          <p class="mb-0" style="font-size: 16px;">Present Today</p>
          <div style="font-size: 12px; color: #555; margin-top: 5px;">
            <span class="fw-bold">Total: <?= $t_stu ?></span> | <span class="text-danger">Absent: <?= $absent ?></span>
          </div>
        </div>
      </div>
    </div>


    <!-- Card 11 - Total Earning -->
    <div class="col-6 col-md-4 col-lg-4 mb-3">
      <div class="card text-white text-center h-100 shadow-sm" style="background-color: #adeefd;">
        <div class="card-body">
          <div class="icon-wrapper mb-2">    
            <i class="fas fa-dollar-sign h1 icon-hover" style="color: #ed0808;"></i> <strong class="text-dark h2">+</strong>
            <i class="fa-solid fa-bangladeshi-taka-sign h1 icon-hover text-danger"></i>
          </div>
          <h4 class="fw-bold mb-1 text-dark" id="counter11" data-target="227014416">
            0
          </h4>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const counter11 = document.getElementById('counter11');
              const target = +counter11.getAttribute('data-target');
              let count = 0;

              const speed = 20; // Smaller value = faster

              const updateCount = () => {
                const increment = Math.ceil(target / 100);
                if (count < target) {
                  count += increment;
                  counter11.innerText = count > target ? target : count;
                  setTimeout(updateCount, speed);
                } else {
                  counter11.innerText = target;
                }
              };

              updateCount();
            });
          </script>


          <p class="mb-0 h5" style="color: red !important; font-weight: bold;">Total Earning in BDT</p>
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