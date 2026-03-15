<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $eid=$_GET['id']; ?>
<body>

    <div id="wrapper">
		<?php include('navbar.php'); ?>
		<br><br>
		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Edit Employee
						<span class="pull-right">
							<a href="employee.php" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
						</span>
						</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
                <div class="col-lg-12">
					<div class="container-fluid">
                    <form role="form" method="POST" action="edit_employee.php<?php echo '?id='.$eid; ?>" enctype="multipart/form-data">
						<div class="container-fluid">
						<?php
							$eq=mysqli_query($con,"select * from employee left join `user` on user.userid=employee.userid left join emp_position on emp_position.positionid=employee.positionid where employee.userid='$eid'");
							$eqrow=mysqli_fetch_array($eq);
						?>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Firstname:</span>
                            <input type="text" style="width:275px; text-transform:capitalize;" class="form-control" name="firstname" value="<?php echo $eqrow['firstname']; ?>">
							
							<span style="width:120px;" class="input-group-addon">Middle I.:</span>
                            <input type="text" style="width:275px; text-transform:capitalize;" class="form-control" name="middle" maxlength="1" value="<?php echo $eqrow['middle_i']; ?>">
                        </div>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Lastname:</span>
                            <input type="text" style="width:275px; text-transform:capitalize;" class="form-control" name="lastname" value="<?php echo $eqrow['lastname']; ?>">
							
							<span style="width:120px;" class="input-group-addon">Gender:</span>
                            <select style="width:275px;" class="form-control" name="gender">
								<option value="<?php echo $eqrow['gender']; ?>"><?php echo $eqrow['gender']; ?></option>
								<?php
									if ($eqrow['gender']=="Male"){
										?>
										<option value="Female">Female</option>
										<?php
									}
									else{
										?>
										<option value="Male">Male</option>
										<?php
									}
								?>
								
							</select>
                        </div>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Address:</span>
                            <input type="text" style="width:670px; text-transform:capitalize;" class="form-control" name="address" value="<?php echo $eqrow['address']; ?>">
                        </div>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Contact Info:</span>
                            <input type="text" style="width:275px;" class="form-control" name="contact" value="<?php echo $eqrow['contact_info']; ?>">
							
							<span style="width:120px;" class="input-group-addon">Birthdate:</span>
                            <input type="date" style="width:275px;" class="form-control" name="birthdate" value="<?php echo $eqrow['birthdate']; ?>">
                        </div>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Position:</span>
                            <select style="width:275px;" class="form-control" name="position" >
							<option value="<?php echo $eqrow['positionid']; ?>"><?php echo $eqrow['p_description']; ?></option>
								<?php
									$p=mysqli_query($con,"select * from emp_position");
									while($posrow=mysqli_fetch_array($p)){
										?>
											<option value="<?php echo $posrow['positionid']; ?>"><?php echo $posrow['p_description']; ?></option>
										<?php
									}
								?>
							</select>
							
							<span style="width:120px;" class="input-group-addon">Hired Date:</span>
                            <input type="date" style="width:275px;" class="form-control" name="hiredate" value="<?php echo $eqrow['hire_date']; ?>">
                        </div>
						<div class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Photo:</span>
                            <input type="file" style="width:670px;" class="form-control" name="image">
                        </div>
						<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-square-o"></i> Update</button>
						</form>
						</div>                  
					</div>
   
				</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php include('scripts.php'); ?>
	<?php include ('modal.php'); ?>
	<?php include ('admin_modal.php'); ?>
	
	
</body>
</html>