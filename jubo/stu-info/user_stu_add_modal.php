<!-- Modal -->
<div class="modal fade" id="adddealer" tabindex="-1" aria-labelledby="addDealerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title w-100 text-center">Add New Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="addStudentForm" class="needs-validation" novalidate method="POST" action="user_stu_add_action.php">
        <div class="modal-body">
          <div class="container-fluid">

            <!-- District -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select District:</span>
              <select class="form-select" name="DistrictId" required>
                <?php
                $sql = "SELECT id, dist_name FROM district WHERE user_id='" . $_SESSION['id'] . "'";
                $result = $con->query($sql);
                while ($row = $result->fetch_array()) {
                  echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Batch -->
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

            <!-- Group -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select Group:</span>
              <select class="form-control" name="GroupId" required>
                <option value="">Select Group</option>
                <?php
                $sql = "SELECT * FROM group_list";
                $result = $con->query($sql);
                while ($row = $result->fetch_array()) {
                  echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
                }
                ?>
              </select>
            </div>

            <!-- Student Name -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Student Name:</span>
              <input type="text" class="form-control" placeholder="Enter Student Name" name="StuName" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text" style="width:120px;">Phone No:</span>
                <input type="tel" class="form-control" name="Contact" id="contactInput"
                  placeholder="Enter Phone" required pattern="01[0-9]{9}">
              </div>
              <div id="phone-feedback" class="small mt-1 ps-2"></div>
            </div>

            <!-- Hidden Username -->
            <div class="mb-3 input-group d-none">
              <span class="input-group-text" style="width:120px;">Username:</span>
              <input type="text" class="form-control" name="UserName" value="none">
            </div>

            <!-- Email -->
            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text" style="width:120px;">User Email:</span>
                <input type="email" class="form-control" name="Email" id="emailInput" placeholder="Enter Email"
                  value="<?= $_SESSION['old_input']['Email'] ?? '' ?>" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$">
              </div>
              <div id="email-feedback" class="small mt-1 ps-2"></div>
            </div>
            <?php if (isset($_SESSION['add_error'])): ?>
              <div class="text-danger small ms-2 mb-2"><?= $_SESSION['add_error'] ?></div>
            <?php endif; ?>

            <!-- Note about password -->
            <div class="mb-3">
              <div class="alert alert-info py-2">
                <i class="fa fa-info-circle me-1"></i> Phone number will be used as the login password.
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Script to reset form on modal close -->
<script>
  const addStudentModal = document.getElementById('adddealer');
  addStudentModal.addEventListener('hidden.bs.modal', function() {
    document.getElementById('addStudentForm').reset();
  });
</script>

<!-- Show Modal If Error -->
<?php if (!empty($_SESSION['add_error'])): ?>
  <script>
    const modal = new bootstrap.Modal(document.getElementById('adddealer'));
    modal.show();
  </script>
  <?php unset($_SESSION['add_error'], $_SESSION['old_input']); ?>
<?php endif; ?>

<!-- Show Success Alert -->
<?php if (!empty($_SESSION['add_success'])): ?>
  <script>
    alert("<?= $_SESSION['add_success'] ?>");
  </script>
  <?php unset($_SESSION['add_success']); ?>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Phone Validation
    $('#contactInput').on('keyup blur', function() {
        var phone = $(this).val();
        var feedback = $('#phone-feedback');
        var input = $(this);
        
        if (phone.length === 11 && /^01[0-9]{9}$/.test(phone)) {
            $.post('check_duplicate.php', {phone: phone}, function(data) {
                if (data === 'exists') {
                    feedback.html('<span class="text-danger"><i class="fa fa-times-circle"></i> This phone is already registered.</span>');
                    input.addClass('is-invalid').removeClass('is-valid');
                } else {
                    feedback.html('<span class="text-success"><i class="fa fa-check-circle"></i> Phone number is available.</span>');
                    input.addClass('is-valid').removeClass('is-invalid');
                }
            });
        } else {
            feedback.html('<span class="text-muted">Enter a valid 11-digit number starting with 01.</span>');
            input.removeClass('is-valid is-invalid');
        }
    });

    // Email Validation
    $('#emailInput').on('keyup blur', function() {
        var email = $(this).val();
        var feedback = $('#email-feedback');
        var input = $(this);
        // Require .com at the end
        var regex = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/;
        var dotCom = /\.com$/i;
        if (regex.test(email) && dotCom.test(email)) {
          $.post('check_duplicate.php', {email: email}, function(data) {
            if (data === 'exists') {
              feedback.html('<span class="text-danger"><i class="fa fa-times-circle"></i> This email is already registered.</span>');
              input.addClass('is-invalid').removeClass('is-valid');
            } else {
              feedback.html('<span class="text-success"><i class="fa fa-check-circle"></i> Email is available.</span>');
              input.addClass('is-valid').removeClass('is-invalid');
            }
          });
        } else {
          feedback.html('<span class="text-danger"><i class="fa fa-times-circle"></i> Enter a valid email address ending with .com.</span>');
          input.addClass('is-invalid').removeClass('is-valid');
        }
    });

    // Prevent form submission if invalid
    $('#addStudentForm').on('submit', function(e) {
        if ($(this).find('.is-invalid').length > 0) {
            e.preventDefault();
            alert('Please fix the errors before saving.');
        }
    });
});
</script>
<script>
  (function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
