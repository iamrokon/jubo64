<?php require_once 'header.php'; ?> 

<link rel = "stylesheet" type = "text/css" href = "css/chosen.css" />
 
<div class="container"><center><h4><ol class="breadcrumb"><li>Report By Category</li> </ol> </h4></center>
<div class="row">
	<div class="col-md-8">
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
				      <td> <select style="width:100%;" class="form-control chosen-select" Id="CatId" name="CatId" required=""/>
		<option value="#">Select Category</option>
				      	<?php 
				      	$sql = "SELECT distinct course_type,categories_name FROM certificate 
						left join categories on categories.categories_id=certificate.course_type  
						";
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
				      <center> <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i>View  Report  </button></center>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->
</div>


<?php require_once 'includes/footer.php'; ?>

</div>




<script src="custom/js/report.js"></script>
<script src = "js/chosen.js"></script>
<script type = "text/javascript">
	$('.chosen-select').chosen({width: "100%"});
</script>
