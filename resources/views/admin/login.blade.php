<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT Bintang Cakra Kencana">
    <meta name="author" content="Kurniawan E. Yulianto">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/images/web/bck-icon.png">
    <title>Login - PT. Bintang Cakra Kencana</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/') }}/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="{{ url('/') }}/admin/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/admin/css/style.css" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ url('/') }}/admin/css/colors/default.css" id="theme"  rel="stylesheet">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script src="//malsup.github.com/jquery.form.js"></script>
</head>

<body>
    @include('sweet::alert')
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="new-login-register">
        <div class="lg-info-panel">
            <div class="inner-panel">
                <a href="/" class="p-20 di"><img src="{{ url('/') }}/images/web/bck-title-white.png""></a>
                <div class="lg-content">
                    <h2>ADMINISTRATION PANEL<br><b>PT. BINTANG CAKRA KENCANA</b></h2>
                    <p class="text-muted">Official Website of BCKGUNS Digital Catalogue <br> Copyright &copy; 2021 - PT. Bintang Cakra Kencana </p>
                    <a href="/" class="btn btn-rounded btn-danger p-l-20 p-r-20">Home</a>
                </div>
            </div>
        </div>
        <div class="new-login-box">
            <div class="white-box">
                <h3 class="box-title m-b-0">LOGIN PAGE</h3>
                <small>Please insert your valid account information</small>
                    
                <form class="form-horizontal new-lg-form" id="loginform" action="{{ route('auth.login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group  m-t-20">
                        <div class="col-xs-12">
                            <label>Username</label>
                            <input class="form-control" type="text" name="username" required="" autocomplete="false">
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
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-center"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a>
                        </div>
                    </div>
                </form>

                <form class="form-horizontal" id="recoverform" action="{{ route('auth.reset') }}" method="POST">
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
