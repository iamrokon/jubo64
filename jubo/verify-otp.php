<?php
session_start();

$error = "";

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    
    if (isset($_SESSION['reset_otp']) && $entered_otp == $_SESSION['reset_otp']) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset-password.php");
        exit();
    } else {
        $error = "Incorrect OTP. Please try again.";
    }
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
                        <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Verify OTP</h3>
                    </div>
                    <div class="panel-body">
                         <div class="alert alert-success">OTP sent for email: <?php echo $_SESSION['reset_email'] ?? 'undefined'; ?></div>
                        
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form role="form" method="POST" action="">
                            <fieldset>
                                <div class="form-group">
                                    <label>Enter 4-digit OTP</label>
                                    <input class="form-control" placeholder="4-digit OTP" name="otp" type="number" maxlength="4" required>
                                </div>

                                <button type="submit" name="verify_otp" class="btn btn-lg btn-success btn-block">
                                    Verify OTP
                                </button>
                                <div class="text-center" style="margin-top: 15px;">
                                    <a href="forgot-password.php" class="text-success">Resend OTP</a>
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
