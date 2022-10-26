@extends('admin.header')
@section('title', 'Tot. Defect / Departemen - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-sm-8">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('report.qty_defect') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
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
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="box-title">REPORT QTY DEFECT INLINE  |  <b style="color: red"> DEPT :
                            @if(isset($select_dept))
                                {{ $select_dept }} / {{ strtoupper($bulan) }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny inspeksi-list" data-page-size="20">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Defect</th>
                            <th>Qty Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_qty_defect_inline as $rqdi)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rqdi->defect }}</td>
                                <td>{{ $rqdi->qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="text-right">
                                    <ul class="pagination pagination-split m-t-30"> </ul>
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
                        <h3 class="box-title">REPORT QTY DEFECT FINAL  |  <b style="color: red"> DEPT :
                            @if(isset($select_dept))
                                {{ $select_dept }} / {{ $bulan }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny inspeksi-list" data-page-size="20">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Defect</th>
                            <th>Qty Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_qty_defect_final as $rqdf)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rqdf->defect }}</td>
                                <td>{{ $rqdf->qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="text-right">
                                    <ul class="pagination pagination-split m-t-30"> </ul>
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
