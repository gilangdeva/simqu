@extends('admin.header')
@section('title', 'Report Inspeksi - SIMQU')

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
                                        <option value="{{ $dept->id_departemen }}" {{ old("id_departemen", $select_dept) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <select class="form-control select2" name="bulan" id="bulan">
                                <option value="0">Pilih Bulan</option>
                                <option value="Januari" {{ old('bulan', $bulan) == "Januari" ? 'selected':''}}>JANUARI</option>
                                <option value="Februari" {{ old('bulan', $bulan) == "Februari" ? 'selected':''}}>FEBRUARI</option>
                                <option value="Maret" {{ old('bulan', $bulan) == "Maret" ? 'selected':''}}>MARET</option>
                                <option value="April" {{ old('bulan', $bulan) == "April" ? 'selected':''}}>APRIL</option>
                                <option value="Mei" {{ old('bulan', $bulan) == "Mei" ? 'selected':''}}>MEI</option>
                                <option value="Juni" {{ old('bulan', $bulan) == "Juni" ? 'selected':''}}>JUNI</option>
                                <option value="Juli" {{ old('bulan', $bulan) == "Juli" ? 'selected':''}}>JULI</option>
                                <option value="Agustus" {{ old('bulan', $bulan) == "Agustus" ? 'selected':''}}>AGUSTUS</option>
                                <option value="September" {{ old('bulan', $bulan) == "September" ? 'selected':''}}>SEPTEMBER</option>
                                <option value="Oktober" {{ old('bulan', $bulan) == "Oktober" ? 'selected':''}}>OKTOBER</option>
                                <option value="November" {{ old('bulan', $bulan) == "November" ? 'selected':''}}>NOVEMBER</option>
                                <option value="Desember" {{ old('bulan', $bulan) == "Desember" ? 'selected':''}}>DESEMBER</option>
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

                        <div class="col-sm-1">
                            <button type="submit" name="action" value="submit" class="btn btn-danger waves-effect pull-right waves-light">Submit</button>
                        </div>

                        <div class="col-sm-1">
                            <button type="submit" name="action" value="export_pdf" href="/ReportInspeksiPDF" class="btn btn-info" target="_blank">Export to PDF</button>
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
                            @if(isset($report_inspeksi[0]))
                                {{ $report_inspeksi[0]->nama_departemen }} / {{ $bulan }} {{ $f_tahun }}
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
                                        <td>{{ $report_inspeksi[$i]->tgl_mulai_periode }}</td>
                                        <td>{{ $report_inspeksi[$i]->tgl_akhir_periode }}</td>
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
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ number_format(($s->persen_inline), 1,'.','.')  }}%</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->final }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ number_format(($s->persen_final), 1,'.','.')  }}%</td>
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
