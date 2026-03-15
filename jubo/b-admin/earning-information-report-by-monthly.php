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
  </div>

  <div class="container-fluid">
    <div class="d-flex justify-content-between my-3">
      <h3>Student Earning Monthly Report </h3>
      <button class="btn btn-primary" onclick="exportToExcel('dataTables-example')">Export</button>
    </div>

    <table width="100%" class="table m-0 table-bordered" student_id="dataTables-example">
      <thead class="bg-light">
        <tr>
          <th>SL</th>
          <th>STD ID</th>
          <!-- <th>Branch Name</th> -->
          <th>Studnet Name</th>
          <th>Gender</th>
          <th>Fathers Name</th>
          <th>Contact No.</th>
          <th>Earning Dollar</th>
          <th>Earning BD</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <?php
        $sl = 0;
        $total_dollar = 0;
        $total_bd = 0;

        $DistID = isset($_GET['dist_id']) ? $_GET['dist_id'] : null;
        $BatchID = isset($_GET['batch_id']) ? $_GET['batch_id'] : null;
        $StartDate = isset($_GET['earning_start']) ? $_GET['earning_start'] : null;
        $EndDate = isset($_GET['earning_end']) ? $_GET['earning_end'] : null;

        if ($DistID && $BatchID && $StartDate && $EndDate) {
          $query = "SELECT DISTINCT * FROM income_info 
            LEFT JOIN jobs ON jobs.j_id = income_info.job_id 
            LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
            LEFT JOIN district ON district.id = student_list.district 
            LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
            LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
            WHERE income_info.status=1
            AND student_list.batch_id = $BatchID
            AND student_list.district = $DistID
            AND income_info.earning_date BETWEEN '$StartDate' AND '$EndDate'
            ORDER BY income_info.earning_dollar DESC";

          $eq = mysqli_query($con, $query);

          if (mysqli_num_rows($eq) > 0) {
            while ($eqrow = mysqli_fetch_array($eq)) {
              $sl++;
              $total_dollar += $eqrow['earning_dollar'];
              $total_bd += $eqrow['earning_bd'];
        ?>
              <tr>
                <td><?= $sl; ?></td>
                <td><?= $eqrow['student_id']; ?></td>
                <!-- <td><?= $eqrow['dist_name']; ?></td> -->
                <td><?= $eqrow['stu_name']; ?></td>
                <td><?= $eqrow['gender']; ?></td>
                <td><?= $eqrow['father_name']; ?></td>
                <td><?= $eqrow['contact']; ?></td>
                <td><?= number_format($eqrow['earning_dollar'], 2); ?></td>
                <td><?= number_format($eqrow['earning_bd'], 2); ?></td>
                <td><?= $eqrow['job_name']; ?></td>
              </tr>
        <?php
            }
          } else {
            echo '<tr><td colspan="10" class="text-center py-2">No records found.!</td></tr>';
          }
        }
        ?>
      </tbody>

      <tfoot class="bg-light fw-bold">
        <tr>
          <td colspan="7" class="text-end">Total</td>
          <td><?= number_format($total_dollar, 2); ?> USD/=</td>
          <td><?= number_format($total_bd, 2); ?> BDT/=</td>
          <td></td>
        </tr>
      </tfoot>

    </table>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script>
    function exportToExcel(tableID, filename = 'student_earning_status.xlsx') {
      const table = document.querySelector(`table[student_id="${tableID}"]`);
      const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
      XLSX.writeFile(wb, filename);
    }
  </script>

</body>

</html>
