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
  <?php include('session.php'); ?>
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
            <img src="assets/img/all/banner-2.jpg" class="img-fluid rounded shadow" alt="" width="100%">
          </div>

        <div class="col-lg-12 ">
            <div class="mt-3 mb-3 rounded shadow py-2 px-2">
          <h1 class="text-center">DASHBOARD</h1>
          <!-- <p>"Employment Creation Through Freelancing Training for the Educated Job Seekers Project in 48 District of the Country"</p> -->
          </div>
        </div>

          <?php include('category-card.php'); ?>

          <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
               <?php  include('report-by-category-old.php'); ?>
            </div>
          </div>

           <!-- <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
               <?php  include('attendance-report.php'); ?>
            </div>
          </div> -->


          <!-- <div class="col-lg-12 mt-3" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> Trainer List </strong></h3>
          </div>

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php include('trainer-list.php'); ?>
            </div>
          </div> -->

          <div class="col-lg-12 mt-3 d-none" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> All Trainees List </strong></h3>
          </div>

          <div class="col-lg-12 mt-1 d-none " data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php // include('student-list-home.php'); ?>
              <?php  // include('student-list-home1.php'); ?>
			  
              
              <table width="100%" class="d-none table table-hover table-striped m-0" student_id="dataTables-example">
                <thead class="bg-dark text-white">

                  <tr>

                    <th>SL</th>
                    <th>Name</th>
                    <th>Bistrict</th>
                    <th>Batch</th>
                    <th>Phone</th>
                    <th>Income</th>
                    <th>Jobs</th>

                  </tr>
                </thead>




                <tbody id="tbody">
                  <?php
                  $sl = 0;
                  $eq = mysqli_query($con, "SELECT * FROM dyd_48_income ORDER BY id DESC LIMIT 15");
                  while ($eqrow = mysqli_fetch_array($eq)) {
                  ?>
                    <tr>
                      <td><?php echo ++$sl; ?></td>
                      <td><?php echo $eqrow['student_name']; ?></td>
                      <td><?php echo $eqrow['district']; ?></td>
                      <td><?php echo $eqrow['batch']; ?></td>
                      <td><?php echo $eqrow['phone']; ?></td>
                      <td><?php echo $eqrow['income']; ?></td>
                      <td><?php echo $eqrow['jobs']; ?></td>
                    </tr>
                  <?php
                  }
                  ?>







                </tbody>

              </table>

			  
            </div>
          </div>

        </div>

      </div>
    </section>

  </main>

  <?php include('footer.php'); ?>