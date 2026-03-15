<?php
// Export endpoint for DYD Certificate (returns JSON rows for client-side XLSX generation)

header('Content-Type: application/json; charset=utf-8');

//$con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
 $con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
if ($con->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}
$con->set_charset("utf8mb4");

function exp_get($key, $default = '') {
  return isset($_GET[$key]) ? $_GET[$key] : $default;
}

$district = trim((string)exp_get('district', ''));
$batch = trim((string)exp_get('batch', ''));
$group = trim((string)exp_get('group', ''));
$searchValue = trim((string)exp_get('search', ''));

$where = [];
$params = [];
$types = "";

if ($district !== '') { $where[] = "district = ?"; $params[] = $district; $types .= "s"; }
if ($batch !== '') { $where[] = "batch = ?"; $params[] = $batch; $types .= "s"; }
if ($group !== '') { $where[] = "`group` = ?"; $params[] = $group; $types .= "s"; }

if ($searchValue !== '') {
  $like = "%" . $searchValue . "%";
  $where[] = "(district LIKE ? OR `group` LIKE ? OR batch LIKE ? OR stu_id LIKE ? OR stu_name LIKE ? OR gender LIKE ? OR nid LIKE ? OR father LIKE ? OR mother LIKE ? OR duration LIKE ?)";
  for ($i = 0; $i < 10; $i++) { $params[] = $like; $types .= "s"; }
}

$whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";

// Hard cap to avoid memory issues
$limit = 50000;

$sql = "SELECT district, `group`, batch, stu_id, stu_name, gender, nid, father, mother, duration
        FROM dyd_certificate
        $whereSql
        ORDER BY district ASC
        LIMIT $limit";

$stmt = $con->prepare($sql);
if ($params) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();

$rows = [];
while ($r = $res->fetch_assoc()) {
  $rows[] = [
    (string)($r['district'] ?? ''),
    (string)($r['group'] ?? ''),
    (string)($r['batch'] ?? ''),
    (string)($r['stu_id'] ?? ''),
    (string)($r['stu_name'] ?? ''),
    (string)($r['gender'] ?? ''),
    (string)($r['nid'] ?? ''),
    (string)($r['father'] ?? ''),
    (string)($r['mother'] ?? ''),
    (string)($r['duration'] ?? ''),
  ];
}

$stmt->close();
$con->close();

echo json_encode([
  "headers" => ['District', 'Group', 'Batch', 'Student ID', 'Student Name', 'Gender', 'NID', 'Father Name', 'Mother Name', 'Duration'],
  "rows" => $rows,
  "limit" => $limit
]);


