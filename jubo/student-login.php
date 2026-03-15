<?php
session_start();
$errors = $_SESSION['login_errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];
$success_msg = $_SESSION['password_reset_success'] ?? "";
unset($_SESSION['login_errors'], $_SESSION['old_input'], $_SESSION['password_reset_success']);
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
                        <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Student Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <?php if($success_msg): ?>
                            <div class="alert alert-success mt-2"><?php echo $success_msg; ?></div>
                        <?php endif; ?>
                        <?php if(!empty($errors['dropout'])): ?>
                            <div class="alert alert-danger mt-2"><?php echo $errors['dropout']; ?></div>
                        <?php endif; ?>
                        <?php if(!empty($errors['blocked'])): ?>
                            <div class="alert alert-danger mt-2"><?php echo $errors['blocked']; ?></div>
                        <?php endif; ?> 
                        <form role="form" method="POST" action="stu-login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="text"
                                        value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                                    <?php if (!empty($errors['email'])): ?>
                                        <div class="text-danger"><?= $errors['email'] ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" id="passwordField" required>
                                        <span class="input-group-addon" onclick="togglePassword()" style="cursor: pointer;">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                    <?php if (!empty($errors['password'])): ?>
                                        <div class="text-danger"><?= $errors['password'] ?></div>
                                    <?php endif; ?>
                                </div>


                                <button type="submit" class="btn btn-lg btn-success btn-block">
                                    <span class="glyphicon glyphicon-log-in"></span> Login
                                </button>
                                <div class="text-center" style="margin-top: 15px;">
                                    <a href="forgot-password.php" class="text-success">Forgot Password?</a>
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

<script>
    function togglePassword() {
        const passwordField = document.getElementById("passwordField");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>