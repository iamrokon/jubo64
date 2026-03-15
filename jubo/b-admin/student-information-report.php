<!doctype html>
<html lang="en">

<head>
  <title>Student Information Report | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Dashboard</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All Student Information</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom pt-5 pb-3 text-center">
                    <h3>
                      <?php
                      // initialize
                      $DistrictName = '';
                      $DistId = null;
                      $Batch = null;
                      $Group = null;

                      if (isset($_GET['dist_id']) && isset($_GET['batch_id'])) {
                        // sanitize incoming ids
                        $DistId = intval($_GET['dist_id']);
                        $Batch = intval($_GET['batch_id']);
                        $Group = isset($_GET['group_id']) && $_GET['group_id'] !== '' ? intval($_GET['group_id']) : null;

                        // fetch district name
                        $pq = mysqli_query($con, "SELECT * FROM district WHERE id = {$DistId} LIMIT 1");
                        if ($pq && $pqrow = mysqli_fetch_array($pq)) {
                          $DistrictName = $pqrow['dist_name'];
                          echo "<b>" . htmlspecialchars($DistrictName) . " District</b>";
                        }

                        echo "</h3><h3>Course Student List</h3><h3 class='m-0'>Student List : ";

                        // fetch batch name
                        $pq = mysqli_query($con, "SELECT * FROM batch_list WHERE batch_id = {$Batch} LIMIT 1");
                        if ($pq && $pqrow = mysqli_fetch_array($pq)) {
                          echo htmlspecialchars($pqrow['batch_name']);
                        }

                        if ($Group) {
                          $pq = mysqli_query($con, "SELECT * FROM group_list WHERE group_id = {$Group} LIMIT 1");
                          if ($pq && $pqrow = mysqli_fetch_array($pq)) {
                            echo " | " . htmlspecialchars($pqrow['group_name']);
                          }
                        } else {
                          echo " | Group A & B";
                        }
                      } else {
                        echo "Invalid Report Request!";
                      }
                      ?>
                    </h3>
                  </div>

                  <hr class="m-0">
                  <div class="card-body">

                    <?php
                    // compute total students BEFORE rendering table so we can show it above
                    $total_students = 0;
                    if ($DistId && $Batch) {
                      if ($Group) {
                        $count_sql = "SELECT COUNT(*) AS cnt FROM student_list WHERE district = {$DistId} AND batch_id = {$Batch} AND group_id = {$Group}";
                      } else {
                        $count_sql = "SELECT COUNT(*) AS cnt FROM student_list WHERE district = {$DistId} AND batch_id = {$Batch}";
                      }
                      $cres = mysqli_query($con, $count_sql);
                      if ($cres) {
                        $crow = mysqli_fetch_assoc($cres);
                        $total_students = isset($crow['cnt']) ? (int)$crow['cnt'] : 0;
                      }
                    }
                    ?>

                    <!-- Total Students + Export Button (above the table) -->
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                      <h4 class="m-0">
                        Total Students:
                        <span class="text-primary fw-bold">
                          <?= $total_students; ?>
                        </span>
                      </h4>

                      <button class="btn btn-success"
                        onclick="exportTableToExcel('studentTable', '<?= preg_replace('/\s+/', '_', addslashes($DistrictName ?: 'District')) ?>_Student_List')">
                        <i class="bi bi-file-earmark-excel"></i> Export to Excel
                      </button>
                    </div>

                    <!-- Student Table -->
                    <table id="studentTable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>SL</th>
                          <th>Name</th>
                          <th>Father</th>
                          <th>Mother</th>
                          <th>Contact Number</th>
                          <th>Gender</th>
                          <th>Address</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Render table rows and SL counter
                        $sl = 0;

                        if ($DistId && $Batch) {
                          if ($Group) {
                            $sql = mysqli_query($con, "SELECT * FROM student_list WHERE district = {$DistId} AND batch_id = {$Batch} AND group_id = {$Group} ORDER BY student_id ASC");
                          } else {
                            $sql = mysqli_query($con, "SELECT * FROM student_list WHERE district = {$DistId} AND batch_id = {$Batch} ORDER BY student_id ASC");
                          }

                          if ($sql && mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_array($sql)) {
                        ?>
                              <tr>
                                <td><?= ++$sl; ?></td>
                                <td><?= htmlspecialchars($row['stu_name']); ?></td>
                                <td><?= htmlspecialchars($row['father_name']); ?></td>
                                <td><?= htmlspecialchars($row['mother_name']); ?></td>
                                <td><?= htmlspecialchars($row['contact']); ?></td>
                                <td><?= htmlspecialchars($row['gender']); ?></td>
                                <td><?= htmlspecialchars($row['address']); ?></td>
                              </tr>
                            <?php
                            }
                          } else {
                            echo "<tr><td colspan='7' class='text-center text-danger'>No Record Found!</td></tr>";
                          }
                        } else {
                          echo "<tr><td colspan='7' class='text-center text-danger'>Invalid Parameters!</td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <?php include "footer.php" ?>
    </div>
  </div>

  <?php include "script.php" ?>

  <!-- Excel Export Script (with border & header style) -->
  <script>
    function exportTableToExcel(tableID, filename = '') {
      const table = document.getElementById(tableID);
      if (!table) {
        alert('Table not found!');
        return;
      }

      // add a small header row inside exported HTML that shows total students (optional)
      // If you want the "Total Students" text inside the Excel file at the top, uncomment below lines and adjust.
      // const totalText = document.querySelector('.text-primary') ? document.querySelector('.text-primary').innerText : '';

      const tableHTML = `
        <html xmlns:x="urn:schemas-microsoft-com:office:excel">
        <head>
          <meta charset="UTF-8">
          <style>
            table, th, td {
              border: 1px solid #000;
              border-collapse: collapse;
            }
            th {
              background-color: #f2f2f2;
              font-weight: bold;
            }
            td, th {
              padding: 5px;
              text-align: left;
            }
          </style>
        </head>
        <body>
          ${table.outerHTML}
        </body>
        </html>`;

      const file = filename ? filename + '.xls' : 'Student_List.xls';
      const downloadLink = document.createElement("a");
      document.body.appendChild(downloadLink);
      downloadLink.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tableHTML);
      downloadLink.download = file;
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
  </script>

</body>
</html>
