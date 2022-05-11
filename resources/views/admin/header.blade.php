<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT Bintang Cakra Kencana">
    <meta name="author" content="Kurniawan E. Yulianto">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/images/web/bck-icon.png">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/') }}/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/admin/bower_components/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="{{ url('/') }}/admin/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/admin/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css">
    <!-- Chartist CSS -->
    <link href="{{ url('/') }}/admin/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="{{ url('/') }}/admin/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Page CSS -->
    <link href="{{ url('/') }}/admin/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/admin/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="{{ url('/') }}/admin/bower_components/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <!-- Animation CSS -->
    <link href="{{ url('/') }}/admin/css/animate.css" rel="stylesheet" type="text/css">
    <!-- morris CSS -->
    <link href="{{ url('/') }}/admin/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/admin/css/style.css" rel="stylesheet" type="text/css">
    <!-- Color CSS -->
    <link href="{{ url('/') }}/admin/css/colors/default.css" id="theme" rel="stylesheet" type="text/css">
    <!-- Toast CSS -->
    <link href="{{ url('/') }}/admin/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="//malsup.github.com/jquery.form.js"></script>
</head>

<body class="fix-header">
    @include('sweetalert::alert')
    {{-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{{ url('/') }}">
                        <!-- Logo icon image, you can use font-icon also -->
                        <b>
                            <!--This is dark logo icon--><img src="{{ url('/') }}/images/web/menu-icon.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="{{ url('/') }}/images/web/menu-icon.png" alt="home" class="light-logo" />
                        </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="{{ url('/') }}/images/web/simqu-header-small.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="{{ url('/') }}/images/web/simqu-header-small.png" alt="home" class="light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        {{-- <form role="search" class="app-search hidden-sm hidden-xs m-r-10"><input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form> --}}
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ url('/') }}/images/users/{{ session()->get('picture') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ session()->get('nama_user') }}</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ url('/') }}/images/users/{{ session()->get('picture') }}" alt="user" /></div>
                                    <div class="u-text" style="width: 65%">
                                        <h4 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ session()->get('nama_user') }}</h4>
                                        @if (session()->get('user_default') == 0 )
                                            <span class="label label-rouded label-danger">Administrator</span>
                                        @else 
                                            <span class="label label-rouded label-info">Master</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/change-password/{{ Crypt::encrypt(session()->get('user_id')) }}"><i class="ti-settings"></i> Change Password</a></li>
                            <li><a href="/auth-logout/{{ Crypt::encrypt(session()->get('user_id')) }}"><i class=" ti-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation Menu</span></h3> 
                </div>
                
                <ul class="nav" id="side-menu">
                    <li>
                        @if($menu == 'dashboard')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard</span></a>
                        @else 
                            <a href="/dashboard" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu"> Dashboard</span></a>
                        @endif
                    </li>
                    
                    <li> 
                        @if($menu == 'master')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-database-plus fa-fw"></i> <span class="hide-menu">Master Data<span class="fa arrow"></span></span></a>
                        @else
                            <a href="#" class="waves-effect"><i class="mdi mdi-database-plus fa-fw"></i> <span class="hide-menu">Master Data<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/defect"><i class="mdi mdi-clipboard-check fa-fw"></i> <span class="hide-menu">Defect</span></a></li>
                            <li><a href="/mesin"><i class="mdi mdi-washing-machine fa-fw"></i> <span class="hide-menu">Mesin</span></a></li>
                            <li><a href="/department"><i class="mdi mdi-account-network fa-fw"></i> <span class="hide-menu">Departemen</span></a></li>
                            <li><a href="/subdepartment"><i class="mdi mdi-account-multiple-plus fa-fw"></i> <span class="hide-menu">Sub Departemen</span></a></li>
                            <li><a href="/periode"><i class="mdi mdi-calendar fa-fw"></i> <span class="hide-menu">Periode</span></a></li>
                            <li><a href="/users"><i class="mdi mdi-account fa-fw"></i> <span class="hide-menu">Users</span></a></li>
                            <li><a href="/inspeksiheader"><i class="mdi mdi-yeast fa-fw"></i> <span class="hide-menu">Inspeksi Header</span></a></li>

                        </ul>
                    </li>

                    <li>
                        @if($menu == 'company')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-factory fa-fw"></i> <span class="hide-menu">Company<span class="fa arrow"></span></span></a>
                        @else 
                            <a href="#" class="waves-effect"><i class="mdi mdi-factory fa-fw"></i> <span class="hide-menu">Company<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            {{-- <li><a href="/info"><i class="mdi mdi-information-outline fa-fw"></i> <span class="hide-menu">Information</span></a></li> --}}
                            {{-- <li><a href="/about"><i class="mdi mdi-star fa-fw"></i> <span class="hide-menu">About Us</span></a></li> --}}
                            <li><a href="/banners"><i class="mdi mdi-file-image fa-fw"></i> <span class="hide-menu">Banners</span></a></li>
                        </ul>
                    </li>

                    <li> 
                        @if($menu == 'events')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-trophy fa-fw"></i> <span class="hide-menu"> Events Gallery</span></a>
                        @else 
                            <a href="/events" class="waves-effect"><i class="mdi mdi-trophy fa-fw"></i> <span class="hide-menu"> Events Gallery</span></a>
                        @endif
                    </li>

                    <li> 
                        @if($menu == 'subscriber')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-gmail fa-fw"></i> <span class="hide-menu"> Subscriber</span></a>
                        @else 
                            <a href="/subscriber" class="waves-effect"><i class="mdi mdi-gmail fa-fw"></i> <span class="hide-menu"> Subscriber</span></a>
                        @endif
                    </li>

                    <li> 
                        @if($menu == 'catalog')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu"> Catalog Files</span></a>
                        @else 
                            <a href="/catalog" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu"> Catalog Files</span></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->

        <div id="page-wrapper">
        
        @yield('content')