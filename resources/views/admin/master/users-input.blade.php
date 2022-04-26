@extends('admin.header')
@section('title', 'Input Users - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT USERS DATA</h3>
                <form class="form-horizontal" action="{{ route('users.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">NIK</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="kode_user" maxlength="10" placeholder="NIK" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Nama Lengkap</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama_user" maxlength="20" placeholder="Nama Lengkap" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Email <i>contoh : "rookie@gmail.com"</i></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" maxlength="150" placeholder="Email" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Foto Profil</label>
                        <div class="col-md-12">
                            <input type="file" id="input-file-now-custom-2" name="picture" class="dropify" data-height="130" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
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