@extends('admin.header')
@section('title', 'Report List - SIMQU')

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
                        <h3 class="box-title">LIST REPORT INSPEKSI</h3>
                    </div>
                </div>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny inspeksi-list" data-page-size="20">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Bagian</th>
                            <th>Periode</th>
                            <th>Jml Total Inspeksi</th>
                            <th>Jml Reject</th>
                            <th>Jml Critical</th>
                            <th>Jml Temuan Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report as $r)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $r->nama_departemen }}</td>
                                <td>{{ $r->nama_departemen }}</td>
                                <td>{{ $r->qty_defect }}</td>
                                <td>{{ $r->qty_defect }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="8">
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