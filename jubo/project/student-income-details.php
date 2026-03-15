<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>

  <style type="text/css">
    .table td,
    .table th {
      padding: 2px;
    }

    .all {
      width: 70%;
      margin: auto;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 5px;
    }

    .table td,
    .table th {
      vertical-align: middle !important;
    }

    .table thead tr>th {
      padding: 12px 0 !important;
    }

    .title {
      text-align: center;
      margin: 4rem 0 12px 0;
    }

    .title h4 {
      font-size: 16px;
      background: rgb(11, 164, 6, .3);
      display: inline-block;
      padding: 8px 48px;
      border-radius: 2px;
      color: #000;
    }
  </style>

</head>

<body>

  <div class="d-none"> <?php include('header.php'); ?></div>

  <section id="about-us" class="about-us p-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mt-1">
          <img src="assets/img/all/banner.jpg" class="img-fluid rounded shadow" alt="" width="100%">
        </div>
      </div>
    </div>
  </section>

  <?php
  if (isset($_GET['view_id']) && !empty($_GET['view_id'])) {
    $IncomeId = $_GET['view_id'];
    $stmt_details = $DB_con->prepare('SELECT * FROM income_info 
    LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type 
    LEFT JOIN work_source ON work_source.ws_id = income_info.work_source 
    LEFT JOIN jobs ON jobs.j_id = income_info.job_id
    WHERE in_id = :uid');
    $stmt_details->execute(array(':uid' => $IncomeId));
    $details_row = $stmt_details->fetch(PDO::FETCH_ASSOC);

    // Assuming 'student_id' is the column name in the income_info table
    $student_id = $details_row['student_id'];
    $stmt_student = $DB_con->prepare('SELECT * FROM student_list 
    LEFT JOIN district ON district.id = student_list.district
    LEFT JOIN batch_list ON batch_list.batch_id=student_list.batch_id 
    LEFT JOIN group_list ON group_list.group_id=student_list.group_id 
    WHERE student_list.student_id = :uid');
    $stmt_student->execute(array(':uid' => $student_id));
    $student_row = $stmt_student->fetch(PDO::FETCH_ASSOC);
    extract($student_row);
  }
  ?>





  <div class="container mt-4">
    <div class="all border-0">

      <div class="row align-items-center">
        <div class="col-4">
          <img class="rounded" src="../dist/user_images/<?php echo $userPic; ?>" height="150" width="150" style="float: right;">
        </div>
        <div class="col-8">
          <div class="card">
            <div class="card-body">
              <p class="mb-1 text-dark">Name: <?= $stu_name ?></p>
              <p class="mb-1 text-dark">Student ID: <?= $details_row['studentID'] ?></p>
              <p class="mb-1 text-dark">District: <?= $dist_name ?></p>
              <p class="mb-1 text-dark">Batch: <?= $student_row['batch_name'] ?></p>
              <p class="mb-1 text-dark">Contact Number: <?= $contact ?></p>
              <p class="mb-1 text-dark">Email: <?= $email ?></p>
              <p class="mb-1 text-dark">Job: <?= $details_row['job_name'] ?></p>
              <p class="mb-1 text-dark">Earning Platform: <?= $details_row['work_name'] ?></p>

              <?php
              if ($details_row['earning_dollar']) {
                echo "<p class='mb-1 text-dark'>Earned Amount: $" . number_format($details_row['earning_dollar'], 2) . "</p>";
              } else {
                if ($details_row['earning_bd']) {
                  echo "<p class='mb-1 text-dark'>Earned Amount: ৳" . number_format($details_row['earning_bd'], 2) . "</p>";
                }
              }
              ?>

              <p class="mb-1 text-dark">Payment Method: <?= $details_row['payment_name'] ?></p>

              <?php
              if ($upwork !== 'none') { ?>
                <p class="mb-1 text-dark">Freelancing Link: <a target="_blank" href="<?= $upwork ?>"><?= $upwork ?></a></p>
              <?php }
              ?>

              <?php
              if ($fiver !== 'none') { ?>
                <p class="mb-1 text-dark">Freelancing Link: <a class="text-primary" target="_blank" href="<?= $fiver ?>"><?= $fiver ?></a></p>
              <?php }
              ?>

              <?php
              if ($link_three !== 'none') { ?>
                <p class="mb-1 text-dark">Freelancing Link: <a class="text-primary" target="_blank" href="<?= $link_three ?>"><?= $link_three ?></a></p>
              <?php }
              ?>


            </div>
          </div>
        </div>

      </div>

    </div>


    <div class="title">
      <h4>Earning Info Status</h4>
    </div>


    <div class="incomePic text-center">
      <?php
      $images = explode(",", $details_row['incomePics']);
      foreach ($images as $image) {
        echo "<img src='../dist/$image' alt='Image' class='rounded m-1' style='width: 260px; height: 180px;'>";
      }
      ?>
    </div>



  </div>


  <br><br>