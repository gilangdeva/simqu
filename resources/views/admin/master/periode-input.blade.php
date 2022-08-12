@extends('admin.header')
@section('title', 'Input Periode - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-3">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA PERIODE</h3>
                <form class="form-horizontal" action="{{ route('periode.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tahun</label>
                        <div class="col-sm-8">
                            @if (isset($select))
                                <input type="number" class="form-control" name="tahun" maxlength="10" min="2022" max="2050" value="{{ $select->tahun }}" required>
                            @else
                                <input type="number" class="form-control" name="tahun" maxlength="10" min="2022" max="2050" placeholder="Tahun" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Bulan</label>
                        <div class="col-sm-8">
                            <select id="bulan" class="form-control select2" name="bulan" maxlength="20" required>
                                <option value="0">Pilih Bulan</option>
                                @if (isset($select))
                                    <option value="Januari" {{ old('bulan', $select->bulan) == "Januari" ? 'selected':''}}>JANUARI</option>
                                    <option value="Februari" {{ old('bulan', $select->bulan) == "Februari" ? 'selected':''}}>FEBRUARI</option>
                                    <option value="Maret" {{ old('bulan', $select->bulan) == "Maret" ? 'selected':''}}>MARET</option>
                                    <option value="April" {{ old('bulan', $select->bulan) == "April" ? 'selected':''}}>APRIL</option>
                                    <option value="Mei" {{ old('bulan', $select->bulan) == "Mei" ? 'selected':''}}>MEI</option>
                                    <option value="Juni" {{ old('bulan', $select->bulan) == "Juni" ? 'selected':''}}>JUNI</option>
                                    <option value="Juli" {{ old('bulan', $select->bulan) == "Juli" ? 'selected':''}}>JULI</option>
                                    <option value="Agustus" {{ old('bulan', $select->bulan) == "Agustus" ? 'selected':''}}>AGUSTUS</option>
                                    <option value="September" {{ old('bulan', $select->bulan) == "September" ? 'selected':''}}>SEPTEMBER</option>
                                    <option value="Oktober" {{ old('bulan', $select->bulan) == "Oktober" ? 'selected':''}}>OKTOBER</option>
                                    <option value="November" {{ old('bulan', $select->bulan) == "November" ? 'selected':''}}>NOVEMBER</option>
                                    <option value="Desember" {{ old('bulan', $select->bulan) == "Desember" ? 'selected':''}}>DESEMBER</option>    
                                @else
                                    <option value="Januari">JANUARI</option>
                                    <option value="Februari">FEBRUARI</option>
                                    <option value="Maret">MARET</option>
                                    <option value="April">APRIL</option>
                                    <option value="Mei">MEI</option>
                                    <option value="Juni">JUNI</option>
                                    <option value="Juli">JULI</option>
                                    <option value="Agustus">AGUSTUS</option>
                                    <option value="September">SEPTEMBER</option>
                                    <option value="Oktober">OKTOBER</option>
                                    <option value="November">NOVEMBER</option>
                                    <option value="Desember">DESEMBER</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Minggu Ke</label>
                        <div class="col-sm-8">
                            <select id="minggu_ke" class="form-control select2" name="minggu_ke" maxlength="20" required>
                                <option value="0">Pilih Minggu</option>
                                @if (isset($select))
                                    <option value="1" {{ old('minggu_ke', $select->minggu_ke) == "1" ? 'selected':''}}>1</option>
                                    <option value="2" {{ old('minggu_ke', $select->minggu_ke) == "2" ? 'selected':''}}>2</option>
                                    <option value="3" {{ old('minggu_ke', $select->minggu_ke) == "3" ? 'selected':''}}>3</option>
                                    <option value="4" {{ old('minggu_ke', $select->minggu_ke) == "4" ? 'selected':''}}>4</option>
                                    <option value="5" {{ old('minggu_ke', $select->minggu_ke) == "5" ? 'selected':''}}>5</option>
                                @else
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tgl Mulai</label>
                        <div class="col-sm-8">
                            @if (isset($select))
                                <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="150" value="{{ date('Y-m-d', strtotime($select->tgl_mulai_periode)) }}" required>
                            @else
                                <input type="date" class="form-control" name="tgl_mulai_periode" maxlength="150" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tgl Akhir</label>
                        <div class="col-sm-8">
                            @if (isset($select))
                                <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="150" value="{{ date('Y-m-d', strtotime($select->tgl_akhir_periode)) }}" required>                                
                            @else
                                <input type="date" class="form-control" name="tgl_akhir_periode" maxlength="150" required>
                            @endif
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

