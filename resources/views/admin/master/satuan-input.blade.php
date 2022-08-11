@extends('admin.header')
@section('title', 'Input Satuan - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA SATUAN</h3>
                <form class="form-horizontal" action="{{ route('satuan.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Kode Satuan</label>
                        <div class="col-sm-7">
                            @if (isset($select))
                                <input type="text" class="form-control" name="kode_satuan" maxlength="10" value="{{ $select->kode_satuan }}" required>
                            @else   
                                <input type="text" class="form-control" name="kode_satuan" maxlength="10" placeholder="Kode Satuan" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Nama Satuan</label>
                        <div class="col-sm-7">
                            @if (isset($select))
                                <input type="text" class="form-control" name="nama_satuan" maxlength="50" value="{{ $select->nama_satuan }}" required>
                            @else
                                <input type="text" class="form-control" name="nama_satuan" maxlength="50" placeholder="Nama Satuan" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-7">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/satuan"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    </div>
<!-- end container-fluid -->

@include('admin.footer')

@endsection
