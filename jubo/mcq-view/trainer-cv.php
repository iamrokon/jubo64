<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>
 
</head>

<body>
<?php include('header.php'); ?>

<?php
	 
	
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$student_id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM trainer WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$student_id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	 	
?>
 
       
      <div class="container mt-5">   
	  <br><br><br><br>
	<table class="table table-hover table-responsive mt-5">
	
	<tr> 
        <p style="font-size:18px;font-weight:bold;text-align:center;"> 
	  <img class="rounded" src="../dist/trainer_images/<?php echo $userPic; ?>" height="150" width="150" > 
     <br>
	 <?php echo $name; ?>  
	 
	 </p>
	   
    </tr>
     
	
	<tr>
    <td><label class="control-label">Designation</label></td>
		<td><?php echo $designation; ?> </td>
    </tr>
    
	
	<tr>
    	<td><label class="control-label">About  </label></td>
        <td><?php echo $about_trainer; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Earning / Marketplace </label></td>
        <td><?php echo $earn_market; ?></td>
    </tr>
	
	
	<tr>
    	<td><label class="control-label">Freelancing Link 1 </label></td>
        <td><a target="_blank" href="<?php echo $link1; ?>"><?php echo $link1; ?></a></td>
    </tr>
	
	
	<tr>
    	<td><label class="control-label">Freelancing Link 2 </label></td>
        <td><a target="_blank" href="<?php echo $link2; ?>"><?php echo $link2; ?></a></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Freelancing Link 3 </label></td>
        <td><a target="_blank" href="<?php echo $link3; ?>"><?php echo $link3; ?></a></td>
    </tr>
	
	<tr style="display:none;">
    	<td><label class="control-label">Active/In-Active</label></td>
       	<td><select style="width:100%;" class="form-control" name="status"  value="<?php echo $status; ?>" />
		<option value="1">Active</option> 
		<option value="0">In-Active</option>
		</select> </td>       
	</tr>
	 
    
      
    
    </table>
	
	 
 
 </div>
  <br><br>
  