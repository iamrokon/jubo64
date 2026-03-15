<?php  
	require_once 'session.php';
	require_once '../admin/includes/conn.php';
	require_once '../admin/includes/dbconfig.php'; 

	?>

	<?php include('../scripts.php'); ?>
	<?php include('modal.php'); ?>
	
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>E-Learning</title>

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
	  <a class="navbar-brand" href="index.php">  <i class="fa fa-desktop"></i> E-Learning </a> 
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
    </div>

     
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
	
   <ul class="nav navbar-nav navbar-right">  
   <li id="topNavUser"><a href="index.php"> <i class="glyphicon glyphicon-home"></i></a></li>   
   <li id="topNavUser"><a href="question-category.php"> <i class="glyphicon glyphicon-list"></i> Question Category</a></li> 
   <li id="topNavUser"><a href="question.php"> <i class="glyphicon glyphicon-th-list"></i> Question</a></li> 
   <li id="topNavUser"><a href="short-question.php"> <i class="glyphicon glyphicon-th-list"></i> Short Question</a></li>
 
 <!--   
  <li class="dropdown" id="navOrder1">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> Student List <span class="caret"></span></a>
        <ul class="dropdown-menu">  
        <li id="topNavUser"><a href="student-list1"> <i class="glyphicon glyphicon-user"></i> Batch-01</a></li>
        <li id="topNavUser"><a href="student-list2"> <i class="glyphicon glyphicon-user"></i> Batch-02</a></li>
  
  </ul></li>
  

 -->    
      <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-lock"></span> <?php echo $user; ?>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						  
                        <li><a href="#logout" data-toggle="modal"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    
       </li> 
               
      </ul>
    </div> 
  </div> 
	</nav>
	</div>

 