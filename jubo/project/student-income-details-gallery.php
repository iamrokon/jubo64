<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>

  <!-- Include Lightbox CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

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

    .title {
      text-align: center;
      margin: 4rem 0 12px 0;
    }

    .title h4 {
      font-size: 16px;
      background: rgb(11, 164, 6, .3);
      display: inline-block;
      padding: 8px 48px;
      border-radius: 4px;
      color: #000;
    }

    .student_info h2 {
      position: absolute;
      left: 0;
      top: 0;
      padding: 6px 22px;
      background: #28a745;
      color: #fff;
      border-radius: 4px 0 4px 0;
      margin: 0;
      font-size: 22px;
    }


    .student_info h4 {
      margin-top: 1rem;
    }

    .student_info h6 {
      color: #000;
    }

    .student_info p {
      text-align: center;
      color: #000;
    }
  </style>

</head>

<body>

  <div class="d-none"> <?php include('header.php'); ?></div>

  <!-- <section id="about-us" class="about-us p-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mt-1">
          <img src="assets/img/all/banner.jpg" class="img-fluid rounded shadow" alt="" width="100%">
        </div>
      </div>
    </div>
  </section> -->

  <?php
  if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt_edit = $DB_con->prepare('SELECT * FROM student_list 
    left join district on district.id=student_list.district 
    left join batch_list on batch_list.batch_id=student_list.batch_id 
    left join group_list on group_list.group_id=student_list.group_id 
    WHERE student_list.student_id =:uid');
    $stmt_edit->execute(array(':uid' => $student_id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
  }

  ?>





  <div class="container mt-4">

    <div class="student_info">
      <div class="card text-center">
        <div class="card-body">
          <h2><?= $student_id ?></h2>
          <img class="rounded" src="../stu-info/user_images/<?= $userPic; ?>" height="150" width="150">
          <h4><?= $stu_name; ?> <br></h4>
          <h6>District : <?= $dist_name; ?> | <?= $batch_name; ?> | <?= $group_name; ?> | Contact: <?= $contact ?> | Email: <?= $email ?></h6>



          <h6> Jobs:
            <?php
            $student_id = $_GET['student_id'];
            $stmt = $DB_con->prepare("SELECT * FROM income_info
              LEFT JOIN jobs ON jobs.j_id = income_info.job_id
              WHERE student_id = $student_id");
            $stmt->execute();

            $jobs = array();
            while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $jobs[] = $eqrow['job_name'];
            }

            if (!empty($jobs)) {
              $jobs_str = implode(", ", $jobs);
              echo $jobs_str;
            } else {
              echo 'N/A';
            }
            ?>

            | Earning Platform:
            <?php
            $student_id = $_GET['student_id'];
            $stmt = $DB_con->prepare("SELECT * FROM income_info
              LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
              WHERE student_id = $student_id");
            $stmt->execute();

            $earnings = array();
            while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $earnings[] = $eqrow['work_name'];
            }

            if (!empty($earnings)) {
              $earnings_str = implode(", ", $earnings);
              echo $earnings_str;
            } else {
              echo 'N/A';
            }
            ?>
          </h6>

          <h6> Payment Method:
            <?php
            $student_id = $_GET['student_id'];
            $stmt = $DB_con->prepare("SELECT * FROM income_info
              LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
              WHERE student_id = $student_id");
            $stmt->execute();

            $payment_methods = array();
            while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $payment_methods[] = $eqrow['payment_name'];
            }

            if (!empty($payment_methods)) {
              $payment_methods_str = implode(", ", $payment_methods);
              echo $payment_methods_str;
            } else {
              echo 'N/A';
            }
            ?>
          </h6>



          <h6>Earned Amount Dollar ($) :
            <?php
            $student_id = $_GET['student_id'];
            $stmt = $DB_con->prepare("SELECT SUM(earning_dollar) AS total_dollar FROM income_info WHERE student_id = $student_id");
            $stmt->execute();
            $eqrow = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p class='d-inline-block m-0'> <strong>$</strong>" . number_format($eqrow['total_dollar'], 2) . "</p>";
            ?>


            | Earned Amount BD.TK :
            <?php
            $student_id = $_GET['student_id'];
            $stmt = $DB_con->prepare("SELECT SUM(earning_bd) AS total_bd FROM income_info WHERE student_id = $student_id");
            $stmt->execute();
            $eqrow = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p class='d-inline-block m-0'> <strong>৳</strong>" . number_format($eqrow['total_bd'], 2) . "</p>";
            ?>
          </h6>


          <?php
          if ($upwork && $upwork !== 'none') {
            echo "<h6>Upwork: " . "<a href='" . $upwork . "'>" . $upwork . "</a></h6>";
          }

          if ($fiver && $fiver !== 'none') {
            echo "<h6>Fiverr: " . "<a href='" . $fiver . "'>" . $fiver . "</a></h6>";
          }

          if ($link_three && $link_three !== 'none') {
            echo "<h6>Freelancing Link: " . "<a href='" . $link_three . "'>" . $link_three . "</a></h6>";
          }
          ?>


          <p class="mt-2 m-0"><?= $about; ?></p>

        </div>
      </div>
    </div>


    <div class="title">
      <h4>Earning Info Status On Image</h4>
    </div>



    <div class="incomePic text-center">
      <div class="row justify-content-center">
        <?php
        $StudentId = $_GET['student_id'];
        $stmt = $DB_con->prepare("SELECT * FROM income_info WHERE student_id = ? ORDER BY in_id DESC");
        $stmt->execute([$StudentId]);
        while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $images = explode(",", $eqrow['incomePics']);
          foreach ($images as $key => $image) {
            $imageId = "image_" . $key;
            echo "<div class='col-lg-3 col-md-4 col-sm-6 col-12 p-2'><a href='../dist/$image' data-lightbox='incomeGallery' data-title='Image'><img src='../dist/$image' alt='Image' class='rounded' style='width: 100%; height: 220px;'></a></div>";
          }
        }
        ?>
      </div>
    </div>


    <!-- Include Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>

  </div>


  <br><br>