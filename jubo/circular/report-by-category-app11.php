<?php 
require_once 'includes/conn.php';
require_once 'includes/dbconfig.php';
?>

<?php include('../scripts.php'); ?> 

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
  <title>E-Learning</title>
<link rel = "stylesheet" type = "text/css" href = "css/chosen.css" />
<script src="js/search.js"></script>
  <style type="text/css">
    nav a {
      font-size: 16px;
      font-weight: bold;
    }

    a {
      font-size: 14px;
      font-weight: bold;
    }
  </style>
  
 


</head>
   
<div class="container-fluid1"> 
<div class="row">
 
	<div class="col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading">
			<?php 
$sql = $con->query("SELECT count(`stu_id`) as `total` FROM `student_reg_jubo`  ");
$row = $sql->fetch_assoc();
$GT=$row['total'];  
?> 
				<i class="glyphicon glyphicon-user"></i> <strong> 	48 - District  Student Registration Information </strong>
			</div>
			 
			<div class="panel-body" style="padding:0px">
			
			<table width="100%" class="table table-bordered table-hover" customer_id="dataTables-example">
                        <thead>
						<tr>
                  <th class="text-center"  colspan="4"> 
				  <img src="img/banner.jpg" width="100%" /><br> <br>
                                                  আপডেট রেজিস্ট্রেশন এর তথ্য <br>
					 
                    Total Student Registration = <?php echo $GT; ?>					
				  </th> 
                </tr>
				<tr> 
				<th colspan="3"> 
   <div style="width:100%" class="form-group input-group">
                 
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search.....">
	</div>
	</th>			</tr>
                            <tr>							 
                                
                                <th>SL</th>  
                                <th>District</th>  
                                <th>Total</th>   
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;
								$eq=mysqli_query($con,"select count(student_reg_jubo.stu_id)as Total,district.dist_name from student_reg_jubo
                              left join district on district.id=student_reg_jubo.district
							  group by district.dist_name  
                              ORDER BY Total DESC
							  ");
								while($eqrow=mysqli_fetch_array($eq)){
							?>
										<tr> 
											<td><?php echo  ++$sl; ?></td>
											 <td><?php echo $eqrow['dist_name']; ?></td> 
											<td><?php echo $eqrow['Total']; ?></td> 
											 
			 
			</tr>
		<?php
		}  
		?>

</tbody>
</table>  

			</div> 
		</div>
	</div>
	
	
</div>


<?php require_once 'includes/footer.php'; ?>

</div>




<script src="custom/js/report.js"></script>
<script src = "js/chosen.js"></script>
<script type = "text/javascript">
	$('.chosen-select').chosen({width: "100%"});
</script>
