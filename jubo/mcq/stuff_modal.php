<!-- Add Stuff -->
    <div class="modal fade" id="adddealer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><center>Add New Stuff</center></h4>
                </div>
                <div class="modal-body">
				<div class="container-fluid">
                    <form role="form" method="POST" action="add_stuff.php" enctype="multipart/form-data">
						<div class="container-fluid">
						<div style="height:15px;"></div>
		<!--  -->				
						<div style="width:100%" class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Stuff Name:</span>
                            <input type="text" style="width:100%; text-transform:capitalize;" class="form-control" name="StuffName" required>
					     </div>
						
						
						
						<div style="width:100%" class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Position:</span>
                            <input type="text" style="width:100%; text-transform:capitalize;" class="form-control" name="Position" required>
                        </div>
						
						<div  style="width:100%" class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Phone No:</span>
                            <input type="text" style="width:100%;" class="form-control" name="contact">
                        </div>
						
												
						<div style="width:100%" class="form-group input-group">	
							<span style="width:120px;" class="input-group-addon">Joined Date:</span>
                            <input type="date" style="width:100%;" class="form-control" name="joindate" required>
                        </div>
						
											
						<div style="width:100%" class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Username:</span>
                            <input type="text" style="width:100%;" class="form-control" name="username" required>
						</div>
						
						<div style="width:100%" class="form-group input-group">
							<span style="width:120px;" class="input-group-addon">Password:</span>
                            <input type="password" style="width:100%;" class="form-control" name="password" required>
                        </div>
						
						<div style="width:100%" class="form-group input-group">
                            <span style="width:120px;" class="input-group-addon">Photo:</span>
                            <input type="file" style="width:100%;" class="form-control" name="image">
                        </div>
						</div>
				</div>    <!--  -->
				 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                   <a href="stuff.php"></a> <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
					</form>
                </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->

