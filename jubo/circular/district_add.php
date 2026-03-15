<?php require_once 'header.php'; ?>
<?php 
	
	if(isset($_POST['btnsave']))
	{
		
		$UserId = $_POST['UserId'];
		$DistName = $_POST['DistName'];
		$DivName = $_POST['DivName'];
		
		
		
		if(empty($DistName)){
			$errMSG = "Please Enter District Name.";
		}
		 
		
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO district (user_id,dist_name,div_id) VALUES(:UserId,:DistName,:DivName)');
			
			
			$stmt->bindParam(':UserId',$UserId);
			$stmt->bindParam(':DistName',$DistName);
			$stmt->bindParam(':DivName',$DivName);
			
			
			if($stmt->execute())
			{
			
			?>
                <script>
				alert(' District Add Successful...');
				window.location.href='district.php';
				</script>
                <?php
			//	$successMSG = "Data Add Successful...";
				//header("refresh:2; expense.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>

<div class="container">
<center><h4><ol class="breadcrumb"> <li class="active">  District   </li></ol></h4></center>	


    	<h1 class="h2">&nbsp;<a class="btn btn-default" href="district_add.php"> <span class="glyphicon glyphicon-plus"></span>Add New</a> <a class="btn btn-default" href="district.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View</a></h1>
  
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal" >
	    
	<table class="table table-bordered table-responsive">
	
   <tr>
    	
		<?php    
				   $pq=mysqli_query($con,"select * from user where userid='".$_SESSION['id']."'");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
        
        <input class="form-control" type="hidden" name="UserId"  value="<?php echo $pqrow['userid']; ?>" />
		<?php }?>
    </tr>
	
	<tr>
    	<td><label class="control-label">Division</label></td>
    <td>
        <select style="width:100%;" class="form-control" Id="DivName" name="DivName" >
		 <option value="#">Select Division</option>
				      	<?php 
				      	$sql = "SELECT  div_id,div_name FROM division ";
								$result = $con->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[0]."-".$row[1]."</option>";
								} 
				      	?>
						
		</select> 
	</td>	
   </tr>
	
	
	
	<tr>
    	<td><label class="control-label">District Name</label></td>
		<td><input class="form-control" type="text" name="DistName" placeholder="District Name"></td>
    </tr>
	
		
	 
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; Save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>



</div>

</body>
</html>





