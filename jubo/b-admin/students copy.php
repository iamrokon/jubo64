<!doctype html>
<html lang="en">

<head>

  <title>Students | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

  <style>
    .dataTables_wrapper .row:nth-child(2) {
      overflow-x: scroll;
    }

    .dataTables_wrapper .row:nth-child(2) table {
      width: 1560px !important;
    }
  </style>

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
                    <li class="breadcrumb-item active">All Students</li>
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
                  <div class="card-header border-bottom py-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <h4 class="card-title m-0">All Student Lists</h4>
                      <a href="student-add" class="btn btn-success waves-effect"><i class="fa fa-plus me-2"></i>Add New Student</a>
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">

                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Father Name</th>
                          <th>Batch</th>
                          <th>Group </th>
                          <th>Upwork </th>
                          <th>Fiverr </th>
                          <th>Freelancer.com </th>
                          <th>Photo</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $query = "SELECT student_list.*, batch_list.batch_name, group_list.group_name
                                  FROM student_list
                                  LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                                  LEFT JOIN group_list ON group_list.group_id = student_list.group_id
                                  WHERE student_list.user_id = " . $_SESSION['id'];

                        $result = $con->query($query);

                        $sl = 1;
                        while ($row = $result->fetch_assoc()) {
                        ?>

                          <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= $row['stu_name']; ?></td>
                            <td><?= $row['father_name']; ?></td>
                            <td><?= $row['batch_name']; ?></td>
                            <td><?= $row['group_name']; ?></td>
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

                            <td>
                              <?php
                              if ($row['link_three'] && $row['link_three'] !== 'none') {
                                echo "<a traget='_blank' href='" . $row['link_three'] . "'>Freelancer.com Linked<a>";
                              } else {
                                echo '-';
                              }
                              ?>
                            </td>


                            <td>
                              <?php
                              if ($row['userPic'] == null) {
                                echo '<img src="website/user.png" class="img-fluid img-thumbnail rounded-circle" style="width:40px; height: 40px;" />';
                              } else {
                                echo '<img src="user_images/' . $row["userPic"] . '" class="img-fluid img-thumbnail rounded-circle" style="width:40px; height: 40px;" />';
                              }
                              ?>
                            </td>

                            <td width="10%">
                              <a class="btn btn-success waves-effect" href="student-edit?edit_id=<?= $row['student_id']; ?>" title="click for edit"><i class="fa fa-edit"></i></a>
                              <a class="btn btn-primary waves-effect" href="student-view?view_id=<?= $row['student_id']; ?>" title="Click To View"><i class="fa fa-eye"></i></a>
                              <a class="btn btn-danger waves-effect" href="?delete_id=<?= $row['student_id']; ?>" title="click for delete" onclick="return confirm('Are You Sure....?')"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>

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


  <script>
    $('#datatable').dataTable({
      "lengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      // "lengthMenu": [20, 50, 100],
      // "pageLength": 50,
      //"lengthChange": false,
      //"searching": false,
    });
  </script>

</body>

</html>