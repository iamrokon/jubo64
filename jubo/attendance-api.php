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

    // Use a more compatible comparison method
    if ($valid !== $signature_decoded) {
        return false;
    }

    $payload = json_decode(base64UrlDecode($payload), true);
    
    // Check if payload is valid JSON and has exp field
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
if (!isset($headers['Authorization'])) {
    respond(false, "Authorization header missing", null, 401);
}

if (!preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
    respond(false, "Invalid token format", null, 401);
}

$jwt = $matches[1];
$userPayload = verifyJWT($jwt, $JWT_SECRET);

if (!$userPayload) {
    respond(false, "Invalid or expired token", null, 401);
}

$user_id = $userPayload['user_id'];
$email = $userPayload['email'];

/*
|--------------------------------------------------------------------------
| ONLY POST
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond(false, "POST required", null, 405);
}

/*
|--------------------------------------------------------------------------
| INPUT
|--------------------------------------------------------------------------
*/
$data = json_decode(file_get_contents("php://input"), true);

$lat = $data['lat'] ?? null;
$lng = $data['lng'] ?? null;
$device_id = $data['device_id'] ?? null;

if (!$lat || !$lng || !$device_id) {
    respond(false, "lat, lng, device_id required", null, 422);
}

/*
|--------------------------------------------------------------------------
| GET USER BRANCH
|--------------------------------------------------------------------------
*/
$q = mysqli_query($con, "SELECT district FROM student_list WHERE stu_user_id='$user_id'");
if (mysqli_num_rows($q) == 0) {
    respond(false, "Student branch not found", null, 404);
}

$row = mysqli_fetch_assoc($q);
$branch_id = $row['district'];

/*
|--------------------------------------------------------------------------
| GET BRANCH POLES
|--------------------------------------------------------------------------
*/
$poles = [];
$r = mysqli_query($con, "SELECT lat,lng,radius FROM branch_distances WHERE branch_id='$branch_id'");
while ($p = mysqli_fetch_assoc($r)) $poles[] = $p;

if (!$poles) {
    respond(false, "Attendance location not configured", null, 400);
}

/*
|--------------------------------------------------------------------------
| DISTANCE FUNCTION
|--------------------------------------------------------------------------
*/
function distanceMeters($lat1,$lon1,$lat2,$lon2)
{
    $R = 6371000;
    $dLat = deg2rad($lat2-$lat1);
    $dLon = deg2rad($lon2-$lon1);
    $a = sin($dLat/2)*sin($dLat/2) +
         cos(deg2rad($lat1))*cos(deg2rad($lat2))*
         sin($dLon/2)*sin($dLon/2);
    return $R * 2 * atan2(sqrt($a), sqrt(1-$a));
}

/*
|--------------------------------------------------------------------------
| LOCATION VALIDATION
|--------------------------------------------------------------------------
*/
$inRange = false;
foreach($poles as $p){
    if(distanceMeters($lat,$lng,$p['lat'],$p['lng']) <= $p['radius']){
        $inRange = true;
        break;
    }
}

if(!$inRange){
    respond(false, "Outside permitted location", null, 403);
}

/*
|--------------------------------------------------------------------------
| DATE INFO
|--------------------------------------------------------------------------
*/
$today = date('Y-m-d');
$time  = date('h:i A');
$month = date('F');
$year  = date('Y');

/*
|--------------------------------------------------------------------------
| DEVICE CHECK (NO MULTI USER SAME DEVICE)
|--------------------------------------------------------------------------
*/
$dq = mysqli_query($con,
"SELECT student_id FROM attendance 
 WHERE device_id='$device_id' AND att_date='$today'");

if(mysqli_num_rows($dq) > 0){
    $d = mysqli_fetch_assoc($dq);
    if($d['student_id'] != $user_id){
        respond(false, "Device already used by another user today", null, 403);
    }
}

/*
|--------------------------------------------------------------------------
| CHECK TODAY RECORD
|--------------------------------------------------------------------------
*/
$check = mysqli_query($con,
"SELECT * FROM attendance 
 WHERE student_id='$user_id' AND att_date='$today'");

/*
|--------------------------------------------------------------------------
| CHECK IN
|--------------------------------------------------------------------------
*/
if(mysqli_num_rows($check) == 0){

    mysqli_query($con,
    "INSERT INTO attendance
    (student_id,branch_id,att_date,check_in,lat,lng,mp,yp,device_id)
    VALUES
    ('$user_id','$branch_id','$today','$time','$lat','$lng','$month','$year','$device_id')");

    respond(true,"Check in successful",[
		"user_id" => $user_id,
		"email" => $email,
        "type"=>"check_in",
		"date" => $today,
        "time"=>$time
    ]);
}

/*
|--------------------------------------------------------------------------
| CHECK OUT
|--------------------------------------------------------------------------
*/
mysqli_query($con,
"UPDATE attendance SET
check_out='$time',
lat='$lat',
lng='$lng'
WHERE student_id='$user_id' AND att_date='$today'");

respond(true,"Check out successful",[
    "user_id" => $user_id,
    "email" => $email,
    "type"=>"check_out",
	"date" => $today,
    "time"=>$time
]);