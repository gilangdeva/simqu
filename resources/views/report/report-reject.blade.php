@extends('admin.header')
@section('title', 'Report Reject - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-sm-8">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('report.reject') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-6">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <button type="submit" name="action" value="submit" class="btn btn-primary waves-effect pull-right waves-light">Submit</button>
                        </div>

                        <div class="col-sm-3">
                            <button type="submit" name="action" value="export_pdf" href="/ReportRejectPDF" class="btn btn-primary" target="_blank">Export to PDF</button>
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
                        <h3 class="box-title">REPORT REKAPITULASI REJECT  |  <b style="color: red"> DEPT :
                            @if(isset($report_reject[0]))
                                {{ $report_reject[0]->nama_departemen }} / {{ $tahun }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table id="demo-foo" class="table m-b-0 toggle-arrow-tiny inspeksi-list">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Bulan</th>
                            <th>Periode</th>
                            <th>Tgl Awal</th>
                            <th>Tgl Akhir</th>
                            <th>Jml Inspeksi</th>
                            <th>Jml Reject</th>
                            <th>Jml Critical</th>
                            <th>Jml Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_reject[0]))
                            @for ($i = 0; $i < count($report_reject); $i++)
                                <tr height="-10px;">
                                    <tr height="-10px;">
                                        <td>{{ $i+1 }}</td>
                                        <td>{{ $report_reject[$i]->bulan }}</td>
                                        <td>Minggu Ke-{{ $report_reject[$i]->minggu_ke }}</td>
                                        <td>{{ $report_reject[$i]->tgl_mulai_periode }}</td>
                                        <td>{{ $report_reject[$i]->tgl_akhir_periode }}</td>
                                        <td>{{ $report_reject[$i]->qty_inspek }}</td>
                                        <td>{{ $report_reject[$i]->qty_reject }}</td>
                                        <td>{{ $report_reject[$i]->qty_critical }}</td>
                                        <td>{{ $report_reject[$i]->qty_defect }}</td>
                                    </tr>
                                </tr>
                            @endfor

                            @foreach($report_summary as $s)
                                <tr style="background-color: #F2F2F2; font-weight:bold;">
                                    <td colspan="5" align="center" style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">Total</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->qty_inspek }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->qty_reject }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->qty_critical }}</td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; color:blue;">{{ $s->qty_defect }}</td>
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
                    <h3 class="box-title">Grafik Reject</h3>
                    <ul class="list-inline text-right">
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Tot. Inspek</h5> </li>
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Tot. Reject</h5> </li>
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #fcc9ba;"></i>Tot. Critical</h5> </li>
                        <li><h5><i class="fa fa-circle m-r-5" style="color: #BB6464;"></i>Tot. Defect</h5> </li>
                    </ul>
                    <div>
                        <div id="morris-reject"></div>
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
    var graf_rej = @json(json_encode($graf_rej));

    $(document).ready(function () {
        // Morris Reject
        Morris.Bar({
            element: 'morris-reject',
            data: JSON.parse(graf_rej),
            xkey: 'bulan',
            ykeys: ['qty_inspek', 'qty_reject', 'qty_critical', 'qty_defect'],
            labels: ['T. Inspek', 'T. Reject', 'T. Critical', 'T. Defect'],
            barColors:['#b8edf0', '#b4c1d7', '#fcc9ba', '#BB6464'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });
    });
</script>

@endsection
