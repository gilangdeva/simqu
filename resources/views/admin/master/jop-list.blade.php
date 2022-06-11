@extends('admin.header')
@section('title', 'Upload JOP Edar - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-sm-4">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="box-title" style="margin-bottom:-5px;">UPLOAD FILE JOP EDAR</h3>
                        <label for="input-file-now-custom-1">Letakkan file (.xlsx) pada box dibawah ini!</label>
                    </div>

                    <div class="col-sm-12">
                        <form class="form-group" action="{{ route('upload.jop') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group" style="margin-bottom:10px;">
                                <input type="file" name="upload_file" id="input-file-now-custom-1" class="dropify" /> 
                            </div>
                            
                            <div class="form-group" style="margin-bottom:1px;">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Upload</button>
                            </div>
                        </form>
                    </div>

                    @if($errors->any())
                        <br>
                        <div class="col-md-12 mg-t-5 mg-md-t-0">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Error!</strong> {{ $error }}
                                </div><!-- alert -->
                            @endforeach
                        </div><!-- col -->
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">LIST JOP EDAR</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>JOP</th>
                                <th>Nama Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($defect as $def) --}}
                            <tr>
                                <td align="center"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            {{-- @endforeach --}}
                        </tbody>
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
