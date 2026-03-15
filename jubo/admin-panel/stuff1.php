<?php include('header.php'); ?>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="css/table_data_center.css">
<body>

    <div id="wrapper">
		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">User List
						<span class="pull-right">
							<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#adddealer"><i class="fa fa-plus-circle"></i> Add Stuff</button>
							<a href="view_stuff.php" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-print"></span> Print</a>
						</span>
						</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				<div class="row">
                <div class="col-lg-12">
                   <table width="100%" class="table  table-bordered " id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Id No</th>
                                <th>Stuff Name</th>
								<th>Position</th>
								<th>Username</th>
								<th>Password</th>
                                <th>Photo</th>
								<th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
								$dq=mysqli_query($con,"select * from stuff left join `user` on user.userid=stuff.userid  where stuff.status='1' order by stuff.userid asc");
								while($dqrow=mysqli_fetch_array($dq)){
									$did=$dqrow['userid'];
								?>
								<tr>
									<td><?php echo ucwords($dqrow['userid']); ?> </td>
									<td><?php echo ucwords($dqrow['stuff_name']); ?> </td>
									<td><?php echo ucwords($dqrow['position']); ?> </td>
									<td><?php echo $dqrow['username']; ?></td>
									<td>
										<?php
											$pass=mysqli_query($con,"select * from `password` where mdfive='".$dqrow['password']."'");
											$passrow=mysqli_fetch_array($pass);
												
											echo $passrow['original'];
										?>
									</td>
									
									<td><img src="../<?php if($dqrow['photo']==""){echo "/img/profile.jpg";}else{echo $dqrow['photo'];} ?>" height="30px;" width="30px;"></td>
									<td><a href="#details_<?php echo $did; ?>" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Full Details</a>
										<a href="#update<?php echo $did; ?>" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</a>
										<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delemp_<?php echo $did; ?>"><i class="fa fa-trash"></i> Delete </button>
										
										<?php include('stuff_edit_details_modal.php'); ?>
									</td>
								</tr>
								<?php
								}
							?>
                        </tbody>
                    </table>
					 
                </div>
                 
            </div>
			 <?php include('includes/footer.php'); ?>
			 
            </div>
           
        </div>
		
		
		
	</div>
	
	 
    
	<?php include ('modal.php'); ?>
	<?php include ('stuff_modal.php'); ?>
	
	
</body>
</html>
</html>
</html>