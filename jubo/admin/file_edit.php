<?php require_once 'header.php'; ?> 
<?php
	error_reporting( ~E_NOTICE ); 
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM gallery WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
	
	if(isset($_POST['btn_save_updates']))
	{
		
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
					
		if($imgFile)
		{
			$upload_dir = 'user_images/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp', 'svg'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					//unlink($upload_dir.$edit_row['userPic']);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $edit_row['userPic']; // old image from database
		}	
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE gallery 
									     SET name =:Name,
									         designation =:Desi, 
									         location =:Location, 
									         total_earn =:Earn, 
									         total_job =:Job, 
									         total_hours =:Hours, 
									         overview =:Overview, 
									         link =:Link, 
									         type =:MarkPlace, 
										     userPic=:upic 
								       WHERE id=:uid');

			
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
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='file.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- custom stylesheet -->
<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container"> 
<center><h4><ol class="breadcrumb"> <li class="active">Update</li></ol></h4></center>


<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-hover table-responsive">
	
    <tr>
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" placeholder="Name" value="<?php echo $name; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Designation </label></td>
        <td><input class="form-control" type="text" name="Desi" value="<?php echo $designation; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label"> Address / Location </label></td>
        <td><input class="form-control" type="text" name="Location" value="<?php echo $location; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Earn </label></td>
        <td><input class="form-control" type="text" name="Earn" value="<?php echo $total_earn; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Job </label></td>
        <td><input class="form-control" type="text" name="Job" value="<?php echo $total_job; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Total Hours </label></td>
        <td><input class="form-control" type="text" name="Hours"  value="<?php echo $total_hours; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Overview </label></td>
        <td><textarea style="height:100px; width:100%;" class="form-control" name="Overview"><?php echo $overview; ?></textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Link </label></td>
        <td><input class="form-control" type="text" name="Link" value="<?php echo $link; ?>"  /></td>
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
        <td>
        	<p><img src="user_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image"  />
        </td>
    </tr>
	 
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="file.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>



