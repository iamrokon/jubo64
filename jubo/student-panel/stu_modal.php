<!-- Logout -->
    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="logoutLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="logoutLabel">Are You Sure Logout!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
        <h4>User: <strong><?php echo $user; ?></strong></h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fa fa-times"></i> Cancel
        </button>
        <a href="logout.php" class="btn btn-danger">
          <i class="fa fa-sign-out"></i> Logout
        </a>
      </div>

    </div>
  </div>
</div>

<!-- /.modal -->

<!-- My Account -->
<div class="modal fade" id="account" tabindex="-1" aria-labelledby="accountLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="accountLabel">My Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="update_account.php">
        <div class="modal-body">
          <div class="mb-3 input-group">
            <span class="input-group-text" style="width:150px;">Username:</span>
            <input type="text" class="form-control" style="width:350px;" name="username" value="<?php echo $srow['username']; ?>">
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text" style="width:150px;">Password:</span>
            <input type="password" class="form-control" style="width:350px;" name="password" value="<?php echo $srow['password']; ?>">
          </div>

          <hr>
          <p>Type current password to update:</p>

          <div class="mb-3 input-group">
            <span class="input-group-text" style="width:150px;">Password:</span>
            <input type="password" class="form-control" style="width:350px;" name="cpass" required>
          </div>

          <div class="mb-3 input-group">
            <span class="input-group-text" style="width:150px;">Re-type:</span>
            <input type="password" class="form-control" style="width:350px;" name="repass" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-check-square-o"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- /.modal -->

<!-- Edit Profile -->
   <div class="modal fade" id="edit_profile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title w-100 text-center" id="editProfileLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="save_profile.php<?php echo '?id='.$_SESSION['id']; ?>" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container-fluid">

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Firstname:</span>
              <input type="text" class="form-control text-capitalize" style="width:275px;" name="firstname" value="<?php echo ucwords($drow['firstname']); ?>">
              <span class="input-group-text" style="width:120px;">Middle I.:</span>
              <input type="text" class="form-control text-capitalize" style="width:275px;" maxlength="1" name="middle" value="<?php echo ucwords($drow['middle_i']); ?>">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Lastname:</span>
              <input type="text" class="form-control text-capitalize" style="width:275px;" name="lastname" value="<?php echo ucwords($drow['lastname']); ?>">
              <span class="input-group-text" style="width:120px;">Gender:</span>
              <select class="form-control" style="width:275px;" name="gender">
                <option value="<?php echo $drow['gender']; ?>"><?php echo $drow['gender']; ?></option>
                <option value="<?php echo $drow['gender'] == 'Male' ? 'Female' : 'Male'; ?>">
                  <?php echo $drow['gender'] == 'Male' ? 'Female' : 'Male'; ?>
                </option>
              </select>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Address:</span>
              <input type="text" class="form-control text-capitalize" style="width:670px;" name="address" value="<?php echo ucwords($drow['address']); ?>">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Contact Info:</span>
              <input type="text" class="form-control" style="width:670px;" name="contact" value="<?php echo $drow['contact_info']; ?>">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Birthdate:</span>
              <input type="date" class="form-control" style="width:275px;" name="birthdate" value="<?php echo $drow['birthdate']; ?>">
              <span class="input-group-text" style="width:120px;">Joined Date:</span>
              <input type="date" class="form-control" style="width:275px;" name="joindate" value="<?php echo $drow['join_date']; ?>">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Recruiter:</span>
              <select class="form-control" style="width:670px;" name="recruiter">
                <option value="<?php echo ucwords($drow['recruiter']); ?>"><?php echo ucwords($drow['recruiter']); ?></option>
                <option>None</option>
                <?php
                  $uq=mysqli_query($con,"select * from dealer where userid!='$did'");
                  while($uqrow=mysqli_fetch_array($uq)){
                    echo '<option>' . ucwords($uqrow['firstname']) . ' ' . ucwords($uqrow['middle_i']) . '. ' . ucwords($uqrow['lastname']) . '</option>';
                  }
                ?>
              </select>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Photo:</span>
              <input type="file" class="form-control" style="width:670px;" name="image">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancel
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-check-square-o"></i> Update
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- /.modal -->
