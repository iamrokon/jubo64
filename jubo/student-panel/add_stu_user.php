<?php
	include('session.php');

	$DistrictId = $_POST['DistrictId'];
	$BatchId   = $_POST['BatchId'];
	$GroupId   = $_POST['GroupId'];
	$StuName   = $_POST['StuName'];
	$Email     = $_POST['Email'];
	$Contact   = $_POST['Contact'];
	 
	$UserName  = $_POST['UserName'];
	$original  = $_POST['Password'];
	$Password  = md5($_POST['Password']);

	
	mysqli_query($con,"insert into `student_user` (username ,password, access_level, status) values ('$UserName','$Password', '4', '1')");
	$uid=mysqli_insert_id($con);
	
	mysqli_query($con,"insert into student_password (passwordid, original, mdfive) values ('$uid', '$original', '$Password')");

	mysqli_query($con,"insert into student_stuff (userid, district_id, batch_id, group_id, stu_name, email, contact, status) 
					values ('$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuName', '$Email', '$Contact', '1')");

	mysqli_query($con,"insert into student_list (user_id, stu_user_id,  district,     batch_id,   group_id,    stu_name,  email, contact) 
				          				values ('$DistrictId',  '$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuName', '$Email', '$Contact')");
				
	
	?>
		<script>
			window.alert('Student User added successfully!');
			window.history.back();
		</script>
	<?php
?>