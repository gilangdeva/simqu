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
                        <div class="col-sm-4">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen">
                            @else
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                @if(isset($id_departemen))
                                    <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                @else
                                    <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                @endif
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
                            <button type="submit" name="action" value="submit" class="btn btn-primary waves-effect pull-right waves-light">Submit</button>
                        </div>

                        <div class="col-sm-2">
                            <button type="submit" name="action" value="export_pdf" href="/ReportQtyDefectPDF" class="btn btn-primary" target="_blank">Export to PDF</button>
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
                            <th>Tahun</th>
                            <th>Nama Defect</th>
                            <th>Qty Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_qty_defect_inline as $rqdi)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rqdi->tahun }}</td>
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
                    <div class="col-sm-6 col-xs-12">
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
                            <th>Tahun</th>
                            <th>Nama Defect</th>
                            <th>Qty Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_qty_defect_final as $rqdf)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rqdf->tahun }}</td>
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
