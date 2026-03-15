<?php require_once 'header.php'; ?> 
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	 
	if(isset($_POST['btnsave']))
	{ 
		$user_id = $_POST['user_id'];
		
		$Name = $_POST['Name']; 
		$Desi = $_POST['Desi']; 
		$Location = $_POST['Location']; 
		$Earn = $_POST['Earn']; 
		$Job = $_POST['Job']; 
		$Hours = $_POST['Hours']; 
		$Overview = $_POST['Overview']; 
		$Link = $_POST['Link']; 
		$MarkPlace = $_POST['MarkPlace'];
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($Name)){
			$errMSG = "Please Enter  Name.";
		}
		
		
		else
		{
			$upload_dir = 'user_images/'; // upload directory
	
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
			$stmt = $DB_con->prepare('INSERT INTO gallery (user_id,name,designation,location,total_earn,total_job,total_hours,overview,link,type,userPic,entry_date) 
															VALUES(:user_id,:Name,:Desi,:Location,:Earn,:Job,:Hours,:Overview,:Link,:MarkPlace,:upic,NOW() ) ');
			 
			$stmt->bindParam(':user_id',$user_id); 
			
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':Desi',$Desi);
			$stmt->bindParam(':Location',$Location);
			$stmt->bindParam(':Earn',$Earn);
			$stmt->bindParam(':Job',$Job);
			$stmt->bindParam(':Hours',$Hours);
			$stmt->bindParam(':Overview',$Overview);
			$stmt->bindParam(':Link',$Link);
			$stmt->bindParam(':MarkPlace',$MarkPlace);
			
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				$successMSG = " New File Add Succesfully  ...";
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

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>

<div class="container"> 
<center><h4><ol class="breadcrumb"> <li class="active"> Add New </li></ol></h4></center>


    	<h1 class="h2"><a class="btn btn-default" href="file_add.php"> <span class="glyphicon glyphicon-plus"></span> Add New  </a> <a class="btn btn-default" href="file.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View  </a></h1>
  

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
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" placeholder="Name"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Designation </label></td>
        <td><input class="form-control" type="text" name="Desi"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label"> Address / Location </label></td>
        <td><input class="form-control" type="text" name="Location"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Earn </label></td>
        <td><input class="form-control" type="text" name="Earn" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Job </label></td>
        <td><input class="form-control" type="text" name="Job" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Hours </label></td>
        <td><input class="form-control" type="text" name="Hours" placeholder="Total Hours" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Overview </label></td>
        <td><textarea style="height:100px; width:100%;" class="form-control" name="Overview" placeholder="Please Write Here " ></textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Link </label></td>
        <td><input class="form-control" type="text" name="Link" placeholder="Link" /></td>
   </tr>
	 
	<tr>
    	<td><label class="control-label"> Select Market Place </label></td>
        <td>
		<select class="form-control"  name="MarkPlace">
		<option value="1">Upwork</option>
		<option value="2">Fiver</option>  
		</select>
		</td>
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


