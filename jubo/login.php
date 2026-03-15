<?php
    include('admin/includes/conn.php');
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		function check_input($data){
			$data=trim($data);
			$data=stripslashes($data);
			$data=htmlspecialchars($data);
			return $data;
		}
		$username = check_input($_POST['username']);
		$fpassword = md5(check_input($_POST['password']));
		if (!preg_match("/^[a-zA-Z0-9_]*$/",$username)){
			?>
				<script>
					window.alert('Username should not contain space and special characters. Only underscore(_) is allowed!');
					window.location.href='login_form.php';
				</script>
				
				
			<?php
		}
		else{
			$fusername=$username;
			$lquery=mysqli_query($con,"select * from `user` where username='$fusername' && password='$fpassword'");
			$lrow=mysqli_fetch_array($lquery);
			$lnum=mysqli_num_rows($lquery);
			if ($lnum == 0 ){
				header('location:log_fail.php');
			}
			else{
			    
				if($lrow['access_level']=="1")
				{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome Admin!');
						window.location.href='admin/index.php';
					</script>
					
					<?php
				}
			elseif($lrow['access_level']=="7")
				{
				$_SESSION['id']=$lrow['userid'];
			
				?>
					<script>
						window.alert('Welcome To Branch Admin Panel!');
						window.location.href='b-admin/';
					</script>
					
					
					
					<?php
				}
			elseif($lrow['access_level']=="11")
				{
				$_SESSION['id']=$lrow['userid'];
			
				?>
					<script>
						window.alert('Welcome To Admin Panel!');
						window.location.href='admin-panel/index.php';
					</script>
					
					
				<?php
				}
			elseif($lrow['access_level']=="2")
				{
				$_SESSION['id']=$lrow['userid'];
			
				?>
					<script>
						window.alert('Welcome To Branch panel !');
						window.location.href='stu-info/index.php';
					</script>
					
					
				<?php
				}
			elseif($lrow['access_level']=="5")
				{
				$_SESSION['id']=$lrow['userid'];
			
				?>
					
				<script>
						window.alert('Welcome To MCQ Entry Panel!');
						window.location.href='mcq-view/index.php';
				</script>
				
				  <?php
				}
				elseif($lrow['access_level']=="6")
				{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome To Question Bank');
						window.location.href='mcq/';
					</script>
				
				<?php
				}
				elseif($lrow['access_level']=="4")
				{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome To Jubo Project');
						window.location.href='project/';
					</script>	
					
					
					
				<?php
				}
				elseif($lrow['access_level']=="3")
				{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome To Circular Panel ');
						window.location.href='circular/';
					</script>
				<?php
				}
				elseif($lrow['access_level']=="10")
				{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome To Student Dashboard Panel ');
						window.location.href='student-panel/';
					</script>
				<?php
				}
				
				else{
				$_SESSION['id']=$lrow['userid'];
				
				?>
					<script>
						window.alert('Welcome To Dashboard Panel!');
						window.location.href='staff/index.php';
					</script>
				<?php
				}
			}
		}
	}
?>