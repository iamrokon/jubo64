

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>
 
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include('header.php'); ?>
  <!-- End Header -->

 <main id="main">
 <?php //include('breadcrumb.php'); ?> 

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us mt-5">
      <div class="container" data-aos="fade-left"> 
	  
	  
        <div class="row content">
 
		 

 <div class="col-lg-12 mt-1" data-aos="fade-left">		
 <img src="assets/img/all/banner.jpg" class="img-fluid rounded shadow" alt="" width="100%"> 
 </div> 

  
 <div class="col-lg-12 mt-3" data-aos="fade-left"> 
  <div class="shadow rounded p-2 text-center" > 
  <h3> 
  <?php 
				   $DistId = $_POST['DistId'];
				   $Batch = $_POST['Batch'];  
				   $pq=mysqli_query($con,"SELECT * FROM district   where id = '$DistId' ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
			    <b>  <?php echo $pqrow['dist_name']; ?> District</b>    
				
				   
				   <?php }?>
				   </h3>
  </div>
 </div>  

 
 <div class="col-lg-12 mt-3" data-aos="fade-left">		
 <h3 class="text-center shadow rounded p-3"> <strong> Trainer & Course Coordinator List </strong></h3> 
 </div> 
 
 <div class="col-lg-12 mt-1" data-aos="fade-left">	
 <div class="shadow p-3 rounded"> 
  <?php include('trainer-list-dist.php'); ?> 
  </div> 
  </div> 
  
  <div class="col-lg-12 mt-3" data-aos="fade-left">		
 <h3 class="text-center shadow rounded p-3"> <strong> Student List :  
				<?php
				if($Batch== 1) { echo "Batch-01"; }
				if($Batch== 2) { echo "Batch-02"; }
				?>
				 </strong></h3> 
 </div> 
 
 <div class="col-lg-12 mt-1" data-aos="fade-left">	
 <div class="shadow p-3 rounded"> 
  <?php include('student-list-dist.php'); ?>
  </div> 
  </div> 
		 
  
		  
        </div>
  
      </div>
    </section> 
 
  </main> 
 
  <?php include('footer.php'); ?> 
  
 