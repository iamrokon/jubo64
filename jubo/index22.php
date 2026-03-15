<?php
	session_start();
	if (isset($_SESSION['id'])){
		$ses=mysqli_query($conn,"select * from user where userid='".$_SESSION['id']."'");
		$sesrow=mysqli_fetch_array($ses);		
		if ($ses['access']==1){
			header('location:admin/index.php');
		}
		elseif ($ses['access']==2){
			header('location:staff/index.php');
		}
		else{
			header('location:logout_please.php');
		}
	}
?>

<?php include('login_header.php'); ?>
<body>
<style type="text/css"> 
body {	
	background: url(images/bg1.jpg)no-repeat center 0px;
	background-attachment:fixed;
	  
	font-family: 'Open Sans', sans-serif;
}</style>
<div style="height:20px;"></div>


    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary">
				
				<div class="text-center"><br>
                <span style="color:blue; font-size:18px;"><img src="includes/logo.png" width="70%" />
				<br> <br> 
                </div>
				
				
                    <div class="panel-heading">
                        <h3 class="panel-title"><center><span class="glyphicon glyphicon-lock"></span> Sign In</center></h3>
                    </div>
					
                    <div class="panel-body">
                        <form role="form" id="logform" method="POST" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary	 btn-block"><span class="glyphicon glyphicon-log-in"></span> Login</button>
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
