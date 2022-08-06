@extends('admin.header')
@section('title', 'Report Qty Defect - SIMQU')

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
                            <button type="submit" name="action" value="export_pdf" href="/ReportQtyDefectPDF" class="btn btn-info" target="_blank">Export to PDF</button>
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
                            @if(isset($report_qty_defect_inline[0]))
                                {{ $report_qty_defect_inline[0]->nama_departemen }} / {{ $bulan }}
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
                            @if(isset($report_qty_defect_final[0]))
                                {{ $report_qty_defect_final[0]->nama_departemen }} / {{ $bulan }}
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
