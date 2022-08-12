<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT Bintang Cakra Kencana">
    <meta name="author" content="Kurniawan E. Yulianto">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/images/web/logo-kiky.png">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/') }}/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/admin/bower_components/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="{{ url('/') }}/admin/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/admin/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css">

    <!--My admin Custom CSS -->
    <link href="{{ url('/') }}/admin/bower_components/owl.carousel/owl.carousel.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/admin/bower_components/owl.carousel/owl.theme.default.css" rel="stylesheet" type="text/css" />

    <!-- Chartist CSS -->
    <link href="{{ url('/') }}/admin/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/chartist-js/dist/chartist-init.css" rel="stylesheet">
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
    <!-- Footable CSS -->
    <link href="{{ url('/') }}/admin/bower_components/footable/css/footable.core.css" rel="stylesheet">
    <link href="{{ url('/') }}/admin/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

    <style>
        input:focus {
            background-color: #f6f6f6;
        }

        input:hover {
            background-color: #f6f6f6;
        }

        .form-control:focus,
        .sp-page-root .form-control:focus {
            border-color: #f74949;
            outline: none;
            -webkit-box-shadow: 0 0 5px #f74949;
            box-shadow: 0 0 5px #f74949;
        }
        .select2-container.select2-container-active {
            outline: 5px auto #f74949;
            border-color: #f74949;
            box-shadow: 0 0 5px #f74949;
            outline-offset: -2px;
        }
        .select2-container-active .select2-choice {
            border-color: #f74949;
        }
        .select2-results .select2-highlighted {
            background: #f74949;
            color: #fff;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <style>
        input:focus {
            background-color: #f6f6f6;
        }

        input:hover {
            background-color: #f6f6f6;
        }

        .form-control:focus,
        .sp-page-root .form-control:focus {
            border-color: #f74949;
            outline: none;
            -webkit-box-shadow: 0 0 5px #f74949;
            box-shadow: 0 0 5px #f74949;
        }
        .select2-container.select2-container-active {
            outline: 5px auto #f74949;
            border-color: #f74949;
            box-shadow: 0 0 5px #f74949;
            outline-offset: -2px;
        }
        .select2-container-active .select2-choice {
            border-color: #f74949;
        }
        .select2-results .select2-highlighted {
            background: #f74949;
            color: #fff;
        }
    </style>
</head>

<body class="fix-header" onload="loadHours()">
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
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ url('/') }}/images/users/{{ session()->get('picture') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ session()->get('nama_user') }}</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ url('/') }}/images/users/{{ session()->get('picture') }}" alt="user" /></div>
                                    <div class="u-text" style="width: 65%">
                                        <h4 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ session()->get('nama_user') }}</h4>
                                        <span class="label label-rouded label-danger">{{ session()->get('jenis_user') }}</span>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/change-password/{{ Crypt::encrypt(session()->get('id_user')) }}"><i class="ti-lock"></i> Ubah Password</a></li>
                            <li><a href="/auth-logout/{{ Crypt::encrypt(session()->get('id_user')) }}"><i class=" ti-power-off"></i> Logout</a></li>
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
    @if ($jenis_user == 'Administrator')
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
                            <li><a href="/satuan"><i class="mdi mdi-ruler fa-fw"></i> <span class="hide-menu">Satuan</span></a></li>
                            <li><a href="/defect"><i class="mdi mdi-clipboard-check fa-fw"></i> <span class="hide-menu">Defect</span></a></li>
                            <li><a href="/mesin"><i class="mdi mdi-washing-machine fa-fw"></i> <span class="hide-menu">Mesin</span></a></li>
                            <li><a href="/department"><i class="mdi mdi-account-network fa-fw"></i> <span class="hide-menu">Departemen</span></a></li>
                            <li><a href="/subdepartment"><i class="mdi mdi-account-multiple-plus fa-fw"></i> <span class="hide-menu">Sub Departemen</span></a></li>
                            <li><a href="/periode"><i class="mdi mdi-calendar fa-fw"></i> <span class="hide-menu">Periode</span></a></li>
                            <li><a href="/aql"><i class="mdi mdi-counter fa-fw"></i> <span class="hide-menu">AQL</span></a></li>
                            <li><a href="/users"><i class="mdi mdi-account fa-fw"></i> <span class="hide-menu">Users</span></a></li>
                        </ul>
                    </li>

                    <li>
                        @if($menu == 'inspeksi')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-magnify fa-fw"></i> <span class="hide-menu"> Inspeksi<span class="fa arrow"></span></span></a>
                        @else
                            <a href="/inspeksi" class="waves-effect"><i class="mdi mdi-magnify fa-fw"></i> <span class="hide-menu"> Inspeksi<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/inline"><i class="mdi mdi-sync fa-fw"></i> <span class="hide-menu">Inline</span></a></li>
                            <li><a href="/final"><i class="mdi mdi-wallet-giftcard fa-fw"></i> <span class="hide-menu">Final</span></a></li>
                            <li><a href="/approval"><i class="mdi mdi-check fa-fw"></i> <span class="hide-menu">Approval</span></a></li>
                        </ul>
                    </li>

                    <li>
                        @if($menu == 'upload')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-upload fa-fw"></i> <span class="hide-menu"> Upload Data<span class="fa arrow"></span></span></a>
                        @else
                            <a href="/upload" class="waves-effect"><i class="mdi mdi-upload fa-fw"></i> <span class="hide-menu"> Upload Data<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/jop"><i class="mdi mdi-ticket-confirmation fa-fw"></i> <span class="hide-menu">JOP Edar</span></a></li>
                        </ul>
                    </li>

                    <li>
                        @if($menu == 'laporan')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu">Report<span class="fa arrow"></span></span></a>
                        @else
                            <a href="#" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu">Report<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/report-defect"><i class="mdi mdi-comment-check-outline fa-fw"></i> <span class="hide-menu">Tot. Kriteria / Dept</span></a></li>
                            <li><a href="/report-inspeksi"><i class="mdi mdi-numeric fa-fw"></i> <span class="hide-menu">Tot. Inspek / Dept</span></a></li>
                            <li><a href="/report-critical"><i class="mdi mdi-magnify-minus-outline fa-fw"></i> <span class="hide-menu">Tot. Critical / Dept</span></a></li>
                            <li><a href="/report-qty-defect"><i class="mdi mdi-file-chart fa-fw"></i> <span class="hide-menu">Tot. Defect / Dept</span></a></li>
                            <li><a href="/report-reject"><i class="mdi mdi-basket-unfill fa-fw"></i> <span class="hide-menu">Rekap Reject / Dept</span></a></li>
                            <li><a href="/rekap-inspeksi"><i class="mdi mdi-book fa-fw"></i> <span class="hide-menu">Rekap Inspek / Thn</span></a></li>
                            <li><a href="/report-historical-jop"><i class="mdi mdi-timer-sand fa-fw"></i> <span class="hide-menu">Historical JOP</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    @elseif($jenis_user == 'Inspektor')
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
                        @if($menu == 'inspeksi')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-magnify fa-fw"></i> <span class="hide-menu"> Inspeksi<span class="fa arrow"></span></span></a>
                        @else
                            <a href="/inspeksi" class="waves-effect"><i class="mdi mdi-magnify fa-fw"></i> <span class="hide-menu"> Inspeksi<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/inline"><i class="mdi mdi-sync fa-fw"></i> <span class="hide-menu">Inline</span></a></li>
                            <li><a href="/final"><i class="mdi mdi-wallet-giftcard fa-fw"></i> <span class="hide-menu">Final</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    @else
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
                        @if($menu == 'laporan')
                            <a href="{{ $sub }}" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu">Report<span class="fa arrow"></span></span></a>
                        @else
                            <a href="#" class="waves-effect"><i class="mdi mdi-book-open-page-variant fa-fw"></i> <span class="hide-menu">Report<span class="fa arrow"></span></span></a>
                        @endif
                        <ul class="nav nav-second-level">
                            <li><a href="/report-defect"><i class="mdi mdi-comment-check-outline fa-fw"></i> <span class="hide-menu">Tot. Kriteria / Dept</span></a></li>
                            <li><a href="/report-inspeksi"><i class="mdi mdi-numeric fa-fw"></i> <span class="hide-menu">Tot. Inspek / Dept</span></a></li>
                            <li><a href="/report-critical"><i class="mdi mdi-magnify-minus-outline fa-fw"></i> <span class="hide-menu">Tot. Critical / Dept</span></a></li>
                            <li><a href="/report-qty-defect"><i class="mdi mdi-file-chart fa-fw"></i> <span class="hide-menu">Tot. Defect / Dept</span></a></li>
                            <li><a href="/report-reject"><i class="mdi mdi-basket-unfill fa-fw"></i> <span class="hide-menu">Rekap Reject / Dept</span></a></li>
                            <li><a href="/rekap-inspeksi"><i class="mdi mdi-book fa-fw"></i> <span class="hide-menu">Rekap Inspek / Thn</span></a></li>
                            <li><a href="/report-historical-jop"><i class="mdi mdi-timer-sand fa-fw"></i> <span class="hide-menu">Historical JOP</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    @endif
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->

        <div id="page-wrapper">

        @yield('content')
