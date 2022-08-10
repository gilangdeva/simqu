<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <style>
        td,
        th {
            font-size: 10.5pt;
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

    </style>

    <div class="row">
        <div class="col-md-10">
            <div class="white-box">
                <div class="row">
                    <div>
                        <h3 class="box-title">REPORT REKAPITULASI REJECT  |  <b style="color: red"> DEPT :
                            @if(isset($report_reject[0]))
                                {{ $report_reject[0]->nama_departemen }} / {{ strtoupper($tahun) }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table class='table table-bordered'>
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
                                        <td>{{ date('d/m/Y', strtotime($report_reject[$i]->tgl_mulai_periode)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($report_reject[$i]->tgl_akhir_periode)) }}</td>
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
</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
