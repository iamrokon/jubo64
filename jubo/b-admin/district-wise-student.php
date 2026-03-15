<!doctype html>
<html lang="en">

<head>

  <title>district wise student | e-Learning & Earning Ltd.</title>

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



                   <table id="datatable" class="table table-bordered table-hover table-striped align-middle">

                      <thead>
                        <tr>
                          <th>#</th>
                          <th>District Name</th>
                         <th>Total Student</th>
                        </tr>
                      </thead>
                     <tbody>
                    <?php
                    $query = "SELECT d.dist_name, COUNT(s.student_id) AS total_students
                              FROM district d
                              LEFT JOIN student_list s 
                                ON d.id = s.district
                              GROUP BY d.id, d.dist_name";

                    $result = $con->query($query);

                    $sl = 1;
                    while ($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?= $sl++ ?></td>
                        <td><?= $row['dist_name'] ?></td>
                        <td><?= $row['total_students'] ?></td>
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