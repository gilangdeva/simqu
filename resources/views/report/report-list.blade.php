@extends('admin.header')
@section('title', 'Tot. Kriteria / Departemen - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-sm-8">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('report.filter') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-md-3">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @else
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option value="">PILIH DEPARTEMEN</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($select_dept))
                                        <option value="{{ $dept->nama_departemen }}" {{ old("nama_departemen", $select_dept) == $dept->nama_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->nama_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select class="form-control select2" name="bulan" id="bulan" required>
                                <option value="">PILIH BULAN</option>
                                <option value="JANUARI" {{ old('bulan', $bulan) == "JANUARI" ? 'selected':''}}>JANUARI</option>
                                <option value="FEBRUARI" {{ old('bulan', $bulan) == "FEBRUARI" ? 'selected':''}}>FEBRUARI</option>
                                <option value="MARET" {{ old('bulan', $bulan) == "MARET" ? 'selected':''}}>MARET</option>
                                <option value="APRIL" {{ old('bulan', $bulan) == "APRIL" ? 'selected':''}}>APRIL</option>
                                <option value="MEI" {{ old('bulan', $bulan) == "MEI" ? 'selected':''}}>MEI</option>
                                <option value="JUNI" {{ old('bulan', $bulan) == "JUNI" ? 'selected':''}}>JUNI</option>
                                <option value="JULI" {{ old('bulan', $bulan) == "JULI" ? 'selected':''}}>JULI</option>
                                <option value="AGUSTUS" {{ old('bulan', $bulan) == "AGUSTUS" ? 'selected':''}}>AGUSTUS</option>
                                <option value="SEPTEMBER" {{ old('bulan', $bulan) == "SEPTEMBER" ? 'selected':''}}>SEPTEMBER</option>
                                <option value="OKTOBER" {{ old('bulan', $bulan) == "OKTOBER" ? 'selected':''}}>OKTOBER</option>
                                <option value="NOVEMBER" {{ old('bulan', $bulan) == "NOVEMBER" ? 'selected':''}}>NOVEMBER</option>
                                <option value="DESEMBER" {{ old('bulan', $bulan) == "DESEMBER" ? 'selected':''}}>DESEMBER</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            @if(isset($f_tahun))
                            <select class="form-control select2" name="tahun" id="tahun">
                            @else
                            <select class="form-control select2" name="tahun" id="tahun" required>
                            @endif
                                <option value="0">Pilih Tahun</option>
                                @foreach ($list_tahun as $lt)
                                    @if(isset($select_tahun))
                                        <option value="{{ $lt->tahun }}" {{ old("tahun", $select_tahun) == $lt->tahun ? 'selected':''}}>{{ $lt->tahun }}</option>
                                    @else
                                        <option value="{{ $lt->tahun }}">{{ $lt->tahun }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="button-box">
                                <button type="submit" name="action" value="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-search"></i></button>
                                <button type="submit" name="action" value="export_pdf" href="/ReportInspeksiPDF" class="btn btn-info waves-effect waves-light" target="_blank"><i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REPORT INSPEKSI INLINE   |   <b style="color: red">DEPT :
                            @if(isset($select_dept) && isset($bulan))
                                {{ $select_dept }} / {{ $bulan }} {{ $tahun }}</b></h3>
                            @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th data-toggle="true">No.</th>
                                <th>Periode</th>
                                <th data-hide="phone">Tgl Awal</th>
                                <th data-hide="phone">Tgl Akhir</th>
                                <th data-hide="phone">Critical</th>
                                <th data-hide="phone">% Critical</th>
                                <th data-hide="phone">Major</th>
                                <th data-hide="phone">% Major</th>
                                <th data-hide="phone">Minor</th>
                                <th data-hide="phone">% Minor</th>
                                <th style="font-weight: bold;">Total</th>
                                <th style="font-weight: bold;" data-hide="phone">% Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($report_inline[0]))
                                @foreach($report_inline as $ri)
                                    <tr height="-10px;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Minggu Ke-{{ $ri->minggu_ke }}</td>
                                        <td>{{ date('d/m/Y', strtotime($ri->tgl_mulai_periode)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($ri->tgl_akhir_periode)) }}</td>
                                        <td>{{ $ri->critical }}</td>
                                        <td>{{ $ri->persen_critical }}%</td>
                                        <td>{{ $ri->major }}</td>
                                        <td>{{ $ri->persen_major }}%</td>
                                        <td>{{ $ri->minor }}</td>
                                        <td>{{ $ri->persen_minor }}%</td>
                                        <td style="font-weight: bold; color:blue;">{{ $ri->total }}</td>
                                        @if(isset($total_inl))
                                            <td style="font-weight: bold; color:blue;">{{ number_format(($ri->total/$total_inl)*100,2,'.','.')  }}%</td>
                                        @else
                                            <td style="font-weight: bold;">0%</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">Tidak ada data untuk ditampilkan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
             <div class="row">
              <div class="col-sm-12 col-xs-12">
                <h3 class="box-title">Grafik Inspeksi Inline</h3>
                <ul class="list-inline text-right">
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Minor</h5> </li>
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Major</h5> </li>
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #fcc9ba;"></i>Critical</h5> </li>
                </ul>
                <div>
                    <div id="morris-inline"></div>
                </div>
                </div>
             </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REPORT INSPEKSI FINAL   |   <b style="color: red">DEPT :
                            @if(isset($select_dept) && isset($bulan))
                                {{ $select_dept }} / {{ $bulan }} {{ $tahun }}</b></h3>
                            @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Periode</th>
                                <th>Tgl Awal</th>
                                <th>Tgl Akhir</th>
                                <th>Pass</th>
                                <th>% Pass</th>
                                <th>Reject</th>
                                <th>% Reject</th>
                                <th style="font-weight: bold;">Total</th>
                                <th style="font-weight: bold;">% Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($report_final[0]))
                                @foreach($report_final as $fnl)
                                    <tr height="-10px;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Minggu Ke-{{ $fnl->minggu_ke }}</td>
                                        <td>{{ date('d/m/Y', strtotime($fnl->tgl_mulai_periode)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($fnl->tgl_akhir_periode)) }}</td>
                                        <td>{{ $fnl->pass }}</td>
                                        <td>{{ $fnl->persen_pass }}%</td>
                                        <td>{{ $fnl->reject }}</td>
                                        <td>{{ $fnl->persen_reject }}%</td>
                                        <td style="font-weight: bold; color:blue;">{{ $fnl->total }}</td>
                                        @if(isset($total_fnl))
                                            <td style="font-weight: bold; color:blue;">{{ number_format(($fnl->total/$total_fnl)*100,2,'.','.')  }}%</td>
                                        @else
                                            <td style="font-weight: bold; color:blue;">0%</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10">Tidak ada data untuk ditampilkan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
           <div class="white-box">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="box-title">Grafik Inspeksi Final</h3>
                        <ul class="list-inline text-right">
                            <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Pass</h5> </li>
                            <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Reject</h5> </li>
                        </ul>
                        <div>
                            <div id="morris-final"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REPORT KRITERIA   |   <b style="color: red">DEPT :
                            @if(isset($select_dept) && isset($bulan))
                                {{ $select_dept }} / {{ $bulan }} {{ $tahun }}</b></h3>
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th data-toggle="true">No.</th>
                                <th>Periode</th>
                                <th data-hide="phone">Tgl Awal</th>
                                <th data-hide="phone">Tgl Akhir</th>
                                <th data-hide="phone">Critical</th>
                                <th data-hide="phone">% Critical</th>
                                <th data-hide="phone">Major</th>
                                <th data-hide="phone">% Major</th>
                                <th data-hide="phone">Minor</th>
                                <th data-hide="phone">% Minor</th>
                                <th data-hide="phone">Tot.</th>
                                <th>Tot. Smpling</th>
                                <th data-hide="phone">% Sampling</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($report_kriteria[0]))
                                @foreach($report_kriteria as $krt)
                                    <tr height="-10px;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>Minggu Ke-{{ $krt->minggu_ke }}</td>
                                        <td>{{ date('d/m/Y', strtotime($krt->tgl_mulai_periode)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($krt->tgl_akhir_periode)) }}</td>
                                        <td>{{ $krt->critical }}</td>
                                        <td>{{ $krt->persen_critical }}%</td>
                                        <td>{{ $krt->major }}</td>
                                        <td>{{ $krt->persen_major }}%</td>
                                        <td>{{ $krt->minor }}</td>
                                        <td>{{ $krt->persen_minor }}%</td>
                                        <td>{{ $krt->total }}</td>
                                        <td>{{ $krt->qty_riil }}</td>
                                        @if($krt->qty_riil <> '0')
                                            <td style="font-weight: bold; color:blue;">{{ number_format(($krt->total/$krt->qty_riil)*100,2,'.','.')  }}%</td>
                                        @else
                                            <td style="font-weight: bold; color:blue;">0%</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">Tidak ada data untuk ditampilkan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <h3 class="box-title">Grafik Kriteria</h3>
                    <ul class="list-inline text-right">
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Minor</h5> </li>
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Major</h5> </li>
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #fcc9ba;"></i>Critical</h5> </li>
                    </ul>
                    <div>
                        <div id="morris-kriteria"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- end row -->
</div>
</div>
<!-- end container-fluid -->
@include('admin.footer')

<script>

    var graf_inl = @json(json_encode($graf_inl));
    var graf_fnl = @json(json_encode($graf_fnl));
    var graf_krt = @json(json_encode($graf_krt));

    $(document).ready(function () {

        // Morris Inline
        Morris.Bar({
            element: 'morris-inline',
            data: JSON.parse(graf_inl),
            xkey: 'week',
            ykeys: ['minor', 'major', 'critical'],
            labels: ['Minor', 'Major', 'Critical'],
            barColors:['#b8edf0', '#b4c1d7', '#fcc9ba'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });

        // Morris Final
        Morris.Bar({
            element: 'morris-final',
            data: JSON.parse(graf_fnl),
            xkey: 'week',
            ykeys: ['pass', 'reject'],
            labels: ['Pass', 'Reject'],
            barColors:['#b8edf0', '#b4c1d7'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });

        // Morris Keriteria
        Morris.Bar({
            element: 'morris-kriteria',
            data: JSON.parse(graf_krt),
            xkey: 'week',
            ykeys: ['minor', 'major', 'critical'],
            labels: ['Minor', 'Major', 'Critical'],
            barColors:['#b8edf0', '#b4c1d7', '#fcc9ba'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
    });
</script>

@endsection
