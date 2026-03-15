
<!doctype html>
<html lang="en">

<head>

  <title>Students | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

	<style type="text/css"> 
	body{
	  background-color:#f8f9fa;
}
  .table td, .table th {
  padding:2px;
}  
  .all{
  width:70%;
  margin:auto;
  border:1px solid #dee2e6;
  border-radius:10px;
  padding:5px;
}

    .dataTables_wrapper .row:nth-child(2) {
      overflow-x: scroll;
    }

    .dataTables_wrapper .row:nth-child(2) table {
      width: 1560px !important;
    }
  </style>

</head>

<body data-topbar="colored">

  <!-- <body data-layout="horizontal" data-topbar="colored"> -->

  <!-- Begin page -->
  <div id="layout-wrapper">

    <!-- ========== Header Start ========== -->
    <?php include "header.php" ?>
    <!-- ========== Header End ========== -->

    <!-- ========== Left Sidebar Start ========== -->
    <?php include "sidebar.php" ?>
    <!-- ========== Left Sidebar End ========== -->


    <!-- ========== Main Content Start ========== -->
    <div class="main-content">

      <div class="page-content">
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Dashboard</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All Students</li>
                  </ol>
                </div>

                <div class="state-information d-none d-sm-block">
                  <div class="state-graph">
                    <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                  </div>
                  <div class="state-graph">
                    <div id="header-chart-2" data-colors='["--bs-danger"]'></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <!-- Start Page-content-Wrapper -->
          <div class="page-content-wrapper">


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


	 <div class="all mt-5 bg-white" >   
	<table class="table table-hover">	
	<tr> 
	 
        <p class="mt-4" style="font-size:18px;font-weight:bold;text-align:center;"> 
	  <img  class="rounded mb-2" src="../stu-info/user_images/<?php echo $userPic; ?>" height="150" width="150" > 
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

	<!-- <div style="text-align:center; margin-top:20px;">
		<a href="generate-cv-pdf.php?student_id=<?php echo $student_id; ?>" class="btn btn-primary" target="_blank">
			<i class="fa fa-download me-2"></i>Download CV as PDF
		</a>
	</div> -->
 
 </div>






          </div>
          <!-- End Page-content -->

        </div>
      </div>


      <!-- ========== Footer Start ========== -->
      <?php include "footer.php" ?>
      <!-- ========== Footer End ========== -->
    </div>
    <!-- ========== Main Content End ========== -->

  </div>
  <!-- END layout-wrapper -->



  <?php include "script.php" ?>


  <script>
    $('#datatable').dataTable({
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      // "lengthMenu": [20, 50, 100],
      // "pageLength": 50,
      //"lengthChange": false,
      //"searching": false,
    });
  </script>

</body>

</html>






