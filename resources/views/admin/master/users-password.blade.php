@extends('admin.header')
@section('title', 'Change Password - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">CHANGE PASSWORD</h3>
                <form class="form-horizontal" action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-5 control-label">Password Sekarang</label>
                        <div class="col-sm-7">
                            <input type="hidden" class="form-control" name="id_user" value="{{ $users->id_user }}" required> 
                            <input type="password" class="form-control" name="password" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="new_password" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-5 control-label">Konfirmasi Password</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" name="confirm_password" required> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-5 control-label"></div>
                        <div class="col-sm-7">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/users"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    </div>
<!-- end container-fluid -->

@include('admin.footer')

@endsection