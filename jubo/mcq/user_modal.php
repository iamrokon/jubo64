<!-- Monthly Userlog Report -->
    <div class="modal fade" id="m_userlog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Monthly User Log Report</h4>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
					<form method="POST" action="view_userlog.php">
						<div class="form-group input-group">
							<span class="input-group-addon" style="width:150px;">Month:</span>
							<select style="width:350px;" class="form-control" name="month">
								<option></option>
								<option>January</option>
								<option>February</option>
								<option>March</option>
								<option>April</option>
								<option>May</option>
								<option>June</option>
								<option>July</option>
								<option>August</option>
								<option>September</option>
								<option>October</option>
								<option>November</option>
								<option>December</option>
							</select>
						</div>
						<div class="form-group input-group">
							<span class="input-group-addon" style="width:150px;">Year:</span>
							<select style="width:350px;" class="form-control" name="year">
								<option></option>
								<?php
									for($i=2010;$i<=2050;$i++){
										?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</div>                
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> View</button>
					</form>
                </div>
				</div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->