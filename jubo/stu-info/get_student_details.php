<?php
require_once '../admin/includes/conn.php';
require_once '../admin/includes/dbconfig.php';
$id = $_GET['id'];
$sql = "SELECT student_id, stu_name, email, contact FROM student_list WHERE student_id='$id'";
$result = $con->query($sql);
echo json_encode($result->fetch_assoc());
?>

