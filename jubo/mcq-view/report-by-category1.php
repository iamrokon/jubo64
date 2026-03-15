<?php require_once 'header.php'; ?> 

<link rel = "stylesheet" type = "text/css" href = "css/chosen.css" />
 
<div class="container"><center><h4><ol class="breadcrumb"><li>Report By Category</li> </ol> </h4></center>
<div class="row">

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			
				<i class="glyphicon glyphicon-check"></i>	Report By Category
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/report-by-category.php" method="post" id="getOrderReportForm">
				
				 <div class="form-group">
				    <label for="ExpId" class="col-sm-4 control-label">Select Category</label>
				    <div class="col-sm-6">
				      <td> <select style="width:100%;" class="form-control chosen-select" Id="DistId" name="DistId" required=""/>
		<option value="#">Select Category</option>
				      	<?php 
				      	$sql = "SELECT distinct student_reg_jubo.district,district.dist_name FROM student_reg_jubo 
						left join district on district.id=student_reg_jubo.district ";
								$result = $con->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
		</select> </td>
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <center> <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> View  Report  </button></center>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			<?php 
$sql = $con->query("SELECT count(`stu_id`) as `total` FROM `student_reg_jubo`  ");
$row = $sql->fetch_assoc();
$GT=$row['total']; 
?> 
				<i class="glyphicon glyphicon-check"></i> <strong> 	District Wise Student Registration ( Total = <?php echo $GT;?> ) </strong>
			</div>
			 
			<div class="panel-body">
			<table width="100%" class="table table-bordered table-hover" customer_id="dataTables-example">
                        <thead>
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
							  group by student_reg_jubo.district limit 200 ");
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
