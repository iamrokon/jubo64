<!doctype html>
<html lang="en">

<head>
  <title>DYD Certificate Information | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php"; ?>

  <style>
    .table-responsive {
      overflow-x: auto;
    }

    table.dataTable {
      width: 100% !important;
    }

    @media (max-width: 576px) {
      .action-buttons {
        flex-direction: column;
        align-items: stretch;
      }

      .action-buttons a {
        width: 100%;
      }
    }

    .card-header h4 {
      font-weight: 600;
    }

    .page-title-box {
      flex-wrap: wrap;
    }

    .breadcrumb {
      margin-bottom: 0;
    }

    .btn {
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.05);
    }
  </style>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">

    <?php include "header.php"; ?>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <!-- Page Title -->
          <div class="row mb-3">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Dashboard</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All DYD Certificate Information</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <!-- Certificate Table -->
          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header py-3 bg-light">
                  <h4 class="card-title m-0">All DYD Certificate Lists</h4>
                </div>
                <div class="card-body">
                  <h3 class="text-center mb-4">DYD Certificate List</h3>

                  <?php
                  $con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
                  if ($con->connect_error) {
                    die("Database connection failed: " . $con->connect_error);
                  }

                  //  $con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
                  // if ($con->connect_error) {
                  //   die("Database connection failed: " . $con->connect_error);
                  // }
                


                  if (isset($_GET['delete_id'])) {
                    $delete_id = intval($_GET['delete_id']);
                    $con->query("DELETE FROM dyd_certificate WHERE id = $delete_id");
                    echo "<script>alert('Record deleted successfully'); window.location='certificate-dyd-48-view.php';</script>";
                  }

                  // Filter options
                  $districts = $con->query("SELECT DISTINCT district FROM dyd_certificate ORDER BY district ASC");
                  $batches = $con->query("SELECT DISTINCT batch FROM dyd_certificate ORDER BY batch ASC");
                  $groups = $con->query("SELECT DISTINCT `group` FROM dyd_certificate ORDER BY `group` ASC");

                  $currentDistrict = $_GET['district'] ?? '';
                  $currentBatch = $_GET['batch'] ?? '';
                  $currentGroup = $_GET['group'] ?? '';
                  ?>
                  <?php
                  // Import success/error message
                  if (isset($_GET['imported'])) {
                    echo "<div class='alert alert-success mb-3'>✅ Imported: <b>" . intval($_GET['imported']) . "</b>, Skipped (duplicate): <b>" . intval($_GET['skipped']) . "</b></div>";
                  }
                  if (isset($_GET['error'])) {
                    echo "<div class='alert alert-danger mb-3'>❌ " . htmlspecialchars($_GET['error']) . "</div>";
                  }
                  ?>
                  <!-- Filter Form -->
                  <form method="GET" class="mb-4">
                    <div class="row g-2">
                      <div class="col-md-3 col-sm-6">
                        <select name="district" class="form-select">
                          <option value="">🔍 Filter by District</option>
                          <?php while ($d = $districts->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($d['district']); ?>" <?= ($currentDistrict == $d['district']) ? 'selected' : ''; ?>>
                              <?= htmlspecialchars($d['district']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <select name="batch" class="form-select">
                          <option value="">🔍 Filter by Batch</option>
                          <?php while ($b = $batches->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($b['batch']); ?>" <?= ($currentBatch == $b['batch']) ? 'selected' : ''; ?>>
                              <?= htmlspecialchars($b['batch']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-6">
                        <select name="group" class="form-select">
                          <option value="">🔍 Filter by Group</option>
                          <?php while ($g = $groups->fetch_assoc()) { ?>
                            <option value="<?= htmlspecialchars($g['group']); ?>" <?= ($currentGroup == $g['group']) ? 'selected' : ''; ?>>
                              <?= htmlspecialchars($g['group']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                        <?php if ($currentDistrict || $currentBatch || $currentGroup) { ?>
                          <a href="certificate-dyd-48-view.php" class="btn btn-outline-secondary">Reset</a>
                        <?php } ?>
                      </div>
                    </div>
                  </form>
                  <div class="btn mb-3">
                    <a href="assets/demo/dyd_certificate_demo.xlsx" class="btn btn-primary w-100">
                      📄 Download Demo Excel
                    </a>
                  </div>
                  <div class="btn mb-3">
                    <a href="certificate-dyd-48-add.php" class="btn btn-success w-100">
                      ➕ Add New Certificate
                    </a>
                  </div>
                  <!-- Bulk Import Form -->

                  <form method="POST" enctype="multipart/form-data" action="certificate-dyd-48-import.php" class="mb-4">
                    <div class="row g-2 align-items-end">

                      <div class="col-md-4 col-sm-8">
                        <input type="file" name="import_file" accept=".xlsx" class="form-control" required>
                      </div>
                      <div class="col-md-2 col-sm-4">
                        <button type="submit" name="import_excel" class="btn btn-success w-100">📥 Import Excel</button>
                      </div>

                    </div>
                  </form>




                  <button onclick="exportTableToExcel()" class="btn btn-outline-success mb-3">
                    📤 Export to Excel
                  </button>


                  <!-- Table -->
                  <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead class="table-light">
                        <tr>
                          <th>SL</th>
                          <th>District</th>
                          <th>Group</th>
                          <th>Batch</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>Gender</th>
                          <th>NID</th>
                          <th>Father Name</th>
                          <th>Mother Name</th>
                          <th>Duration</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <?php include "footer.php"; ?>
    </div>
  </div>

  <?php include "script.php"; ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script>
    async function exportTableToExcel() {
      const table = $('#datatable').DataTable();
      const district = $('select[name=district]').val() || '';
      const batch = $('select[name=batch]').val() || '';
      const group = $('select[name=group]').val() || '';
      const search = table.search() || '';

      const url = new URL('certificate-dyd-48-export.php', window.location.href);
      url.searchParams.set('district', district);
      url.searchParams.set('batch', batch);
      url.searchParams.set('group', group);
      url.searchParams.set('search', search);

      const res = await fetch(url.toString(), { method: 'GET' });
      const payload = await res.json();
      if (payload.error) {
        alert(payload.error);
        return;
      }

      const data = [payload.headers, ...payload.rows];
      const wb = XLSX.utils.book_new();
      const ws = XLSX.utils.aoa_to_sheet(data);
      XLSX.utils.book_append_sheet(wb, ws, "DYD Certificates");
      XLSX.writeFile(wb, 'dyd_certificates.xlsx');
    }
  </script>





  <script>
    $(document).ready(function() {
      // Server-side DataTable (fast for large datasets)
      $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 25, // show 25 rows per page
        lengthMenu: [
          [25, 50, 100, -1],
          [25, 50, 100, "All"]
        ],
        ajax: {
          url: 'certificate-dyd-48-data.php',
          type: 'GET',
          data: function(d) {
            d.district = $('select[name=district]').val() || '';
            d.batch = $('select[name=batch]').val() || '';
            d.group = $('select[name=group]').val() || '';
          }
        },
        columnDefs: [
          { targets: [0, 11], orderable: false, searchable: false }
        ],
        destroy: true,
        language: {
          search: "🔍 Search:",
          lengthMenu: "Show _MENU_ entries",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          paginate: {
            first: "First",
            last: "Last",
            next: "→",
            previous: "←"
          }
        }
      });

      // Redraw table on filter change (optional)
      $('select[name=district], select[name=batch], select[name=group]').on('change', function() {
        // Optional: live reload on change (without clicking Apply Filter)
        // $('#datatable').DataTable().ajax.reload();
      });
    });
  </script>





</body>

</html>