
<!doctype html>
<html lang="en">

<head>

  <title>Earning Information | e-Learning & Earning Ltd.</title>

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
  // Prepare and execute statement to select image paths from the database
  $stmt_select = $DB_con->prepare('SELECT incomePics FROM income_info WHERE in_id = :uid');
  $stmt_select->execute(array(':uid' => $_GET['delete_id']));
  $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);

  // Check if the 'incomePics' column contains any data
  if ($imgRow && isset($imgRow['incomePics'])) {
    // Convert the fetched string of image paths into an array
    $images = explode(',', $imgRow['incomePics']);

    // Loop through each image path and delete the file from the server if it exists
    foreach ($images as $image) {
      if (file_exists($image)) {
        unlink($image); // Delete the file
      }
    }
  }

  // it will delete an actual record from db
  $stmt_delete = $DB_con->prepare('DELETE FROM income_info WHERE in_id  =:uid');
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


    <!-- ======= About Us Section ======= -->



        <div class="row content">


           <div class="col-lg-12 mt-3" data-aos="fade-left">
            <div class="shadow rounded p-2">
              
               <?php  include('report-by-category-old.php'); ?>
            </div>
          </div>
              <h3 class="text-center mt-4">
                <?php
                $DistId = $_REQUEST['DistId'];
                $Batch = $_REQUEST['Batch'];
                $Group = $_REQUEST['Group'] ?? null;

                $pq = mysqli_query($con, "SELECT * FROM district where id = '$DistId' ");
                while ($pqrow = mysqli_fetch_array($pq)) {
                  echo $pqrow['dist_name'] . 'District';
                } ?>




              <?php
              $DistId = $_REQUEST['DistId'];
              $Batch = $_REQUEST['Batch'];
              $Group = $_REQUEST['Group'] ?? null;

              $pq = mysqli_query($con, "SELECT * FROM district where id = '$DistId' ");
              while ($pqrow = mysqli_fetch_array($pq)) {
                echo 'District : ' . $pqrow['dist_name'];
              }

              echo ' | Student List : ';

              $Batch = $_REQUEST['Batch'];
              $Group = $_REQUEST['Group'];

              $pq = mysqli_query($con, "SELECT * FROM batch_list where batch_id = '$Batch' ");
              while ($batchRow = mysqli_fetch_array($pq)) {
                echo $batchRow['batch_name'];
              }

              if (!empty($Group)) {
                $pq = mysqli_query($con, "SELECT * FROM group_list where group_id = '$Group' ");
                while ($groupRow = mysqli_fetch_array($pq)) {
                  echo ' | '  . $groupRow['group_name'];
                }
              } else {

                echo " | Group A & B";
              }
              ?>
            </h3>
          </div>

          <div class="col-lg-12 mt-1" data-aos="fade-left">
            <div class="shadow p-3 rounded">
              <?php include('student-list-dist.php'); ?>
            </div>
          </div>




    </section>





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
    });
  </script>


</body>

</html>