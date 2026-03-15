<?php 
session_start();
require_once '../includes/conn.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="css/table_data_center_with_border_black.css">
</head>
<body> 

<div class="container" style="width:100%;">
<br>
 <center> 
  
 <h2> 16 District Jubo Project </h2> 
 <h3> Student Registration Report -  Date Wise </h3> 
 <span style="font-size:19;">  
				   <?php 
$startDate = $_POST['startDate'];  $endDate = $_POST['endDate'];
echo '   Date From : ' ; echo date("d - M - Y", strtotime( $startDate));
echo ' |   To :  ' ; echo date("d - M - Y", strtotime( $endDate));
?> 
	 </span> 			   
				   <br>
	<span style="font-size:18;">			   
	 
Date :<?php echo date("M d,Y") ;?> |
Time :<?php date_default_timezone_set("Asia/Dhaka"); echo  date("h:i:sa");?>
 </span> 
 </center> 
<br>  

<table width="100%" class="table table-bordered table-hover" customer_id="dataTables-example">
                        <thead>
                            <tr>
								 
                                
                                <th>SL</th>  
                                <th>District</th>  
                                <th>Total</th>   
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
			if($_POST) {				
							$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y',$startDate);
	$start_date = $date->format("Y-m-d");


	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y',$endDate);
	$end_date = $format->format("Y-m-d");
	
							  $sl=0;
							  $eq=mysqli_query($con,"select count(student_reg_jubo_new.stu_id)as Total,district.dist_name from student_reg_jubo_new
                              left join district on district.id=student_reg_jubo_new.district
							  where student_reg_jubo_new.entry_date >= '$start_date' AND student_reg_jubo_new.entry_date <= '$end_date'
							  
							  group by student_reg_jubo_new.district ");
							  while($eqrow=mysqli_fetch_array($eq)){
							?>
										<tr> 
											<td><?php echo  ++$sl; ?></td>
											 <td><?php echo $eqrow['dist_name']; ?></td> 
											<td><?php echo $eqrow['Total']; ?></td> 
											 
			 
			</tr>
		<?php
		}  
		}  
		?>

</tbody>
</table>  

  
 
</body>
</html>

