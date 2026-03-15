<div class="container-fluid">
  <table width="100%" class="table m-0 table-bordered" student_id="dataTables-example">
    <thead class="bg-light ">

      <tr>
        <th>SL</th>
        <th>Id No</th>
        <th>Name</th>
        <th>Address</th>
        <th>Contact Info</th>
        <th>Marketplace</th>
        <th>Earning Amount</th>
        <th>Photo</th>
      </tr>
    </thead>
    <tbody id="tbody">
      <?php
      $sl = 0;

      $BatchID = isset($_GET['batch_id']) ? $_GET['batch_id'] : null;
      $GroupID = isset($_GET['group_id']) ? $_GET['group_id'] : null;


      if ($BatchID && $GroupID) {
        $query = "SELECT distinct * FROM income_info 
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
        LEFT JOIN district ON district.id = student_list.district 
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
        WHERE income_info.status  !=1 and  income_info.earning_dollar >=1
        
         ";
      } else if ($BatchID) {
        $query = "SELECT distinct * FROM income_info 
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
        LEFT JOIN district ON district.id = student_list.district 
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
        WHERE income_info.status !=1  and  income_info.earning_dollar >=1
        
         ";
      } else {
        $query = "SELECT distinct * FROM income_info 
        LEFT JOIN student_list ON student_list.student_id = income_info.student_id 
        LEFT JOIN district ON district.id = student_list.district 
        LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
        LEFT JOIN group_list ON group_list.group_id = student_list.group_id   
        WHERE income_info.status !=1     and  income_info.earning_dollar >=1
          ";
      }






      $eq = mysqli_query($con, $query);

      // Check if any records are found
      if (mysqli_num_rows($eq) > 0) {
        while ($eqrow = mysqli_fetch_array($eq)) {
          $StudentId = $eqrow['student_id'];
          $incomeQuery = mysqli_query($con, "SELECT * FROM income_info 
          LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
          WHERE income_info.student_id = $StudentId and  income_info.earning_dollar >=1
          
           ");
          $incomeRow = mysqli_fetch_array($incomeQuery);
      ?>
          <tr>
            <td><?php echo ++$sl; ?></td>
            <td><?php echo $eqrow['student_id']; ?></td>
            <td>
              <b> <?php echo $eqrow['stu_name']; ?> </b><br>
              <b> NID No : </b> <?php echo $eqrow['nid_no']; ?> <br>
              <b>District : </b> <?php echo $eqrow['dist_name']; ?><br>
              <b>Batch : </b><?php echo $eqrow['batch_name']; ?>
            </td>
            <td><?php echo $eqrow['address']; ?></td>
            <td>
              <b>Phone :</b> <?php echo $eqrow['contact']; ?> <br>
              <b>Email : </b> <?php echo $eqrow['email']; ?>
            </td>


            <td>

              <?php // echo $incomeRow['work_name'] ?? '-' 
              ?>

              <?php
              if ($eqrow['upwork'] !== 'none') { ?>
                <p class="mb-1 text-dark"> Upwork : <a target="_blank" href="<?php echo $eqrow['upwork']; ?>"><?php echo $eqrow['upwork']; ?></a></p>
              <?php }
              ?>

              <?php
              if ($eqrow['fiver'] !== 'none') { ?>
                <p class="mb-1 text-dark">Fiver : <a class="text-primary" target="_blank" href="<?php echo $eqrow['fiver']; ?>"><?php echo $eqrow['fiver']; ?></a></p>
              <?php }
              ?>

              <?php
              if ($eqrow['link_three'] !== 'none') { ?>
                <p class="mb-1 text-dark"> Other : <a class="text-primary" target="_blank" href="<?php echo $eqrow['link_three']; ?>"><?php echo $eqrow['link_three']; ?></a></p>
              <?php }
              ?>
            </td>



            <td>
              $ <?php echo $eqrow['earning_dollar']; ?>

              <?php
              /*
              if ($incomeRow['earning_bd']) {
                echo '৳' . number_format($incomeRow['earning_bd'], 2);
              } else if ($incomeRow['earning_dollar']) {
                echo '$' . number_format($incomeRow['earning_dollar'], 2);
              } else {
                echo '-';
              }
              */
              ?>
            </td>
            <td><img src="../dist/user_images/<?php echo $eqrow['userPic']; ?>" class="img-rounded" height="120px;" width="120px;" /></td>

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
</div>