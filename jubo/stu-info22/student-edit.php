<!doctype html>
<html lang="en">

<head>

  <title>Edit Student Info | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<body data-topbar="colored">

  <?php
  if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $student_id = $_GET['edit_id'];
    $stmt_edit = $DB_con->prepare('SELECT * FROM student_list WHERE student_id =:uid');
    $stmt_edit->execute(array(':uid' => $student_id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
  } else {
    header("Location: index.php");
  }



  if (isset($_POST['btn_save_updates'])) {
    $StuName = $_POST['StuName'];
    $Group = $_POST['Group'];
    $About = $_POST['About'];
    $Work = $_POST['Work'];
    $Gender = $_POST['Gender'];
    $FatherName = $_POST['FatherName'];
    $MotherName = $_POST['MotherName'];
    $Dob = $_POST['Dob'];
    $Age = $_POST['Age'];

    $Contact = $_POST['Contact'];
    $Email = $_POST['Email'];
    $NidNo = $_POST['NidNo'];

    $BloodGrp = $_POST['BloodGrp'];
    $Computer = $_POST['Computer'];
    $Profession = $_POST['Profession'];

    $Religion = $_POST['Religion'];
    $Disabilities = $_POST['Disabilities'];
    $Address = $_POST['Address'];
    $PermaAddress = $_POST['PermaAddress'];

    $EduQual = $_POST['EduQual'];
    $PassYear = $_POST['PassYear'];

    $Linkedin = $_POST['Linkedin'];
    $Upwork = $_POST['Upwork'];
    $Fiverr = $_POST['Fiverr'];
    $LinkThree = $_POST['LinkThree'];
    $LinkFour = $_POST['LinkFour'];



    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];

    if ($imgFile) {
      $upload_dir = 'user_images/'; // upload directory	
      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
      $userpic = rand(1000, 1000000) . "." . $imgExt;
      if (in_array($imgExt, $valid_extensions)) {
        if ($imgSize < 5000000) {
          //	unlink($upload_dir.$edit_row['userPic']);
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
      $stmt = $DB_con->prepare('UPDATE student_list 
									     SET 
										      group_id=:Group,
										      stu_name=:StuName,
										      about=:About,
											  work=:Work, 
											  gender=:Gender, 
											  father_name=:FatherName, 
											  mother_name=:MotherName, 
											  birth_date=:Dob, 
											  age=:Age,
											  
											  contact=:Contact, 
											  email=:Email, 
											  nid_no=:NidNo, 
											  
											  blood_grp=:BloodGrp, 
											  computer=:Computer, 
											  profession=:Profession, 
											  
											  religion=:Religion, 
											  disabilities=:Disabilities, 
											  address=:Address, 
											  perma_address=:PermaAddress,
											  
											  edu_qual=:EduQual,  
											  pass_year=:PassYear,  
											  
											  
											  
										     linked_in=:Linkedin, 
										     upwork=:Upwork, 
										     fiver=:Fiverr, 
										     link_three=:LinkThree, 
										     link_four=:LinkFour,
											 status=2,  											 
											 userPic=:upic
											 
								       WHERE student_id=:uid');

      $stmt->bindParam(':Group', $Group);
      $stmt->bindParam(':StuName', $StuName);
      $stmt->bindParam(':About', $About);
      $stmt->bindParam(':Work', $Work);
      $stmt->bindParam(':Gender', $Gender);
      $stmt->bindParam(':FatherName', $FatherName);
      $stmt->bindParam(':MotherName', $MotherName);
      $stmt->bindParam(':Dob', $Dob);
      $stmt->bindParam(':Age', $Age);

      $stmt->bindParam(':Contact', $Contact);
      $stmt->bindParam(':Email', $Email);
      $stmt->bindParam(':NidNo', $NidNo);

      $stmt->bindParam(':BloodGrp', $BloodGrp);
      $stmt->bindParam(':Computer', $Computer);
      $stmt->bindParam(':Profession', $Profession);

      $stmt->bindParam(':Religion', $Religion);
      $stmt->bindParam(':Disabilities', $Disabilities);
      $stmt->bindParam(':Address', $Address);
      $stmt->bindParam(':PermaAddress', $PermaAddress);

      $stmt->bindParam(':EduQual', $EduQual);
      $stmt->bindParam(':PassYear', $PassYear);


      $stmt->bindParam(':Linkedin', $Linkedin);
      $stmt->bindParam(':Upwork', $Upwork);
      $stmt->bindParam(':Fiverr', $Fiverr);
      $stmt->bindParam(':LinkThree', $LinkThree);
      $stmt->bindParam(':LinkFour', $LinkFour);

      $stmt->bindParam(':uid', $student_id);
      $stmt->bindParam(':upic', $userpic);

      if ($stmt->execute()) {
  ?>
        <script>
          alert('Update Successfully Done...');
          window.location.href = window.location.href;
        </script>
  <?php
      } else {
        $errMSG = "Sorry Data Could Not Updated !";
      }
    }
  }

  ?>

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
                    <li class="breadcrumb-item active">Edit Student Information</li>
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
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">Edit Student Information</h4>
                  </div>
                  <div class="card-body">

                    <?php
                    if (isset($errMSG)) {
                      echo '<div class="alert alert-danger">' . $errMSG . '</div>';
                    } else if (isset($successMSG)) {
                      echo '<div class="alert alert-success">' . $successMSG . '</div>';
                    }
                    ?>



                    <form method="post" enctype="multipart/form-data" class="form-horizontal">

                      <div class="row">

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select District</label>
                            <select class="form-control" name="District" required>
                              <?php
                              $sql = "SELECT id,dist_name FROM district where id ='" . $_SESSION['id'] . "'";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row[0] . "'>" . $row[0] . " - " . $row[1] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>


                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select Batch</label>
                            <select class="form-control" name="Batch" required>
                              <?php
                              $sql = "SELECT * FROM batch_list WHERE status = 1";
                              $result = $con->query($sql);
                              while ($row = $result->fetch_array()) {
                                echo '<option value="' . $row['batch_id'] . '">' . $row['batch_name'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select Group</label>
                            <select class="form-control" name="Group" required>
                              <?php
                              $sql = "SELECT * FROM group_list";
                              $result = $con->query($sql);
                              while ($row = $result->fetch_array()) {
                                $selected = ($group_id == $row['group_id']) ? 'selected' : '';
                                echo '<option value="' . $row['group_id'] . '" ' . $selected . '>' . $row['group_name'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Student Name</label>
                            <input class="form-control" type="text" name="StuName" value="<?php echo $stu_name; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">About / Objective</label>
                            <textarea style="height: 90px; width: 100%;" class="form-control" name="About"><?php echo $about; ?></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Work Experience</label>
                            <textarea style="height: 90px; width: 100%;" class="form-control" name="Work"><?php echo $work; ?></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="Gender">
                              <option><?php echo $gender; ?></option>
                              <option>Male</option>
                              <option>Female</option>
                              <option>Prefer Not To Say</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Father Name</label>
                            <input style="width: 100%;" class="form-control" name="FatherName" value="<?php echo $father_name; ?>">
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Mother Name</label>
                            <input class="form-control" type="text" name="MotherName" value="<?php echo $mother_name; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Date Of Birth</label>
                            <input class="form-control" type="text" name="Dob" value="<?php echo $birth_date; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Age</label>
                            <input class="form-control" type="text" name="Age" value="<?php echo $age; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Contact</label>
                            <input class="form-control" type="text" name="Contact" value="<?php echo $contact; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">E-mail</label>
                            <input class="form-control" type="text" name="Email" value="<?php echo $email; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">NID/Birth Certificate No</label>
                            <input class="form-control" type="text" name="NidNo" value="<?php echo $nid_no; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Blood Group</label>
                            <input class="form-control" type="text" name="BloodGrp" value="<?php echo $blood_grp; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Have a Computer</label>
                            <select class="form-control" type="text" name="Computer">
                              <option value="<?php echo $computer; ?>"><?php echo $computer; ?></option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Profession</label>
                            <input class="form-control" type="text" name="Profession" value="<?php echo $profession; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Religion</label>
                            <select class="form-control" type="text" name="Religion" required>
                              <option value="<?php echo $religion; ?>"><?php echo $religion; ?></option>
                              <option>Islam</option>
                              <option>Hindu</option>
                              <option>Others</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Disabilities</label>
                            <select class="form-control" type="text" name="Disabilities">
                              <option value="<?php echo $disabilities; ?>"><?php echo $disabilities; ?></option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Address</label>
                            <input class="form-control" type="text" name="Address" value="<?php echo $address; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <input class="form-control" type="text" name="PermaAddress" value="<?php echo $perma_address; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Last Academic Qualification</label>
                            <input class="form-control" type="text" name="EduQual" value="<?php echo $edu_qual; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Passing Year</label>
                            <input class="form-control" type="text" name="PassYear" value="<?php echo $pass_year; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Linkedin</label>
                            <input class="form-control" type="text" name="Linkedin" value="<?php echo $linked_in; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Upwork</label>
                            <input class="form-control" type="text" name="Upwork" value="<?php echo $upwork; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Fiverr</label>
                            <input class="form-control" type="text" name="Fiverr" value="<?php echo $fiver; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 3</label>
                            <input class="form-control" type="text" name="LinkThree" value="<?php echo $link_three; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 4</label>
                            <input class="form-control" type="text" name="LinkFour" value="<?php echo $link_four; ?>" />
                          </div>
                        </div>

                        <div class="col-md-6" style="display:none;">
                          <div class="form-group">
                            <label class="control-label">Active/In-Active</label>
                            <select style="width: 100%;" class="form-control" name="status">
                              <option value="1">Active</option>
                              <option value="0">In-Active</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Choose Photo</label>
                            <p><img src="user_images/<?php echo $userPic; ?>" class="img-fluid img-thumbnail rounded-circle" style="width: 150px; height: 150px;" /></p>
                            <input class="input-group" type="file" name="user_image" accept="image/*" />
                          </div>
                        </div>

                        <div class="col-12 mb-3">
                          <div class="form-group text-center">
                            <a class="btn btn-danger waves-effect" href="students"><i class="fa fa-arrow-left me-2"></i> Back Now</a>
                            <button type="submit" name="btn_save_updates" class="btn btn-primary waves-effect"> <i class="fa fa-upload me-2"></i> Update Now</button>
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