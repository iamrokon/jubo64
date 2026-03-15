<?php
include('session.php');

if (isset($_POST['status']) && isset($_POST['stu_user_id'])) {
    $status = $_POST['status'];
    $stu_user_id = $_POST['stu_user_id'];

    // Update student_user
    $q1 = mysqli_query($con, "UPDATE student_user SET status = '$status' WHERE userid = '$stu_user_id'");
    
    // Update student_list
    $q2 = mysqli_query($con, "UPDATE student_list SET status = '$status' WHERE stu_user_id = '$stu_user_id'");
    
    // Update student_stuff
    $q3 = mysqli_query($con, "UPDATE student_stuff SET status = '$status' WHERE userid = '$stu_user_id'");

    if ($q1 && $q2 && $q3) {
        echo 'success';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
} else {
    echo 'Invalid request.';
}
?>
