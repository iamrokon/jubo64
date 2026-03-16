<?php
include('admin/includes/conn.php');
header("Content-Type: application/json");

/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
$JWT_SECRET = "dfkdfgdifh"; // change this
$JWT_EXPIRE = 60 * 60 * 24 * 90; // 90 days (3 months)


/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

// send json response
function jsonResponse($status, $message, $data = null, $code = 200)
{
    http_response_code($code);
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit();
}

// sanitize input
function clean($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// base64 url encode
function base64UrlEncode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// create jwt
function createJWT($payload, $secret)
{
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];

    $base64Header = base64UrlEncode(json_encode($header));
    $base64Payload = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac(
        'sha256',
        $base64Header . "." . $base64Payload,
        $secret,
        true
    );

    $base64Signature = base64UrlEncode($signature);

    return $base64Header . "." . $base64Payload . "." . $base64Signature;
}


/*
|--------------------------------------------------------------------------
| ONLY POST ALLOWED
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(false, "Invalid request method", null, 405);
}


/*
|--------------------------------------------------------------------------
| GET JSON INPUT
|--------------------------------------------------------------------------
*/
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    jsonResponse(false, "Invalid JSON input", null, 400);
}

$email = isset($input['email']) ? clean($input['email']) : '';
$password = isset($input['password']) ? clean($input['password']) : '';

if (!$email || !$password) {
    jsonResponse(false, "Email and password required", null, 422);
}


/*
|--------------------------------------------------------------------------
| VALIDATE EMAIL FORMAT
|--------------------------------------------------------------------------
*/
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, "Invalid email format", null, 422);
}


/*
|--------------------------------------------------------------------------
| CHECK USER
|--------------------------------------------------------------------------
*/
$stmt = mysqli_prepare($con, "SELECT userid, email, password, access_level FROM student_user WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    jsonResponse(false, "Invalid credentials", null, 401);
}

$user = mysqli_fetch_assoc($result);


/*
|--------------------------------------------------------------------------
| VERIFY PASSWORD
|--------------------------------------------------------------------------
| Your system uses md5. Keeping same logic.
| Strongly recommend migrating to password_hash later.
*/
if ($user['password'] !== md5($password)) {
    jsonResponse(false, "Invalid credentials", null, 401);
}


/*
|--------------------------------------------------------------------------
| CHECK ACCESS LEVEL
|--------------------------------------------------------------------------
*/
if ($user['access_level'] != "10") {
    jsonResponse(false, "Access denied", null, 403);
}


/*
|--------------------------------------------------------------------------
| CREATE JWT TOKEN
|--------------------------------------------------------------------------
*/
$expire_at = time() + $JWT_EXPIRE;

$payload = [
    "iss" => "e-laeltd.com",
    "iat" => time(),
    "exp" => $expire_at,
    "user_id" => $user['userid'],
    "email" => $user['email']
];

$token = createJWT($payload, $JWT_SECRET);


/*
|--------------------------------------------------------------------------
| FETCH STUDENT BASIC INFO
|--------------------------------------------------------------------------
*/


$student_sql = mysqli_query($con, "
    SELECT stu_name, about, userPic 
    FROM student_list 
    WHERE stu_user_id = '" . $user['userid'] . "'
");


if (mysqli_num_rows($student_sql) > 0) {
    $student_data = mysqli_fetch_assoc($student_sql);
    
    // Build profile image URL
    $profile_image = null;
    if (!empty($student_data['userPic'])) {
        // URL encode the filename to handle spaces and special characters
        $encoded_filename = urlencode($student_data['userPic']);
        $profile_image = "../stu-info/user_images/" . $encoded_filename;
    } 
}



/*
|--------------------------------------------------------------------------
| SUCCESS RESPONSE
|--------------------------------------------------------------------------
*/
jsonResponse(true, "Login successful", [

    "user_id" => $user['userid'],
	"name" => $student_data['stu_name'] ?? null,
    "email" => $user['email'],
	"profile_image" => $profile_image,
	"about" => $student_data['about'] ?? null,
    "token" => $token,
    "token_type" => "Bearer",
    "expires_in" => $JWT_EXPIRE,
    "expire" => $expire_at,
    "expire_date" => date("d-m-Y H:i:s", $expire_at)
]);