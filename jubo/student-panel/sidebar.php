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

            <li class="<?= $activePage == 'student-profile' || $activePage == 'student-profile' || $activePage == 'student-edit' || $activePage == 'change-password' || $activePage == 'student-information-report-by-students'  ? 'mm-active' : '' ?>">
              <a href="student-profile" class="waves-effect">
                <i class="mdi mdi-account-group"></i>
                <span>My Profile</span>
              </a>                                                                                
            </li>

            <!-- <hr class="m-0">
            <li class="<?= $activePage == 'student-edit' || $activePage == 'student-add' || $activePage == 'student-edit' || $activePage == 'student-information-report-by-students'  ? 'mm-active' : '' ?>">
              <a href="student-edit" class="waves-effect">
                <i class="mdi mdi-account-group"></i>
                <span>Students</span>
              </a>                                                                                
            </li> -->

            <hr class="m-0">

            <li class="<?= $activePage == 'earning-information' || $activePage == 'earning-information-report' || $activePage == 'earning-add-with-student' || $activePage == 'earning-information-edit' ? 'mm-active' : '' ?>">
              <a href="earning-information" class="waves-effect">
                <i class="mdi mdi-cash-multiple"></i>
                <span>Earning Info</span>
              </a>
            </li>

            <hr class="m-0">

          
          

            <li class="<?= $activePage == 'attandanc-add' ? 'mm-active' : '' ?>">
              <a href="attandanc-add" class="waves-effect">
                <i class="mdi mdi-calendar-check-outline" <?= $activePage != 'attandanc-add' ? 'style="color: red;"' : '' ?>></i>
                <span <?= $activePage != 'attandanc-add' ? 'style="color: red;"' : '' ?>>Attendance</span>
              </a>
            </li>

            <hr class="m-0">
           


       


            <li>
              <a href="logout" class="waves-effect">
                <i class="mdi mdi-logout"></i>
                <span>Logout</span>
              </a>
            </li>

            

            <hr class="m-0">

          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
    <!-- Left Sidebar End -->