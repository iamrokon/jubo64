<?php require_once 'header.php'; ?> 

<link rel = "stylesheet" type = "text/css" href = "css/chosen.css" />
 
<div class="container"><center><h4><ol class="breadcrumb"><li>Report By Date</li> </ol> </h4></center>
 
 <div class="row">
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
			
				<i class="glyphicon glyphicon-check"></i> Sales Report - Date Wise
			</div> 
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/report-by-date.php" method="post" id="getOrderReportForm">
				
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Start Date</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">End Date</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-7">
				      <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> View Report</button>
				    </div>
				  </div>
				</form>

			</div> 
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
