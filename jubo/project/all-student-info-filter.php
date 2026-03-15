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


  <div class="container mt-4">

    <div class="card">
      <div class="card-body">
        <form action="">
          <div class="row align-items-center justify-content-center">

            <div class="col-md-2 form-group m-md-0">
              <select Id="DistId" name="district_id" class="form-control" required>
                <option value="">Select District</option>
                <?php
                $DistID = isset($_GET['district_id']) ? $_GET['district_id'] : null;
                $sl = 0;
                $sql = "SELECT distinct student_list.district,district.dist_name,district.id FROM student_list left join district on district.id=student_list.district order by student_list.student_id ASC ";
                $result = $con->query($sql);

                while ($row = $result->fetch_array()) {
                  $selected = ($row['id'] == $DistID) ? 'selected' : '';
                  echo "<option value='" . $row['id'] . "' $selected>" . $row['dist_name'] . "</option>";
                }

                ?>
              </select>
            </div>


            <div class="col-md-2 form-group m-md-0">
              <select Id="Batch" name="batch_id" class="form-control" required>
                <option value="">Select Batch</option>
                <?php
                $BatchID = $_GET['batch_id'];
                $sql = "SELECT * FROM batch_list";
                $result = $con->query($sql);

                while ($row = $result->fetch_array()) {
                  $selected = ($row['batch_id'] == $BatchID) ? 'selected' : '';
                  echo "<option value='" . $row['batch_id'] . "' $selected>" . $row['batch_name'] . "</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-md-2 form-group m-md-0">
              <select Id="Group" name="group_id" class="form-control">
                <option value="">Select Group</option>
                <?php
                $GroupID = $_GET['group_id'];
                $sql = "SELECT * FROM group_list";
                $result = $con->query($sql);

                while ($row = $result->fetch_array()) {
                  $selected = ($row['group_id'] == $GroupID) ? 'selected' : '';
                  echo "<option value='" . $row['group_id'] . "' $selected>" . $row['group_name'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-2 form-group m-md-0">
              <button class="btn btn-success">Filter Now</button>
              <a href="https://e-laeltd.com/jubo/project/all-student-info-filter" class="btn btn-danger">Reset</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="student_info">

      <?php

      $DistID = isset($_GET['district_id']) ? $_GET['district_id'] : null;
      $BatchID = isset($_GET['batch_id']) ? $_GET['batch_id'] : null;
      $GroupID = isset($_GET['group_id']) ? $_GET['group_id'] : null;

      if ($DistID && $BatchID && $GroupID) {
        $stmt = $DB_con->prepare("SELECT * FROM income_info
        LEFT JOIN jobs ON jobs.j_id = income_info.job_id
        LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
        LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id
        LEFT JOIN district ON district.id = student_list.district
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id
        WHERE income_info.earning_dollar !=0
        AND student_list.district = $DistID
        AND student_list.batch_id = $BatchID
        AND student_list.group_id = $GroupID
        ORDER BY income_info.student_id ASC LIMIT 50");
      } else if ($DistID && $BatchID) {
        $stmt = $DB_con->prepare("SELECT * FROM income_info
        LEFT JOIN jobs ON jobs.j_id = income_info.job_id
        LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
        LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id
        LEFT JOIN district ON district.id = student_list.district
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id
        WHERE income_info.earning_dollar !=0
        AND student_list.district = $DistID
        AND student_list.batch_id = $BatchID
        ORDER BY income_info.student_id ASC LIMIT 50");
      } else {
        $stmt = $DB_con->prepare("SELECT * FROM income_info
        LEFT JOIN jobs ON jobs.j_id = income_info.job_id
        LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
        LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id
        LEFT JOIN district ON district.id = student_list.district
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id
        WHERE income_info.earning_dollar !=0
        ORDER BY income_info.student_id ASC LIMIT 50");
      }





      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        while ($eqrow = $stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="card text-center my-3">
            <div class="card-body">
              <h2><?= $eqrow['student_id'] ?></h2>
              <img class="rounded" src="../dist/user_images/<?= $eqrow['userPic'] ?>" height="150" width="150">
              <h4 class="text-uppercase"><?= $eqrow['stu_name'] ?><br></h4>
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

              if ($eqrow['link_three'] && $eqrow['link_three'] !== 'none') {
                echo "<h6>Freelancing Link: " . "<a href='" . $eqrow['link_three'] . "'>" . $eqrow['link_three'] . "</a></h6>";
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


              <?php } ?>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p class='py-3'>No data found.</p>";
      }
      ?>





    </div>


  </div>

  <br><br>