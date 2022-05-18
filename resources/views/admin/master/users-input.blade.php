@extends('admin.header')
@section('title', 'Input Users - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA PENGGUNA</h3>
                <form class="form-horizontal" action="{{ route('users.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">NIK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="kode_user" maxlength="10" placeholder="NIK" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_user" maxlength="20" placeholder="Nama Lengkap" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" maxlength="150" placeholder="Email" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Jenis Pengguna</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="jenis_user" required>
                                <option>Pilih Jenis Pengguna</option>
                                <option value="Inspektor">Inspektor</option>
                                <option value="Manager">Manager</option>
                                <option value="Administrator">Administrator</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                                <option>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Sub Dept</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required>
                                {{-- <option>Pilih Sub Departemen</option>
                                @foreach ($subdepartemen as $subdept)
                                    <option value="{{ $subdept->id_sub_departemen }}">{{ $subdept->nama_sub_departemen }}</option>
                                @endforeach --}}
                                <option selected>Pilih Sub Departemen</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Foto Profil</label>
                        <div class="col-sm-9">
                            <input type="file" id="input-file-now-custom-2" name="picture" class="dropify" data-height="130" />
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

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/users-sub/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_sub_departemen"]').empty();
                            $('select[name="id_sub_departemen"]').append('<option value="0" selected>Pilih Sub Departemen</option>');
                            // Remove options
                            $('#id_sub_departemen').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_sub_departemen"]').append('<option value="'+ data[i].id_sub_departemen +'">'+ data[i].nama_sub_departemen +'</option>');
                            };
                        } else {
                            $('select[name="id_sub_departemen"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_sub_departemen"]').empty();
            }
        });
    });
</script>

@endsection