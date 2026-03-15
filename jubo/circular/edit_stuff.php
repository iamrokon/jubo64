<?php
	include('session.php');
	$uid=$_GET['id'];

	
	$username=$_POST['username'];
	
	$original=($_POST['password']);
	$password=md5($_POST['password']);
	
	$StuffName= $_POST['StuffName'];
	$Position= $_POST['Position'];
	$contact= $_POST['contact'];
	$joindate= $_POST['joindate'];
	$Status= $_POST['Status'];
	
	$uq=mysqli_query($con,"select * from stuff where userid='$uid'");
	$uqrow=mysqli_fetch_array($uq);
	
	$fileInfo = PATHINFO($_FILES["image"]["name"]);
	
	if (empty($_FILES["image"]["name"])){
		$location=$uqrow['photo'];
	}
	else{
		if ($fileInfo['extension'] == "jpg" OR $fileInfo['extension'] == "png") {
			$newFilename = $fileInfo['filename'] . "_" . time() . "." . $fileInfo['extension'];
			move_uploaded_file($_FILES["image"]["tmp_name"], "../upload/" . $newFilename);
			$location = "upload/" . $newFilename;
		}
		else{
			$location=$uqrow['photo'];
			?>
				<script>
					window.alert('Photo not updated. Please upload JPG or PNG photo only!');
				</script>
			<?php
		}
	}
	
	mysqli_query($con,"update stuff set stuff_name='$StuffName',position='$Position',contact_info='$contact',
	                                   photo='$location', status='$Status' where userid='$uid'");
	
	//Update user
	mysqli_query($con,"update user set username='$username',password='$password',status='$Status' where userid='$uid'");
	//Update password
	mysqli_query($con,"update password set original='$original',mdfive='$password' where passwordid='$uid'");
	//mysqli_query($con,"insert into activitylog (userid,action,activity_date) values ('".$_SESSION['id']."','Update Stuff Details - Stuff Name: ".$uqrow['stuff_name']."',NOW())");
	?>
		<script>
			window.alert('stuff updated successfully!');
			window.history.back();
		</script>
	<?php
	
?>