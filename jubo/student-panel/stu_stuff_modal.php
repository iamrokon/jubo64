<!-- Add Stuff Modal (Bootstrap 5) -->
<div class="modal fade" id="adddealer" tabindex="-1" aria-labelledby="addDealerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="addDealerLabel">Add New Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="add_stu_user.php" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container-fluid">


            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select District:</span>
              <select class="form-select" name="DistrictId" required>
               <?php
                              $sql = "SELECT id,dist_name FROM district where user_id='" . $_SESSION['id'] . "'";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                              }
                              ?>
              </select>
              <!-- <input type="text" class="form-control text-capitalize" name="StuffName" required> -->
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select Batch:</span>
              <select class="form-select" name="BatchId" required>
                <?php
                $sql = "SELECT * FROM batch_list";
                $result = $con->query($sql);

                while ($row = $result->fetch_array()) {
                  echo "<option value='" . $row['batch_id'] . "'>" . $row['batch_name'] . "</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select Group:</span>
              <select class="form-control" name="GroupId" required>
                <option>Select Group</option>
                <?php
                $sql = "SELECT * FROM group_list";
                $result = $con->query($sql);

                while ($row = $result->fetch_array()) {
                  echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Student Name:</span>
              <input type="text" class="form-control text-capitalize" placeholder="Enter Student Name" name="StuName" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Email:</span>
              <input type="email" class="form-control text-capitalize" name="Email" placeholder="Enter Student Email" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Phone No:</span>
              <input type="number" class="form-control" name="Contact" placeholder="Enter Student Phone No" required>
            </div>


            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Username:</span>
              <input type="text" class="form-control" name="UserName" placeholder="Enter Username" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Password:</span>
              <input type="password" class="form-control" name="Password" placeholder="Enter Password" required>
            </div>



          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Save
          </button>
        </div>
      </form>

    </div>
  </div>
</div>