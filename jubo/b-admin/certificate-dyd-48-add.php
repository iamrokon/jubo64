<!doctype html>
<html lang="en">

<head>
  <title>Add DYD Certificate | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php"; ?>
  <style>
    .card-header h4 { font-weight: 600; }
  </style>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php"; ?>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">
          <?php
            // DB connection (consistent with other pages)


             $con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
         //   $con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
            if ($con->connect_error) {
              die("<div class='alert alert-danger m-3'>Database connection failed: " . htmlspecialchars($con->connect_error) . "</div>");
            }
            $con->set_charset("utf8mb4");

            // Fetch distinct values for selects (may be empty if table empty)
            $districts = $con->query("SELECT DISTINCT district FROM dyd_certificate ORDER BY district ASC");
            $batches = $con->query("SELECT DISTINCT batch FROM dyd_certificate ORDER BY batch ASC");
            $groups = $con->query("SELECT DISTINCT `group` FROM dyd_certificate ORDER BY `group` ASC");

            // Handle create
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
              $district = trim($_POST['district'] ?? '');
              $group = trim($_POST['group'] ?? '');
              $batch = trim($_POST['batch'] ?? '');
              if ($district === '__custom__') { $district = trim($_POST['district_custom'] ?? ''); }
              $stu_id = trim($_POST['stu_id'] ?? '');
              $stu_name = trim($_POST['stu_name'] ?? '');
              $gender = trim($_POST['gender'] ?? '');
              $nid = trim($_POST['nid'] ?? '');
              $father = trim($_POST['father'] ?? '');
              $mother = trim($_POST['mother'] ?? '');
              $duration = trim($_POST['duration'] ?? '');

              if ($stu_id === '' || $stu_name === '') {
                echo "<div class='alert alert-danger'>Student ID and Student Name are required.</div>";
              } else if ($district === '' || $group === '' || $batch === '' || $group === '__custom__' || $batch === '__custom__') {
                echo "<div class='alert alert-danger'>District, Group and Batch are required.</div>";
              } else {
                // Duplicate check
                $dupStmt = $con->prepare("SELECT id FROM dyd_certificate WHERE stu_id = ?");
                $dupStmt->bind_param("s", $stu_id);
                $dupStmt->execute();
                $dupRes = $dupStmt->get_result();
                $dupStmt->close();
                if ($dupRes->num_rows > 0) {
                  echo "<div class='alert alert-danger'>Duplicate Student ID found. Please use a unique Student ID.</div>";
                } else {
                  $ins = $con->prepare("INSERT INTO dyd_certificate (district, `group`, batch, stu_id, stu_name, gender, nid, father, mother, duration)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                  $ins->bind_param("ssssssssss", $district, $group, $batch, $stu_id, $stu_name, $gender, $nid, $father, $mother, $duration);
                  if ($ins->execute()) {
                    $ins->close();
                    echo "<script>alert('Record added successfully'); window.location='certificate-dyd-48-view.php';</script>";
                    exit;
                  } else {
                    $ins->close();
                    echo "<div class='alert alert-danger'>Create failed. Please try again.</div>";
                  }
                }
              }
            }
          ?>

          <div class="row mb-3">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Add DYD Certificate</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="certificate-dyd-48-view.php">All DYD Certificate</a></li>
                    <li class="breadcrumb-item active">Add</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header py-3 bg-light">
                  <h4 class="card-title m-0">New Certificate</h4>
                </div>
                <div class="card-body">
                  <form method="POST" class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label">District</label>
                      <select name="district" class="form-select" id="districtSelect">
                        <option value="">Select District</option>
                        <?php
                          $hasAnyDistrict = false;
                          if ($districts && $districts->num_rows > 0) {
                            while ($d = $districts->fetch_assoc()) {
                              $val = $d['district'];
                              $hasAnyDistrict = true;
                              echo '<option value="'.htmlspecialchars($val).'">'.htmlspecialchars($val).'</option>';
                            }
                          }
                        ?>
                        <option value="__custom__" <?php echo !$hasAnyDistrict ? 'selected' : ''; ?>>➕ Add new…</option>
                      </select>
                      <input type="text" class="form-control mt-2" name="district_custom" id="districtCustom" placeholder="Type new district" <?php echo !$hasAnyDistrict ? '' : 'style="display:none"'; ?>>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Group</label>
                      <select name="group" class="form-select" id="groupSelect">
                        <option value="">Select Group</option>
                        <?php
                          $hasAnyGroup = false;
                          if ($groups && $groups->num_rows > 0) {
                            while ($g = $groups->fetch_assoc()) {
                              $val = $g['group'];
                              $hasAnyGroup = true;
                              echo '<option value="'.htmlspecialchars($val).'">'.htmlspecialchars($val).'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Batch</label>
                      <select name="batch" class="form-select" id="batchSelect">
                        <option value="">Select Batch</option>
                        <?php
                          $hasAnyBatch = false;
                          if ($batches && $batches->num_rows > 0) {
                            while ($b = $batches->fetch_assoc()) {
                              $val = $b['batch'];
                              $hasAnyBatch = true;
                              echo '<option value="'.htmlspecialchars($val).'">'.htmlspecialchars($val).'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Student ID <span class="text-danger">*</span></label>
                      <input type="text" name="stu_id" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Student Name <span class="text-danger">*</span></label>
                      <input type="text" name="stu_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Gender</label>
                      <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">NID</label>
                      <input type="text" name="nid" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Father Name</label>
                      <input type="text" name="father" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Mother Name</label>
                      <input type="text" name="mother" class="form-control">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Duration</label>
                      <input type="text" name="duration" class="form-control">
                    </div>

                    <div class="col-12 d-flex gap-2">
                      <button type="submit" name="create" class="btn btn-success">Save</button>
                      <a href="certificate-dyd-48-view.php" class="btn btn-secondary">Back to List</a>
                    </div>
                  </form>
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
  <script>
    (function() {
      function toggleCustom(selectId, inputId) {
        var sel = document.getElementById(selectId);
        var inp = document.getElementById(inputId);
        if (!sel || !inp) return;
        function update() {
          if (sel.value === '__custom__') {
            inp.style.display = '';
          } else {
            inp.style.display = 'none';
          }
        }
        sel.addEventListener('change', update);
        update();
      }
      toggleCustom('districtSelect', 'districtCustom');
      // Group and Batch: adding new is disabled
    })();
  </script>
</body>

</html>

