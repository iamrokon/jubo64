<?php
session_start();
include('admin/includes/conn.php');

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: forgot-password.php");
    exit();
}

$error = "";

if (isset($_POST['reset_password'])) {
    $new_password = mysqli_real_escape_string($con, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($con, trim($_POST['confirm_password']));
    
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $userid = $_SESSION['reset_userid'];
        $email = $_SESSION['reset_email'];
        $md5_password = md5($new_password);
        
        // Update student_user table
        $update_user = mysqli_query($con, "UPDATE `student_user` SET password='$md5_password' WHERE userid='$userid'");
        
        // Update student_password table (for plain text record)
        $update_pass = mysqli_query($con, "UPDATE `student_password` SET original='$new_password' WHERE passwordid='$userid'");
        
        if ($update_user) {
            $_SESSION['id'] = $userid; // Set login session
            unset($_SESSION['reset_otp'], $_SESSION['reset_email'], $_SESSION['reset_userid'], $_SESSION['otp_verified']);
            header("Location: student-panel/attandanc-add"); // Redirect to attendance page
            exit();
        } else {
            $error = "Failed to update password. Please try again.";
        }
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
                        <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Reset Password</h3>
                    </div>
                    <div class="panel-body">
                        <?php if($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form role="form" method="POST" action="">
                            <fieldset>
                                <div class="form-group">
                                    <label>Enter new Password</label>
                                    <input class="form-control" name="password" id="passwordField" type="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm new Password</label>
                                    <input class="form-control" name="confirm_password" id="confirmPasswordField" type="password" required>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" onclick="togglePassword()"> Show Passwords
                                    </label>
                                </div>

                                <button type="submit" name="reset_password" class="btn btn-lg btn-success btn-block">
                                    Reset Password
                                </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('scripts.php'); ?>
    <script>
        function togglePassword() {
            var p1 = document.getElementById("passwordField");
            var p2 = document.getElementById("confirmPasswordField");
            if (p1.type === "password") {
                p1.type = "text";
                p2.type = "text";
            } else {
                p1.type = "password";
                p2.type = "password";
            }
        }
    </script>
</body>
</html>
