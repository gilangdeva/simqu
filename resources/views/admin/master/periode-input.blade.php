@extends('admin.header')
@section('title', 'Input Periode - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT PERIODE DATA</h3>
                <form class="form-horizontal" action="{{ route('periode.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">Tahun</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="tahun" maxlength="10" placeholder="Tahun" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Bulan</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="bulan" maxlength="20" placeholder="Bulan" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Minggu Ke</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="minggu_ke" maxlength="150" placeholder="Minggu Ke" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Tanggal Mulai Periode</label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="150" placeholder="Tanggal Mulai" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Tanggal Akhir Periode</label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="150" placeholder="Tanggal Akhir" required> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/periode"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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