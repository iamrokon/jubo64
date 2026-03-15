<?php require_once 'header.php'; ?> 
<?php
	error_reporting( ~E_NOTICE ); 
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM emp_list WHERE id =:uid');
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
		
		$SerNo = $_POST['SerNo']; 
		$DepName = $_POST['DepName']; 
		$Name = $_POST['Name']; 
		$Desi = $_POST['Desi']; 
		$ShortDes = $_POST['ShortDes'];  
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'emp_images/'; // upload directory	
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
			$stmt = $DB_con->prepare('UPDATE emp_list 
									     SET name =:Name,
									         emp_serial =:SerNo, 
									         designation =:Desi, 
									         short_des =:ShortDes, 
									         department =:DepName, 
										     userPic=:upic 
											 
								       WHERE id=:uid');

			
			 
			$stmt->bindParam(':SerNo',$SerNo);
			$stmt->bindParam(':DepName',$DepName);
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':Desi',$Desi);
			$stmt->bindParam(':ShortDes',$ShortDes); 
			
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='emp_list.php';
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
    	<td><label class="control-label"> Select Department </label></td>
        <td>
		<select class="form-control"  name="DepName">
		<option value="<?php echo $department; ?>"><?php echo $department; ?></option>
		<option value="1">E-Learning</option>
		<option value="2">CTP</option>  
		<option value="3">HR / Accounts</option>  
		</select>
		</td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Serial No </label></td>
        <td><input class="form-control" type="text" name="SerNo"  value="<?php echo $emp_serial; ?>" /></td>
    </tr>
	
    <tr>
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" placeholder="Name" value="<?php echo $name; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Designation </label></td>
        <td><input class="form-control" type="text" name="Desi" value="<?php echo $designation; ?>" /></td>
    </tr>
	
	
	
	<tr>
    	<td><label class="control-label">  Short Descriptions </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="ShortDes"> <?php echo $short_des; ?></textarea></td>
    </tr>
	
	  
	
    <tr>
    	<td><label class="control-label"> Select Photo </label></td>
        <td>
        	<p><img src="emp_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image"  />
        </td>
    </tr>
	 
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-default" href="emp_list.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>



