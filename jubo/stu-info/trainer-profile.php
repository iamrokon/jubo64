<!doctype html>
<html lang="en">

<head>

    <title>Trainer Profile | e-Learning & Earning Ltd.</title>

    <?php include "header-link.php" ?>

</head>

<?php



if (isset($_GET['view_id'])) {
    $id = $_GET['view_id'];
    $stmt = $con->prepare("SELECT * FROM trainer WHERE id=? AND type='trainer'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<h4>Trainer Not Found!</h4>";
        exit;
    }
} else {
    echo "<h4>Invalid Request!</h4>";
    exit;
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
                                        <li class="breadcrumb-item active">Trainer Profile</li>
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
                    <div class="page-content-wrapper" style="min-height: 60vh;">
                       
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
                            <div class="col-md-7 col-12">
                                <div class="card shadow">
                                   
                                    <div class="card-body">
                                        
                                        <div class="row align-items-center" style="border-bottom: 2px dotted #ccc;">
                                            <!-- Left Side: Photo, Name, Designation -->
                                            <div class="col-md-4 text-center mb-3">
                                              
                                                <img src="trainer_images/<?= $row['userPic'] ?>" alt="<?= $row['name'] ?>" class="img-thumbnail rounded-circle mb-3" style="width: 120px; height: 120px;">
                                                <h4 class="mb-1"><?= htmlspecialchars($row['name']) ?></h4>
                                                <p class="text-muted mb-0"><?= htmlspecialchars($row['designation']) ?></p>
                                            </div>

                                            <!-- Right Side: Details -->
                                            <div class="col-md-8" style="border-left: 2px dotted #ccc;">
                                                    <h3 class="" style="border-bottom: 2px dotted #ccc; padding-bottom: 5px;">Trainer Information</h3>
                                                <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
                                                <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                                                <p><strong>Permanent Address:</strong> <?= htmlspecialchars($row['p_address']) ?></p>
                                                <p><strong>Freelancing Link-1:</strong> <?= htmlspecialchars($row['link1']) ?></p>
                                                <p><strong>Freelancing Link-2:</strong> <?= htmlspecialchars($row['link2']) ?></p>
                                                <p><strong>Freelancing Link-3:</strong> <?= htmlspecialchars($row['link3']) ?></p>
                                              
                                            </div>
                                          
                                        </div>
                                          <div class="col-md-8 px-5 mt-3">
                                                  <p><strong>About:</strong> <?= nl2br(htmlspecialchars($row['about_trainer'])) ?></p>
                                                  <p><strong>Short Description:</strong> <?= nl2br(htmlspecialchars($row['short_des'])) ?></p>
                                            </div>
                                        <div class="text-end mt-4">
                                            <a href="trainers" class="btn btn-primary">
                                                <i class="fa fa-arrow-left me-1"></i> Back to List
                                            </a>
                                        </div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div> <!-- end col-md-8 -->
                        </div> <!-- end center-wrapper -->
                    </div> <!-- end page-content-wrapper -->


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