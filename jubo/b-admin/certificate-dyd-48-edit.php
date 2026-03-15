<!doctype html>
<html lang="en">

<head>
  <title>Edit DYD Certificate | e-Learning & Earning Ltd.</title>
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
            // DB connection (keep consistent)
            //$con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
             $con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
            if ($con->connect_error) {
              die("<div class='alert alert-danger m-3'>Database connection failed: " . htmlspecialchars($con->connect_error) . "</div>");
            }
            $con->set_charset("utf8mb4");

            $id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
            if ($id <= 0) {
              echo "<script>alert('Invalid request'); window.location='certificate-dyd-48-view.php';</script>";
              exit;
            }

            // Fetch distincts for selects
            $districts = $con->query("SELECT DISTINCT district FROM dyd_certificate ORDER BY district ASC");
            $batches = $con->query("SELECT DISTINCT batch FROM dyd_certificate ORDER BY batch ASC");
            $groups = $con->query("SELECT DISTINCT `group` FROM dyd_certificate ORDER BY `group` ASC");

            // Handle update
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
              // District / Group / Batch may come from select or custom input
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

              // Minimal validation
              if ($stu_id === '' || $stu_name === '') {
                echo "<div class='alert alert-danger'>Student ID and Student Name are required.</div>";
              } else if ($district === '' || $group === '' || $batch === '' || $group === '__custom__' || $batch === '__custom__') {
                echo "<div class='alert alert-danger'>District, Group and Batch are required.</div>";
              } else {
                // Duplicate check for stu_id (exclude current id)
                $dupStmt = $con->prepare("SELECT id FROM dyd_certificate WHERE stu_id = ? AND id <> ?");
                $dupStmt->bind_param("si", $stu_id, $id);
                $dupStmt->execute();
                $dupRes = $dupStmt->get_result();
                $dupStmt->close();
                if ($dupRes->num_rows > 0) {
                  echo "<div class='alert alert-danger'>Duplicate Student ID found. Please use a unique Student ID.</div>";
                } else {
                  $upd = $con->prepare("UPDATE dyd_certificate
                                        SET district = ?, `group` = ?, batch = ?, stu_id = ?, stu_name = ?, gender = ?, nid = ?, father = ?, mother = ?, duration = ?
                                        WHERE id = ?");
                  $upd->bind_param("ssssssssssi", $district, $group, $batch, $stu_id, $stu_name, $gender, $nid, $father, $mother, $duration, $id);
                  if ($upd->execute()) {
                    $upd->close();
                    echo "<script>alert('Record updated successfully'); window.location='certificate-dyd-48-view.php';</script>";
                    exit;
                  } else {
                    $upd->close();
                    echo "<div class='alert alert-danger'>Update failed. Please try again.</div>";
                  }
                }
              }
            }

            // Load current row
            $stmt = $con->prepare("SELECT * FROM dyd_certificate WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
              echo "<script>alert('Record not found'); window.location='certificate-dyd-48-view.php';</script>";
              exit;
            }
          ?>

          <div class="row mb-3">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Edit DYD Certificate</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="certificate-dyd-48-view.php">All DYD Certificate</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card shadow-sm">
                <div class="card-header py-3 bg-light">
                  <h4 class="card-title m-0">Edit Certificate (ID: <?php echo (int)$row['id']; ?>)</h4>
                </div>
                <div class="card-body">
                  <form method="POST" class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label">District</label>
                      <select name="district" class="form-select" id="districtSelect">
                        <option value="">Select District</option>
                        <?php
                          // Reset result pointer if needed by re-query
                          $districts2 = $con->query("SELECT DISTINCT district FROM dyd_certificate ORDER BY district ASC");
                          $hasDistrict = false;
                          while ($d = $districts2->fetch_assoc()) {
                            $val = $d['district'];
                            $sel = ($row['district'] === $val) ? 'selected' : '';
                            if ($sel) { $hasDistrict = true; }
                            echo '<option value="'.htmlspecialchars($val).'" '.$sel.'>'.htmlspecialchars($val).'</option>';
                          }
                        ?>
                        <option value="__custom__" <?php echo !$hasDistrict ? 'selected' : ''; ?>>➕ Add new…</option>
                      </select>
                      <input type="text" class="form-control mt-2" name="district_custom" id="districtCustom" placeholder="Type new district"
                             value="<?php echo !$hasDistrict ? htmlspecialchars($row['district']) : ''; ?>" <?php echo !$hasDistrict ? '' : 'style="display:none"'; ?>>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Group</label>
                      <select name="group" class="form-select" id="groupSelect">
                        <option value="">Select Group</option>
                        <?php
                          $groups2 = $con->query("SELECT DISTINCT `group` FROM dyd_certificate ORDER BY `group` ASC");
                          while ($g = $groups2->fetch_assoc()) {
                            $val = $g['group'];
                            $sel = ($row['group'] === $val) ? 'selected' : '';
                            echo '<option value="'.htmlspecialchars($val).'" '.$sel.'>'.htmlspecialchars($val).'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Batch</label>
                      <select name="batch" class="form-select" id="batchSelect">
                        <option value="">Select Batch</option>
                        <?php
                          $batches2 = $con->query("SELECT DISTINCT batch FROM dyd_certificate ORDER BY batch ASC");
                          while ($b = $batches2->fetch_assoc()) {
                            $val = $b['batch'];
                            $sel = ($row['batch'] === $val) ? 'selected' : '';
                            echo '<option value="'.htmlspecialchars($val).'" '.$sel.'>'.htmlspecialchars($val).'</option>';
                          }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Student ID <span class="text-danger">*</span></label>
                      <input type="text" name="stu_id" class="form-control" value="<?php echo htmlspecialchars($row['stu_id']); ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Student Name <span class="text-danger">*</span></label>
                      <input type="text" name="stu_name" class="form-control" value="<?php echo htmlspecialchars($row['stu_name']); ?>" required>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Gender</label>
                      <select name="gender" class="form-select">
                        <?php
                          $genders = ["", "Male", "Female", "Other"];
                          foreach ($genders as $g) {
                            $sel = ($row['gender'] === $g) ? 'selected' : '';
                            $label = $g === "" ? "Select Gender" : $g;
                            echo '<option value="'.htmlspecialchars($g).'" '.$sel.'>'.htmlspecialchars($label).'</option>';
                          }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">NID</label>
                      <input type="text" name="nid" class="form-control" value="<?php echo htmlspecialchars($row['nid']); ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Father Name</label>
                      <input type="text" name="father" class="form-control" value="<?php echo htmlspecialchars($row['father']); ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Mother Name</label>
                      <input type="text" name="mother" class="form-control" value="<?php echo htmlspecialchars($row['mother']); ?>">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Duration</label>
                      <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($row['duration']); ?>">
                    </div>

                    <div class="col-12 d-flex gap-2">
                      <button type="submit" name="update" class="btn btn-success">Save Changes</button>
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
            // Optional: clear when hidden
            // inp.value = '';
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

