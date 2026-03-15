<?php
include('session.php');

$StuId      = $_POST['StuId'];
$DistrictId = $_POST['DistrictId'];
$BatchId    = $_POST['BatchId'];
$GroupId    = $_POST['GroupId'];
$StuName    = $_POST['StuName'];
$Email      = $_POST['Email'];
$Contact    = $_POST['Contact'];
$UserName   = $_POST['UserName'];
$original   = $_POST['Password'];
$Password   = md5($_POST['Password']);

// Check if email ends in .com
if (!preg_match('/\.com$/i', $Email)) {
    $_SESSION['add_error'] = "Invalid email format! Email must end with .com";
    $_SESSION['old_input'] = $_POST;
    header("Location: user-student-list.php");
    exit();
}

// Check if email already exists
$check = mysqli_query($con, "SELECT * FROM student_user WHERE email = '$Email'");
if (mysqli_num_rows($check) > 0) {
    $_SESSION['add_error'] = "This email is already registered!";
    $_SESSION['old_input'] = $_POST;
    header("Location: user-student-list.php"); 
    exit();
}

// Insert into tables
mysqli_query($con,"INSERT INTO student_user (district_id, batch_id, group_id, email, username, password, access_level, status) 
  VALUES ('$DistrictId', '$BatchId', '$GroupId', '$Email', '$UserName', '$Password', '10', '1')");
$uid = mysqli_insert_id($con);

mysqli_query($con,"INSERT INTO student_password (passwordid, original, mdfive) VALUES ('$uid', '$original', '$Password')");

mysqli_query($con,"INSERT INTO student_stuff (userid, district_id, batch_id, group_id, stu_name, email, contact, status) 
  VALUES ('$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuName', '$Email', '$Contact', '1')");

// mysqli_query($con,"INSERT INTO student_list (user_id, stu_user_id, district, batch_id, group_id, stu_name, email, contact) 
//   VALUES ('$DistrictId', '$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuName', '$Email', '$Contact')");

//======================Student_List Update=====================
	mysqli_query($con,"update student_list set stu_user_id='$uid' where student_id ='$StuId'");


	// mysqli_query($con,"update income_info set user_id='$uid' where student_id ='$StuId'");
	mysqli_query($con,"update income_info set stu_user_id='$uid' where student_id ='$StuId'");



$_SESSION['add_success'] = "Student User added successfully!";
header("Location: user-student-list.php");
exit();
?>
