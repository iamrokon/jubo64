           
		   <form class="form-horizontal" action="report-by-category-open.php"  target="_blank" method="post" id="getOrderReportForm">
			 
			 <div class="form-row mt-3"> 
				<div class="col-md-5 form-group text-center">
				<h4> Category Wise Question View </h4>
				</div>
				
				<div class="col-md-4 form-group">
	             <select Id="CatId" name="CatId" class="form-control" required>
                <option value="" >Select Question</option>
                   <?php 
				       $sl=0;
				      	$sql = "select * from question_category ";
								$result = $con->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".++$sl."-".$row[1]."</option>";
								} // while
								
				      	?>
                 </select> 
                </div>
								 
				
				 <div class="col-md-2 form-group">
                  <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Open  Report  </button>
                </div>
				 
				  
              </div>			    
            
			</form>	
			
			 

<script src="custom/js/report.js"></script> 
