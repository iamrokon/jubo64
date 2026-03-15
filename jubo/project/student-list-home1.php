  <style>
    .table td,
    .table th {
      vertical-align: middle !important;
    }

    .table thead tr>th {
      padding: 12px 8px !important; 
    }

    .table tbody tr>td {
      padding: 8px 8px !important;
    }
  </style>

  <table width="100%" class="table table-hover table-striped m-0" student_id="dataTables-example">
    <thead class="bg-dark text-white">

      <tr>

        <th>SL</th>
     <!--   <th>Group</th>-->
        <th>Name</th>
     <!--    <th>Father</th>  -->
        <th>Marketplace</th>
        <th>Earning Amount</th>

        <th>Photo</th>
        <!-- <th>CV </th> -->
        <th><center>  Action </center></th>
        <!-- <th>Income</th> -->
        <!-- <th colspan="3">Profile</th> -->

      </tr>
    </thead>
    <tbody id="tbody">
      <?php
      $sl = 0;
      $DistId = '2';
      $Batch = '1';
      $Group = '1';

      if (!empty($Group)) {
        $query = "SELECT * FROM student_list 
              LEFT JOIN district ON district.id = student_list.district 
              LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
              LEFT JOIN group_list ON group_list.group_id = student_list.group_id
              WHERE student_list.district = '$DistId' AND student_list.batch_id = '$Batch' AND student_list.group_id = '$Group' 
              ORDER BY student_list.student_id ASC LIMIT 100";
      } else {
        $query = "SELECT * FROM student_list 
              LEFT JOIN district ON district.id = student_list.district 
              LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
              LEFT JOIN group_list ON group_list.group_id = student_list.group_id
              WHERE student_list.district = '$DistId' AND student_list.batch_id = '$Batch'
              ORDER BY student_list.student_id ASC LIMIT 100";
      }

      $eq = mysqli_query($con, $query);

      // Check if any records are found
      if (mysqli_num_rows($eq) > 0) {
        while ($eqrow = mysqli_fetch_array($eq)) {
          $StudentId = $eqrow['student_id'];
          $incomeQuery = mysqli_query($con, "SELECT * FROM income_info 
      LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
      WHERE student_id = $StudentId ORDER BY in_id DESC");
          $incomeRow = mysqli_fetch_array($incomeQuery);
      ?>
          <tr>
            <td><?php echo ++$sl; ?></td>
           <!--  <td><?php echo $eqrow['group_name']; ?></td> -->
            <td><?php echo $eqrow['stu_name']; ?></td>
           <!--  <td><?php echo $eqrow['father_name']; ?></td> -->
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
            <td><img src="../dist/user_images/<?php echo $eqrow['userPic']; ?>" class="img-rounded" height="30px;" width="30px;" /></td>
            <td>
			<center>
			<a class="btn btn-primary btn-sm px-3" target="_blank" href="student-cv?view=<?= $eqrow['student_id'] ?>"> <strong><i class="fa fa-file"></i> CV  </strong></a>
			<a class="btn btn-success btn-sm px-3" target="_blank" href="student-income?income_id=<?= $StudentId ?>"> <strong><i class="fa fa-user-tie"></i> Earning Profile  </strong></a>
			</center>
			</td>
          </tr>
        <?php
        }
      } else {
        ?>
        <tr>
          <td colspan="12" class="text-center py-2">No records found.!</td>
        </tr>
      <?php
      }
      ?>
    </tbody>
 
  </table>