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

        <div class="row content justify-content-center align-items-center">

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <img src="assets/img/all/banner-2.jpg" class="img-fluid rounded shadow" alt="" width="100%">
          </div>

          <div class="col-lg-12 ">
            <div class="mt-3 mb-3 rounded shadow py-2 px-2">
              <h1 class="text-center">All Trainees List</h1>
              <!-- <p>"Employment Creation Through Freelancing Training for the Educated Job Seekers Project in 48 District of the Country"</p> -->
            </div>
          </div>

          <?php // include('category-card.php'); 
          ?>

          <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
              <form class="form-horizontal" target="_blank" action="open-dyd-48-trainees" method="post" id="getOrderReportForm">
                <div class="form-row mt-3">
                  <div class="col-md-3 form-group text-center">
                    <h3> District Wise Reports </h3>
                  </div>

                  <div class="col-md-3 form-group">
                    <select id="DistId" name="DistId" class="form-control" required>
                      <option value="">Select District</option>
                      <?php
                      $sql = "SELECT DISTINCT district FROM trainees ORDER BY district ASC";
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
                      $sql = "SELECT DISTINCT batch FROM trainees ORDER BY batch ASC";
                      $result = $con->query($sql);
                      while ($row = $result->fetch_array()) {
                        echo "<option value='" . $row['batch'] . "'>" . $row['batch'] . "</option>";
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

          <div class="col-lg-12 mt-3n d-none" data-aos="fade-left">
            <h3 class="text-center shadow rounded p-3"> <strong> All Trainees List </strong></h3>
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

                            <style>
  /* Ensure the Certificate SL column doesn't truncate or overflow */
  .table th.certificate-sl,
  .table td.certificate-sl {
    white-space: nowrap;       /* Prevent wrapping */
    overflow: visible;         /* Allow content to fully display */
    text-overflow: unset;      /* No ellipsis (...) */
    width: auto !important;    /* Allow dynamic width */
    max-width: none !important;
  }
</style>

              <?php
// Pagination setup
$recordsPerPage = 25;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // avoid negative or 0
$offset = ($page - 1) * $recordsPerPage;

// Get total records
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM trainees");
$totalRow = mysqli_fetch_assoc($totalQuery);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Fetch current page data
$eq = mysqli_query($con, "SELECT * FROM trainees ORDER BY id ASC LIMIT $offset, $recordsPerPage");
$sl = $offset;
?>

<table width="100%" class="table table-hover table-striped m-0" student_id="dataTables-example">
  <thead class="bg-dark text-white">
    <tr>
      <th class="text-center">SL</th>
      <th class="certificate-sl text-center">Certificate SL</th>
      <th class="text-center">Name</th>
      <th class="text-center">Phone</th>
      <th class="text-center">NID</th>
      <th class="text-center">Father Name</th>
      <th class="text-center">District</th>
    </tr>
  </thead>
  <tbody id="tbody">
    <?php while ($eqrow = mysqli_fetch_array($eq)): ?>
      <tr>
        <td><?= ++$sl ?></td>
        <td class="certificate-sl"><?= $eqrow['certificate_sl'] ?></td>
        <td><?= $eqrow['name'] ?></td>
        <td><?= $eqrow['contact'] ?></td>
        <td><?= $eqrow['nid_no'] ?></td>
        <td><?= $eqrow['father_name'] ?></td>
        <td><?= $eqrow['district'] ?></td>
      </tr>
    <?php endwhile; ?>
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
      $range = 1; // change to 2 for wider page range
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