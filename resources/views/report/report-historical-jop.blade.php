@extends('admin.header')
@section('title', 'Report historical JOP - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="box-title">REPORT HISTORICAL JOP</h1>
                    </div>
                    <form action="{{ route('report.historical-jop') }}" id="f_jop" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-6">
                            <div class="col-sm-5"><label></label></div>
                            <div class="col-sm-6">
                                    <input type="text" class="form-control" name="text_search" id="text_search" maxlength="200" placeholder="Search...">
                            </div>

                            <div class="col-sm-1">
                                <button type="submit" name="action" value="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="table-responsive">
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny inspeksi-list" data-page-size="10">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>JOP</th>
                            <th>Nama Barang</th>
                            <th>Tahun</th>
                            <th>Bulan</th>
                            <th>Defect</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report_jop as $rj)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rj->jop }}</td>
                                <td>{{ $rj->item }}</td>
                                <td>{{ $rj->tahun }}</td>
                                <td>{{ $rj->bulan }}</td>
                                <td>{{ $rj->defect }}</td>
                                <td>{{ $rj->qty }}</td>
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
