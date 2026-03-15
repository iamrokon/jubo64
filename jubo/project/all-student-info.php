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
      padding-inline: 12px !important;
    }

    .table tbody tr>td {
      padding-inline: 12px !important;
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
      margin: 0;
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
    
 
  </style>

</head>

<body>

  <div class="d-none"> <?php include('header.php'); ?></div>


  <div class="container mt-4 mb-4" >

    <div class="student_info" >

      <?php
      $stmt = $DB_con->prepare("SELECT * FROM income_info
      LEFT JOIN jobs ON jobs.j_id = income_info.job_id
      LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
      LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
      LEFT JOIN student_list ON student_list.student_id = income_info.student_id
      LEFT JOIN district ON district.id = student_list.district
      LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
      LEFT JOIN group_list ON group_list.group_id = student_list.group_id
      WHERE income_info.status=1     
      ORDER BY income_info.earning_dollar desc ");
      $stmt->execute();
      while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <div class="card text-center my-3" style="height:1400px;">
          <div class="card-body">
            <h2><?= $eqrow['student_id'] ?></h2>
            <img class="rounded" src="../dist/user_images/<?= $eqrow['userPic'] ?>" height="150" width="150">
            <h4 class="text-uppercase"><?= $eqrow['stu_name'] ?><br></h4>
            <h6>NID No: <?= $eqrow['nid_no'] ?></h6><br>
            <h6>District: <?= $eqrow['dist_name'] ?> | <?= $eqrow['batch_name'] ?> | <?= $eqrow['group_name'] ?> | Contact: <?= $eqrow['contact'] ?> | Email: <?= $eqrow['email'] ?></h6>

            <h6>Jobs: <?= $eqrow['job_name'] ?> | Earning Platform: <?= $eqrow['work_name'] ?> | Payment Method: <?= $eqrow['payment_name'] ?></h6>


            <h6>
              <?php
              if ($eqrow['earning_dollar']) {
                echo 'Earned Amount Dollar ($): $' . number_format($eqrow['earning_dollar'], 2);
              } elseif ($eqrow['earning_bd']) {
                echo ' Earned Amount BD.TK: ৳' . number_format($eqrow['earning_bd'], 2);
              }
              ?>
            </h6>

            <?php
            if ($eqrow['upwork'] && $eqrow['upwork'] !== 'none') {
              echo "<h6>Upwork: " . "<a href='" . $eqrow['upwork'] . "'>" . $eqrow['upwork'] . "</a></h6>";
            }

            if ($eqrow['fiver'] && $eqrow['fiver'] !== 'none') {
              echo "<h6>Fiverr: " . "<a href='" . $eqrow['fiver'] . "'>" . $eqrow['fiver'] . "</a></h6>";
            }

            if ($eqrow['link_three']&& $eqrow['link_three'] !== 'none') {
              echo "<h6>Freelancing.com: " . "<a href='" . $eqrow['link_three'] . "'>" . $eqrow['link_three'] . "</a></h6>";
            }
            ?>

            <p><?= $eqrow['about'] ?></p>

            <?php
            if ($eqrow['incomePics']) {
            ?>

              <div class="title mt-4">
                <h4>Earning Info Status On Image</h4>
              </div>

              <div class="row justify-content-center">
                <?php
                $images = explode(",", $eqrow['incomePics']);
                foreach ($images as $key => $image) {
                  echo "<div class='col-lg-3 col-md-4 col-sm-6 col-12 p-2'><img src='../dist/$image' alt='Image' class='rounded' style='width: 100%; height: 220px;'></div>";
                }

                ?>
              </div>


            <?php       } ?>
          </div>
        </div>
      <?php
      }
      ?>





    </div>


  </div>

  <br><br>