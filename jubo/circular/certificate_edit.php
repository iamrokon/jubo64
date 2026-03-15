<?php require_once 'header.php'; ?> 
<?php
	error_reporting( ~E_NOTICE ); 
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM certificate
        left join categories on categories.categories_id=certificate.course_type
		WHERE certificate.id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: certificate_all.php");
	}
	
	if(isset($_POST['btn_save_updates']))
	{
		
		$IdNo = $_POST['IdNo']; 
		$IssueDate = $_POST['IssueDate']; 
		$Name = $_POST['Name'];  
		$CourseType = $_POST['CourseType']; 
		$CourseName = $_POST['CourseName']; 
		$Duration = $_POST['Duration']; 
			
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
			$stmt = $DB_con->prepare('UPDATE certificate 
									     SET id_no =:IdNo,
									         issue_date =:IssueDate, 
									         student_name =:Name, 
									         course_type =:CourseType, 
									         course_name =:CourseName, 
									         duration =:Duration  
											 
								       WHERE id=:uid');

			
			 
			$stmt->bindParam(':IdNo',$IdNo);
			$stmt->bindParam(':IssueDate',$IssueDate); 
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':CourseType',$CourseType);
			$stmt->bindParam(':CourseName',$CourseName);
			$stmt->bindParam(':Duration',$Duration);
			
			$stmt->bindParam(':uid',$id);
				
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated ...');
				window.location.href='certificate_all.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		
		}
		
						
	}
	
?>



<!DOCTYPE html PUBLIC >
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
    	<td><label class="control-label">  Id No </label></td>
		<td> <input class="form-control" type="text" name="IdNo"  value="<?php echo $id_no; ?>" /></td>
	</tr>
		
	<tr>
    	<td><label class="control-label">  Issue Date </label></td>
        <td><input class="form-control" type="date" name="IssueDate" value="<?php echo $issue_date; ?>" ></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" value="<?php echo $student_name; ?>"  /></td>
    </tr>
	
	
	<tr>
    	<td><label class="control-label">Course</label></td>
    <td>
        <select style="width:100%;" class="form-control" Id="CourseType" name="CourseType" >
		 <option value="<?php echo $course_type; ?>"><?php echo $categories_name; ?></option>
				      	<?php 
				      	$sql = "SELECT  categories_id,categories_name FROM categories where user_id='".$_SESSION['id']."' ";
								$result = $con->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} 
				      	?>
						
		</select> 
	</td>	
   </tr>
   
	 
	
	<tr>
    	<td><label class="control-label">  Course Name  </label></td>
        <td><input class="form-control" type="text" name="CourseName" value="<?php echo $course_name; ?>" /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Duration </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="Duration" ><?php echo $duration; ?></textarea></td>
    </tr>
	
	  
	
    <tr style="display:none;">
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
        
        <a class="btn btn-default" href="certificate_all.php"> <span class="glyphicon glyphicon-backward"></span> cancel </a>
        
        </td>
    </tr>
    
    </table>
    
</form>
<?php include('includes/footer.php'); ?>
</div>



