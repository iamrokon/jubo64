<table width="100%" class="table table-hover" customer_id="dataTables-example">
                        <thead>
                            <tr>
								 
                                
                                <th> SL</th>
                                <th> Name</th>
                                <th> Designation</th>  
								 <th>Photo</th> 
								  <th>CV</th> 
								 <th>Freelancing Profile</th>  
								 
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;
								$eq=mysqli_query($con,"select * from trainer  ORDER BY id asc limit 5  ");
								while($eqrow=mysqli_fetch_array($eq)){
							?>
										<tr>
										
											<td><?php echo  ++$sl; ?></td>
											<td><?php echo $eqrow['name']; ?></td>
											<td><?php echo $eqrow['designation']; ?></td> 
											
				<td><img src="../dist/trainer_images/<?php echo $eqrow['userPic']; ?>" width="50px" height="50px" /></td> 
                <td><a  class="btn btn-primary" href="trainer-cv.php?edit_id=<?php echo $eqrow['id']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> CV</a> </td>
				 <td>
			   <a  class="btn btn-info" target="_blank" href="<?php echo $eqrow['link1']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> Profile1</a> 
			   <a  class="btn btn-info" target="_blank" href="<?php echo $eqrow['link2']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> Profile2</a> 
			   
			   </td>
			</tr>
		<?php
		}  
		?>

</tbody>
</table>