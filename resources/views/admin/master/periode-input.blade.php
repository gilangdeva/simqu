@extends('admin.header')
@section('title', 'Input Periode - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-7">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA PERIODE</h3>
                <form class="form-horizontal" action="{{ route('periode.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tahun</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="tahun" maxlength="10" placeholder="Tahun" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Bulan</label>
                        <div class="col-sm-8">
                            <select id="bulan" class="form-control select2" name="bulan" maxlength="20" required>
                                <option value="0">Pilih Bulan</option>
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

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Minggu Ke</label>
                        <div class="col-sm-8">
                            <select id="minggu_ke" class="form-control select2" name="minggu_ke" maxlength="20" required>
                                <option value="0">Pilih Minggu</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tanggal Mulai Periode</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="150" placeholder="Tanggal Mulai" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tanggal Akhir Periode</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="150" placeholder="Tanggal Akhir" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
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
