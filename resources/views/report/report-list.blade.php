@extends('admin.header')
@section('title', 'Report List - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="white-box">
        <div class="row">
            <form action="{{ route('report.filter') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                <div class="col-sm-5">
                    <div class="col-sm-5">
                        <select class="form-control select2" name="id_departemen" required>
                            <option value="0">Pilih Departemen</option>
                            @foreach ($departemen as $dept)
                                <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="col-sm-5">
                        <select class="form-control select-option" name="bulan" id="bulan">
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

                    <div class="col-sm-4">
                        <button class="btn btn-primary waves-effect pull-right waves-light" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REPORT INSPEKSI INLINE</h3>
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
                            <th>Total</th>
                            <th>% Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_inline[0]))
                            @foreach($report_inline as $ri)
                                <tr height="-10px;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Minggu Ke{{ $ri->minggu_ke }}</td>
                                    <td>{{ $ri->tgl_mulai_periode }}</td>
                                    <td>{{ $ri->tgl_akhir_periode }}</td>
                                    <td>{{ $ri->critical }}</td>
                                    <td>{{ $ri->persen_critical }}%</td>
                                    <td>{{ $ri->major }}</td>
                                    <td>{{ $ri->persen_major }}%</td>
                                    <td>{{ $ri->minor }}</td>
                                    <td>{{ $ri->persen_minor }}%</td>
                                    <td>{{ $ri->total }}</td>
                                    <td>{{ ($ri->total/$total_inl)*100  }}%</td>
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
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REPORT INSPEKSI FINAL</h3>
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
                            <th>Total</th>
                            <th>% Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($report_final[0]))
                            @foreach($report_final as $fin)
                                <tr height="-10px;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Minggu Ke{{ $fin->minggu_ke }}</td>
                                    <td>{{ $fin->tgl_mulai_periode }}</td>
                                    <td>{{ $fin->tgl_akhir_periode }}</td>
                                    <td>{{ $fin->pass }}</td>
                                    <td>{{ $fin->persen_pass }}%</td>
                                    <td>{{ $fin->reject }}</td>
                                    <td>{{ $fin->persen_reject }}%</td>
                                    <td>{{ $fin->total }}</td>
                                    <td>{{ ($fin->total/$total_fnl)*100 }}%</td>
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
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REKAP</h3>
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
                            <th>Persentase Critical</th>
                            <th>Major</th>
                            <th>Persentase Major</th>
                            <th>Minor</th>
                            <th>Persentase Minor</th>
                            <th>Total</th>
                            <th>Total Sampling</th>
                            <th>Persentase Sampling</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_inline as $ri)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>Minggu Ke{{ $ri->minggu_ke }}</td>
                                <td>{{ $ri->tgl_mulai_periode }}</td>
                                <td>{{ $ri->tgl_akhir_periode }}</td>
                                <td>{{ $ri->critical }}</td>
                                <td>{{ $ri->persen_critical }}%</td>
                                <td>{{ $ri->major }}</td>
                                <td>{{ $ri->persen_major }}%</td>
                                <td>{{ $ri->minor }}</td>
                                <td>{{ $ri->persen_minor }}%</td>
                                <td>{{ $ri->total }}</td>
                                {{-- <td>{{ $ri->total_sampling }}</td> --}}
                                {{-- <td>{{ $ri->persen_sampling }}</td> --}}
                            </tr>
                        @endforeach
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
<!-- end row -->
</div>
<!-- end container-fluid -->
@include('admin.footer')

@endsection
