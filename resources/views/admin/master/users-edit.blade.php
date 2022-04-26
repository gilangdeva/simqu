@extends('admin.header')
@section('title', 'Edit Users - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA PENGGUNA</h3>
                <form class="form-horizontal" action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="col-md-12">NIK</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_user" value="{{ $users->id_user }}" readonly autocomplete="false"> 
                            <input type="text" class="form-control" name="kode_user" maxlength="10" placeholder="Username" value="{{ $users->kode_user }}" readonly autocomplete="false"> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Nama Lengkap</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama_user" maxlength="20" placeholder="Complete Name" value="{{ $users->nama_user }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Email <i>e.g : "rookie@gmail.com"</i></label>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" maxlength="150" value="{{ $users->email }}" required> 
                            <input type="hidden" class="form-control" name="original_email" maxlength="150" value="{{ $users->email }}"> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Foto Profil</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="original_picture" maxlength="150" value="{{ $users->picture }}"> 
                            <input type="file" id="input-file-now-custom-2" class="dropify" data-height="130" name="picture" data-default-file="{{ url('/') }}/images/users/{{ $users->picture }}" />
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