@extends('admin.header')
@section('title', 'Edit Departemen - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">EDIT DATA DEPARTMENT</h3>
                <form class="form-horizontal" action="{{ route('department.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Kode Departemen</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_departemen" value="{{ $department->id_departemen }}" readonly autocomplete="false">
                            <input type="text" class="form-control" name="kode_departemen" maxlength="3" placeholder="Kode Departemen" value="{{ $department->kode_departemen }}" readonly required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Nama Departemen</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="original_nama_departemen" maxlength="20" placeholder="Nama Departemen" value=" {{ $department->nama_departemen }}" required>
                            <input type="text" class="form-control" name="nama_departemen" maxlength="20" placeholder="Nama Departemen" value="{{ $department->nama_departemen }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/department"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
