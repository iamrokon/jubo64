<!doctype html>
<html lang="en">

<head>

  <title>Edit Trainer Info | e-Learning & Earning Ltd.</title>

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
                    <li class="breadcrumb-item active">Edit Trainer Information</li>
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


          <?php
          error_reporting(~E_NOTICE);
          if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $stmt_edit = $DB_con->prepare('SELECT * FROM trainer WHERE id =:uid');
            $stmt_edit->execute(array(':uid' => $id));
            $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
            extract($edit_row);
          } else {
            header("Location: index.php");
          }

          if (isset($_POST['btn_save_updates'])) {

            $Name = $_POST['Name'];
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

            if ($imgFile) {
              $upload_dir = 'trainer_images/'; // upload directory	
              $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
              $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp', 'svg'); // valid extensions
              $userpic = rand(1000, 1000000) . "." . $imgExt;
              if (in_array($imgExt, $valid_extensions)) {
                if ($imgSize < 5000000) {
                  //unlink($upload_dir.$edit_row['userPic']);
                  move_uploaded_file($tmp_dir, $upload_dir . $userpic);
                } else {
                  $errMSG = "Sorry, your file is too large it should be less then 5MB";
                }
              } else {
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              }
            } else {
              // if no image selected the old image remain as it is.
              $userpic = $edit_row['userPic']; // old image from database
            }


            // if no error occured, continue ....
            if (!isset($errMSG)) {
              $stmt = $DB_con->prepare('UPDATE trainer 
									     SET name =:Name,
                           email =:Email,
                           phone =:Phone,
                           p_address =:PAddress,
                           joining_date =:JoiningDate,
									         designation =:Desi, 
									         short_des =:ShortDes, 
									         earn_market =:Earning, 
									         about_trainer =:About,  
									         link1 =:Link1,  
									         link2 =:Link2,  
									         link3 =:Link3,  
										     userPic=:upic 
											 
								       WHERE id=:uid');



             $stmt->bindParam(':Name', $Name);
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
              $stmt->bindParam(':uid', $id);

              if ($stmt->execute()) {
          ?>
                <script>
                  alert('Successfully Updated ...');
                   window.location.href = 'trainer';
                </script>
          <?php
              } else {
                $errMSG = "Sorry Data Could Not Updated !";
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
                    <h4 class="card-title m-0">Edit Trainer Information</h4>
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
                          <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control" type="text" name="Name" placeholder="Name" value="<?php echo $name; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Phone</label>
                            <input class="form-control" type="text" name="Phone" id="phone" placeholder="Enter Your Phone" value="<?php echo $phone; ?>" />
                            <small id="phone-error" class="text-danger d-none">Please enter a valid 11-digit phone number.</small>
                          </div>
                        </div>

                        <script>
                          document.getElementById('phone').addEventListener('input', function() {
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
                            <input class="form-control" type="email" name="Email" placeholder="Enter Your Email" value="<?php echo $email; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Designation</label>
                            <input class="form-control" type="text" name="Desi" placeholder="Designation" value="<?php echo $designation; ?>" />
                          </div>
                        </div>
                      </div>




                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <textarea cols="10" rows="2" class="form-control" name="PAddress" placeholder="Permanent Address"><?php echo $p_address; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Joining Date</label>
                            <input class="form-control" type="date" name="JoiningDate" placeholder="Joining Date" value="<?php echo $joining_date; ?>" />
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Short Descriptions</label>
                            <textarea cols="10" rows="3" class="form-control" name="ShortDes"><?php echo $short_des; ?></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Earning / Marketplace</label>
                            <textarea cols="10" rows="3" class="form-control" name="Earning"><?php echo $earn_market; ?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <label class="control-label">About Trainer</label>
                            <textarea cols="10" rows="4" class="form-control" name="About"><?php echo $about_trainer; ?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 01</label>
                            <input class="form-control" type="text" name="Link1" value="<?php echo $link1; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 02</label>
                            <input class="form-control" type="text" name="Link2" value="<?php echo $link2; ?>" />
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 03</label>
                            <input class="form-control" type="text" name="Link3" value="<?php echo $link3; ?>" />
                          </div>
                        </div>
                      </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="control-label">Select Photo</label>
                          <!-- Image Preview -->
                          <p>
                            <img id="previewImage" src="trainer_images/<?php echo $userPic; ?>" class="img-fluid img-thumbnail rounded-circle" style="width: 120px; height: 120px;" />
                          </p>
                          
                          <!-- File Input -->
                          <input type="file" name="user_image" accept="image/*" onchange="previewFile(this)" />
                          
                          <p class="text-danger m-0">Please Upload Your Passport Size (300px X 320px) Image Here.</p>
                        </div>
                      </div>
                    </div>

                    <!-- JavaScript for Preview -->
                    <script>
                      function previewFile(input) {
                        const file = input.files[0];
                        if (file) {
                          const reader = new FileReader();
                          
                          reader.onload = function (e) {
                            document.getElementById('previewImage').src = e.target.result;
                          }
                          
                          reader.readAsDataURL(file);
                        }
                      }
                    </script>


                      <div class="row">
                        <div class="col-md-12 text-center">
                          <div class="form-group">
                            <a class="btn btn-danger waves-effect" href="trainers"><i class="fa fa-arrow-left me-2"></i>Back now</a>
                            <button type="submit" name="btn_save_updates" class="btn btn-primary waves-effect"><i class="fa fa-upload me-2"></i>Update Now</button>
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