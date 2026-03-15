<?php


$district = isset($_POST['DistId']) ? $_POST['DistId'] : '';
$batch = isset($_POST['Batch']) ? $_POST['Batch'] : '';

$sql = "SELECT * FROM dyd_48_income WHERE 1=1";

if (!empty($district)) {
    $sql .= " AND district = '".mysqli_real_escape_string($con, $district)."'";
}

if (!empty($batch)) {
    $sql .= " AND batch = '".mysqli_real_escape_string($con, $batch)."'";
}

$sql .= " ORDER BY id DESC";

$result = mysqli_query($con, $sql);
$sl = 0;

while ($row = mysqli_fetch_array($result)) {
    $sl++;
    echo '<tr>
        <td>'.$sl.'</td>
        <td>'.$row['student_name'].'</td>
        <td>'.$row['district'].'</td>
        <td>'.$row['batch'].'</td>
        <td>'.$row['phone'].'</td>
        <td>'.$row['income'].'</td>
        <td>'.$row['jobs'].'</td>
    </tr>';
}

if ($sl == 0) {
    echo '<tr><td colspan="7" class="text-center">No records found</td></tr>';
}
?>