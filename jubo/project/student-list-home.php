<table width="100%" class="table table-hover table-striped m-0" student_id="dataTables-example">
  <thead class="bg-dark text-white">

    <tr>
      <th>SL</th>
      <th>Name</th>
      <th>Father</th>
      <th>Marketplace</th>
      <th>Earning Amount</th>

      <th>Photo</th>
      <th>Action </th>

    </tr>
  </thead>
  <tbody id="tbody">
    <?php
    $sl = 0;
    $eq = mysqli_query($con, "SELECT * from student_list  
    left join district on district.id=student_list.district 							   
    left join group_list on group_list.group_id=student_list.group_id
    where student_list.status=2 and  student_list.batch_id=4

    ORDER BY student_list.student_id asc limit 20");

    while ($eqrow = mysqli_fetch_array($eq)) {
      $StudentId = $eqrow['student_id'];
      $incomeQuery = mysqli_query($con, "SELECT * FROM income_info 
        LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
        WHERE income_info.student_id = $StudentId and income_info.earning_dollar !=0 ");
      $incomeRowCount = mysqli_num_rows($incomeQuery);
      $incomeRow = mysqli_fetch_array($incomeQuery);
    ?>
      <tr>

        <td><?php echo ++$sl; ?></td>
        <td><?php echo $eqrow['stu_name']; ?></td>
        <td><?php echo $eqrow['father_name']; ?></td>
        <td><?php echo $incomeRow['work_name'] ?? '-' ?></td>

        <td>
          <?php
          if ($incomeRow['earning_bd']) {
            echo '৳' . number_format($incomeRow['earning_bd'], 2);
          } else if ($incomeRow['earning_dollar']) {
            echo '$' . number_format($incomeRow['earning_dollar'], 2);
          } else {
            echo '-';
          }
          ?>
        </td>

        <td> <img src="../dist/user_images/<?php echo $eqrow['userPic']; ?>" class="img-rounded" height="30px;" width="30px;" /></td>
        <td>
		<a class="btn btn-primary btn-sm px-3" target="_blank" href="student-cv?view=<?= $eqrow['student_id'] ?>">CV</a>
		<a class="btn btn-info btn-sm px-3" target="_blank" href="student-income?income_id=<?= $StudentId ?>">View</a>
		</td>

      </tr>
    <?php
    }
    ?>



  </tbody>
</table>