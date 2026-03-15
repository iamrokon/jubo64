    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

      <div data-simplebar class="h-100">
        <div class="user-details">
          <div class="d-flex">
            <div class="me-2">
              <img src="assets/images/users/avatar-4.jpg" alt="" class="avatar-md rounded-circle">
            </div>
            <div class="user-info w-100">
              <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Donald Johnson
                  <i class="mdi mdi-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-account-circle text-muted me-2"></i>
                      Profile<div class="ripple-wrapper me-2"></div>
                    </a></li>
                  <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-cog text-muted me-2"></i>
                      Settings</a></li>
                  <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-lock-open-outline text-muted me-2"></i>
                      Lock screen</a></li>
                  <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-power text-muted me-2"></i>
                      Logout</a></li>
                </ul>
              </div>

              <p class="text-white-50 m-0">Administrator</p>
            </div>
          </div>
        </div>


        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Main</li>

            <li>
              <a href="index" class="waves-effect">
                <i class="mdi mdi-home"></i>
                <span>Dashboard</span>
              </a>
            </li>


            <hr class="m-0">

            <li class="<?= $activePage == 'attendance-list' || $activePage == 'attendance-student-view' || $activePage == 'attendance-report-view'  ? 'mm-active' : '' ?>">
              <a href="attendance-list" class="waves-effect">
                <i class="mdi mdi-account-group"></i>
                <span>Attendance List</span>
              </a>
            </li>

             <!-- <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect <?= $activePage == 'attendance-list' || $activePage == 'attendance-report-view' ? 'mm-active' : '' ?>">
                <i class="mdi mdi-file-document"></i>
              <span>Attendance Report</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li class="<?= $activePage == 'distance-list' || $activePage == 'distance-add' ? 'mm-active' : '' ?>"><a href="distance-list">Distance Setting</a></li>


                <li class="<?= $activePage == 'attendance-list' || $activePage == 'attendance-student-view' || $activePage == 'attendance-report-view' ? 'mm-active' : '' ?>"><a href="attendance-list">Attendance List</a></li>
              </ul>
            </li> -->

            <hr class="m-0">

            <li class="<?= $activePage == 'students' || $activePage == 'student-add' || $activePage == 'student-edit' || $activePage == 'student-information-report-by-students'  ? 'mm-active' : '' ?>">
              <a href="students" class="waves-effect">
                <i class="mdi mdi-account-group"></i>
                <span>Students</span>
              </a>
            </li>

            <hr class="m-0">

            <li class="<?= $activePage == 'earning-information' || $activePage == 'earning-information-report' || $activePage == 'earning-add-with-student' || $activePage == 'earning-information-edit' ? 'mm-active' : '' ?>">
              <a href="earning-information" class="waves-effect">
                <i class="mdi mdi-cash-multiple"></i>
                <span>Earning Info</span>
              </a>
            </li>

            <hr class="m-0">

            <li class="<?= $activePage == 'trainers' || $activePage == 'trainer-add' || $activePage == 'trainer-edit' || $activePage == 'trainer-profile'  ? 'mm-active' : '' ?>">
              <a href="trainers" class="waves-effect">
                <i class="mdi mdi-account-tie"></i>
                <span>Trainers</span>
              </a>
            </li>

            <hr class="m-0">
            <li class="<?= $activePage == 'stuff' || $activePage == 'stuff-add' || $activePage == 'stuff-edit' || $activePage == 'stuff-profile'  ? 'mm-active' : '' ?>">
              <a href="stuff" class="waves-effect">
                <i class="mdi mdi-account-tie"></i>
                <span>Stuff</span>
              </a>
            </li>

            <hr class="m-0">

          
      <li class="<?= $activePage == 'certificate-dyd-48' || $activePage == 'certificate-dyd-48-info-add' || $activePage == 'certificate-dyd-48-info-edit' || $activePage == 'certificate-dyd-48-information-report' ? 'mm-active' : '' ?>">
      
        <a href="certificate-dyd-48" class="waves-effect">   
          <i class="mdi mdi-certificate"></i>
          <span>Certificate</span>
        </a>
      </li>

   <hr class="m-0">

      <li class="<?= $activePage == 'job-placement-dyd-48' || $activePage == 'job-placement-dyd-48-info-add' || $activePage == 'job-placement-dyd-48-info-edit' || $activePage == 'job-placement-dyd-48-information-report' ? 'mm-active' : '' ?>">
      
        <a href="job-placement-dyd-48" class="waves-effect">   
          <i class="fa fa-briefcase"></i>
          <span>Job Placement</span>
        </a>
      </li>

            <hr class="m-0">
      <li class="<?= $activePage == 'user-student-list' ? 'mm-active' : '' ?>">
      
        <a href="user-student-list" class="waves-effect">   
          <i class="fa fa-briefcase"></i>
          <span>Student User</span>
        </a>
      </li>

            <hr class="m-0">

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-cog"></i>
                <span>Setting</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="jobs">Jobs</a></li>
                <li><a href="work-sources">Work Source</a></li>
                <li><a href="payment-methoad">Payment Methoad</a></li>
                <li><a href="batches">Batches</a></li>
              </ul>
            </li>


            <hr class="m-0">


            <li>
              <a href="logout" class="waves-effect">
                <i class="mdi mdi-logout"></i>
                <span>Logout</span>
              </a>
            </li>


          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->