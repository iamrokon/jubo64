<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <?php include('link.php'); ?>
  
  <style type="text/css"> 
  .table td, .table th {padding:2px;}  
  .all{width:70%;margin:auto;border:1px solid #dee2e6;border-radius:10px;padding:5px;}
  </style>
 
</head>

<body>
<?php include('header.php'); ?>

<?php
	 
	
	if(isset($_GET['view']) && !empty($_GET['view']))
	{
		$student_id = $_GET['view'];
		$stmt_edit = $DB_con->prepare('SELECT * FROM student_list
        left join district on district.id=student_list.district 
		WHERE student_list.student_id =:uid');
		$stmt_edit->execute(array(':uid'=>$student_id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	 	
?>
  
      <div class="container mt-5">   
	  <br><br> 
	 <div class="all mt-5">   
	<table class="table table-hover">	
	<tr> 
	 
        <p style="font-size:18px;font-weight:bold;text-align:center;"> 
	  <img  class="rounded" src="../stu-info/user_images/<?php echo $userPic; ?>" height="150" width="150" > 
     <br>
	 <?php echo $stu_name; ?> <br>
	 District : <?php echo $dist_name; ?> | Batch : <?php echo $batch_id; ?>
	 
	 </p>
	  
    </tr>
    
	
	<tr>
    <td><label class="control-label">Name</label></td>
		<td>: <?php echo $stu_name; ?> </td>
    </tr>
	
	<tr>
    <td><label class="control-label">About / Objective</label></td>
		<td>: <?php echo $about; ?> </td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Contact</label></td>
        <td>: <?php echo $contact; ?>, <?php echo $email; ?></td>
    </tr>
	
	<!-------                      --------->
	<tr> <td colspan="2"><br><b> <center> Educational Qualification</center></b></td></tr>
 	<tr>
    	<td><label class="control-label">Academic  </label></td>
        <td>: <?php echo $edu_qual; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Passing Year </label></td>
        <td>: <?php echo $pass_year; ?></td>
    </tr>
	
	<!-------                      --------->
	<tr> <td colspan="2"><br><b> <center> Work Experience</center></b></td></tr>
	
	<tr>
    <td><label class="control-label">Experience</label></td>
		<td>: <?php echo $work; ?> </td>
    </tr>
	
	<!-------                      --------->
	<tr> <td colspan="2"><br><b> <center> Personal Details</center></b></td></tr>
	<tr>
    	<td><label class="control-label">Age</label></td>
        <td> : <?php echo $age; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Profession</label></td>
        <td> : <?php echo $profession; ?></td>
    </tr>
	
	<tr>
    <td><label class="control-label">Father Name</label></td>
		<td>: <?php echo $father_name; ?> </td>
    </tr>
	
	<tr>
    <td><label class="control-label">Mother Name</label></td>
		<td>: <?php echo $mother_name; ?> </td>
    </tr>  
	
	<tr>
    	<td><label class="control-label">Religion </label></td>
        <td>: <?php echo $religion; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Blood Group </label></td>
        <td>: <?php echo $blood_grp; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Address </label></td>
        <td> : <?php echo $address; ?></td>
    </tr>
	
	<!-------                      --------->
	<tr> <td colspan="2"><br><b> <center> Other Information</center></b></td></tr>
	<tr>
    	<td><label class="control-label">NID/Birth Certificate No</label></td>
        <td>: <?php echo $nid_no; ?></td>
    </tr>
	
	<tr>
    	<td><label class="control-label">Have a Computer </label></td>
        <td>: <?php echo $computer; ?></td>
		
    </tr>
		
	<tr>
    	<td><label class="control-label">Disabilities</label></td>
        <td>: <?php echo $disabilities; ?></td> 
    </tr>
	
	<!-------                      --------->
	<tr> <td colspan="2"><br><b> <center> Freelancing Profile</center></b></td></tr>
	
	<tr style="display:<?php echo $linked_in; ?>;">
    	<td><label class="control-label">LinkedIn </label></td>
        <td><a target="_blank" href="<?php echo $linked_in; ?>"><?php echo $linked_in; ?></a></td>
    </tr>
	
	<tr style="display:<?php echo $upwork; ?>;">
    	<td><label class="control-label">Upwork </label></td>
        <td><a target="_blank" href="<?php echo $upwork; ?>"><?php echo $upwork; ?></a></td>
    </tr>
	
	<tr style="display:<?php echo $fiver; ?>;">
    	<td><label class="control-label">Fiverr </label></td>
        <td><a target="_blank" href="<?php echo $fiver; ?>"><?php echo $fiver; ?></a></td>
    </tr>
	
	<tr style="display:<?php echo $link_three; ?>;">
    	<td><label class="control-label">Freelancing Link 3 </label></td>
        <td><a target="_blank" href="<?php echo $link_three; ?>"><?php echo $link_three; ?></a></td>
    </tr>
	
	<tr style="display:<?php echo $link_four; ?>;">
    	<td><label class="control-label">Freelancing Link 4 </label></td>
        <td><a target="_blank" href="<?php echo $link_four; ?>"><?php echo $link_four; ?></a></td>
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
 </div>
  <br><br>
  