<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ url('css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            @if(isset($employee_session))
                <a class="navbar-brand ps-3" href="{{ url(route('home')) }}">Task Management</a>
            @endif

            @if(isset($HR__ADMIN__session))
                <a class="navbar-brand ps-3" href="{{ url(route('home')) }}">Task Allocation</a>
            @endif
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." id = "navbarSearchInput" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if(isset($HR__ADMIN__session))
                            <li><a class="dropdown-item" href="{{ url(route('activity_log')) }}">Activity Log</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url(route('password_reset_page_in_dashabord', $HR__ADMIN__session->employees->first()->employee_email )) }}">Password Reset</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" onclick = "return confirm('Are you sure to logout from your account !')" href="{{ route('HR__ADMIN__logout') }}">Logout</a></li>
                        @endif

                        @if(isset($employee_session))
                            <li><a class="dropdown-item" href="{{ url(route('password_reset_page_in_dashabord', $employee_session->employees->first()->employee_email )) }}">Password Reset</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" onclick = "return confirm('Are you sure to logout from your account !')" href="{{ route('employee_logout') }}">Logout</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">

                        @if(isset($employee_session))
                            <div class="nav">
                                <a class="nav-link mt-5" href="{{ url(route('home')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>
                                <div class="sb-sidenav-menu-heading">Task Record</div>

                                <a class="nav-link" href="{{ url(route('allocated_task')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                    Allocated Task
                                </a>

                                <a class="nav-link" href="{{ url(route('deadline_crossed_task_of_specific_employee')) }}">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                    Deadline Crossed Task
                                </a>

                                <a class="nav-link collapsed" href="{{ url(route('completed_task_of_specific_employee')) }}" >
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                    Completed Task
                                </a>

                                        <a class="nav-link collapsed" href="{{ url(route('accepted_task_of_specific_employee')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fas fa-check-double"></i></div>
                                            Accepted Task
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('unapproved_task_of_specific_employee')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-xmark"></i></div>
                                            Unapproved Task
                                        </a>
                            </div>
                        @endif

                        @if(isset($HR__ADMIN__session))
                            <div class="nav">
                                <a class="nav-link mt-5" href="{{ url(route('home')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>
                                <div class="sb-sidenav-menu-heading">Manage</div>

                                <a class="nav-link collapsed" href="{{ url(route('services')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                                    Services
                                </a>
                                
                                @if(isset($HR__ADMIN__session))
                                    @if($HR__ADMIN__session->employees->first()->user_type == "ADMIN")
                                        <a class="nav-link collapsed" href="{{ url(route('client')) }}">
                                            <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                            Clients
                                        </a>
                                    @endif
                                @endif

                                <a class="nav-link collapsed" href="{{ url(route('employee')) }}" >
                                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                    Employee
                                </a>

                                <a class="nav-link collapsed" href="{{ url(route('task_allocation')) }}" >
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                    Task Allocation
                                </a>

                                @if(isset($HR__ADMIN__session))
                                    @if($HR__ADMIN__session->employees->first()->user_type == "HR")
                                        <a class="nav-link collapsed" href="{{ url(route('task_approv')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fas fa-check"></i></div>
                                            Task Approval
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('approved_tasks')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fas fa-check-double"></i></div>
                                            Approved Tasks
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('declined_tasks')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-xmark"></i></div>
                                            Declined Tasks
                                        </a>
                                    @endif
                                @endif

                                <div class="sb-sidenav-menu-heading">Report</div>
                                <a class="nav-link" href="{{ url(route('task_vice_report')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                    Task
                                </a>
                                <a class="nav-link" href="{{ url(route('service_report')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                                    Service
                                </a>
                                <a class="nav-link" href="{{ url(route('task_report')) }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                    Employee
                                </a>
                                @if(isset($HR__ADMIN__session))
                                    @if($HR__ADMIN__session->employees->first()->user_type == "ADMIN")
                                        <a class="nav-link" href="{{ url(route('client_report')) }}">
                                            <div class="sb-nav-link-icon"><i class="fas fa-rupee-sign"></i></div>
                                            Client Payment
                                        </a>
                                    @endif
                                @endif

                                @if(isset($HR__ADMIN__session))
                                    @if($HR__ADMIN__session->employees->first()->user_type == "HR")
                                        <div class="sb-sidenav-menu-heading">Task Record</div>

                                        <a class="nav-link" href="{{ url(route('allocated_task')) }}">
                                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                            Allocated Task
                                        </a>

                                        <a class="nav-link" href="{{ url(route('deadline_crossed_task_of_specific_employee')) }}">
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                            Deadline Crossed Task
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('completed_task_of_specific_employee')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                            Completed Task
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('accepted_task_of_specific_employee')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fas fa-check-double"></i></div>
                                            Accepted Task
                                        </a>

                                        <a class="nav-link collapsed" href="{{ url(route('unapproved_task_of_specific_employee')) }}" >
                                            <div class="sb-nav-link-icon"><i class="fa-solid fa-xmark"></i></div>
                                            Unapproved Task
                                        </a>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        @if(isset($HR__ADMIN__session))
                            <h6>{{ $HR__ADMIN__session->employees->first()->employee_name }}</h6>
                        @endif

                        @if(isset($employee_session))
                            <h6>{{ $employee_session->employees->first()->employee_name }}</h6>
                        @endif
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
            <main>
            <div class="container-fluid px-4">
                        