<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- App favicon -->
  <link rel="shortcut icon" href="website/favicon.png">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

  <style type="text/css">
    table,
    tr,
    th,
    td {
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>

</head>

<body>

  <?php
  require_once 'session.php';
  require_once '../admin/includes/conn.php';
  require_once '../admin/includes/dbconfig.php';

  ?>


  <div class="row">
    <div class="col-lg-12 mt-1 aos-init aos-animate" data-aos="fade-left">
      <img src="../project/assets/img/all/banner.jpg" class="img-fluid rounded shadow" alt="" width="100%">
    </div>
    <!-- <div class="col-12 text-center mt-5 mb-3 border-bottom pb-2">
      <h3>Student Earning Status</h3>
    </div> -->
  </div>



  <!-- <div class="row">
    <div class="col-12 text-center mt-5 d-flex justify-content-between mx-5 mb-3 border-bottom pb-2">
      <h3>Student Earning Status</h3>
      <button>Export</button>
    </div>
  </div> -->

  <div class="container-fluid">
    <div class="d-flex justify-content-between my-3">
        <h3>Student Earning Status</h3>
     <button class="btn btn-primary" onclick="exportToExcel('dataTables-example')">Export</button>

    </div>
    <table width="100%" class="table m-0 table-bordered" student_id="dataTables-example">
      <thead class="bg-light ">
        <tr>
          <th>SL</th>
          <th>STD ID</th>
          <th>Branch Name</th>
          <th>Studnet Name</th>
          <th>Gender</th>
          <th>Fathers Name</th>
          <th>Contact No.</th>
          <th>Earning Dollar</th>
          <th>Earning BD</th>
          <th>Work Source</th>
          <th>Fiver</th>
          <th>Upwork</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <?php
        $sl = 0;

        $DistID = isset($_GET['dist_id']) ? $_GET['dist_id'] : null;
        $BatchID = isset($_GET['batch_id']) ? $_GET['batch_id'] : null;
        $GroupID = isset($_GET['group_id']) ? $_GET['group_id'] : null;

        if ($DistID && $BatchID && $GroupID) {
          $query = "SELECT distinct * FROM income_info 
          LEFT JOIN jobs ON jobs.j_id = income_info.job_id 
          LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
          LEFT JOIN district ON district.id = student_list.district 
          LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
          LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
          WHERE income_info.status=1
          AND student_list.district = $DistID
          AND student_list.batch_id = $BatchID
          AND student_list.group_id = $GroupID
          ORDER BY income_info.earning_dollar desc";
        } else if ($DistID && $BatchID) {
          $query = "SELECT distinct * FROM income_info 
          LEFT JOIN jobs ON jobs.j_id = income_info.job_id 
          LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
          LEFT JOIN district ON district.id = student_list.district 
          LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
          LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
          WHERE income_info.status=1
          AND student_list.district = $DistID
          AND student_list.batch_id = $BatchID
          ORDER BY income_info.earning_dollar desc";
        }

        $eq = mysqli_query($con, $query);

        // Check if any records are found
        if (mysqli_num_rows($eq) > 0) {
          while ($eqrow = mysqli_fetch_array($eq)) {
            $StudentId = $eqrow['student_id'];
            $incomeQuery = mysqli_query($con, "SELECT * FROM income_info 
            LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
            WHERE income_info.student_id = $StudentId ORDER BY income_info.in_id asc");
            $incomeRow = mysqli_fetch_array($incomeQuery);
        ?>

            <tr>
              <td><?= ++$sl; ?></td>
              <td><?= $eqrow['student_id']; ?></td>
              <td><?= $eqrow['dist_name']; ?></td>
              <td><?= $eqrow['stu_name']; ?></td>
              <td><?= $eqrow['gender']; ?></td>
              <td><?= $eqrow['father_name']; ?></td>
              <td><?= $eqrow['contact']; ?></td>

              <td> $<?= number_format($eqrow['earning_dollar'], 2) ?> </td>
              <td> <strong style="font-size: 22px;">৳</strong><?= number_format($eqrow['earning_bd'], 2) ?> </td>
              <td><?= $incomeRow['work_name']; ?></td>
                 <td><a href="<?= $eqrow['fiver']; ?>"><?= $eqrow['fiver']; ?></a></td>
                 <td><a href="<?= $eqrow['upwork']; ?>"><?= $eqrow['upwork']; ?> </a></td>
              <td></td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="12" class="text-center py-2">No records found.!</td>
          </tr>
        <?php
        }
        ?>
      </tbody>



    </table>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


  <script>
function exportToExcel(tableID, filename = 'student_earning_status.xlsx') {
    const table = document.querySelector(`table[student_id="${tableID}"]`);
    const wb = XLSX.utils.table_to_book(table, {sheet:"Sheet1"});
    XLSX.writeFile(wb, filename);
}
</script>
