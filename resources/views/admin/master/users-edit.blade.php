@extends('admin.header')
@section('title', 'Edit Pengguna - SIMQU')

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
                    
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">NIK</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" name="id_user" value="{{ $users->id_user }}" readonly autocomplete="false"> 
                            <input type="text" class="form-control" name="kode_user" maxlength="10" placeholder="Username" value="{{ $users->kode_user }}" readonly autocomplete="false"> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_user" maxlength="20" placeholder="Complete Name" value="{{ $users->nama_user }}" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Email </i></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" maxlength="150" value="{{ $users->email }}" required> 
                            <input type="hidden" class="form-control" name="original_email" maxlength="150" value="{{ $users->email }}"> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Jenis Pengguna</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="jenis_user" required>
                                <option>Pilih Jenis Pengguna</option>
                                <option value="Inspektor" {{ old('jenis_user', $users->jenis_user) == "Inspektor" ? 'selected':''}}>Inspektor</option>
                                <option value="Manager" {{ old('jenis_user', $users->jenis_user) == "Manager" ? 'selected':''}}>Manager</option>
                                <option value="Administrator" {{ old('jenis_user', $users->jenis_user) == "Administrator" ? 'selected':''}}>Administrator</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value='0'>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $users->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Sub Dept</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_sub_departemen" required>
                                <option value="0">Pilih Sub Departemen</option>
                                @foreach ($subdepartemen as $subdept)
                                    <option value="{{ $subdept->id_sub_departemen }}" {{ old('id_sub_departemen', $users->id_sub_departemen) == $subdept->id_sub_departemen ? 'selected':''}}>{{ $subdept->nama_sub_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Foto Profil</label>
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" name="original_picture" maxlength="150" value="{{ $users->picture }}"> 
                            <input type="file" id="input-file-now-custom-2" class="dropify" data-height="130" name="picture" data-default-file="{{ url('/') }}/images/users/{{ $users->picture }}" />
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
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