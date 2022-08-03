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
    <div>
        <h3 class="box-title">REPORT LIST   |   <b style="color: red">DEPT :
            @if(isset($report_inline[0]) && isset($bulan))
                {{ $report_inline[0]->nama_departemen }} / {{ $bulan }}</b></h3>
            @endif
    </div>
</div>
<br><br>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div>
                        <h3 class="box-title">REPORT INSPEKSI INLINE</h3>
                    </div>
                </div>

                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Periode</th>
                            <th>Tgl Awal</th>
                            <th>Tgl Akhir</th>
                            <th>Critical</th>
                            <th>% Critical</th>
                            <th>Major</th>
                            <th>% Major</th>
                            <th>Minor</th>
                            <th>% Minor</th>
                            <th style="font-weight: bold;">Total</th>
                            <th style="font-weight: bold;">% Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_inline[0]))
                            @foreach($report_inline as $ri)
                                <tr height="-10px;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Minggu Ke-{{ $ri->minggu_ke }}</td>
                                    <td>{{ $ri->tgl_mulai_periode }}</td>
                                    <td>{{ $ri->tgl_akhir_periode }}</td>
                                    <td>{{ $ri->critical }}</td>
                                    <td>{{ $ri->persen_critical }}%</td>
                                    <td>{{ $ri->major }}</td>
                                    <td>{{ $ri->persen_major }}%</td>
                                    <td>{{ $ri->minor }}</td>
                                    <td>{{ $ri->persen_minor }}%</td>
                                    <td style="font-weight: bold; color:blue;">{{ $ri->total }}</td>
                                    @if(isset($total_inl))
                                    <td style="font-weight: bold; color:blue;">{{ number_format(($ri->total/$total_inl)*100,1,'.','.')  }}%</td>
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
<br><br><br><br><br><br><br><br>

    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div>
                        <h3 class="box-title">REPORT INSPEKSI FINAL</h3>
                    </div>
                </div>

                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
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
                                    <td>{{ $fnl->tgl_mulai_periode }}</td>
                                    <td>{{ $fnl->tgl_akhir_periode }}</td>
                                    <td>{{ $fnl->pass }}</td>
                                    <td>{{ $fnl->persen_pass }}%</td>
                                    <td>{{ $fnl->reject }}</td>
                                    <td>{{ $fnl->persen_reject }}%</td>
                                    <td style="font-weight: bold; color:blue;">{{ $fnl->total }}</td>
                                    @if(isset($total_fnl))
                                    <td style="font-weight: bold; color:blue;">{{ number_format(($fnl->total/$total_fnl)*100,1,'.','.')  }}%</td>
                                @else
                                    <td style="font-weight: bold; color:blue;">0%</td>
                                @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11">Tidak ada data untuk ditampilkan</td>
                            </tr>
                        @endif
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="12">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



    <div class="row">
        <div class="col-md-8">
            <div class="white-box">
                <div class="row">
                    <div>
                        <h3 class="box-title">REPORT KRITERIA</h3>
                    </div>
                </div>

                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Periode</th>
                            <th>Tgl Awal</th>
                            <th>Tgl Akhir</th>
                            <th>Critical</th>
                            <th>% Critical</th>
                            <th>Major</th>
                            <th>% Major</th>
                            <th>Minor</th>
                            <th>% Minor</th>
                            <th>Tot.</th>
                            <th>Tot. Smpling</th>
                            <th>% Sampling</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_kriteria[0]))
                            @foreach($report_kriteria as $krt)
                                <tr height="-10px;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Minggu Ke-{{ $krt->minggu_ke }}</td>
                                    <td>{{ $krt->tgl_mulai_periode }}</td>
                                    <td>{{ $krt->tgl_akhir_periode }}</td>
                                    <td>{{ $krt->critical }}</td>
                                    <td>{{ $krt->persen_critical }}%</td>
                                    <td>{{ $krt->major }}</td>
                                    <td>{{ $krt->persen_major }}%</td>
                                    <td>{{ $krt->minor }}</td>
                                    <td>{{ $krt->persen_minor }}%</td>
                                    <td>{{ $krt->total }}</td>
                                    <td>{{ $krt->qty_riil }}</td>
                                    @if($krt->qty_riil <> '0')
                                    <td style="font-weight: bold; color:blue;">{{ number_format(($krt->total/$krt->qty_riil)*100,1,'.','.')  }}%</td>
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
                    <tfoot>
                        <tr>
                            <td colspan="15">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>



<!-- end row -->
</div>
<!-- end container-fluid -->
