 

<div class="row">

<div class="col-md-12">
		<div class="panel panel-default">
			
			<div class="panel-body">
				<div id="calendar"><center><img src="includes/mcq.jpg" width="100%"alt="" /></div>
			</div>	
		</div> 
	</div>

<!--
	
<div class="col-md-12">	 
<center><h3><ol class="breadcrumb "> <li class="">Trainer & Co-Ordinator </li></ol></h3></center>
</div>
 

<?php
							$sl=0;
								$eq=mysqli_query($con,"select * from trainer  ORDER BY id ASC   ");
								while($eqrow=mysqli_fetch_array($eq)){
							?>
	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading text-center">
			<h3> 
			<img src="trainer_images/<?php echo $eqrow['userPic']; ?>" width="100%" /><br><br>
			<?php echo $eqrow['name']; ?>
			</h3>
   <p> <?php echo $eqrow['designation']; ?></p>			
			</div>  
		</div>  
	</div> 

<?php
		}  
		?>	
	
		
	
	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading">
			<a href="php_action/view_product_stock.php" style="text-decoration:none;color:black;">
					Total On Going Project
					<span class="badge pull pull-right">
					<?php 
$sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>	
				</a>
				
			</div>  
		</div>  
	</div>
	
	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading">
			<a href="php_action/view_product_stock.php" style="text-decoration:none;color:black;">
					Total Hand Over Project
					<span class="badge pull pull-right">
					<?php 
$sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>	
				</a>
				
			</div>  
		</div>  
	</div>
	
		<div class="col-md-3">
		<div class="panel panel-info">
			<div class="panel-heading">

              <a href="customer.php" style="text-decoration:none;color:black;">
					Total Up-Coming Project
					<span class="badge pull pull-right"> 
								<?php 
$sql = $con->query("SELECT count(`student_id`) as `total` FROM `student_list`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>
				</a>
				

				
			</div>  
		</div>  
	</div>
-->		
	<div class="col-md-12">
	<?php include('student-list-home.php'); ?>
	
	</div>


	<div class="col-md-4" style="display:none;">
			<div class="card">
			
			<div class="cardHeader">
		    <h2><i class="fa fa-desktop"> </i> 
			Admin Panel ( ITM )
			</h2>
		  </div><hr>
		 <!-- 
		   <div class="cardContainer">
		    <p><h3><?php
				
				 $pq=mysqli_query($con,"select * from stuff left join `user` on user.userid=stuff.userid where stuff.userid='".$_SESSION['id']."'");
				 while($pqrow=mysqli_fetch_array($pq)){
				?>
			    <?php echo $pqrow['position']; ?>
			    <?php }?>
				</h3><p>
		  </div>
		 --> 
		  
		  <div class="cardHeader">
		    <h2><i class="fa fa-clock-o fa-fw"></i> <?php include('time.php'); ?></h2></center></h1>
		  </div>

		  <div class="cardContainer">
		    <p><h3><?php
        $date = new DateTime();
        echo $date->format('l -- F j, Y');
    ?></h3></p>
		    
		  </div>
		</div> 
		<br/>

	
		
		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <img src="includes/itm.png" alt="" />
		  </div>

		  <div class="cardContainer"> 
		  </div>
		</div> 

	</div>

	
  </div> 


<?php include('modal.php'); ?>
