<!--=================================== Delete Student User ===================================  -->
<div class="modal fade" id="delemp_<?php echo $did; ?>" tabindex="-1" aria-labelledby="deleteStuffLabel<?php echo $did; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteStuffLabel<?php echo $did; ?>">Delete Student User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="user_stu_delete_action.php<?php echo '?id=' . $did; ?>">
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