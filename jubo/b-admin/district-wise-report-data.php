<?php
include('session.php'); 
header('Content-Type: application/json; charset=utf-8');

// DataTables params
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 25;
if ($length <= 0) $length = 25;
if ($length > 500) $length = 500; 

$searchValue = isset($_GET['search']['value']) ? trim($_GET['search']['value']) : '';

// Custom filters from the form
$distId = isset($_GET['DistId']) ? trim($_GET['DistId']) : '';
$batchId = isset($_GET['Batch']) ? trim($_GET['Batch']) : '';
$groupId = isset($_GET['Group']) ? trim($_GET['Group']) : '';

// Build the where clause
$whereConditions = [];
if ($distId !== '') {
    $whereConditions[] = "student_list.district = '" . mysqli_real_escape_string($con, $distId) . "'";
}
if ($batchId !== '') {
    $whereConditions[] = "student_list.batch_id = '" . mysqli_real_escape_string($con, $batchId) . "'";
}
if ($groupId !== '') {
    $whereConditions[] = "student_list.group_id = '" . mysqli_real_escape_string($con, $groupId) . "'";
}

if ($searchValue !== '') {
    $s = mysqli_real_escape_string($con, $searchValue);
    $whereConditions[] = "(student_list.stu_name LIKE '%$s%')";
}

$whereSql = "";
if (!empty($whereConditions)) {
    $whereSql = "WHERE " . implode(" AND ", $whereConditions);
}

// 1. Get total records (unfiltered)
$resTotal = mysqli_query($con, "SELECT COUNT(*) FROM student_list");
$recordsTotal = (int)mysqli_fetch_row($resTotal)[0];

// 2. Get filtered records count
$resFiltered = mysqli_query($con, "SELECT COUNT(*) FROM student_list $whereSql");
$recordsFiltered = (int)mysqli_fetch_row($resFiltered)[0];

// 3. Main data query (joining with latest income)
$query = "
    SELECT 
        student_list.student_id, student_list.stu_name, student_list.userPic,
        i.in_id, i.earning_bd, i.earning_dollar,
        ws.work_name
    FROM student_list
    LEFT JOIN (
        SELECT student_id, MAX(in_id) as last_in_id
        FROM income_info
        GROUP BY student_id
    ) last_income ON student_list.student_id = last_income.student_id
    LEFT JOIN income_info i ON last_income.last_in_id = i.in_id
    LEFT JOIN work_source ws ON i.work_source = ws.ws_id
    $whereSql
    ORDER BY student_list.student_id ASC
    LIMIT $start, $length
";

$res = mysqli_query($con, $query);
$data = [];
$sl = $start + 1;

while ($row = mysqli_fetch_assoc($res)) {
    $StudentId = $row['student_id'];
    
    $earning_bd = !empty($row['earning_bd']) ? '৳' . number_format($row['earning_bd'], 2) : '-';
    $earning_dollar = !empty($row['earning_dollar']) ? '$' . number_format($row['earning_dollar'], 2) : '-';
    $userPic = !empty($row['userPic']) ? $row['userPic'] : 'default.png';
    
    $action = "
        <center>
            <a class='btn btn-primary btn-sm px-3' target='_blank' href='student-cv?view=$StudentId'>
                <i class='fa fa-file'></i> <strong>CV</strong>
            </a>";
    if (!empty($row['in_id'])) {
        $action .= " <a class='btn btn-success btn-sm waves-effect' href='earning-information-edit?edit_id=" . htmlspecialchars($row['in_id']) . "'><i class='fa fa-edit me-2'></i>Edit</a>";
    }
    $action .= " <a class='btn btn-success btn-sm px-3 mt-2' target='_blank' href='student-income?income_id=$StudentId'>
                <i class='fa fa-user-tie'></i> <strong>Earning Profile</strong>
            </a>
        </center>";

    $data[] = [
        $sl++,
        htmlspecialchars($row['stu_name']),
        $row['work_name'] ?? '-',
        $earning_bd,
        $earning_dollar,
        "<img src='../stu-info/user_images/$userPic' class='rounded-circle' height='30' width='30'>",
        $action
    ];
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => $data
]);
