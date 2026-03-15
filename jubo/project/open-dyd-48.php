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
            <img src="assets/img/all/banner-2.jpg" class="img-fluid rounded shadow" alt="" width="100%">
          </div>

      
    
       

          <div class="col-lg-12 ">
            <div class="mt-3 shadow rounded d-flex justify-content-between align-items-center p-3" data-aos="fade-left">
  <h3 class="text-center m-0">
    <strong>Student List</strong>
  </h3>
  <a href="earningns-info" class="btn btn-primary">
    <i class="fa fa-refresh"></i> Back
  </a>
</div>
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

           <?php


// Sanitize POST values
$district = isset($_POST['DistId']) ? mysqli_real_escape_string($con, $_POST['DistId']) : '';
$batch = isset($_POST['Batch']) ? mysqli_real_escape_string($con, $_POST['Batch']) : '';

// Only query if both filters are provided
$sql = "SELECT * FROM dyd_48_income WHERE district = '$district' AND batch = '$batch' ORDER BY id DESC";
$result = mysqli_query($con, $sql);
$sl = 0;
?>

<table width="100%" class="table table-hover table-striped m-0" student_id="dataTables-example">
  <thead class="bg-dark text-white">
    <tr>
      <th>SL</th>
      <th>Name</th>
      <th>District</th>
      <th>Batch</th>
      <th>Phone</th>
      <th>Income</th>
      <th>Jobs</th>
    </tr>
  </thead>

  <tbody id="tbody">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($eqrow = mysqli_fetch_array($result)): ?>
        <tr>
          <td><?php echo ++$sl; ?></td>
          <td><?php echo $eqrow['student_name']; ?></td>
          <td><?php echo $eqrow['district']; ?></td>
          <td><?php echo $eqrow['batch']; ?></td>
          <td><?php echo $eqrow['phone']; ?></td>
          <td><?php echo $eqrow['income']; ?></td>
          <td><?php echo $eqrow['jobs']; ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" class="text-center text-danger">No data found for the selected district and batch.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>



            </div>
          </div>

        </div>

      </div>
    </section>

  </main>

  <?php include('footer.php'); ?>