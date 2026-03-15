<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

  <style type="text/css">
    table,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;

      text-align: center;
    }
  </style>

</head>

<body>

  <?php
  require_once 'session.php';
  require_once '../admin/includes/conn.php';
  require_once '../admin/includes/dbconfig.php';

  ?>


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
            <a href="https://e-laeltd.com/jubo/project/all-student-filter" class="btn btn-danger">Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>



  <?php include('student-list-all.php'); ?>