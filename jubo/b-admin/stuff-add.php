<!doctype html>
<html lang="en">

<head>

  <title>Add New Stuff | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

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
                    <li class="breadcrumb-item active">Add New Stuff</li>
                  </ol>
                </div>

                <div class="state-information d-none d-sm-block">
                  <div class="state-graph">
                    <div id="header-chart-1" data-colors='["--bs-primary"]'></div>
                    <div class="info">Balance $ 2,317</div>
                  </div>
                  <div class="state-graph">
                    <div id="header-chart-2" data-colors='["--bs-danger"]'></div>
                    <div class="info">Item Sold 1230</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->


          <?php

          error_reporting(~E_NOTICE); // avoid notice

          if (isset($_POST['btnsave'])) {
            $user_id = $_POST['user_id'];

            $Name = $_POST['Name'];
            $Type = $_POST['Type'];
            $Phone = $_POST['Phone'];
            $Email = $_POST['Email'];
            $JoiningDate = $_POST['JoiningDate'];
            $PAddress = $_POST['PAddress'];
            $Desi = $_POST['Desi'];
            $ShortDes = $_POST['ShortDes'];
            $Earning = $_POST['Earning'];
            $About = $_POST['About'];
            $Link1 = $_POST['Link1'];
            $Link2 = $_POST['Link2'];
            $Link3 = $_POST['Link3'];

            $imgFile = $_FILES['user_image']['name'];
            $tmp_dir = $_FILES['user_image']['tmp_name'];
            $imgSize = $_FILES['user_image']['size'];


            if (empty($Name)) {
              $errMSG = "Please Enter  Name.";
            } else {
              $upload_dir = 'trainer_images/'; // upload directory

              $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

              // valid image extensions
              $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp', 'svg'); // valid extensions

              // rename uploading image
              //$userpic = rand(1000,1000000).".".$imgExt;
              $userpic = "ela-trainer-" . $imgFile;

              // allow valid image file formats
              if (in_array($imgExt, $valid_extensions)) {
                // Check file size '5MB'
                if ($imgSize < 5000000) {
                  move_uploaded_file($tmp_dir, $upload_dir . $userpic);
                } else {
                  $errMSG = "Sorry, your file is too large.";
                }
              }
              //else{
              //	$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
              //}
            }


            // if no error occured, continue ....
            if (!isset($errMSG)) {
              $stmt = $DB_con->prepare('INSERT INTO trainer (user_id,name,type,phone,email,joining_date,p_address,designation,short_des,earn_market,about_trainer,link1,link2,link3,userPic,entry_date) 
															VALUES(:user_id,:Name,:Type,:Phone,:Email,:JoiningDate,:PAddress,:Desi,:ShortDes,:Earning,:About,:Link1,:Link2,:Link3,:upic,NOW() )');

              $stmt->bindParam(':user_id', $user_id);

              $stmt->bindParam(':Name', $Name);
              $stmt->bindParam(':Type', $Type);
              $stmt->bindParam(':Phone', $Phone);
              $stmt->bindParam(':Email', $Email);
              $stmt->bindParam(':JoiningDate', $JoiningDate);
              $stmt->bindParam(':PAddress', $PAddress);
              $stmt->bindParam(':Desi', $Desi);
              $stmt->bindParam(':ShortDes', $ShortDes);
              $stmt->bindParam(':Earning', $Earning);
              $stmt->bindParam(':About', $About);
              $stmt->bindParam(':Link1', $Link1);
              $stmt->bindParam(':Link2', $Link2);
              $stmt->bindParam(':Link3', $Link3);

              $stmt->bindParam(':upic', $userpic);

              if ($stmt->execute()) {
          ?>
                <script>
                  alert('Data Successfully Add ...');
                  window.location.href = 'stuff-add';
                </script>
          <?php
              } else {
                $errMSG = "error while inserting....";
              }
            }
          }
          ?>

          <!-- Start Page-content-Wrapper -->
          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Add New Stuff</h4>
                  </div>
                  <div class="card-body">

                    <?php
                    if (isset($errMSG)) {
                      echo '<div class="alert alert-danger">' . $errMSG . '</div>';
                    } else if (isset($successMSG)) {
                      echo '<div class="alert alert-success">' . $successMSG . '</div>';
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data">

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <?php
                          $pq = mysqli_query($con, "select * from user where userid='" . $_SESSION['id'] . "' ");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
                            <input class="form-control" type="hidden" name="user_id" value="<?php echo $pqrow['userid']; ?>" />
                          <?php } ?>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="Name" placeholder="Name" />
                          </div>
                        </div>

                      <div class="col-md-6 mb-3">
                      <div class="form-group">
                        <label class="control-label">Phone</label>
                        <input class="form-control" type="text" name="Phone" id="phone" placeholder="Enter Your Phone" />
                        <small id="phone-error" class="text-danger d-none">Please enter a valid 11-digit phone number.</small>
                      </div>
                    </div>

                    <script>
                      document.getElementById('phone').addEventListener('input', function () {
                        const phoneInput = this.value;
                        const errorMsg = document.getElementById('phone-error');

                        // Remove non-digit characters
                        const cleaned = phoneInput.replace(/\D/g, '');
                        this.value = cleaned;

                        // Validation check
                        if (cleaned.length !== 11) {
                          errorMsg.classList.remove('d-none');
                        } else {
                          errorMsg.classList.add('d-none');
                        }
                      });
                    </script>

                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="Email" placeholder="Enter Your Email" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Designation</label>
                            <input class="form-control" type="text" name="Desi" placeholder="Designation" />
                          </div>
                        </div>
                      </div>
  <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <textarea cols="10" rows="2" class="form-control" name="PAddress" placeholder="Permanent Address"></textarea>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Joining Date</label>
                            <input class="form-control" type="date" name="JoiningDate" placeholder="Joining Date" />
                          </div>
                        </div>
                      </div>




                      <div class="row d-none">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Short Description</label>
                            <textarea cols="10" rows="3" class="form-control" name="ShortDes" placeholder="Short Description" value="None"></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3 d-none">
                          <div class="form-group">
                            <label class="control-label">Earning / Marketplace</label>
                            <textarea cols="10" rows="3" class="form-control" name="Earning" placeholder="Earning / Marketplace" value="None"></textarea>
                          </div>
                        </div>
                      </div>

                      <!-- <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <textarea cols="10" rows="2" class="form-control" name="PAddress" placeholder="Permanent Address"></textarea>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Joining Date</label>
                            <input class="form-control" type="date" name="JoiningDate" placeholder="Joining Date" />
                          </div>
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">About Stuff</label>
                            <textarea cols="10" rows="4" class="form-control" name="About" placeholder="About Stuff"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row d-none">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 01</label>
                            <input class="form-control" type="text" name="Link1" placeholder="Freelancing Link 01" value="None" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 02</label>
                            <input class="form-control" type="text" name="Link2" placeholder="Freelancing Link 02" value="None" />
                          </div>
                        </div>
                      </div>

                      <div class="row d-none">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 03</label>
                            <input class="form-control" type="text" name="Link3" placeholder="Freelancing Link 03" value="None" />
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select Photo</label>
                            <input type="file" name="user_image" id="user_image" accept="image/*" onchange="previewImage(event)" />
                            <p class="text-danger m-0">Please Upload Your Passport Size (300px X 320px) Image Here.</p>
                            <img id="image_preview" src="#" alt="Image Preview" style="display:none; margin-top: 10px; width: 150px; height: auto; border: 1px solid #ccc; padding: 5px;" />
                          </div>
                        </div>
                      </div>

                      <script>
                        function previewImage(event) {
                          const input = event.target;
                          const preview = document.getElementById('image_preview');

                          if (input.files && input.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                              preview.src = e.target.result;
                              preview.style.display = 'block';
                            }

                            reader.readAsDataURL(input.files[0]);
                          } else {
                            preview.src = '#';
                            preview.style.display = 'none';
                          }
                        }
                      </script>


                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <!-- <label class="control-label">Type</label> -->
                            <input class="form-control" type="hidden" name="Type" placeholder="" value="stuff" />
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-12 text-center">
                          <div class="form-group">
                            <a href="stuff" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                            <button type="submit" name="btnsave" class="btn btn-success waves-effect"><i class="fa fa-save me-2"></i>Add Now</button>
                          </div>
                        </div>
                      </div>

                    </form>



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