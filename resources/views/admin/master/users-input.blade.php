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
                            <input type="email" class="form-control" name="email" maxlength="150" placeholder="Email" required>
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
                            <select class="form-control select2" name="departemen" id="departemen" required>
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
                            <select class="form-control form-select-lg" name="SubDept" id="SubDept" required>
                                <option>Pilih Sub Departemen</option>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
$('#departemen').change(function(){
    var deptID = $(this).val();
    if(deptID){
        $.ajax({
           type:"GET",
           url:"/getSubDept?deptID="+deptID,
           dataType: 'JSON',
           success:function(res){
            if(res){
                $("#SubDept").empty();
                $("#SubDept").append('<option>---Pilih Sub Departemen---</option>');
                $.each(res,function(key,value){
                    $("#SubDept").append('<option value="'+key+'">'+value+'</option>');
                });
            }else{
               $("#SubDept").empty();
            }
           }
        });
    }else{
        $("#SubDept").empty();
    }
   });
</script>
@include('admin.footer')

@endsection
