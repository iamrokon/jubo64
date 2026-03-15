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
  
 <span style="font-size:19;">
 Category Wise Report <br>
  
 
				   <?php 
				   $CatId = $_POST['CatId'];
				   $pq=mysqli_query($con,"SELECT categories_id,categories_name FROM categories   where categories_id = '$CatId' ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
			    Category Name : <b>  <?php echo $pqrow['categories_name']; ?></b>
				  
				   <?php }?>
	 </span> 			   
				   <br>
	<span style="font-size:18;">			   
	 
Date :<?php echo date("M d,Y") ;?> |
Time :<?php date_default_timezone_set("Asia/Dhaka"); echo  date("h:i:sa");?>
 </span> 
 </center> 
<br>  
 
<?php  
if($_POST) {
	
	$CatId = $_POST['CatId']; 
	$sql = "SELECT * FROM certificate  
	WHERE  course_type= '$CatId'  order by id asc";
	$query = $con->query($sql);
	$countOrder = $query->num_rows;

	$table = '
	<table border="1" class="table table-bordered" style="width:100%;">
      <tr> 
		 <th>SL  </th>
		 <th>Issue Date  </th>
		 <th>Id No  </th>
		 <th>Name  </th>
		 <th>Course</th>
		 <th>Duration  </th> 
	 <tr>
		 

		<tr>'; 
		$sl=0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
		      	<td><center>'.++$sl.'</center></td>
			    <td><center>'.date("d-M-Y", strtotime($result['issue_date'])).'</center></td>
				
				<td><center>'.$result['id_no'].'</center></td>
				<td><center>'.$result['student_name'].'</center></td>
				<td><center>'.$result['course_name'].'</center></td> 
				<td><center>'.$result['duration'].'</center></td> 
			</tr>';	 
			
		}
		$table .= '
		</tr>

		 
	</table>
	';	

	echo $table;

}

?>




 
</body>
</html>

