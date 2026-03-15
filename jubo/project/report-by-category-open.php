<?php 
session_start();
require_once 'includes/conn.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="css/table_data_center_with_border_black.css">
<?php include('link.php'); ?>
<script src="js/excel.js"></script>
</head>
<body> 
<!--
<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export To Excel">
-->

<div class="container-fluid" style="width:100%;">
<br>
 <center> 
  
 <h3> District Wise Report</h3> 
 <span style="font-size:19;">  
				   <?php 
				   $DistId = $_POST['DistId'];
				   $Batch = $_POST['Batch'];  
				   $pq=mysqli_query($con,"SELECT * FROM district   where id = '$DistId' ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
			    District Name :  <b>  <?php echo $pqrow['dist_name']; ?></b> <br>
				
				Batch :   <b>
				<?php
				if($Batch== 1) { echo "Batch-01"; }
				if($Batch== 2) { echo "Batch-02"; }
				?>
				 </b>  
				   
				   <?php }?>
				   
				  
				   
				     
	 </span> 			   
				   <br>
	<span style="font-size:18;">			   
	 
Date : <?php echo date("M d,Y") ;?> |
Time : <?php date_default_timezone_set("Asia/Dhaka"); echo  date("h:i:sa");?>
 </span> 
 </center> 
 <br>
 
 <table id="testTable" border="1" class="table table-bordered" style="width:100%;">
                        <thead>
                            
                            <tr> 
                                <th>SL</th> 
                                <th>Session</th>
                                <th>Batch</th> 
                                <th>Name</th>  
                                <th>Age</th>  
                                <th>Birth Date</th>  
								<th>Father</th>
								<th>Mother</th>
								<th>Address</th>
                                <th>Photo</th> 
                               
								
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;  
								$DistId = $_POST['DistId'];  
								$Batch = $_POST['Batch'];  
								$eq=mysqli_query($con,"SELECT * FROM student_list  
	left join district on district.id=student_list.district
	WHERE  district= '$DistId' and batch= '$Batch'  order by student_id asc");
	
								while($eqrow=mysqli_fetch_array($eq)){
									$eidm=$eqrow['user_id'];
									?>
										<tr>
											 
											<td><?php echo ++$sl; ?></td>
											 
											<td><?php echo $eqrow['session']; ?></td>
											<td><?php echo $eqrow['batch']; ?></td>
											
											<td><?php echo $eqrow['stu_name']; ?></td>  
											<td><?php echo $eqrow['age']; ?></td>  
											<td><?php echo date("d-M-Y", strtotime($eqrow['birth_date'])); ?></td>
											 <td><?php echo $eqrow['father_name']; ?></td>
											<td><?php echo $eqrow['mother_name']; ?></td> 
											<td><?php echo $eqrow['address']; ?></td> 
											 											
										 <td> <img src="../dist/user_images/<?php echo $eqrow['userPic']; ?>" class="img-rounded" height="30px;" width="30px;" /></td>
			 
			</tr>
		<?php
		}  
		?>

</tbody>
</table>
  

