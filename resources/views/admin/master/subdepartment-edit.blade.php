@extends('admin.header')
@section('title', 'Edit Sub Department - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">EDIT SUB-DEPARTMENT DATA</h3>
                <form class="form-horizontal" action="{{ route('subdepartment.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-12">Nama Departemen</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Kode Sub Departemen</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_sub_departemen" value="{{ $subdepartment->id_sub_departemen }}" readonly autocomplete="false">                         
                            <input type="text" class="form-control" name="kode_sub_departemen" maxlength="20" placeholder="Kode ub Departemen" value="{{ $subdepartment->kode_sub_departemen }}" required> 
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-md-12">Nama Sub Departemen</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" value="{{ $subdepartment->nama_sub_departemen }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
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