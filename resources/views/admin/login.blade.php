<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT Solo Murni">
    <meta name="author" content="HRBA">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>Login - PT Solo Murni</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/') }}/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ url('/') }}/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/admin/css/style.css" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ url('/') }}/admin/css/colors/default.css" id="theme"  rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="new-login-register">
        <div class="lg-info-panel">
            <div class="inner-panel">
                <a href="/" class="p-20 di"><img src="{{ url('/') }}/images/web/simqu-title-white.png""></a>
                <div class="lg-content">
                    <h2>PANEL ADMINISTRASI<br><b>SISTEM INFORMASI MANAGEMENT QUALITY CONTROL</b></h2>
                    <p class="text-muted">SIMQU - Modul Inspeksi <br> Copyright &copy; 2022 - PT. Bintang Cakra Kencana </p>
                    <a href="/" class="btn btn-rounded btn-danger p-l-20 p-r-20">Bantuan</a>
                </div>
            </div>
        </div>
        <div class="new-login-box">
            <div class="white-box">
                <div align="center">
                    <img src="{{ url('/') }}/images/web/logo-kiky.png" width="85px" height="auto">
                </div>
                <h3 class="box-title m-b-0">HALAMAN LOGIN</h3>
                <small>Mohon Masukkan Informasi Akun Valid Anda</small>
                    
                <form class="form-horizontal new-lg-form" id="loginform" action="{{ route('auth.login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group  m-t-20">
                        <div class="col-xs-12">
                            <label>NIK</label>
                            <input class="form-control" type="text" name="kode_user" required="" autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" required="" autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12" style="padding-bottom:20px;">
                            <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Login</button>
                        </div>
                        
                        <div class="col-xs-12" align="center">
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-center"><i class="fa fa-lock m-r-5"></i> Lupa Password?</a>
                        </div>
                    </div>
                </form>

                <form class="form-horizontal" id="recoverform" action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Reset Password</h3>
                            <p class="text-muted">Enter your email registered in system to receive reset code!</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button><br><br>
                            <a href="/panel" id="to-recover" class="text-dark pull-center"><i class="fa fa-sign-in m-r-5"></i> Login Form</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>                   
    </section>

    <!-- jQuery -->
    <script src="{{ url('/') }}/admin/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('/') }}/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ url('/') }}/admin/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ url('/') }}/admin/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ url('/') }}/admin/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ url('/') }}/admin/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="{{ url('/') }}/admin/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
