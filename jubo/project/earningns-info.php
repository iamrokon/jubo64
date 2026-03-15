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
            <div class="mt-3 mb-3 rounded shadow py-2 px-2">
              <h1 class="text-center">Earning Info List</h1>
              <!-- <p>"Employment Creation Through Freelancing Training for the Educated Job Seekers Project in 48 District of the Country"</p> -->
            </div>
          </div>

          <?php // include('category-card.php'); 
          ?>

          <div class="col-lg-12 mt-3 d-none" data-aos="fade-left">
            <div class="shadow rounded p-2">
              <form class="form-horizontal" target="_blank" action="open-dyd-48" method="post" id="getOrderReportForm">
                <div class="form-row mt-3">
                  <div class="col-md-3 form-group text-center">
                    <h3> District Wise Reports </h3>
                  </div>

                  <div class="col-md-3 form-group">
                    <select id="DistId" name="DistId" class="form-control" required>
                      <option value="">Select District</option>
                      <?php
                      $sql = "SELECT DISTINCT district FROM dyd_48_income ORDER BY district ASC";
                      $result = $con->query($sql);
                      while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-3 form-group">
                    <select id="Batch" name="Batch" class="form-control" required>
                      <option value="">Select Batch</option>
                      <?php
                      $sql = "SELECT DISTINCT batch FROM dyd_48_income ORDER BY batch ASC";
                      $result = $con->query($sql);
                      while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row['batch'] . "'> Batch-" . $row['batch'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-3 form-group">
                    <button type="submit" class="btn btn-success" id="generateReportBtn">
                      <i class="glyphicon glyphicon-ok-sign"></i> Open Report
                    </button>
                  </div>
                </div>
              </form>




              <script src="custom/js/report.js"></script>
            </div>
          </div>


          <!-- <div class="col-lg-12 mt-3" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> Trainer List </strong></h3>
          </div>

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php include('trainer-list.php'); ?>
            </div>
          </div> -->

          <div class="col-lg-12 mt-3 d-none" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> Student List </strong></h3>
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
// Include database connection here or before this block
// Example: include('db.php');

// Pagination configuration
$recordsPerPage = 25;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $recordsPerPage;

// Get total records (excluding non-income students)
$totalQuery = mysqli_query($con, "SELECT COUNT(*) AS total FROM dyd_48_income WHERE income NOT IN ('0 USD', '00', '0', 'N/A', 'still trying', 'No Earning', 'None')");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get current page records
$result = mysqli_query($con, "
    SELECT * FROM dyd_48_income 
    WHERE income NOT IN ('0 USD', '00', '0', 'N/A', 'still trying', 'No Earning', 'None')
    ORDER BY id DESC 
    LIMIT $offset, $recordsPerPage
");
?>

<!-- Display Table -->
<table class="table table-hover table-striped m-0">
    <thead class="bg-dark text-white">
        <tr>
            <th>SL</th>
            <th class="text-center">Name</th>
            <th class="text-center">District</th>
            <th class="text-center">Batch</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Income</th>
            <th class="text-center">Work Category</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sl = $offset;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . ++$sl . "</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['district']}</td>
                    <td>{$row['batch']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['income']}</td>
                    <td>{$row['jobs']}</td>
                  </tr>";
        }

        if (mysqli_num_rows($result) === 0) {
            echo '<tr><td colspan="7" class="text-center text-danger">No records found.</td></tr>';
        }
        ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-3">
  <nav aria-label="Page navigation">
    <ul class="pagination pagination-sm flex-wrap">

      <!-- First page -->
      <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=1">&laquo;&laquo;</a>
      </li>

      <!-- Previous page -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $page > 1 ? '?page=' . ($page - 1) : '#' ?>">&laquo;</a>
      </li>

      <?php
      // Set range for visible page numbers (e.g., 5 6 7)
      $range = 1;
      $start = max($page - $range, 1);
      $end = min($page + $range, $totalPages);

      for ($i = $start; $i <= $end; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <!-- Next page -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" href="<?= $page < $totalPages ? '?page=' . ($page + 1) : '#' ?>">&raquo;</a>
      </li>

      <!-- Last page -->
      <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $totalPages ?>">&raquo;&raquo;</a>
      </li>
    </ul>
  </nav>
</div>


            </div>
          </div>

        </div>

      </div>
    </section>

  </main>

  <?php include('footer.php'); ?>