<?php
	include('session.php');
	$uid=$_GET['id'];


	$BatchId    = $_POST['BatchId'];
	$GroupId    = $_POST['GroupId'];
	$UserName   = $_POST['UserName'];
	$original   = ($_POST['password']);
	$password   = md5($_POST['password']);
	
	$StuName    = $_POST['StuName'];
	$Email      = $_POST['Email'];
	$Contact= $_POST['Contact'];
	$Status= $_POST['Status'];
	
	$uq=mysqli_query($con,"select * from student_stuff
	 left join `batch_list` on batch_list.batch_id=student_stuff.batch_id
     left join `group_list` on group_list.group_id=student_stuff.group_id
	 where student_stuff.userid='$uid'");
	$uqrow=mysqli_fetch_array($uq);
	
	
	mysqli_query($con,"update student_stuff set stu_name='$StuName', batch_id='$BatchId', group_id='$GroupId', email='$Email', contact='$Contact', status='$Status' where userid='$uid'");
	
	//Update user
	mysqli_query($con,"update student_user set username='$UserName', password='$password', status='$Status' where userid='$uid'");
	//Update password
	mysqli_query($con,"update student_password set original='$original', mdfive='$password' where passwordid='$uid'");

	//======================Student_List Update=====================
	mysqli_query($con,"update student_list set stu_name='$StuName', batch_id='$BatchId', group_id='$GroupId', email='$Email', contact='$Contact', status='$Status' where stu_user_id='$uid'");

	?>
		<script>
			window.alert('stuff updated successfully!');
			window.history.back();
		</script>
	<?php
	
?>