 
<?php 
require_once 'includes/db_connect.php'; 
 ?>

<div class="row">


	<div class="col-md-3">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="php_action/view_product_stock.php" style="text-decoration:none;color:black;">
					Total News
					<span class="badge pull pull-right">
					<?php 
$sql = $connect->query("SELECT count(`id`) as `total` FROM `news_section`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>						
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
	
	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading">
			<a href="php_action/view_product_stock.php" style="text-decoration:none;color:black;">
					Total On Going Project
					<span class="badge pull pull-right">
<?php 
$sql = $connect->query("SELECT count(`id`) as `total` FROM `project_on_going`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div>
	
	<div class="col-md-3">
		<div class="panel panel-success">
			<div class="panel-heading">
			<a href="php_action/view_product_stock.php" style="text-decoration:none;color:black;">
					Total Hand Over Project
					<span class="badge pull pull-right">
<?php 
$sql = $connect->query("SELECT count(`id`) as `total` FROM `project_hand_over`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div>
	
		<div class="col-md-3">
		<div class="panel panel-info">
			<div class="panel-heading">

              <a href="customer.php" style="text-decoration:none;color:black;">
					Total Up-Coming Project
					<span class="badge pull pull-right"> 
					<?php 
$sql = $connect->query("SELECT count(`id`) as `total` FROM `project_up_comming`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
					</span>
				</a>
				

				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div>


	<div class="col-md-4">
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
		    <p>Design & Developed By ITM-SOFTS</p>
		  </div>
		</div> 

	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			
			<div class="panel-body">
				<div id="calendar"><center><img src="../staff/img/itmm.jpg" width="100%"alt="" /></div>
			</div>	
		</div>
		
	</div>
</div> <!--/row-->


<?php include('modal.php'); ?>
