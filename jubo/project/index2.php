<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>

  <style>
    .table td,
    .table th {
      vertical-align: middle !important;
    }

    .table thead tr>th {
      padding: 12px 8px !important;
    }

    .table tbody tr>td {
      padding: 8px 8px !important;
    }
  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>
  <!-- End Header -->

  <main id="main">
    <?php //include('breadcrumb.php'); 
    ?>

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us mt-5">
      <div class="container" data-aos="fade-left">


        <div class="row content">


          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <img src="assets/img/all/banner.jpg" class="img-fluid rounded shadow" alt="" width="100%">
          </div>


          <div class="col-12 my-5">
            <div class="row">
              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT COUNT(`id`) AS count FROM `district`");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Total Branchs</h4>
                    <strong><?= $row['count'] ?></strong>
                  </div>
                </div>
              </div>



              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT COUNT(`batch_id`) AS count FROM `batch_list`");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Total Batch</h4>
                    <strong><?= $row['count'] ?></strong>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT COUNT(`student_id`) AS count FROM `student_list`");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Total Students</h4>
                    <strong><?= $row['count'] ?></strong>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT COUNT(`student_id`) AS count FROM `student_list` WHERE gender = 'Male'");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Male Students</h4>
                    <strong><?= $row['count'] ?></strong>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT COUNT(`student_id`) AS count FROM `student_list` WHERE gender = 'Female'");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Female Students</h4>
                    <strong><?= $row['count'] ?></strong>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT SUM(`earning_dollar`) AS count FROM `income_info`");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Total Dollar Earn</h4>
                    <strong><?= '$' . number_format($row['count'], 2) ?></strong>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 my-2" data-aos="fade-left">
                <div class="shadow rounded border p-3 d-flex align-items-center">
                  <div class="mr-3">
                    <i class="fas fa-users fa-3x"></i>
                  </div>
                  <div>

                    <?php
                    $sql  = $con->query("SELECT SUM(`earning_bd`) AS count FROM `income_info`");
                    $row = $sql->fetch_assoc();
                    ?>

                    <h4 class="mb-1">Total TK Earn</h4>
                    <strong><?= '৳' . number_format($row['count'], 2) ?></strong>
                  </div>
                </div>
              </div>

            </div>
          </div>


        </div>

      </div>
    </section>

  </main>

  <?php include('footer.php'); ?>