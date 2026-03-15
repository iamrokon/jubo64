<?php require_once 'header.php'; ?>
<?php 
include('pagination.php');
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT userPic FROM student_reg_jubo WHERE  stu_id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		//unlink("user_images/".$imgRow['userPic']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM student_reg_jubo WHERE  stu_id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		
		//header("Location:customer.php");
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/buttons.css">
<link rel="stylesheet" href="css/table_data_center.css">
<script src="js/search.js"></script>
</head>

<body>
<div class="container-fluid"> 
<center><h4><ol class="breadcrumb"> <li class="active">
Jubo Student List ( Total = 
<?php 
$sql = $con->query("SELECT count(`stu_id`) as `total` FROM `student_reg_jubo`  ");
$row = $sql->fetch_assoc();
echo $row['total'];
?>
) 

</li></ol></h4></center>

	<div class="breadcrumb" id="pagination_controls"><?php echo $paginationCtrls; ?></div>
	
	<div style="width:100%" class="form-group input-group">
                 <span style="width:120px;" class="input-group-addon">Search :</span>
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search..">
			  </div>
 
  
<table width="100%" class="table table-bordered table-hover" customer_id="dataTables-example">
                        <thead>
                            <tr>
								 
                                
                                <th>SL</th> 
                                <th>Date</th> 
                                <th>Name</th>
                                <th>Phone</th>   
                                <th>Email</th>  
                                <th>District</th>  
                                <th>Address</th>  
                                <th>Education</th>  
								<th>Photo</th>
								
								<!--<th>Edit</th>
								<th>Delete</th>
								-->
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;
								while($eqrow=mysqli_fetch_array($nquery)){
							?>
										<tr> 
											<td><?php echo  ++$sl; ?></td>
											<td><?php echo date("d-M-Y", strtotime($eqrow['entry_date'])); ?></td>
											<td><?php echo $eqrow['student_name']; ?></td>
											<td><?php echo $eqrow['phone']; ?></td>
											<td><?php echo $eqrow['email']; ?></td>
											<td><?php echo $eqrow['dist_name']; ?></td> 
											<td><?php echo $eqrow['address']; ?></td> 
											<td><?php echo $eqrow['education']; ?></td> 
											
				<td><img src="jubo-student-image/<?php echo $eqrow['userPic']; ?>" width="50px" height="50px" /></td> 
            <!--
			<td><a  class="btn btn-info" href="emp_list_edit.php?edit_id=<?php echo $eqrow['id']; ?>" title="click for edit" onclick="return confirm('Are You Sure To Edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a> </td>  
			<td><a class="btn btn-danger" href="?delete_id=<?php echo $eqrow['id']; ?>" title="click for delete" onclick="return confirm('Are You Sure To Delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a> </td>
			-->
				
			</tr>
		<?php
		}  
		?>

</tbody>
</table>

<div class="breadcrumb" id="pagination_controls"><?php echo $paginationCtrls; ?></div>


<?php include('includes/footer.php'); ?>
</div>
