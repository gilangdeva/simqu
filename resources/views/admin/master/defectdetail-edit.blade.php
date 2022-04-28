@extends('admin.header')
@section('title', 'Edit Defect Detail - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA DEFECT DETAIL00</h3>
                <form class="form-horizontal" action="{{ route('defectdetail.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="col-md-12">Kode Defect</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_mesin" value="{{ $defectdetail->id_master_defect_detail }}" readonly autocomplete="false"> 
                            <input type="text" class="form-control" name="kode_defect" maxlength="10" placeholder="Kode Defect" value="{{ $defectdetail->kode_defect }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Nama Defect</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="defect" maxlength="20" placeholder="Nama Defect" value="{{ $defectdetail->defect }}" required> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/defectdetail"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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