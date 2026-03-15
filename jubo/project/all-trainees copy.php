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

        <div class="row content justify-content-center align-items-center">

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <img src="assets/img/all/banner-2.jpg" class="img-fluid rounded shadow" alt="" width="100%">
          </div>

          <div class="col-lg-12 ">
            <div class="mt-3 mb-3 rounded shadow py-2 px-2">
              <h1 class="text-center">All Trainees List</h1>
              <!-- <p>"Employment Creation Through Freelancing Training for the Educated Job Seekers Project in 48 District of the Country"</p> -->
            </div>
          </div>

          <?php // include('category-card.php'); 
          ?>

          <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
              <form class="form-horizontal" target="_blank" action="open-dyd-48-trainees" method="post" id="getOrderReportForm">
                <div class="form-row mt-3">
                  <div class="col-md-3 form-group text-center">
                    <h3> District Wise Reports </h3>
                  </div>

                  <div class="col-md-3 form-group">
                    <select id="DistId" name="DistId" class="form-control" required>
                      <option value="">Select District</option>
                      <?php
                      $sql = "SELECT DISTINCT district FROM dyd_48_income ORDER BY district ASC";
                      $result = $con->query($sql);
                      while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-3 form-group">
                    <select id="Batch" name="Batch" class="form-control" required>
                      <option value="">Select Batch</option>
                      <?php
                      $sql = "SELECT DISTINCT batch FROM dyd_48_income ORDER BY batch ASC";
                      $result = $con->query($sql);
                      while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row['batch'] . "'> Batch-" . $row['batch'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-3 form-group">
                    <button type="submit" class="btn btn-success" id="generateReportBtn">
                      <i class="glyphicon glyphicon-ok-sign"></i> Open Report
                    </button>
                  </div>
                </div>
              </form>

              <script src="custom/js/report.js"></script>
            </div>
          </div>


          <!-- <div class="col-lg-12 mt-3" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> Trainer List </strong></h3>
          </div>

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php include('trainer-list.php'); ?>
            </div>
          </div> -->

          <div class="col-lg-12 mt-3n d-none" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> All Trainees List </strong></h3>
          </div>

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php // include('student-list-home.php'); 
              ?>
              <?php // include('student-list-home1.php'); 
              ?>

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

              <table width="100%" class="table table-hover table-striped m-0" student_id="dataTables-example">
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