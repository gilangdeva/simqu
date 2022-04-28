@extends('admin.header')
@section('title', 'Edit Periode - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">EDIT PERIODE DATA</h3>
                <form class="form-horizontal" action="{{ route('periode.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-12">Tahun</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_periode" value="{{ $periode->id_periode }}" readonly autocomplete="false">                         
                            <input type="text" class="form-control" name="tahun" maxlength="20" placeholder="Tahun" value="{{ $periode->tahun }}" required> 
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-md-12">Bulan</label>
                        <div class="col-md-12">
                            <select id="bulan" class="form-control" name="bulan" maxlength="20" required>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Minggu Ke</label>
                        <div class="col-md-12">
                            <select id="minggu_ke" class="form-control" name="minggu_ke" maxlength="20" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Tanggal Mulai Periode</label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="20" placeholder="Tanggal Mulai Periode" value="{{ $periode->tgl_mulai_periode }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Tanggal Akhir Periode</label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="20" placeholder="Tanggal Akhir Periode" value="{{ $periode->tgl_akhir_periode }}" required> 
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