<!-- Bootstrap 5 Compatible Modals -->

<!-- Edit Stuff -->
<div class="modal fade" id="update<?php echo $did; ?>" tabindex="-1" aria-labelledby="editStuffLabel<?php echo $did; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStuffLabel<?php echo $did; ?>">Edit Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="user_stu_edit_action.php<?php echo '?id=' . $did; ?>" enctype="multipart/form-data">
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
          <div class="mb-3 d-none">
            <label class="form-label">Batch Name</label>
            <select class="form-select" name="BatchId" required>
              <option value="<?php echo $dqrow['batch_id']; ?>"> <?php echo $dqrow['batch_name']; ?></option>
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

          <div class="mb-3 d-none">
            <label class="form-label">Group Name</label>
            <select class="form-control" name="GroupId" required>
              <option value="<?php echo $dqrow['group_id']; ?>"> <?php echo $dqrow['group_name']; ?></option>
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
            <label class="form-label">Stu User Id</label>
            <input type="text" class="form-control" name="InStuUserId" readonly value="<?php echo ucwords($dqrow['stu_user_id']); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">User Id</label>
            <?php
            $pq = mysqli_query($con, "SELECT user.userid FROM user WHERE user.userid='" . $_SESSION['id'] . "'");
            while ($pqrow = mysqli_fetch_array($pq)) {
            ?>
              <input type="text" class="form-control" name="InUserId" readonly value="<?php echo ucwords($pqrow['userid']); ?>">
            <?php } ?>


          </div>
          <div class="mb-3">
            <label class="form-label">Student Id</label>
            <input type="text" class="form-control" name="StuId" readonly value="<?php echo ucwords($dqrow['student_id']); ?>">
          </div>



          <div class="mb-3 d-none">
            <label class="form-label">Student Name</label>
            <input type="text" class="form-control" name="StuName" maxlength="50" value="<?php echo ucwords($dqrow['stu_name']); ?>">
          </div>


          <div class="mb-3 d-none">
            <label class="form-label">Phone No</label>
            <input type="e" class="form-control" name="Contact" value="<?php echo $dqrow['contact']; ?>">
          </div>


          <div class="mb-3 d-none">
            <label class="form-label">Status</label>
            <select class="form-select" name="Status">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div class="mb-3 d-none">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="Email" value="<?php echo $dqrow['email']; ?>">
          </div>
          <div class="mb-3 d-none">
            <label class="form-label">Password</label>
            <!-- <input type="password" class="form-control" name="password" value="<?php echo $passrow['original']; ?>"> -->
            <!-- <input type="password" class="form-control" name="password" value="<?php echo $passrow['original']; ?>" placeholder="Leave blank to keep existing"> -->

            <div style="position: relative;">
              <input style="width: 100%;" type="password" class="form-control" name="password" id="passwordField" value="<?php echo $passrow['original']; ?>">
              <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                <i id="eyeIcon" class="fa fa-eye"></i>
              </span>
            </div>

            <!-- FontAwesome আইকনের জন্য -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

            <script>
              function togglePassword() {
                const passwordInput = document.getElementById("passwordField");
                const eyeIcon = document.getElementById("eyeIcon");
                if (passwordInput.type === "password") {
                  passwordInput.type = "text";
                  eyeIcon.classList.remove("fa-eye");
                  eyeIcon.classList.add("fa-eye-slash");
                } else {
                  passwordInput.type = "password";
                  eyeIcon.classList.remove("fa-eye-slash");
                  eyeIcon.classList.add("fa-eye");
                }
              }
            </script>


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