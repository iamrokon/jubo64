
    <?php require_once 'session.php'; ?>
    <?php 
	
	require_once 'session.php';
	require_once 'includes/conn.php';
	require_once 'includes/dbconfig.php'; 

	?>

	<?php include('../scripts.php'); ?>
	<?php include('modal.php'); ?>
	
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Promise IT</title>

<style type="text/css"> nav a{font-size:16px;font-weight:bold;} a{font-size:14px;font-weight:bold;} </style>	

</head>
<body>
<div class="container">
	<nav class="navbar navbar-default navbar-static-top">
		
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <a class="navbar-brand" href="main.php">Promise IT </a> 
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
    </div>

     
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
	
    <ul class="nav navbar-nav navbar-right">   
	  
  <li class="dropdown" id="navOrder1">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-list"></i> Certificate  <span class="caret"></span></a>
        <ul class="dropdown-menu">  
        <li id="topNavUser"><a href="certificate.php"> <i class="glyphicon glyphicon-user"></i> Web</a></li>  
        <li id="topNavUser"><a href="certificate.php"> <i class="glyphicon glyphicon-user"></i> Graphic</a></li>  
        <li id="topNavUser"><a href="certificate.php"> <i class="glyphicon glyphicon-user"></i> Networking</a></li>  
  </ul></li>

  <li class="dropdown" id="navOrder1">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> Employee <span class="caret"></span></a>
        <ul class="dropdown-menu">  
        <li id="topNavUser"><a href="emp_list.php"> <i class="glyphicon glyphicon-user"></i> E-learning</a></li>  
        <li id="topNavUser"><a href="emp_list_ctp.php"> <i class="glyphicon glyphicon-user"></i> CTP</a></li>  
        <li id="topNavUser"><a href="emp_list_hr-ac.php"> <i class="glyphicon glyphicon-user"></i> HR / Accounts</a></li>  
  </ul></li>	  

        
	   
      
      <li id="topNavUser"><a href="trainer.php"> <i class="glyphicon glyphicon-user"></i> Trainer</a></li>  
      <li id="topNavUser"><a href="file.php"> <i class="glyphicon glyphicon-user"></i> Freelancer's </a></li>  
      
      <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-lock"></span> <?php echo $user; ?>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						<li><a href="#account" data-toggle="modal"><span class="glyphicon glyphicon-lock"></span>  My Account</a></li>
						<li class="divider"></li>  
                        <li><a href="#logout" data-toggle="modal"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    
       </li> 
               
      </ul>
    </div> 
  </div> 
	</nav>
	</div>

 