<?php require_once 'header.php'; ?> 
<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	 
	if(isset($_POST['btnsave']))
	{ 
		$user_id = $_POST['user_id'];
		
		$IdNo = $_POST['IdNo']; 
		$IssueDate = $_POST['IssueDate']; 
		$Name = $_POST['Name'];  
		$CourseType = $_POST['CourseType']; 
		$CourseName = $_POST['CourseName']; 
		$Duration = $_POST['Duration']; 
		
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
			$stmt = $DB_con->prepare('INSERT INTO certificate (user_id,id_no,issue_date,student_name,course_type,course_name,duration,userPic,entry_date) 
															VALUES(:user_id,:IdNo,:IssueDate,:Name,:CourseType,:CourseName,:Duration,:upic,NOW() )');
			 
			$stmt->bindParam(':user_id',$user_id);  
			$stmt->bindParam(':IdNo',$IdNo);
			$stmt->bindParam(':IssueDate',$IssueDate); 
			$stmt->bindParam(':Name',$Name);
			$stmt->bindParam(':CourseType',$CourseType);
			$stmt->bindParam(':CourseName',$CourseName);
			$stmt->bindParam(':Duration',$Duration); 
			
			$stmt->bindParam(':upic',$userpic);
			
			if($stmt->execute())
			{
				
				?>
                <script>
				alert('New Certificate Add Successful.');
				window.location.href='certificate_add.php';
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
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

</head>
<body>

<div class="container"> 
<center><h4><ol class="breadcrumb"> <li class="active"> Add New </li></ol></h4></center>


    	<h1 class="h2"><a class="btn btn-default" href="certificate_add.php"> <span class="glyphicon glyphicon-plus"></span> Add New  </a> <a class="btn btn-default" href="certificate_all.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; View  </a></h1>
  

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
    	<td><label class="control-label">  Id No </label></td>
		<td> <input class="form-control" type="text" name="IdNo"  placeholder="Id Number" /></td>
	</tr>
		
	<tr>
    	<td><label class="control-label">  Issue Date </label></td>
        <td><input class="form-control" type="date" name="IssueDate" ></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Name </label></td>
        <td><input class="form-control" type="text" name="Name" placeholder="Name"  /></td>
    </tr>
	
	
	<tr>
    	<td><label class="control-label">Course</label></td>
    <td>
        <select style="width:100%;" class="form-control" Id="CourseType" name="CourseType" >
		 <option value="#">Select Course</option>
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
        <td><input class="form-control" type="text" name="CourseName" placeholder="Course Name"  /></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">  Duration </label></td>
        <td><textarea style="height:60px; width:100%;" class="form-control" name="Duration" placeholder="Short Description" ></textarea></td>
    </tr>
	
	 
	<tr style="display:none;">
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


