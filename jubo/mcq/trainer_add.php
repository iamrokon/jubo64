<?php require_once 'header.php'; ?> 
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	 
	if(isset($_POST['btnsave']))
	{ 
		$user_id = $_POST['user_id'];
		
		$Name = $_POST['Name']; 
		$Desi = $_POST['Desi']; 
		$ShortDes = $_POST['ShortDes']; 
		$Earning = $_POST['Earning']; 
		$About = $_POST['About'];  
		$Link1 = $_POST['Link1'];  
		$Link2 = $_POST['Link2'];  
		$Link3 = $_POST['Link3'];  
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		
		if(empty($Name)){
			$errMSG = "Please Enter  Name.";
		}
		
		
		else
		{
			$upload_dir = 'trainer_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp', 'svg'); // valid extensions
		
			// rename uploading image
			//$userpic = rand(1000,1000000).".".$imgExt;
			$userpic ="ela-trainer-".$imgFile;
			
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
			$stmt = $DB_con->prepare('INSERT INTO trainer (user_id,name,designation,short_des,earn_market,about_trainer,link1,link2,link3,userPic,entry_date) 
															VALUES(:user_id,:Name,:Desi,:ShortDes,:Earning,:About,:Link1,:Link2,:Link3,:upic,NOW() )');
			 
			$stmt->bindParam(':user_id',$user_id); 
			
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':Desi',$Desi);
			$stmt->bindParam(':ShortDes',$ShortDes);
			$stmt->bindParam(':Earning',$Earning);
			$stmt->bindParam(':About',$About); 
			$stmt->bindParam(':Link1',$Link1); 
			$stmt->bindParam(':Link2',$Link2); 
			$stmt->bindParam(':Link3',$Link3); 
			
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				?>
         <script>
				alert('Data Successfully Add ...');
				window.location.href='trainer.php';
				</script>
          <?php	
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


    	<h1 class="h2">  <a class="btn btn-success" href="trainer.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View  </a></h1>
  

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
        <td><input class="form-control" type="text" name="Desi" placeholder="Designation"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Short Descriptions </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="ShortDes" placeholder="Short Description"  ></textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Earning / Marketplace  </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="Earning" placeholder="Earning / Marketplace" ></textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  About Trainer </label></td>
        <td><textarea style="height:90px; width:100%;" class="form-control" name="About" placeholder="About Trainer" ></textarea></td>
    </tr>
	
		
	<tr>
    	<td><label class="control-label"> Freelancing  Link 01</label></td>
        <td><input class="form-control" type="text" name="Link1" placeholder="Freelancing  Link 01" value="Na" /></td>
   </tr>
   
   <tr>
    	<td><label class="control-label"> Freelancing  Link 02</label></td>
        <td><input class="form-control" type="text" name="Link2" placeholder="Freelancing  Link 02" value="Na"/></td>
   </tr>
   
   <tr>
    	<td><label class="control-label"> Freelancing  Link 03</label></td>
        <td><input class="form-control" type="text" name="Link3" placeholder="Freelancing  Link 03" value="Na" /></td>
   </tr>
	 
	
	<tr>
    	<td><label class="control-label"> Select Photo </label></td>
        <td>Please Upload Your Passport Size(300px X 320px) Image Here :
		<input class="input-group" type="file" name="user_image"/>
		</td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-primary">
        <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>


