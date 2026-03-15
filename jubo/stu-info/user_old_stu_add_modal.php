<?php
include('session.php');
?>


<!-- Modal -->
<div class="modal oldadd fade" id="oldadddealer" tabindex="-1" aria-labelledby="addDealerLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title w-100 text-center">Add Old Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="addStudentForm" class="needs-validation" novalidate method="POST" action="user_old_stu_add_action.php">
        <div class="modal-body">
          <div class="container-fluid">

            <!-- District -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Select District:</span>
              <select class="form-select" name="DistrictId" id="districtSelect" required>
                <option value="">Select District</option>
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
              <select class="form-select" name="BatchId" id="batchSelect" required>
                <option value="">Select Batch</option>
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
              <select class="form-control" name="GroupId" id="groupSelect" required>
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
              <span class="input-group-text" style="width:120px;">Select Student:</span>
              <select class="form-select" name="" id="studentSelect" required>
                <option value="">Select Student</option>
              </select>
            </div>

            <!-- Phone -->
            <div class="mb-3 input-group d-none">
              <span class="input-group-text" style="width:120px;">Student Id:</span>
              <input type="text" class="form-control" name="StuName" id="studentName">
            </div>

            <!-- Phone -->
            <div class="mb-3 input-group d-none">
              <span class="input-group-text" style="width:120px;">Student Id:</span>
              <input type="tel" class="form-control" name="StuId" id="StuId">
            </div>

            <!-- Phone -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Phone No:</span>
              <input type="tel" class="form-control" name="Contact" id="studentPhone"
                     placeholder="Enter Phone" required pattern="01[0-9]{9}">
              <div class="invalid-feedback">
                Please enter a valid 11-digit phone number starting with 01.
              </div>
            </div>

            <!-- Hidden Username -->
            <input type="hidden" name="UserName" value="none">

            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text" style="width:120px;">User Email:</span>
                <input type="email" class="form-control" name="Email" id="studentEmail"
                       value="<?= $_SESSION['old_input']['Email'] ?? '' ?>" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$">
              </div>
              <div id="email-feedback-old" class="small mt-1 ps-2"></div>
            </div>
            <?php if (isset($_SESSION['add_error'])): ?>
              <div class="text-danger small ms-2 mb-2"><?= $_SESSION['add_error'] ?></div>
            <?php endif; ?>

            <!-- Password -->
            <div class="mb-3 input-group">
              <span class="input-group-text" style="width:120px;">Password:</span>
              <input type="password" class="form-control" name="Password" id="passwordInput" required>
              <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                <i class="fa fa-eye" id="eyeIcon"></i>
              </span>
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

<!-- JavaScript Section -->
<script>
  function togglePassword() {
    const input = document.getElementById("passwordInput");
    const icon = document.getElementById("eyeIcon");
    if (input.type === "password") {
      input.type = "text";
      icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.replace("fa-eye-slash", "fa-eye");
    }
  }

  // Bootstrap form validation
  (function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  // AJAX dynamic student loading + autofill
  document.addEventListener('DOMContentLoaded', function () {
    const district = document.getElementById('districtSelect');
    const batch = document.getElementById('batchSelect');
    const group = document.getElementById('groupSelect');
    const studentSelect = document.getElementById('studentSelect');
    const nameInput = document.getElementById('studentName');
    const emailInput = document.getElementById('studentEmail');
    const phoneInput = document.getElementById('studentPhone');
    const StuId = document.getElementById('StuId');

    function loadStudents() {
      const d = district.value;
      const b = batch.value;
      const g = group.value;

      if (d && b && g) {
        fetch(`fetch_students.php?district=${d}&batch=${b}&group=${g}`)
          .then(res => res.json())
          .then(data => {
            studentSelect.innerHTML = '<option value="">Select Student</option>';
            data.forEach(s => {
              const opt = document.createElement('option');
              opt.value = s.id;
              opt.textContent = s.name;
              studentSelect.appendChild(opt);
            });
          });
      }
    }

    [district, batch, group].forEach(sel => sel.addEventListener('change', loadStudents));

    // Email Validation for Old Student Modal
    const feedbackEmail = document.getElementById('email-feedback-old');
    emailInput.addEventListener('keyup', function() {
        const email = this.value;
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/i;
        if (regex.test(email)) {
            feedbackEmail.innerHTML = '<span class="text-success"><i class="fa fa-check-circle"></i> Email is valid.</span>';
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
        } else {
            feedbackEmail.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> Enter a valid email address ending with .com.</span>';
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        }
    });

    studentSelect.addEventListener('change', function () {
      const id = this.value;
      if (id) {
        fetch(`get_student_details.php?id=${id}`)
          .then(res => res.json())
          .then(data => {
            nameInput.value = data.stu_name || '';
            emailInput.value = data.email || '';
            phoneInput.value = data.contact || '';
            StuId.value = data.student_id || '';
            
            // Trigger validation on autofill
            emailInput.dispatchEvent(new Event('keyup'));
          });
      } else {
        nameInput.value = '';
        emailInput.value = '';
        phoneInput.value = '';
        StuId.value = '';
        feedbackEmail.innerHTML = '';
        emailInput.classList.remove('is-valid', 'is-invalid');
      }
    });
  });
</script>

<!-- Show Modal on Error -->
<?php if (!empty($_SESSION['add_error'])): ?>
  <script>
    new bootstrap.Modal(document.getElementById('oldadddealer')).show();
  </script>
  <?php unset($_SESSION['add_error'], $_SESSION['old_input']); ?>
<?php endif; ?>

<!-- Show Success Alert -->
<?php if (!empty($_SESSION['add_success'])): ?>
  <script>alert("<?= $_SESSION['add_success'] ?>");</script>
  <?php unset($_SESSION['add_success']); ?>
<?php endif; ?>
