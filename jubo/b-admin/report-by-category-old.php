<?php
$currentDist = $_REQUEST['DistId'] ?? '';
$currentBatch = $_REQUEST['Batch'] ?? '';
$currentGroup = $_REQUEST['Group'] ?? '';
?>
<div class="row">
  <div class="row mb-4 mt-3">
    <div class="col-xl-11 mx-auto">
      <form class="form-horizontal" action="" method="GET" id="getOrderReportForm">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12 text-center mb-3">
            <h3 class="m-0">District Wise Reports</h3>
          </div>
          <div class="col-md-6 col-lg-3 my-2">
            <select Id="DistId" name="DistId" class="form-control" required>
              <option value="">Select District</option>
              <?php
              $sl = 0;
              $sql = "SELECT DISTINCT student_list.district, district.dist_name, district.id FROM student_list LEFT JOIN district ON district.id = student_list.district ORDER BY student_list.student_id ASC";
              $result = $con->query($sql);
              while ($row = $result->fetch_array()) {
                $selected = ($currentDist == $row[0]) ? 'selected' : '';
                echo "<option value='" . $row[0] . "' $selected>" . ++$sl . "-" . $row[1] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-6 col-lg-3 my-2">
            <select Id="Batch" name="Batch" class="form-control" required>
              <option value="">Select Batch</option>
              <?php
              $sql = "SELECT * FROM batch_list";
              $result = $con->query($sql);
              while ($row = $result->fetch_array()) {
                $selected = ($currentBatch == $row['batch_id']) ? 'selected' : '';
                echo "<option value='" . $row['batch_id'] . "' $selected>" . $row['batch_name'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-6 col-lg-3 my-2">
            <select Id="Group" name="Group" class="form-control">
              <option value="">Select Group</option>
              <?php
              $sql = "SELECT * FROM group_list";
              $result = $con->query($sql);
              while ($row = $result->fetch_array()) {
                $selected = ($currentGroup == $row['group_id']) ? 'selected' : '';
                echo "<option value='" . $row['group_id'] . "' $selected>" . $row['group_name'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-6 col-lg-3 my-2">
            <button type="submit" class="btn btn-success w-100" id="generateReportBtn">
              <i class="fa fa-search me-1"></i> Open Report
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>