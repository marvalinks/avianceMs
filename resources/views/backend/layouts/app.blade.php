<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Aviance System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- plugins -->
    <link href="/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />

    <!-- icons -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/css/override.css">
    @yield('links')

</head>

<body class="loading" data-layout-mode="horizontal"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ms-1">
                                {{ session()->get('user')['name'] ?? auth()->user()->name }} <i class="uil uil-angle-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <a href="#" class="dropdown-item notify-item">
                                <i data-feather="user" class="icon-dual icon-xs me-1"></i><span>My Account</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                                <i data-feather="log-out" class="icon-dual icon-xs me-1"></i><span>Logout</span>
                            </a>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="#" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/assets/images/aviance.png" alt="" height="24">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/aviance.png" alt="" height="24">
                        </span>
                    </a>

                    <a href="#" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/assets/images/aviance.png" alt="" height="24">
                        </span>
                        <span class="logo-lg">
                            <img src="/assets/images/aviance.png" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile">
                            <i data-feather="menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse"
                            data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('backend.dashboard') }}" id="topnav-layout"
                                    role="button" data-bs-toggle="" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="home"></i> Dashboards
                                </a>

                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('backend.acceptance.list') }}"
                                    id="topnav-layout" role="button" data-bs-toggle="" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i data-feather="home"></i> Acceptance Module
                                </a>

                            </li>
                            @if (session()->get('user')['roleid'] == 1)
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('backend.users.list') }}"
                                        id="topnav-layout" role="button" data-bs-toggle="" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i data-feather="home"></i> Manage Users
                                    </a>

                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('backend.signees.list') }}"
                                        id="topnav-layout" role="button" data-bs-toggle="" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i data-feather="home"></i> Manage Signees
                                    </a>

                                </li>
                                {{-- <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('backend.configurations.index') }}"
                                        id="topnav-layout" role="button" data-bs-toggle="" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i data-feather="home"></i> Configurations
                                    </a>

                                </li> --}}
                            @endif
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">
                    @foreach (['alert-danger', 'alert-warning', 'alert-success', 'alert-info'] as $msg)
                        @if (Session::has($msg))
                            <div class="alert {{ $msg }} alert-dismissible fade show" role="alert">
                                {{ Session::get($msg) }}

                            </div>
                        @endif
                    @endforeach

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">@yield('name')</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Aviance</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Modules</a></li>
                                        <li class="breadcrumb-item active">@yield('name')</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('content')

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Aviance Ghana
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-sm-block">
                                <a href="javascript:void(0);">About Us</a>
                                <a href="javascript:void(0);">Help</a>
                                <a href="javascript:void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

    </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="/assets/js/vendor.min.js"></script>

    <!-- optional plugins -->
    <script src="/assets/libs/moment/min/moment.min.js"></script>
    <script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/libs/flatpickr/flatpickr.min.js"></script>

    <!-- page js -->
    <script src="/assets/js/pages/dashboard.init.js"></script>

    <!-- App js -->
    <script src="/assets/js/app.min.js"></script>
    @yield('scripts')

</body>

</html>
