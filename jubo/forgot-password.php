<?php
session_start();
include('admin/includes/conn.php');
include('lite-mailer.php'); // Include the custom lite SMTP mailer

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_with_connection($con, $_POST['email']);
    
    // Check if email exists
    $check_email = mysqli_query($con, "SELECT * FROM `student_user` WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $user = mysqli_fetch_assoc($check_email);
        
        // Generate 4-digit OTP
        $otp = rand(1000, 9999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_userid'] = $user['userid'];
        
        // Send Email using custom SMTP function (Fixes Localhost error)
        if (\LiteMailer\sendOTPSMTP($email, $otp)) {
            $_SESSION['otp_sent'] = true;
            header("Location: verify-otp.php");
            exit();
        } else {
            $error = "Failed to send OTP.";
        }
    } else {
        $error = "Email not found in our records.";
    }
}

function mysqli_real_escape_with_connection($con, $data) {
    if (!$con) return trim($data);
    return mysqli_real_escape_string($con, trim($data));
}
?>

<?php include('login_header.php'); ?>

<body>
    <style>
        body {
            background: url(includes/bg.jpg) no-repeat center 0px;
            background-attachment: fixed;
            font-family: 'Open Sans', sans-serif;
        }

        .login-banner {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.75);
            border-radius: 10px;
        }

        .text-danger {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>

    <div class="container"><br><br><br>
        <img class="login-banner" src="project/assets/img/all/banner-2.jpg" width="100%" />
        <div class="row"><br><br>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-success shadow login-banner">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Forgot Password</h3>
                    </div>
                    <div class="panel-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form role="form" method="POST" action="">
                            <fieldset>
                                <div class="form-group">
                                    <label>Enter your registered Email</label>
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" required>
                                </div>

                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    Send OTP
                                </button>
                                <div class="text-center" style="margin-top: 15px;">
                                    <a href="student-login.php" class="text-success">Back to Login</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('scripts.php'); ?>
</body>
</html>
