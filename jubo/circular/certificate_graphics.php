<?php require_once 'header.php'; ?>
<?php 
	if(isset($_GET['delete_id']))
	{
		// select image from db to delete
		$stmt_select = $DB_con->prepare('SELECT userPic FROM certificate WHERE  id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		//unlink("user_images/".$imgRow['userPic']);
		
		// it will delete an actual record from db
		$stmt_delete = $DB_con->prepare('DELETE FROM certificate WHERE  id =:uid');
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
<center><h4><ol class="breadcrumb"> <li class="active">Certificate - Graphics </li></ol></h4></center>

	
	<div style="width:100%" class="form-group input-group">
                 <span style="width:120px;" class="input-group-addon">Search :</span>
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search..">
			  </div>

	<div class="buttons">
	
		<div class="col-md-2">
		<a class="btn btn-default" style="width:100%" href="certificate_add.php"> <span class="glyphicon glyphicon-plus"></span> Add New  </a> 
		</div>
		
		</div>
    
<table width="100%" class="table table-hover" customer_id="dataTables-example">
                        <thead>
                            <tr> 
                                
                                <th> SL</th>
                                <th> Issue Date</th>
                                <th> Id No</th>
                                <th> Name</th>
                                <th> Course</th>  
                                <th> Duration</th>  
								<th>Edit</th>
								<th>Delete</th>
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;
								$eq=mysqli_query($con,"select * from certificate where course_type=2 ORDER BY id ASC   ");
								while($eqrow=mysqli_fetch_array($eq)){
							?>
										<tr> 
											<td><?php echo  ++$sl; ?></td>
											<td><?php echo $eqrow['issue_date']; ?></td>
											<td><?php echo $eqrow['id_no']; ?></td>
											<td><?php echo $eqrow['student_name']; ?></td>
											<td><?php echo $eqrow['course_name']; ?></td> 
											<td><?php echo $eqrow['duration']; ?></td> 
											
			 <td><a  class="btn btn-info" href="certificate_edit.php?edit_id=<?php echo $eqrow['id']; ?>" title="click for edit" onclick="return confirm('Are You Sure To Edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a> </td>  
				<td><a class="btn btn-danger" href="?delete_id=<?php echo $eqrow['id']; ?>" title="click for delete" onclick="return confirm('Are You Sure To Delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a> </td>
			
				
			</tr>
		<?php
		}  
		?>

</tbody>
</table>


<?php include('includes/footer.php'); ?>
</div>
