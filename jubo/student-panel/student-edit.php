<!doctype html>
<html lang="en">

<head>

  <title>Edit Student Info | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<body data-topbar="colored">

  <?php

  $sql = mysqli_query($con, "SELECT * FROM student_list
  LEFT JOIN district ON district.id = student_list.district
  LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
  LEFT JOIN group_list ON group_list.group_id = student_list.group_id 
  WHERE student_list.stu_user_id = '" . $_SESSION['id'] . "'");
  $surow = mysqli_fetch_array($sql);


  $student_id = $surow['student_id'];
  $userid = $surow['stu_user_id'];



  if (isset($_POST['btn_save_updates'])) {
    $StuName = $_POST['StuName'];
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
      $upload_dir = '../stu-info/user_images/'; // upload directory
      $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
      $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
      $userpic = rand(1000, 1000000) . "." . $imgExt;

      if (in_array($imgExt, $valid_extensions)) {
        if ($imgSize < 5000000) {
          move_uploaded_file($tmp_dir, $upload_dir . $userpic);
        } else {
          $errMSG = "Sorry, your file is too large. It should be less than 5MB.";
        }
      } else {
        $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      }
    } else {
      // নতুন ইমেজ না দিলে পুরাতনটা থাকবে
      $userpic = $surow['userPic'];
    }


    // if no error occured, continue ....
    if (!isset($errMSG)) {
      $stmt = $DB_con->prepare('UPDATE student_list 
									     SET 
                          
										      
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
											 status=1,  											 
											 userPic=:upic
								       WHERE student_id=:uid');
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
        //============================student_stuff==============================================
        $stmt2 = $DB_con->prepare('UPDATE student_stuff 
                            SET stu_name = :StuName, 
                                contact = :Contact, 
                                email = :Email 
                            WHERE userid = :uId');
        $stmt2->bindParam(':StuName', $StuName);
        $stmt2->bindParam(':Contact', $Contact);
        $stmt2->bindParam(':Email', $Email);
        $stmt2->bindParam(':uId', $userid);

        if ($stmt2->execute()) {
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
  }
  ?>

  <!-- Begin page -->
  <div id="layout-wrapper">
    <!-- ========= Header Start ========== -->
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
                    <h4 class="card-title m-0">Update Student Information / <b>District:</b>
                      <?php echo $surow['dist_name']; ?> / <b>Batch:</b> <?php echo $surow['batch_name']; ?> /
                      <b>Group:</b> <?php echo $surow['group_name']; ?> / <b>Phone No:</b>
                      <?php echo $surow['contact']; ?> / <b>Email:</b> <?php echo $surow['email']; ?></h4>
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
                            <label class="control-label">Student Name</label>
                            <input class="form-control" type="text" name="StuName"
                              value="<?php echo $surow['stu_name']; ?>" placeholder="Enter Student Name" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">About / Objective</label>
                            <textarea style="height: 90px; width: 100%;" class="form-control" name="About"
                              placeholder="Enter brief about yourself"><?php echo $surow['about']; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Work Experience</label>
                            <textarea style="height: 90px; width: 100%;" class="form-control" name="Work"
                              placeholder="Enter work experience"><?php echo $surow['work']; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select class="form-control" name="Gender">
                              <option><?php echo $surow['gender']; ?></option>
                              <option>Male</option>
                              <option>Female</option>
                              <option>Prefer Not To Say</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Father Name</label>
                            <input style="width: 100%;" class="form-control" name="FatherName"
                              value="<?php echo $surow['father_name']; ?>" placeholder="Enter Father Name">
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Mother Name</label>
                            <input class="form-control" type="text" name="MotherName"
                              value="<?php echo $surow['mother_name']; ?>" placeholder="Enter Mother Name" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Date Of Birth</label>
                            <input class="form-control" type="date" name="Dob"
                              value="<?php echo $surow['birth_date']; ?>" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Age</label>
                            <input class="form-control" type="text" name="Age" value="<?php echo $surow['age']; ?>"
                              placeholder="Enter Age" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3 d-none">
                          <div class="form-group">
                            <label class="control-label">Contact</label>
                            <input class="form-control" type="number" name="Contact"
                              value="<?php echo $surow['contact']; ?>" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3 d-none">
                          <div class="form-group">
                            <label class="control-label">E-mail</label>
                            <input class="form-control" type="email" name="Email"
                              value="<?php echo $surow['email']; ?>" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">NID/Birth Certificate No</label>
                            <input class="form-control" type="number" name="NidNo"
                              value="<?php echo $surow['nid_no']; ?>" placeholder="Enter NID or Birth Certificate No" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Blood Group</label>
                            <input class="form-control" type="text" name="BloodGrp"
                              value="<?php echo $surow['blood_grp']; ?>" placeholder="Enter Blood Group" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Have a Computer</label>
                            <select class="form-control" type="text" name="Computer">
                              <option value="<?php echo $surow['computer']; ?>"><?php echo $surow['computer']; ?>
                              </option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Profession</label>
                            <input class="form-control" type="text" name="Profession"
                              value="<?php echo $surow['profession']; ?>" placeholder="Enter Profession" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Religion</label>
                            <select class="form-control" type="text" name="Religion" required>
                              <option value="<?php echo $surow['religion']; ?>"><?php echo $surow['religion']; ?>
                              </option>
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
                              <option value="<?php echo $surow['disabilities']; ?>">
                                <?php echo $surow['disabilities']; ?></option>
                              <option>Yes</option>
                              <option>No</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Present Address</label>
                            <input class="form-control" type="text" name="Address"
                              value="<?php echo $surow['address']; ?>" placeholder="Enter Present Address" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <input class="form-control" type="text" name="PermaAddress"
                              value="<?php echo $surow['perma_address']; ?>" placeholder="Enter Permanent Address" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Last Academic Qualification</label>
                            <input class="form-control" type="text" name="EduQual"
                              value="<?php echo $surow['edu_qual']; ?>"
                              placeholder="Enter Last Academic Qualification" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Passing Year</label>
                            <input class="form-control" type="text" name="PassYear"
                              value="<?php echo $surow['pass_year']; ?>" placeholder="Enter Passing Year" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Linkedin</label>
                            <input class="form-control" type="text" name="Linkedin"
                              value="<?php echo $surow['linked_in']; ?>" placeholder="Enter Linkedin Profile URL" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Upwork</label>
                            <input class="form-control" type="url" name="Upwork" value="<?php echo $surow['upwork']; ?>"
                              placeholder="Enter Upwork Profile URL" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Fiverr</label>
                            <input class="form-control" type="url" name="Fiverr" value="<?php echo $surow['fiver']; ?>"
                              placeholder="Enter Fiverr Profile URL" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 3</label>
                            <input class="form-control" type="url" name="LinkThree"
                              value="<?php echo $surow['link_three']; ?>" placeholder="Enter Freelancing Link 3" />
                          </div>
                        </div>
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Freelancing Link 4</label>
                            <input class="form-control" type="url" name="LinkFour"
                              value="<?php echo $surow['link_four']; ?>" placeholder="Enter Freelancing Link 4" />
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
                            <p>
                              <img id="imagePreview" src="../stu-info/user_images/<?php echo $surow['userPic']; ?>"
                                class="img-fluid img-thumbnail rounded-circle" style="width: 150px; height: 150px;" />
                            </p>
                            <input class="input-group" type="file" name="user_image" accept="image/*"
                              onchange="previewImage(event)" />
                          </div>
                        </div>

                        <script>
                          function previewImage(event) {
                            const reader = new FileReader();
                            reader.onload = function () {
                              const output = document.getElementById('imagePreview');
                              output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                          }
                        </script>
                        <div class="col-12 mb-3">
                          <div class="form-group text-center">
                            <a class="btn btn-danger waves-effect" href="student-profile"><i
                                class="fa fa-arrow-left me-2"></i> Back Now</a>
                            <button type="submit" name="btn_save_updates" class="btn btn-primary waves-effect"> <i
                                class="fa fa-upload me-2"></i> Update Now</button>
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