
  <?php require_once 'admin/session.php'; ?>
  
  <?php include('admin/scripts.php'); ?>

	<?php include('admin/modal.php'); ?>


<!DOCTYPE html>
<html>
<head>

<title><?php include('title.php'); ?></title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="admin/assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="admin/assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="admin/assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="admin/custom/css/custom.css">

	<!-- DataTables -->
  <link rel="stylesheet" href="admin/assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="admin/assests/plugins/fileinput/css/fileinput.min.css">

  <!-- jquery -->
	<script src="admin/assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="admin/assests/jquery-ui/jquery-ui.min.css">
  <script src="admin/assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="admin/assests/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>


	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
		
		
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	   <a class="navbar-brand" href="index.php"> E-Learning and Earning Ltd.</a>
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      

      <ul class="nav navbar-nav navbar-right">        

      	

      <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-lock"></span> <?php echo $user; ?>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						
						<li class="divider"></li>
                        <li><a href="#logout" data-toggle="modal"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
               
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
	</nav>
	<br>
	<br>
<center><h1> আপনি Logout করতে ভুলে গিয়েছিলেন ! দয়া করে Logout করে  আবার  Login করুন.</h1> <img src="img/logout.png" alt="" /></center>

	
	
	