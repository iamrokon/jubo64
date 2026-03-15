<?php 
session_start();
require_once '../includes/conn.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="css/table_data_center_with_border_black.css">
<script src="js/excel.js"></script>
</head>
<body> 
<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export To Excel">

<div class="container" style="width:100%;">
<br>
 <center> 
  
 <h3> District Wise Report</h3> 
 <span style="font-size:19;">  
				   <?php 
				   $DistId = $_POST['DistId'];
				   $pq=mysqli_query($con,"SELECT * FROM district   where id = '$DistId' ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
			    District Name : <b>  <?php echo $pqrow['dist_name']; ?></b>
				  
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
	
	$DistId = $_POST['DistId']; 
	$sql = "SELECT * FROM student_reg_jubo  
	left join district on district.id=student_reg_jubo.district
	WHERE  district= '$DistId'  order by stu_id asc";
	$query = $con->query($sql);
	$countOrder = $query->num_rows;

	$table = '
	<table id="testTable" border="1" class="table table-bordered" style="width:100%;">
      <tr> 
		         <th>SL</th> 
                                <th>Date</th> 
                                <th>Name</th>
                                <th>Phone</th>   
                                <th>Email</th>   
                                <th>Address</th>   
                                <th>Photo</th>   
                                <th>Comments</th>   
	 <tr>
		 

		<tr>'; 
		$sl=0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
		      	<td><center>'.++$sl.'</center></td>
			    <td><center>'.date("d-M-Y", strtotime($result['entry_date'])).'</center></td>
				<td><center>'.$result['student_name'].'</center></td>
				<td><center>'.$result['phone'].'</center></td>
				<td><center>'.$result['email'].'</center></td>  
				<td><center>'.$result['address'].'</center></td>  
			    <td><center><img src="jubo-student-image/'.$result[userPic].'" width="50px" height="50px"></center></td>  
			    <td> </td>  
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

