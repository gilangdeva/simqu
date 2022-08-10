<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-10">
            <div class="white-box">
                <div class="row">
                    <div>
                        <h3 class="box-title">REPORT TOTAL INSPEKSI  |  <b style="color: red"> DEPT :
                            @if(isset($report_inspeksi[0]))
                                {{ $report_inspeksi[0]->nama_departemen }} / {{ strtoupper($bulan) }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table class='table table-bordered'>
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
</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
