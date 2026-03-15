<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="shortcut icon" href="website/favicon.png">
  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <style type="text/css">
    table, tr, th, td {
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
</div>

<div class="container-fluid">
  <div class="d-flex justify-content-between my-3">
    <h3>Student Earning Status</h3>
    <button class="btn btn-primary" onclick="exportToExcel('dataTables-example')">Export</button>
  </div>

  <table width="100%" class="table m-0 table-bordered" id="dataTables-example">
    <thead class="bg-light">
      <tr>
        <th>SL</th>
        <th>STD ID</th>
        <th>Branch Name</th>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Father's Name</th>
        <th>Contact No.</th>
        <th>Earning Dollar</th>
        <th>Earning BD</th>
        <th>Work Source</th>
        <th>Work Type</th>
        <th>Fiver</th>
        <th>Upwork</th>
        <th>Remarks</th>
      </tr>
    </thead>
    <tbody id="tbody">
      <?php
      $sl = 0;

    $query = "SELECT DISTINCT income_info.*, 
          student_list.stu_name, student_list.gender, student_list.father_name, student_list.contact,
          district.dist_name, student_list.student_id,
          jobs.job_name, student_list.fiver, student_list.upwork,
          (SELECT work_source.work_name FROM income_info as ii 
           LEFT JOIN work_source ON work_source.ws_id = ii.work_source 
           WHERE ii.student_id = income_info.student_id 
           ORDER BY ii.in_id ASC LIMIT 1) as work_name
          FROM income_info
          LEFT JOIN jobs ON jobs.j_id = income_info.job_id 
          LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
          LEFT JOIN district ON district.id = student_list.district 
          LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
          LEFT JOIN group_list ON group_list.group_id = student_list.group_id
          WHERE income_info.status = 1 AND student_list.batch_id = 12
          ORDER BY income_info.earning_dollar DESC";

      $eq = mysqli_query($con, $query);

      if ($eq && mysqli_num_rows($eq) > 0) {
        while ($eqrow = mysqli_fetch_assoc($eq)) {
          ?>
          <tr>
            <td><?= ++$sl; ?></td>
            <td><?= htmlspecialchars($eqrow['student_id']); ?></td>
            <td><?= htmlspecialchars($eqrow['dist_name']); ?></td>
            <td><?= htmlspecialchars($eqrow['stu_name']); ?></td>
            <td><?= htmlspecialchars($eqrow['gender']); ?></td>
            <td><?= htmlspecialchars($eqrow['father_name']); ?></td>
            <td><?= htmlspecialchars($eqrow['contact']); ?></td>
            <td>$<?= number_format($eqrow['earning_dollar'], 2); ?></td>
            <!-- <td><strong style="font-size: 22px;">৳</strong><?= number_format($eqrow['earning_bd'], 2); ?></td> -->
             <td><strong style="font-size: 22px;">৳</strong><?= number_format(floatval($eqrow['earning_bd']), 2); ?></td>

            <td><?= htmlspecialchars($eqrow['work_name']); ?></td>
            <td><?= htmlspecialchars($eqrow['job_name']); ?></td>
            <td>
              <?php if (!empty($eqrow['fiver'])): ?>
                <a href="<?= htmlspecialchars($eqrow['fiver']); ?>" target="_blank"><?= htmlspecialchars($eqrow['fiver']); ?></a>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($eqrow['upwork'])): ?>
                <a href="<?= htmlspecialchars($eqrow['upwork']); ?>" target="_blank"><?= htmlspecialchars($eqrow['upwork']); ?></a>
              <?php endif; ?>
            </td>
            <td></td>
          </tr>
        <?php
        }
      } else {
        ?>
        <tr>
          <td colspan="13" class="text-center py-2">No records found.!</td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>

<!-- XLSX library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Export Script -->
<script>
function exportToExcel(tableID, filename = 'student_earning_status.xlsx') {
    const table = document.getElementById(tableID);
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(wb, filename);
}
</script>

</body>
</html>
