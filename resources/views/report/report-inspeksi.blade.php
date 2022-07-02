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
                        <h3 class="box-title">REPORT TOTAL INSPEKSI  |  <b style="color: red"> DEPT :
                            @if(isset($report_inspeksi[0]))
                                {{ $report_inspeksi[0]->nama_departemen }} / {{ $bulan }}
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
@include('admin.footer')

@endsection
