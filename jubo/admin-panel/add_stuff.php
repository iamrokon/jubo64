<?php
	include('session.php');
	
	$username=$_POST['username'];
	$original=$_POST['password'];
	$password=md5($_POST['password']);
	$StuffName=$_POST['StuffName'];
	
	$contact=$_POST['contact'];
	$Position=$_POST['Position'];
	$joindate=$_POST['joindate'];
	
	$fileInfo = PATHINFO($_FILES["image"]["name"]);
	
	if (empty($_FILES["image"]["name"])){
		$location="";
	}
	else{
		if ($fileInfo['extension'] == "jpg" OR $fileInfo['extension'] == "png") {
			$newFilename = $fileInfo['filename'] . "_" . time() . "." . $fileInfo['extension'];
			move_uploaded_file($_FILES["image"]["tmp_name"], "../upload/" . $newFilename);
			$location = "upload/" . $newFilename;
		}
		else{
			$location="";
			?>
				<script>
					window.alert('Photo not added. Please upload JPG or PNG photo only!');
				</script>
			<?php
		}
	}
	
	mysqli_query($con,"insert into `user` (username,password,access_level,status) values ('$username','$password','4','1')");
	$uid=mysqli_insert_id($con);
	
//	mysqli_query($con,"insert into `user_backup` (userid, username,password,access_level) values ('$uid','$username','$password','4')");
	
	mysqli_query($con,"insert into password (original, mdfive) values ('$original', '$password')");

	mysqli_query($con,"insert into stuff (userid,stuff_name,position,contact_info,join_date,status,photo) 
					values ('$uid','$StuffName','$Position','$contact','$joindate','1','$location')");
					
	//mysqli_query($con,"insert into dealer_backup (userid,firstname,middle_i,lastname,address,contact_info,birthdate,gender,join_date,credit,recruiter,photo) 
				//	values ('$uid','$firstname','$gardian','$lastname','$address','$contact','$birthdate','$gender','$joindate','1000','$recruiter','$location')");
					
	//mysqli_query($con,"insert into activitylog (userid,action,activity_date) values ('".$_SESSION['id']."','Add Stuff - Name: ".$StuffName."',NOW())");
	
	?>
		<script>
			window.alert('Stuff added successfully!');
			window.history.back();
		</script>
	<?php
?>