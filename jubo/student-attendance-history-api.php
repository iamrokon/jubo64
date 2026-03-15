<?php
include('admin/includes/conn.php');
header("Content-Type: application/json");
date_default_timezone_set('Asia/Dhaka');

/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
$JWT_SECRET = "dfkdfgdifh";

/*
|--------------------------------------------------------------------------
| RESPONSE HELPER
|--------------------------------------------------------------------------
*/
function respond($status, $message, $data = null, $code = 200)
{
    http_response_code($code);
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| BASE64 URL
|--------------------------------------------------------------------------
*/
function base64UrlDecode($data)
{
    return base64_decode(strtr($data, '-_', '+/'));
}

/*
|--------------------------------------------------------------------------
| VERIFY JWT
|--------------------------------------------------------------------------
*/
function verifyJWT($token, $secret)
{
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;

    list($header, $payload, $signature) = $parts;

    $valid = hash_hmac('sha256', $header . "." . $payload, $secret, true);
    $signature_decoded = base64UrlDecode($signature);

    if ($valid !== $signature_decoded) {
        return false;
    }

    $payload_json = base64UrlDecode($payload);
    $payload = json_decode($payload_json, true);
    
    if (!$payload || !isset($payload['exp'])) {
        return false;
    }

    if ($payload['exp'] < time()) {
        return false;
    }

    return $payload;
}

/*
|--------------------------------------------------------------------------
| GET BEARER TOKEN
|--------------------------------------------------------------------------
*/
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;

if (!$authHeader) {
    respond(false, "Authorization header missing", null, 401);
}

if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    respond(false, "Invalid token format", null, 401);
}

$jwt = $matches[1];
$userPayload = verifyJWT($jwt, $JWT_SECRET);

if (!$userPayload) {
    respond(false, "Invalid or expired token", null, 401);
}

$user_id = $userPayload['user_id'];

/*
|--------------------------------------------------------------------------
| FILTERS (Optional)
|--------------------------------------------------------------------------
*/
$month = isset($_GET['month']) ? mysqli_real_escape_string($con, $_GET['month']) : null;
$year = isset($_GET['year']) ? mysqli_real_escape_string($con, $_GET['year']) : null;

/*
|--------------------------------------------------------------------------
| FETCH ATTENDANCE HISTORY
|--------------------------------------------------------------------------
*/
$sql = "SELECT a.att_date, a.check_in, a.check_out, a.branch_id, d.dist_name, a.lat, a.lng, a.mp, a.yp 
        FROM attendance a
        LEFT JOIN district d ON a.branch_id = d.id
        WHERE a.student_id = '$user_id'";

if ($month) {
    $sql .= " AND a.mp = '$month'";
}

if ($year) {
    $sql .= " AND a.yp = '$year'";
}

$sql .= " ORDER BY a.att_date DESC";

$result = mysqli_query($con, $sql);
$history = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $history[] = $row;
    }
} else {
    respond(false, "Database error: " . mysqli_error($con), null, 500);
}

/*
|--------------------------------------------------------------------------
| SUMMARY
|--------------------------------------------------------------------------
*/
$total_present = count($history);
$summary = [
    "total_present_days" => $total_present,
    "filter_month" => $month ?? "All",
    "filter_year" => $year ?? "All"
];

/*
|--------------------------------------------------------------------------
| SUCCESS RESPONSE
|--------------------------------------------------------------------------
*/
respond(true, "Attendance history fetched successfully", [
    "user_id" => $user_id,
    "summary" => $summary,
    "history" => $history
]);
