<!doctype html>
<html lang="en">

<head>

  <title>Earning Report | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>


<?php

if (isset($_GET['delete_id'])) {
  // select image from db to delete
  $stmt_select = $DB_con->prepare('SELECT userPic FROM student_list WHERE student_id =:uid');
  $stmt_select->execute(array(':uid' => $_GET['delete_id']));
  $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
  unlink("user_images/" . $imgRow['userPic']);

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM student_list WHERE student_id =:uid');
  $stmt_delete->bindParam(':uid', $_GET['delete_id']);
  $stmt_delete->execute();
}

?>

<body data-topbar="colored">

  <!-- <body data-layout="horizontal" data-topbar="colored"> -->

  <!-- Begin page -->
  <div id="layout-wrapper">

    <!-- ========== Header Start ========== -->
    <?php include "header.php" ?>
    <!-- ========== Header End ========== -->

    <!-- ========== Left Sidebar Start ========== -->
    <?php include "sidebar.php" ?>
    <!-- ========== Left Sidebar End ========== -->


    <!-- ========== Main Content Start ========== -->
    <div class="main-content">

      <div class="page-content">
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Dashboard</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All Trainers</li>
                  </ol>
                </div>

                <div class="state-information d-none d-sm-block">
                  <div class="state-graph">
                    <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                  </div>
                  <div class="state-graph">
                    <div id="header-chart-2" data-colors='["--bs-danger"]'></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->

          <!-- Start Page-content-Wrapper -->
          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">  
                  <div class="card-header border-bottom pt-5 pb-3 text-center">
                    <h3>
                      <?php
                      if (isset($_GET['dist_id']) || isset($_GET['batch_id']) || isset($_GET['group_id'])) {
                        $DistId = $_GET['dist_id'];
                        $Batch = $_GET['batch_id'];
                        $Group = $_GET['group_id'] ?? null;

                        $pq = mysqli_query($con, "SELECT * FROM district  where id = '$DistId' ");
                        while ($pqrow = mysqli_fetch_array($pq)) {
                      ?>
                          <b> <?= $pqrow['dist_name']; ?> District</b>
                        <?php } ?>
                    </h3>

                    <h3> Course Student List </h3>

                    <h3 class="m-0"> Student List :
                      <?php
                        $pq = mysqli_query($con, "SELECT * FROM batch_list  where batch_id = '$Batch' ");
                        while ($pqrow = mysqli_fetch_array($pq))
                          echo $pqrow['batch_name'];
                      ?>

                    <?php
                        if ($Group) {
                          $pq = mysqli_query($con, "SELECT * FROM group_list  where group_id = '$Group' ");
                          while ($pqrow = mysqli_fetch_array($pq))
                            echo '| ' . $pqrow['group_name'];
                        } else {
                          echo '| ' . 'Group A & B';
                        }
                      }

                    ?>
                    </h3>

                  </div>
                  <hr class="m-0">
                  <div class="card-body">

                  <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>

                        <tr>

                          <th>SL</th>
                          <th>Name</th>
                          <th>Father</th>
                          <th>Upwork</th>
                          <th>Fiver</th>
                          <th>Contact Number</th>
                          <th>Gender</th>
                          <th>Photo</th>
                          <th>Action</th>

                        </tr>
                      </thead>

                      <tbody>

                        <?php
                        if ($_GET['dist_id'] == $_SESSION['id']) {

                          $sl = 0;

                          if (isset($_GET['dist_id']) || isset($_GET['batch_id']) || isset($_GET['group_id'])) {

                            $distId = $_GET['dist_id'];
                            $batch = $_GET['batch_id'];
                            $group = $_GET['group_id'] ?? null;

                            if ($distId && $batch && $group) {
                              $sql = mysqli_query($con, "SELECT student_list.student_id, student_list.stu_name, student_list.father_name,student_list.contact,student_list.gender,student_list.userPic, student_list.upwork, student_list.fiver FROM student_list 
                             
                              WHERE student_list.district = '$distId' AND student_list.batch_id= '$batch' AND student_list.group_id= '$group' ORDER BY student_list.student_id ASC");


                            } elseif ($distId && $batch) {
                              $sql = mysqli_query($con, "SELECT student_list.student_id, student_list.stu_name, student_list.father_name,student_list.contact,student_list.gender,student_list.userPic, student_list.upwork, student_list.fiver FROM student_list 
                            
                               WHERE student_list.district = '$distId' AND student_list.batch_id= '$batch' ORDER BY student_list.student_id ASC");
                            }
                            if (mysqli_num_rows($sql) > 0) {
                              while ($row = mysqli_fetch_array($sql)) {

                        ?>
                                <tr>
                                  <td><?= ++$sl; ?></td>
                                  <td><?= $row['stu_name']; ?></td>
                                  <td><?= $row['father_name']; ?></td> 
                                  <td>
                              <?php
                              if ($row['upwork'] && $row['upwork'] !== 'none') {
                                echo "<a traget='_blank' href='" . $row['upwork'] . "'>Upwork Linked<a>";
                              } else {
                                echo '-';
                              }
                              ?>
                            </td>
                                 <td>
                              <?php
                              if ($row['fiver'] && $row['fiver'] !== 'none') {
                                echo "<a traget='_blank' href='" . $row['fiver'] . "'>Fiverr Linked<a>";
                              } else {
                                echo '-';
                              }
                              ?>
                            </td>
                            </td>
                                  <td><?= $row['contact']; ?></td>
                                  <td><?= $row['gender']; ?></td>
                                  <td> <img src="user_images/<?= $row['userPic']; ?>" class="img-fluid img-thumbnail rounded-circle" style="width:40px; height: 40px;" /></td>
                                   <!-- <td><a href="earning-add-with-student?add_id=<?= $row['student_id']; ?>" target="_blank" class="btn btn-success"><i class="fas fa-money-bill-alt me-2"></i>Add Income</a></td> -->
                                    <td width="10%">
                              <a class="btn btn-success waves-effect" href="student-edit?edit_id=<?= $row['student_id']; ?>" title="click for edit"><i class="fa fa-edit"></i></a>
                              <a class="btn btn-primary waves-effect" href="student-view?view_id=<?= $row['student_id']; ?>" title="Click To View"><i class="fa fa-eye"></i></a>
                              <a class="btn btn-danger waves-effect" href="?delete_id=<?= $row['student_id']; ?>" title="click for delete" onclick="return confirm('Are You Sure....?')"><i class="fa fa-trash"></i></a>
                            </td>
                                </tr>
                          <?php
                              }
                            } else {
                              echo "<tr><td colspan='12' class='text-center text-danger'>Not Record Founds!</td></tr>";
                            }
                          }
                        } else { ?>

                          <script>
                            alert("You are not authorized to access this page")
                            window.location.href = "earning-information";
                          </script>


                        <?php
                        }

                        ?>


                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- End Page-content -->

        </div>
      </div>


      <!-- ========== Footer Start ========== -->
      <?php include "footer.php" ?>
      <!-- ========== Footer End ========== -->
    </div>
    <!-- ========== Main Content End ========== -->

  </div>
  <!-- END layout-wrapper -->



  <?php include "script.php" ?>
</body>

</html>