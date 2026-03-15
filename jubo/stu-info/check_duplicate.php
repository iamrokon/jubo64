<?php
include('session.php');

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $query = "SELECT * FROM student_user WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
    exit;
}

if (isset($_POST['phone'])) {
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $query_list = "SELECT * FROM student_list WHERE contact = '$phone'";
    $query_stuff = "SELECT * FROM student_stuff WHERE contact = '$phone'";
    
    $result_list = mysqli_query($con, $query_list);
    $result_stuff = mysqli_query($con, $query_stuff);
    
    if (mysqli_num_rows($result_list) > 0 || mysqli_num_rows($result_stuff) > 0) {
        echo 'exists';
    } else {
        echo 'available';
    }
    exit;
}
?>
