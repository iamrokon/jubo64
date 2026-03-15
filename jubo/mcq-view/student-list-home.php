 
 
<table width="100%" class="table table-hover text-center" student_id="dataTables-example">
                        <thead>
                            
                            <tr>
								 
                                <th>SL</th> 
                                <th>Session</th>
                                <th>Batch</th> 
                                <th>Name</th>  
								<th>Father</th>
								<th>Mother</th> 
								
                                <th>Photo</th> 
                                <th>CV </th> 
                                <th colspan="3">Profile</th>
								
                            </tr>
                        </thead>
                       <tbody id="tbody">
							<?php
							$sl=0;
								$eq=mysqli_query($con,"select * from student_list 
                               left join district on district.id=student_list.district 
								where student_list.status=2
								ORDER BY student_list.student_id ASC limit 20 ");
								while($eqrow=mysqli_fetch_array($eq)){ 
									?>
										<tr>
											 
											<td><?php echo ++$sl; ?></td>
											 
											<td><?php echo $eqrow['session']; ?></td>
											<td><?php echo $eqrow['batch']; ?></td>
											
											<td><?php echo $eqrow['stu_name']; ?></td>  
											<td><?php echo $eqrow['father_name']; ?></td>
											<td><?php echo $eqrow['father_name']; ?></td> 
											 											
										 <td> <img src="../dist/user_images/<?php echo $eqrow['userPic']; ?>" class="img-rounded" height="30px;" width="30px;" /></td>
			 <td><a  class="btn btn-primary" href="student-cv.php?edit_id=<?php echo $eqrow['student_id']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> CV</a> </td>
			
			<td> 		 
			<span style="display:<?php echo $eqrow['upwork']; ?>;"> <a  class="btn btn-success" target="_blank" href="<?php echo $eqrow['upwork']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> Upwork</a></span>
			</td>
           
		    <td>
			<span style="display:<?php echo $eqrow['fiver']; ?>;"> <a  class="btn btn-dark" target="_blank" href="<?php echo $eqrow['fiver']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> Fiver</a></span>
			</td>
			
            <td>
			<span style="display:<?php echo $eqrow['link_three']; ?>;"> <a  class="btn btn-info" target="_blank" href="<?php echo $eqrow['link_three']; ?>" title="Click To View" ><span class="glyphicon glyphicon-user"></span> Other</a></span>
			</td>
			</tr>
		<?php
		}  
		?>
		
	 

</tbody>
</table>