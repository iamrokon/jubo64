<!doctype html>
<html lang="en">

<head>

  <title>Add New Student | e-Learning & Earning Ltd.</title>

  <?php include "header-link.php" ?>

</head>

<body data-topbar="colored">

  <?php
  if (isset($_POST['btnsave'])) {
    $UserId = $_POST['UserId'];

    $District = $_POST['District'];
    $Batch = $_POST['Batch'];
    $Group = $_POST['Group'];
    // $Group = $_POST['Group'];

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

    $LinedIn = $_POST['LinedIn'];
    $Upwork = $_POST['Upwork'];
    $Fiverr = $_POST['Fiverr'];
    $LinkThree = $_POST['LinkThree'];
    $LinkFour = $_POST['LinkFour'];


    // $Date = $_POST['Date'];
    $Date =  date("Y/m/d");

    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];


    if (empty($StuName)) {
      $errMSG = "Please Enter Student Name.";
    } else if (empty($FatherName)) {
      $errMSG = "Please Enter Father Name";
    } else if (empty($Contact)) {
      $errMSG = "Please Enter Phone Number.";
    }

    if (isset($_POST['Contact']) && $_POST['Contact'] != '') {
      $Contact = $_POST['Contact'];
      $checkQuery = mysqli_query($con, "SELECT * FROM `student_list` WHERE `contact`='$Contact' ");
      if (mysqli_num_rows($checkQuery) > 0) {
        $errMSG = "This Phone Number Already Exist !";
      } else {
        $upload_dir = 'user_images/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        //$userpic = rand(1000,1000000).".".$imgExt;
        $userpic = "e-laeltd-" . $imgFile;

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
        $stmt = $DB_con->prepare('INSERT INTO student_list(user_id,district,batch_id,group_id,stu_name,about,work,gender,father_name,mother_name,birth_date,age,contact,email,nid_no,blood_grp,computer,profession,religion,disabilities,address,perma_address,edu_qual,pass_year,linked_in,upwork,fiver,link_three,link_four,join_date,status,userPic)
			VALUES(:UserId,:District,:Batch, :Group, :StuName,:About,:Work,:Gender, :FatherName, :MotherName,:Dob,:Age,:Contact,:Email,:NidNo,:BloodGrp,:Computer,:Profession,:Religion,:Disabilities,:Address,:PermaAddress,:EduQual,:PassYear,:LinedIn,:Upwork,:Fiverr,:LinkThree,:LinkFour,:Date,1,:upic)');
        $stmt->bindParam(':UserId', $UserId);

        $stmt->bindParam(':District', $District);
        $stmt->bindParam(':Batch', $Batch);
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

        $stmt->bindParam(':LinedIn', $LinedIn);
        $stmt->bindParam(':Upwork', $Upwork);
        $stmt->bindParam(':Fiverr', $Fiverr);
        $stmt->bindParam(':LinkThree', $LinkThree);
        $stmt->bindParam(':LinkFour', $LinkFour);


        $stmt->bindParam(':Date', $Date);
        $stmt->bindParam(':upic', $userpic);

        if ($stmt->execute()) {
  ?>
          <script>
            alert('Data Successfully Add ...');
            window.location.href = 'student-add';
          </script>
  <?php

        } else {
          $errMSG = "error while inserting....";
        }
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
                    <li class="breadcrumb-item active">Add New Student</li>
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
                    <h4 class="card-title m-0">Add New Student</h4>
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
                          $pq = mysqli_query($con, "select * from stuff left join `user` on user.userid=stuff.userid where stuff.userid='" . $_SESSION['id'] . "' ");
                          while ($pqrow = mysqli_fetch_array($pq)) {
                          ?>
                            <input class="form-control" type="hidden" name="UserId" value="<?php echo $pqrow['userid']; ?>">
                          <?php } ?>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select District</label>
                            <select class="form-select" name="District" required>
                              <?php
                              $sql = "SELECT id,dist_name FROM district where id='" . $_SESSION['id'] . "'";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select Batch</label>
                            <select class="form-select" name="Batch" required>
                              <?php
                              $sql = "SELECT * FROM batch_list WHERE status = 1";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row['batch_id'] . "'>" . $row['batch_name'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Select Group</label>
                            <select class="form-select" name="Group" required>
                              <option>Select Group</option>
                              <?php
                              $sql = "SELECT * FROM group_list";
                              $result = $con->query($sql);

                              while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Student Name</label>
                            <input class="form-control" type="text" name="StuName" placeholder="Student Name" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">About / Objective</label>
                            <textarea cols="10" rows="4" class="form-control" name="About" placeholder="Some Description About His / Her.. "></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Work Experience</label>
                            <textarea cols="10" rows="4" class="form-control" name="Work" placeholder="Work Experience"></textarea>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select class="form-select" name="Gender" required>
                              <option value="">Select Gender</option>
                              <option>Male</option>
                              <option>Female</option>
                              <option>Others</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Father Name</label>
                            <input style="width: 100%;" class="form-control" name="FatherName" placeholder="Father Name" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Mother Name</label>
                            <input class="form-control" type="text" id="MotherName" name="MotherName" placeholder="Mother Name" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Date Of Birth</label>
                            <input class="form-control" type="date" name="Dob" value="<?php date_default_timezone_set("Asia/Dhaka");
                                                                                      echo date("Y/m/d"); ?>" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Age</label>
                            <input class="form-control" type="text" name="Age" placeholder="Age " required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Phone</label>
                            <input class="form-control" type="text" name="Contact" placeholder="Phone" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">E-mail</label>
                            <input class="form-control" type="text" name="Email" placeholder="E-mail" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">NID/Birth Certificate No</label>
                            <input class="form-control" type="text" name="NidNo" placeholder="NID/Birth Certificate No" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Blood Group</label>
                            <input class="form-control" type="text" name="BloodGrp" placeholder="Blood Group" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Have a Computer</label>
                            <div>
                              <input type="radio" name="Computer" value="Yes" required> Yes
                              <input class="ms-3" type="radio" name="Computer" value="No" required> No
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Profession</label>
                            <input class="form-control" type="text" name="Profession" placeholder="Profession" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Religion</label>
                            <select class="form-select" name="Religion" required>
                              <option value="">Select Religion</option>
                              <option>Islam</option>
                              <option>Hindu</option>
                              <option>Others</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Disabilities</label>
                            <div>
                              <input type="radio" name="Disabilities" value="Yes"> Yes
                              <input class="ms-3" type="radio" name="Disabilities" value="No" checked> No
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Present Address</label>
                            <input class="form-control" type="text" name="Address" placeholder="Present Address" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Permanent Address</label>
                            <input class="form-control" type="text" name="PermaAddress" placeholder="Permanent Address" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Last Academic Qualification</label>
                            <input class="form-control" type="text" name="EduQual" placeholder="Last Academic Qualification" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Passing Year</label>
                            <input class="form-control" type="text" name="PassYear" placeholder="Passing Year" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">LinkedIn</label>
                            <input class="form-control" type="text" name="LinedIn" placeholder="LinkedIn Link" value="none" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Up-Work</label>
                            <input class="form-control" type="text" name="Upwork" placeholder="Upwork Link" value="none" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Fiver</label>
                            <input class="form-control" type="text" name="Fiverr" placeholder="Fiverr Link" value="none" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Other Freelancing Link 1</label>
                            <input class="form-control" type="text" name="LinkThree" placeholder="Freelancing Link 3" value="none" required>
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Other Freelancing Link 2</label>
                            <input class="form-control" type="text" name="LinkFour" placeholder="Freelancing Link 4" value="none" required>
                          </div>
                        </div>

                        <div class="col-md-6" style="display:none;">
                          <div class="form-group">
                            <label class="control-label">Date</label>
                            <input class="form-control" type="text" name="Date" placeholder="<?php date_default_timezone_set("Asia/Dhaka"); echo date("Y/m/d"); ?>" />
                          </div>
                        </div>

                        <div class="col-md-6 mb-3">
                          <div class="form-group">
                            <label class="control-label">Photo</label>
                            <input class="input-group" type="file" name="user_image" accept="image/*" />
                            <p>Please Upload Your Passport Size (300px X 320px) Image Here:</p>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group text-center">
                            <a href="students" class="btn btn-danger waves-effect"><i class="fa fa-arrow-left me-2"></i>Back Now</a>
                            <button type="submit" name="btnsave" class="btn btn-primary waves-effect"> <i class="fa fa-save me-2"></i>Submit Now</button>
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