<?php
require_once '../admin/includes/conn.php';
require_once '../admin/includes/dbconfig.php';
$district = $_GET['district'];
$batch = $_GET['batch'];
$group = $_GET['group'];

$sql = "SELECT student_id, stu_name FROM student_list 
        WHERE stu_user_id = 0 AND district='$district' AND batch_id='$batch' AND group_id='$group'";
$result = $con->query($sql);

$students = [];
while ($row = $result->fetch_assoc()) {
  $students[] = ['id' => $row['student_id'], 'name' => $row['stu_name']];
}
echo json_encode($students);
?>
