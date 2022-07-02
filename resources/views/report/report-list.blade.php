@extends('admin.header')
@section('title', 'Report List - SIMQU')

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
                        <div class="col-sm-6">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>    
                        <div class="col-sm-4">
                            <select class="form-control select2" name="bulan" id="bulan">
                                <option value="0">Pilih Bulan</option>
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
                            </select>
                        </div>    
                        <div class="col-sm-2">
                            <button class="btn btn-primary waves-effect pull-left waves-light" type="submit">Submit</button>
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
                            @if(isset($report_inline[0]) && isset($bulan))
                                {{ $report_inline[0]->nama_departemen }} / {{ $bulan }}</b></h3> 
                            @endif
                    </div>
                </div>

                <table id="demo-foo" class="table m-b-0 toggle-arrow-tiny inspeksi-list">
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

    <div class="row">
        <div class="col-md-8">
           <div class="white-box">
            <div class="row">
              <div class="col-sm-6 col-xs-12">    
                <h3 class="box-title">Grafik Inspeksi Inline</h3>               
                <div>
                    <div id="morris-bar-chart"></div>
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
                            @if(isset($report_final[0]) && isset($bulan))
                                {{ $report_final[0]->nama_departemen }} / {{ $bulan }}</b></h3> 
                            @endif
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

    <div class="row">
        <div class="col-md-8">
           <div class="white-box">
            <div class="row">
              <div class="col-sm-6 col-xs-12">    
                <h3 class="box-title">Grafik Inspeksi Final</h3>               
                <div>
                    <div id="morris-bar-chart"></div>
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
                            @if(isset($report_kriteria[0]) && isset($bulan))
                                {{ $report_kriteria[0]->nama_departemen }} / {{ $bulan }}</b></h3> 
                            @endif
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
</div>
<div class="row">
        <div class="col-md-8">
           <div class="white-box">
            <div class="row">
              <div class="col-sm-6 col-xs-12">    
                <h3 class="box-title">Grafik Kriteria</h3>              
                <div>                
                    <div id="morris-bar-chart"></div>
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
    
    var bln = document.getElementById('bln').value;
    var inl = document.getElementById('inl').value;
    var fin = document.getElementById('fin').value;

    $(document).ready(function () {
    
        // Morris Defect
        Morris.Bar({
            element: 'morris-bar-chart',
            data: JSON.parse(defect),
            xkey: 'month',
            ykeys: ['minor', 'major', 'critical'],
            labels: ['Minor', 'Major', 'Critical'],
            barColors:['#b8edf0', '#b4c1d7', '#fcc9ba'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });

         // Chartist Status
        //  new Chartist.Line('.ct-sm-line-chart', {
        //     labels: JSON.parse(bln),
        //     series: [JSON.parse(inl), JSON.parse(fin)]
        //     }, {
        //     fullWidth: true,
            
        //     plugins: [
        //         Chartist.plugins.tooltip()
        //     ],
        //     chartPadding: {
        //         right: 40
        //     }
        // });
    });

    

</script>

@endsection