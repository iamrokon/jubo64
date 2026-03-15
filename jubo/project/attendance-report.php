<form class="form-horizontal" action="attendance-report-view.php" method="GET" id="getOrderReportForm">

  <div class="form-row mt-3 align-items-end">
    <div class="col-md-12 mb-3 text-center">
      <h3> Attendance Report </h3>
    </div>

    <div class="col-md-2 form-group">
        <label>District</label>
      <select Id="DistId" name="DistId" class="form-control" required>
        <option value="">Select District</option>
        <?php
        $sl = 0;
        $sql = "SELECT distinct student_list.district,district.dist_name,district.id FROM student_list left join district on district.id=student_list.district order by student_list.student_id ASC ";
        $result = $con->query($sql);

        while ($row = $result->fetch_array()) {
          $selected = (isset($_GET['DistId']) && $_GET['DistId'] == $row[0]) ? 'selected' : '';
          echo "<option value='" . $row[0] . "' $selected>" . ++$sl . "-" . $row[1] . "</option>";
        } 
        ?>
      </select>
    </div>

    <div class="col-md-2 form-group">
        <label>Batch</label>
      <select Id="Batch" name="Batch" class="form-control" required>
        <option value="">Select Batch</option>
        <?php
        $sql = "SELECT * FROM batch_list";
        $result = $con->query($sql);
        while ($row = $result->fetch_array()) {
          $selected = (isset($_GET['Batch']) && $_GET['Batch'] == $row['batch_id']) ? 'selected' : '';
          echo "<option value='" . $row['batch_id'] . "' $selected>" . $row['batch_name'] . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="col-md-2 form-group">
        <label>Group</label>
      <select Id="Group" name="Group" class="form-control">
        <option value="">Select Group</option>
        <?php
        $sql = "SELECT * FROM group_list";
        $result = $con->query($sql);
        while ($row = $result->fetch_array()) {
          $selected = (isset($_GET['Group']) && $_GET['Group'] == $row['group_id']) ? 'selected' : '';
          echo "<option value='" . $row['group_id'] . "' $selected>" . $row['group_name'] . "</option>";
        }
        ?>
      </select>
    </div>

    <div class="col-md-2 form-group">
        <label>Start Date</label>
        <input type="date" name="StartDate" class="form-control" value="<?= isset($_GET['StartDate']) ? $_GET['StartDate'] : date('Y-m-d') ?>" required>
    </div>

    <div class="col-md-2 form-group">
        <label>End Date</label>
        <input type="date" name="EndDate" class="form-control" value="<?= isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d') ?>" required>
    </div>

    <div class="col-md-2 form-group">
      <button type="submit" class="btn btn-success w-100"> <i class="fa fa-eye"></i> View Report </button>
    </div>

  </div>


</form>