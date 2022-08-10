@extends('admin.header')
@section('title', 'Tot. Inspeksi / Tahun - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-sm-3">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('rekap.inspeksi') }}" id="report_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-8">
                            @if(isset($f_tahun))
                            <select class="form-control select2" name="tahun" id="tahun">
                            @else
                            <select class="form-control select2" name="tahun" id="tahun">
                            @endif
                                <option value="">SEMUA TAHUN</option>
                                @foreach ($list_tahun as $lt)
                                    @if(isset($tahun))
                                        <option value="{{ $lt->tahun }}" {{ old("tahun", $tahun) == $lt->tahun ? 'selected':''}}>{{ $lt->tahun }}</option>
                                    @else
                                        <option value="{{ $lt->tahun }}">{{ $lt->tahun }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="button-box">
                                <button type="submit" name="action" value="submit" class="btn btn-danger waves-effect waves-light"><i class="fa fa-search"></i></button>
                                <button type="submit" name="action" value="export_pdf" class="btn btn-info waves-effect waves-light" target="_blank"><i class="fa fa-download"></i></button>
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
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">REKAPITULASI INSPEKSI  |  <b style="color: red"> TAHUN :
                            @if(isset($s_tahun))
                                {{ $s_tahun }}
                            @endif
                            </b>
                        </h3>
                    </div>
                </div>

                <table id="demo-foo" class="table m-b-0 toggle-arrow-tiny inspeksi-list">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Nama Departemen</th>
                            <th>Tahun</th>
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
                                        <td>{{ $report_inspeksi[$i]->nama_departemen }}</td>
                                        <td>{{ $report_inspeksi[$i]->tahun }}</td>
                                        <td>{{ $report_inspeksi[$i]->inline }}</td>
                                        <td>{{ $report_inspeksi[$i]->persen_inline }}%</td>
                                        <td>{{ $report_inspeksi[$i]->final }}</td>
                                        <td>{{ $report_inspeksi[$i]->persen_final }}%</td>
                                    </tr>
                                </tr>
                            @endfor
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
