<?php require_once 'header.php'; ?> 
<?php
	error_reporting( ~E_NOTICE ); 
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM trainer WHERE id =:uid');
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
		$ShortDes = $_POST['ShortDes']; 
		$Earning = $_POST['Earning']; 
		$About = $_POST['About'];  
		
        $Link1 = $_POST['Link1'];  
		$Link2 = $_POST['Link2'];  
		$Link3 = $_POST['Link3'];		
			
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
					
		if($imgFile)
		{
			$upload_dir = 'trainer_images/'; // upload directory	
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
			$stmt = $DB_con->prepare('UPDATE trainer 
									     SET name =:Name,
									         designation =:Desi, 
									         short_des =:ShortDes, 
									         earn_market =:Earning, 
									         about_trainer =:About,  
									         link1 =:Link1,  
									         link2 =:Link2,  
									         link3 =:Link3,  
										     userPic=:upic 
											 
								       WHERE id=:uid');

			
			 
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':Desi',$Desi);
			$stmt->bindParam(':ShortDes',$ShortDes);
			$stmt->bindParam(':Earning',$Earning);
			$stmt->bindParam(':About',$About); 
			
			$stmt->bindParam(':Link1',$Link1); 
			$stmt->bindParam(':Link2',$Link2); 
			$stmt->bindParam(':Link3',$Link3);
			
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='trainer.php';
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
    	<td><label class="control-label">  Short Descriptions </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="ShortDes"> <?php echo $short_des; ?></textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Earning / Marketplace  </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="Earning" > <?php echo $earn_market; ?> </textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  About Trainer </label></td>
        <td><textarea style="height:90px; width:100%;" class="form-control" name="About" > <?php echo $about_trainer; ?> </textarea></td>
    </tr>
	
	<tr>
    	<td><label class="control-label"> Freelancing  Link 01</label></td>
        <td><input class="form-control" type="text" name="Link1" value="<?php echo $link1; ?>" /></td>
   </tr>
   
   <tr>
    	<td><label class="control-label"> Freelancing  Link 02</label></td>
        <td><input class="form-control" type="text" name="Link2" value="<?php echo $link2; ?>" /></td>
   </tr>
   
   <tr>
    	<td><label class="control-label"> Freelancing  Link 03</label></td>
        <td><input class="form-control" type="text" name="Link3" value="<?php echo $link3; ?>" /></td>
   </tr>
	 
	
    <tr>
    	<td><label class="control-label"> Select Photo </label></td>
        <td>
        	<p><img src="trainer_images/<?php echo $userPic; ?>" height="150" width="150" /></p>
        	<input class="input-group" type="file" name="user_image"  />
        </td>
    </tr>
	 
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-primary">
        <span class="glyphicon glyphicon-save"></span> Update
        </button>
        
        <a class="btn btn-danger" href="trainer.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>



