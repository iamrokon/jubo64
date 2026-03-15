<?php
// Server-side endpoint for DataTables (DYD Certificate)
// Returns JSON: draw, recordsTotal, recordsFiltered, data

header('Content-Type: application/json; charset=utf-8');

// DB connection (keep consistent with view page)
//$con = new mysqli("localhost", "root", "", "elaeltdc_jubo_48_db");
 $con = new mysqli("localhost", "elaeltdc_jubo_48_user", "Bog@Tar_A25", "elaeltdc_jubo_48_db");
if ($con->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}
$con->set_charset("utf8mb4");

function dt_get($key, $default = null) {
  return isset($_GET[$key]) ? $_GET[$key] : $default;
}

// DataTables params
$draw = intval(dt_get('draw', 0));
$start = max(0, intval(dt_get('start', 0)));
$length = intval(dt_get('length', 25));
if ($length <= 0) $length = 25;
if ($length > 500) $length = 500; // safety

$searchValue = dt_get('search', []);
if (is_array($searchValue) && isset($searchValue['value'])) {
  $searchValue = trim((string)$searchValue['value']);
} else {
  $searchValue = trim((string)dt_get('search_value', ''));
}

// Custom filters
$district = trim((string)dt_get('district', ''));
$batch = trim((string)dt_get('batch', ''));
$group = trim((string)dt_get('group', ''));

$where = [];
$params = [];
$types = "";

if ($district !== '') {
  $where[] = "district = ?";
  $params[] = $district;
  $types .= "s";
}
if ($batch !== '') {
  $where[] = "batch = ?";
  $params[] = $batch;
  $types .= "s";
}
if ($group !== '') {
  $where[] = "`group` = ?";
  $params[] = $group;
  $types .= "s";
}

// Search across columns (optional)
$searchWhere = [];
if ($searchValue !== '') {
  $like = "%" . $searchValue . "%";
  $searchWhere[] = "(district LIKE ? OR `group` LIKE ? OR batch LIKE ? OR stu_id LIKE ? OR stu_name LIKE ? OR gender LIKE ? OR nid LIKE ? OR father LIKE ? OR mother LIKE ? OR duration LIKE ?)";
  for ($i = 0; $i < 10; $i++) {
    $params[] = $like;
    $types .= "s";
  }
}

$fullWhere = $where;
if ($searchWhere) {
  $fullWhere[] = $searchWhere[0];
}
$whereSql = $fullWhere ? ("WHERE " . implode(" AND ", $fullWhere)) : "";

// Ordering
$orderColIdx = intval(dt_get('order', [['column' => 1]])[0]['column'] ?? 1);
$orderDir = strtolower((string)(dt_get('order', [['dir' => 'asc']])[0]['dir'] ?? 'asc'));
if ($orderDir !== 'asc' && $orderDir !== 'desc') $orderDir = 'asc';

// Map DT column index -> DB column (0=SL, 11=Action)
$orderableColumns = [
  1 => "district",
  2 => "`group`",
  3 => "batch",
  4 => "stu_id",
  5 => "stu_name",
  6 => "gender",
  7 => "nid",
  8 => "father",
  9 => "mother",
  10 => "duration",
];
$orderBy = $orderableColumns[$orderColIdx] ?? "district";
$orderSql = "ORDER BY $orderBy $orderDir";

// Count (recordsTotal = after custom filters; recordsFiltered = after filters + search)
// Build base filters separately (safer for bind_param)
$baseWhereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";
$baseParams = [];
$baseTypes = "";
if ($district !== '') { $baseParams[] = $district; $baseTypes .= "s"; }
if ($batch !== '') { $baseParams[] = $batch; $baseTypes .= "s"; }
if ($group !== '') { $baseParams[] = $group; $baseTypes .= "s"; }

$stmtBase = $con->prepare("SELECT COUNT(*) AS c FROM dyd_certificate $baseWhereSql");
if ($baseParams) {
  $stmtBase->bind_param($baseTypes, ...$baseParams);
}
$stmtBase->execute();
$resBase = $stmtBase->get_result()->fetch_assoc();
$baseCount = intval($resBase['c'] ?? 0);
$stmtBase->close();

// Count filtered (custom filters + search)
$stmtFiltered = $con->prepare("SELECT COUNT(*) AS c FROM dyd_certificate $whereSql");
if ($params) {
  $stmtFiltered->bind_param($types, ...$params);
}
$stmtFiltered->execute();
$resFiltered = $stmtFiltered->get_result()->fetch_assoc();
$filteredCount = intval($resFiltered['c'] ?? 0);
$stmtFiltered->close();

// Data query
$sql = "SELECT id, district, `group`, batch, stu_id, stu_name, gender, nid, father, mother, duration
        FROM dyd_certificate
        $whereSql
        $orderSql
        LIMIT ?, ?";

$stmt = $con->prepare($sql);
$paramsWithLimit = $params;
$typesWithLimit = $types . "ii";
$paramsWithLimit[] = $start;
$paramsWithLimit[] = $length;
$stmt->bind_param($typesWithLimit, ...$paramsWithLimit);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$sl = $start + 1;
while ($row = $result->fetch_assoc()) {
  $id = (int)$row['id'];
  $data[] = [
    $sl++,
    htmlspecialchars($row['district'] ?? ''),
    htmlspecialchars($row['group'] ?? ''),
    htmlspecialchars($row['batch'] ?? ''),
    htmlspecialchars($row['stu_id'] ?? ''),
    htmlspecialchars($row['stu_name'] ?? ''),
    htmlspecialchars($row['gender'] ?? ''),
    htmlspecialchars($row['nid'] ?? ''),
    htmlspecialchars($row['father'] ?? ''),
    htmlspecialchars($row['mother'] ?? ''),
    htmlspecialchars($row['duration'] ?? ''),
    '<div class="action-buttons d-flex justify-content-center gap-2">'
      . '<a class="btn btn-success btn-sm" href="certificate-dyd-48-edit.php?edit_id=' . $id . '"><i class="fa fa-edit me-1"></i>Edit</a>'
      . '<a class="btn btn-danger btn-sm" href="?delete_id=' . $id . '" onclick="return confirm(\'Are you sure you want to delete this record?\')"><i class="fa fa-trash me-1"></i>Delete</a>'
      . '</div>'
  ];
}
$stmt->close();
$con->close();

echo json_encode([
  "draw" => $draw,
  "recordsTotal" => $baseCount,
  "recordsFiltered" => $filteredCount,
  "data" => $data
]);


