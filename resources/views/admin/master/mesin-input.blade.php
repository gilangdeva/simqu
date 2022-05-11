@extends('admin.header')
@section('title', 'Input Mesin - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT MESIN DATA</h3>
                <form class="form-horizontal" action="{{ route('mesin.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-12">ID Departemen</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="id_departemen" maxlength="20" placeholder="ID Departemen" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">ID Sub Departemen</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="id_sub_departemen" maxlength="20" placeholder="ID Sub Departemen" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Kode Mesin</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="kode_mesin" maxlength="10" placeholder="Kode Mesin" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Nama Mesin</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="nama_mesin" maxlength="20" placeholder="Nama Mesin" required> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/mesin"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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