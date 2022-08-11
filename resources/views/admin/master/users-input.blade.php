@extends('admin.header')
@section('title', 'Input Users - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA PENGGUNA</h3>
                <form class="form-horizontal" action="{{ route('users.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">NIK</label>
                        <div class="col-sm-9">
                            @if (isset($select))
                                <input type="text" class="form-control" name="kode_user" maxlength="8" value="{{ $select->kode_user }}" required>
                            @else
                                <input type="text" class="form-control" name="kode_user" maxlength="8" placeholder="NIK" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            @if (isset($select))
                                <input type="text" class="form-control" name="nama_user" maxlength="20" value="{{ $select->nama_user }}" required>
                            @else
                                <input type="text" class="form-control" name="nama_user" maxlength="20" placeholder="Nama Lengkap" required>    
                            @endif
                            
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            @if (isset($select))
                                <input type="email" class="form-control" name="email" maxlength="150" value="{{ $select->email }}" required>
                            @else
                                <input type="email" class="form-control" name="email" maxlength="150" placeholder="Email" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" maxlength="20" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Jenis Pengguna</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="jenis_user" required>

                                @if (isset($select))
                                    <option>Pilih Jenis Pengguna</option>
                                    <option value="Inspektor" {{ old('jenis_user', $select->jenis_user) == 'Inspektor' ? 'selected':''}}>Inspektor</option>
                                    <option value="Manager" {{ old('jenis_user', $select->jenis_user) == 'Manager' ? 'selected':''}}>Manager</option>
                                    <option value="Administrator" {{ old('jenis_user', $select->jenis_user) == 'Administrator' ? 'selected':''}}>Administrator</option>    
                                @else
                                    <option>Pilih Jenis Pengguna</option>
                                    <option value="Inspektor">Inspektor</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Administrator">Administrator</option>    
                                @endif
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                                <option>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($select->id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old("id_departemen", $select->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Sub Dept</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required>
                                @if(isset($sub_dept))
                                    <option value="">Pilih Sub Departemen</option>
                                    @foreach ($sub_dept as $s)
                                        <option value="{{ $s->id_sub_departemen }}">{{ $s->nama_sub_departemen }}</option>
                                    @endforeach
                                @else
                                    <option value="">Pilih Sub Departemen</option>
                                @endif
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
