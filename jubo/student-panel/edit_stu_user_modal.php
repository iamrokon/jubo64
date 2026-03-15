<!-- Bootstrap 5 Compatible Modals -->

<!-- Edit Stuff -->
<div class="modal fade" id="update<?php echo $did; ?>" tabindex="-1" aria-labelledby="editStuffLabel<?php echo $did; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStuffLabel<?php echo $did; ?>">Edit Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="edit_stu_user.php<?php echo '?id=' . $did; ?>" enctype="multipart/form-data">
        <div class="modal-body">





          <!-- <div class="mb-3">
            <label class="form-label">District Name</label>
           <select class="form-select" name="DistrictId" required>
                <?php
                // $sql = "SELECT id,dist_name FROM district where user_id='" . $_SESSION['id'] . "'";
                // $result = $con->query($sql);

                // while ($row = $result->fetch_array()) {
                //   echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                // }
                ?>
              </select>
          </div> -->
          <div class="mb-3">
            <label class="form-label">Batch Name</label>
            <select class="form-select" name="BatchId" required>
              <?php
              $sql = "SELECT * FROM batch_list";

              $result = $con->query($sql);
              while ($row = $result->fetch_array()) {
                $selected = ($batch_id == $row['batch_id']) ? 'selected' : '';
                echo '<option value="' . $row['batch_id'] . '" ' . $selected . '>' . $row['batch_name'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Branch Name</label>
            <select class="form-control" name="GroupId" required>
              <option>Select Group</option>
              <?php
              $sql = "SELECT * FROM group_list";
              $result = $con->query($sql);
              while ($row = $result->fetch_array()) {
                $selected = ($group_id == $row['group_id']) ? 'selected' : '';
                echo '<option value="' . $row['group_id'] . '" ' . $selected . '>' . $row['group_name'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Student Name</label>
            <input type="text" class="form-control" name="StuName" maxlength="50" value="<?php echo ucwords($dqrow['stu_name']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Phone No</label>
            <input type="e" class="form-control" name="Contact" value="<?php echo $dqrow['contact']; ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" name="Email" value="<?php echo $dqrow['email']; ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="Status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="UserName" value="<?php echo $dqrow['username']; ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo $passrow['original']; ?>">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--=================================== Delete Student User ===================================  -->
<div class="modal fade" id="delemp_<?php echo $did; ?>" tabindex="-1" aria-labelledby="deleteStuffLabel<?php echo $did; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteStuffLabel<?php echo $did; ?>">Delete Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="stu_delete_stuff.php<?php echo '?id=' . $did; ?>">
        <div class="modal-body">
          <?php $emp = mysqli_query($con, "select * from student_stuff where userid='$did'");
          $empr = mysqli_fetch_array($emp); ?>
          <p class="text-center">Student Name: <strong><?php echo ucwords($empr['stu_name']); ?></strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>