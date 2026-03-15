<?php
include('session.php');


$DistrictId = $_POST['DistrictId'];
$BatchId    = $_POST['BatchId'];
$GroupId    = $_POST['GroupId'];
$StuId      = $_POST['StuName']; // actually student_id
$Email      = $_POST['Email'];
$Contact    = $_POST['Contact'];
$UserName   = $_POST['UserName'];
$original   = $Contact;
$Password   = md5($Contact); // Always use the submitted contact as password

// Check if email ends in .com
if (!preg_match('/\.com$/i', $Email)) {
    $_SESSION['add_error'] = "Invalid email format! Email must end with .com";
    $_SESSION['old_input'] = $_POST;
    header("Location: user-student-list.php");
    exit();
}

// Check if email already exists
$check_email = mysqli_query($con, "SELECT * FROM student_user WHERE email = '$Email'");
if (mysqli_num_rows($check_email) > 0) {
    $_SESSION['add_error'] = "This email is already registered!";
    $_SESSION['old_input'] = $_POST;
    header("Location: user-student-list.php");
    exit();
}

// Check if phone number already exists in student_list or student_stuff
$check_phone = mysqli_query($con, "SELECT * FROM student_list WHERE contact = '$Contact'");
$check_stuff = mysqli_query($con, "SELECT * FROM student_stuff WHERE contact = '$Contact'");
if (mysqli_num_rows($check_phone) > 0 || mysqli_num_rows($check_stuff) > 0) {
    $_SESSION['add_error'] = "This phone number is already registered!";
    $_SESSION['old_input'] = $_POST;
    header("Location: user-student-list.php");
    exit();
}


// Insert into student_user (password always md5 of contact)
mysqli_query($con, "INSERT INTO student_user (district_id, batch_id, group_id, email, username, password, access_level, status) 
  VALUES ('$DistrictId', '$BatchId', '$GroupId', '$Email', '$UserName', '$Password', '10', '1')");
$uid = mysqli_insert_id($con);

// Insert into student_password (original always contact, mdfive always md5(contact))
mysqli_query($con, "INSERT INTO student_password (passwordid, original, mdfive) VALUES ('$uid', '$Contact', '$Password')");

// Insert into student_stuff
mysqli_query($con, "INSERT INTO student_stuff (userid, district_id, batch_id, group_id, stu_name, email, contact, status) 
  VALUES ('$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuId', '$Email', '$Contact', '1')");

// Insert into student_list
mysqli_query($con, "INSERT INTO student_list (user_id, stu_user_id, district, batch_id, group_id, stu_name, email, contact, status) 
  VALUES ('$DistrictId', '$uid', '$DistrictId', '$BatchId', '$GroupId', '$StuId', '$Email', '$Contact', '1')");

$_SESSION['add_success'] = "Student User added successfully!";
header("Location: user-student-list.php");
exit();
?>
