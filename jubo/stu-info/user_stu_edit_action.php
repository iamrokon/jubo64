<?php
include('session.php'); // সেশনের জন্য

// Error reporting ON রাখুন debug এর জন্য
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ফর্ম সাবমিট হয়েছে কি না চেক করুন
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// id GET method-এ আসবে
	if (!isset($_GET['id'])) {
		die("Missing student user ID.");
	}

	$uid = $_GET['id']; // ইউজার আইডি

	// POST data গুলো নিচ্ছি
	$InUserId     = $_POST['InUserId'];
	$InStuUserId  = $_POST['InStuUserId'];
	$StuId        = $_POST['StuId'];

	// $BatchId      = $_POST['BatchId'];
	// $GroupId      = $_POST['GroupId'];
	// $original     = $_POST['password'];
	// $password     = md5($_POST['password']);
	// $StuName      = $_POST['StuName'];
	// $Email        = $_POST['Email'];
	// $Contact      = $_POST['Contact'];
	// $Status       = $_POST['Status'];

	// ============= UPDATE student_stuff =============
	// $q1 = mysqli_query($con, "UPDATE student_stuff SET 
    //     stu_name = '$StuName', 
    //     batch_id = '$BatchId', 
    //     group_id = '$GroupId', 
    //     email = '$Email', 
    //     contact = '$Contact', 
    //     status = '$Status' 
    //     WHERE userid = '$uid'
    // ");
	// if (!$q1) {
	// 	die("Error updating student_stuff: " . mysqli_error($con));
	// }

	// ============= UPDATE student_user =============
	// $q2 = mysqli_query($con, "UPDATE student_user SET 
    //     batch_id = '$BatchId', 
    //     group_id = '$GroupId', 
    //     email = '$Email', 
    //     password = '$password', 
    //     status = '$Status' 
    //     WHERE userid = '$uid'
    // ");
	// if (!$q2) {
	// 	die("Error updating student_user: " . mysqli_error($con));
	// }

	// ============= UPDATE student_password =============
	// $q3 = mysqli_query($con, "UPDATE student_password SET 
    //     original = '$original', 
    //     mdfive = '$password' 
    //     WHERE passwordid = '$uid'
    // ");
	// if (!$q3) {
	// 	die("Error updating student_password: " . mysqli_error($con));
	// }

	// ============= UPDATE student_list =============
	// $q4 = mysqli_query($con, "UPDATE student_list SET 
    //     stu_name = '$StuName', 
    //     batch_id = '$BatchId', 
    //     group_id = '$GroupId', 
    //     email = '$Email', 
    //     contact = '$Contact', 
    //     status = '$Status' 
    //     WHERE stu_user_id = '$uid'
    // ");
	// if (!$q4) {
	// 	die("Error updating student_list: " . mysqli_error($con));
	// }

	// ============= UPDATE income_info =============
	$q5 = mysqli_query($con, "UPDATE income_info SET 
        user_id = '$InUserId', 
        stu_user_id = '$InStuUserId' 
        WHERE student_id = '$StuId'
    ");
	if (!$q5) {
		die("Error updating income_info: " . mysqli_error($con));
	}

	// =================== Success ===================
	echo "<script>
        alert('Student user updated successfully!');
        window.history.back();
    </script>";
} else {
	die("Invalid request method.");
}
