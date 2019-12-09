
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
            <!-- ============================================================== -->
            <!-- navbar -->
            <!-- ============================================================== -->
           <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white fixed-top">
                    <a class="navbar-brand" href="home">MIT Management System</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right-top">
                            {{-- <li class="nav-item">
                                <div id="custom-search" class="top-search-bar">
                                    <input class="form-control" type="text" placeholder="Search..">
                                </div>
                            </li>
                            <li class="nav-item dropdown notification">
                                <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                    <li>
                                        <div class="notification-title"> Notification</div>
                                        <div class="notification-list">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item list-group-item-action active">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">
    John Abraham</span>is now following you
                                                            <div class="notification-date">2 days ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="notification-info">
                                                        <div class="notification-list-user-img"><img src="images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                        <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                            <div class="notification-date">2 min ago</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="list-footer"> <a href="#">View all notifications</a></div>
                                    </li>
                                </ul>
                            </li> --}}
                            <li class="nav-item dropdown nav-user">
                                <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                                <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                    <div class="nav-user-info">
                                        <h5 class="mb-0 text-white nav-user-name">MMS</h5>
                                        <span class="status"></span><span class="ml-2">Available</span>
                                    </div>
                                    <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                    <a class="dropdown-item" href="user_setting"><i class="fas fa-cog mr-2"></i>Setting</a>
                                    <a class="dropdown-item" href="logout"><i class="fas fa-power-off mr-2"></i>Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- ============================================================== -->
            <!-- end navbar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- left sidebar -->
            <!-- ============================================================== -->
          <div class="nav-left-sidebar sidebar-dark">
                <div class="menu-list">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav flex-column">
                                <li class="nav-divider">
                                    Menu
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link active" href="dashboard" ><i class="fas fa-chart-line"></i>Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-check"></i>Attendance</a>
                                    <div id="submenu-2" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2-1" aria-controls="submenu-2-1"><i class="far fa-check-square"></i>Attendance Record</a>
                                                <div id="submenu-2-1" class="collapse submenu" style="">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="list_of_attendance"><i class="fas fa-list-ol"></i>List of Attendance</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="todays_attendance"><i class="fas fa-clipboard-list"></i>Today's Attendance</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2-3" aria-controls="submenu-2-3"><i class="fas fa-exclamation"></i>Failure</a>
                                                <div id="submenu-2-3" class="collapse submenu" style="">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="list-filed-failure"><i class="fas fa-list-ul"></i>List of Filed Failure</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="failure_form"><i class="fas fa-file-alt"></i>Failure Form</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2-4" aria-controls="submenu-2-4"><i class="far fa-clock"></i>Late</a>
                                                <div id="submenu-2-4" class="collapse submenu" style="">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="list-filed-late"><i class="fas fa-list"></i>List of Filed Late</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="late_form"><i class="fas fa-file-alt"></i>Late Form</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2-5" aria-controls="submenu-2-5"><i class="fas fa-pause-circle"></i>Undertime</a>
                                                <div id="submenu-2-5" class="collapse submenu" style="">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="list-filed-undertime"><i class="fas fa-list-alt"></i>List of Filed Undertime</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="undertime-form"><i class="fas fa-file-alt"></i>Undertime Form</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2-6" aria-controls="submenu-2-6"><i class="fas fa-car"></i>Leave</a>
                                                <div id="submenu-2-6" class="collapse submenu" style="">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="leave-monitoring-record"><i class="far fa-list-alt"></i>Leave Monitoring Record</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="leave-form"><i class="fas fa-file-alt"></i>Leave Form</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="attendance-report"><i class="fas fa-chart-bar"></i>Reports</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-dollar-sign"></i>Overtime</a>
                                <div id="submenu-3" class="collapse submenu {{
                                    request()->is('overtime') ? 'show' : ''
                                }}" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                            <a class="nav-link {{ request()->is('overtime') ? 'active' : '' }}" href="{{ url("overtime") }}"><i class="fas fa-donate"></i>Overtime Records</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="file_overtime"><i class="fas fa-file-alt"></i>File Overtime</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="overtime_reports"><i class="fas fa-chart-bar"></i>Reports</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-bus"></i>Shuttle</a>
                                    <div id="submenu-4" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="default_shuttle"><i class="fab fa-fw fa-wpforms"></i> Shuttle</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="change_shuttle"><i class="fas fa-exchange-alt"></i>Change Shuttle</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="today_shuttle"><i class="fas fa-train"></i>Today Shuttle</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="shuttle_reports"><i class="fas fa-chart-bar"></i>Reports</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-hourglass-half"></i>ManHour</a>
                                    <div id="submenu-5" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="manhour_recurrence"><i class="fas fa-retweet"></i>Recurrence</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="extra_activities"><i class="fas fa-child"></i> Extra Activities</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="manhour_calendar"><i class="fas fa-calendar-alt"></i> Manhour Calendar</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="manhour_reports"><i class="fas fa-chart-bar"></i>Reports</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="gantt_chart" ><i class="fas fa-tasks"></i>Gantt Chart</a>
                                </li>
                                <li class="nav-divider">
                                    Management
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="user_management"><i class="fas fa-users"></i>User Management</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            