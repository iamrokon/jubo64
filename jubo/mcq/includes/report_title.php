<?php
				
				   include('conn.php');
				   
				   $pq=mysqli_query($con,"select * from title_name ");
				   while($eqrow=mysqli_fetch_array($pq)){
				?>
			       <?php echo $eqrow['name']; ?>
				  
				   <?php }?>