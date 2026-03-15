<?php require_once 'header.php'; ?> 
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	 
	if(isset($_POST['btnsave']))
	{ 
		$user_id = $_POST['user_id'];
		
		$SerNo = $_POST['SerNo']; 
		$DepName = $_POST['DepName']; 
		$Name = $_POST['Name']; 
		$Desi = $_POST['Desi']; 
		$ShortDes = $_POST['ShortDes']; 
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($Name)){
			$errMSG = "Please Enter  Name.";
		}
		
		
		else
		{
			$upload_dir = 'emp_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp', 'svg'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			//else{
			//	$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			//}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO emp_list (user_id,emp_serial,department,name,designation,short_des,userPic,entry_date) 
															VALUES(:user_id,:SerNo,:DepName,:Name,:Desi,:ShortDes,:upic,NOW() )');
			 
			$stmt->bindParam(':user_id',$user_id); 
			
			$stmt->bindParam(':SerNo',$SerNo);
			$stmt->bindParam(':DepName',$DepName);
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':Desi',$Desi);
			$stmt->bindParam(':ShortDes',$ShortDes); 
			
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				$successMSG = " New File Add Successfully  ...";
				//header("refresh:2; customer.php"); // redirects image view page after 5 seconds.
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
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>

<div class="container"> 
<center><h4><ol class="breadcrumb"> <li class="active"> Add New </li></ol></h4></center>


    	<h1 class="h2"><a class="btn btn-default" href="emp_list_add.php"> <span class="glyphicon glyphicon-plus"></span> Add New  </a> <a class="btn btn-default" href="emp_list.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View  </a></h1>
  

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
	    
	<table class="table table-hover table-responsive">
	
   <tr>
    	
		<?php 
				   $pq=mysqli_query($con,"select * from `user` where  userid='".$_SESSION['id']."'");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
        
        <input class="form-control" type="hidden" name="user_id"  value="<?php echo $pqrow['userid']; ?>" />
		<?php }?>
    </tr>
	
	<tr>
    	<td><label class="control-label"> Select Department </label></td>
        <td>
		<select class="form-control"  name="DepName">
		<option value="1">E-Learning</option>
		<option value="2">CTP</option>  
		<option value="3">HR / Accounts</option>  
		</select>
		</td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Serial No </label></td>
		<td>
		<?php	 
				   $pq=mysqli_query($con,"select MAX(emp_serial)+1 as max_id from emp_list  where department=2 ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
		<input class="form-control" type="text" name="SerNo" value="<?php echo $pqrow['max_id']; ?>"  /></td>
		<?php }?>
    </tr>
		
	<tr>
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" placeholder="Name"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Designation </label></td>
        <td><input class="form-control" type="text" name="Desi" placeholder="Designation"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Short Descriptions </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="ShortDes" placeholder="Short Description" ></textarea></td>
    </tr>
	
	 
	<tr>
    	<td><label class="control-label"> Select Photo </label></td>
        <td><input class="input-group" type="file" name="user_image"/></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>


