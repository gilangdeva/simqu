@extends('admin.header')
@section('title', 'Edit Sub Department - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">EDIT DATA SUB DEPARTEMEN</h3>
                <form class="form-horizontal" action="{{ route('subdepartment.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Departemen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value='0'>Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $subdepartment->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4">Kode Sub Departemen</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_sub_departemen" value="{{ $subdepartment->id_sub_departemen }}" readonly autocomplete="false">
                            <input type="text" class="form-control" name="kode_sub_departemen" maxlength="3" placeholder="Kode Sub Departemen" value="{{ $subdepartment->kode_sub_departemen }}" readonly required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4">Nama Sub Departemen</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="original_nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" value="{{ $subdepartment->nama_sub_departemen }}" required>
                            <input type="text" class="form-control" name="nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" value="{{ $subdepartment->nama_sub_departemen }}" required>
                            <input type="hidden" class="form-control" name="original_nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" value="{{ $subdepartment->nama_sub_departemen }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/subdepartment"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
