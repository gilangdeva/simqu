@extends('admin.header')
@section('title', 'Tot. Inspeksi / Departemen - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-sm-8">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('report.inspeksi') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-3">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen">
                            @else
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($select_dept))
                                        <option value="{{ $dept->nama_departemen }}" {{ old("nama_departemen", $select_dept) == $dept->nama_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->nama_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control select2" name="bulan" id="bulan">
                                <option value="0">Pilih Bulan</option>
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

                        <div class="col-sm-3">
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
                        <h3 class="box-title">REPORT TOTAL INSPEKSI  |  <b style="color: red"> DEPT :
                            @if(isset($select_dept))
                                {{ $select_dept }} / {{ $bulan }} {{ $f_tahun }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table id="demo-foo" class="table m-b-0 toggle-arrow-tiny inspeksi-list">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Periode</th>
                            <th>Tgl Awal</th>
                            <th>Tgl Akhir</th>
                            <th>Inline</th>
                            <th>% Inline</th>
                            <th>Final</th>
                            <th>% Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_inspeksi[0]))
                            @for ($i = 0; $i < count($report_inspeksi); $i++)
                                <tr height="-10px;">
                                    <tr height="-10px;">
                                        <td>{{ $i+1 }}</td>
                                        <td>Minggu Ke-{{ $report_inspeksi[$i]->minggu_ke }}</td>
                                        <td>{{ date('d/m/Y', strtotime($report_inspeksi[$i]->tgl_mulai_periode)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($report_inspeksi[$i]->tgl_akhir_periode)) }}</td>
                                        <td>{{ $report_inspeksi[$i]->inline }}</td>
                                        <td>{{ $report_inspeksi[$i]->persen_inline }}%</td>
                                        <td>{{ $report_inspeksi[$i]->final }}</td>
                                        <td>{{ $report_inspeksi[$i]->persen_final }}%</td>
                                    </tr>
                                </tr>
                            @endfor

                            @foreach($report_summary as $s)
                                <tr style="background-color: #F2F2F2; font-weight:bold;">
                                    <td colspan="4" align="center" style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">Total</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->inline }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ number_format(($s->persen_inline), 2,'.','.')  }}%</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->final }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ number_format(($s->persen_final), 2,'.','.')  }}%</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12">Tidak ada data untuk ditampilkan</td>
                            </tr>
                        @endif
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="text-right">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
           <div class="white-box">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="box-title">Grafik Total Inspeksi</h3>
                        <ul class="list-inline text-right">
                            <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Inline</h5> </li>
                            <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Final</h5> </li>
                        </ul>
                        <div>
                            <div id="morris-inspeksi"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
@include('admin.footer')

<script>
    var graf_ins = @json(json_encode($graf_ins));

    $(document).ready(function () {
        // Morris Final
        Morris.Bar({
            element: 'morris-inspeksi',
            data: JSON.parse(graf_ins),
            xkey: 'week',
            ykeys: ['inline', 'final'],
            labels: ['Inline', 'Final'],
            barColors:['#b8edf0', '#b4c1d7'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
    });
</script>

@endsection
