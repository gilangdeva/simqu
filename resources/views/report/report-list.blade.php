@extends('admin.header')
@section('title', 'Report List - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="white-box">
        <div class="row">
            <form action="{{ route('inline.filter') }}" id="inline_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                <div class="col-sm-5">
                    <div class="col-sm-5">
                        <select class="form-control select-option" name="nama_departemen" id="nama_departemen">
                            <option value="0">Pilih Bagian :</option>
                            <option value="HANDMADE">HANDMADE</option>
                            <option value="MANUAL">MANUAL</option>
                            <option value="SOFTCOVER">SOFTCOVER</option>
                            <option value="HARDCOVER">HARDCOVER</option>
                            <option value="MNLPACKAGING">MNL PACKAGING</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="col-sm-5">
                        <select class="form-control select-option" name="bulan" id="bulan">
                            <option value="0">Pilih Bulan :</option>
                            <option value="JANUARI">JANUARI</option>
                            <option value="FEBRUARI">FEBRUARI</option>
                            <option value="MARET">MARET</option>
                            <option value="APRIL">APRIL</option>
                            <option value="MEI">MEI</option>
                            <option value="JUNI">JUNI</option>
                            <option value="JULI">JULI</option>
                            <option value="AGUSTUS">AGUSTUS</option>
                            <option value="SEPTEMBER">SEPTEMBER</option>
                            <option value="OKTOBER">OKTOBER</option>
                            <option value="NOVEMBER">NOVEMBER</option>
                            <option value="DESEMBER">DESEMBER</option>
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
                            <th>Persentase Critical</th>
                            <th>Major</th>
                            <th>Persentase Major</th>
                            <th>Minor</th>
                            <th>Persentase Minor</th>
                            <th>Total</th>
                            <th>Persentase Total</th>
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
                                <td>{{ $ri->total/($total_inl)*100 }}</td>
                            </tr>
                        @endforeach
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
                            <th>Persentase Pass</th>
                            <th>Reject</th>
                            <th>Persentase Reject</th>
                            <th>Total</th>
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
                            </tr>
                        @endforeach
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
