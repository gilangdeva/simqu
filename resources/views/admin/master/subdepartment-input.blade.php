@extends('admin.header')
@section('title', 'Input Sub Department - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA SUB DEPARTEMEN</h3>
                <form class="form-horizontal" action="{{ route('subdepartment.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Departemen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($select->id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old("id_departemen", $select->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Kode Sub Departemen</label>
                        <div class="col-sm-8">
                            @if (isset($select->kode_sub_departemen))
                                <input type="text" class="form-control" name="kode_sub_departemen" maxlength="3" value="{{ $select->kode_sub_departemen }}" required>
                            @else
                                <input type="text" class="form-control" name="kode_sub_departemen" maxlength="3" placeholder="Kode Sub Departemen" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Nama Sub Departemen</label>
                        <div class="col-sm-8">
                            @if (isset($select->nama_sub_departemen))
                                <input type="text" class="form-control" name="nama_sub_departemen" maxlength="20" value="{{ $select->nama_sub_departemen }}" required>
                            @else
                                <input type="text" class="form-control" name="nama_sub_departemen" maxlength="20" placeholder="Nama Sub Departemen" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Klasifikasi Proses</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="klasifikasi_proses" required>
                                @if (isset($select->klasifikasi_proses))
                                    <option value="0">Pilih Proses</option>
                                    <option value="INLINE" {{ old('klasifikasi_proses', $select->klasifikasi_proses) == "INLINE" ? 'selected':''}}>INLINE</option>
                                    <option value="FINAL" {{ old('klasifikasi_proses', $select->klasifikasi_proses) == "FINAL" ? 'selected':''}}>FINAL</option>
                                    <option value="NONPROSES" {{ old('klasifikasi_proses', $select->klasifikasi_proses) == "NONPROSES" ? 'selected':''}}>NON PROSES</option>
                                @else
                                    <option value="0">Pilih Proses</option>
                                    <option value="INLINE">INLINE</option>
                                    <option value="FINAL">FINAL</option>
                                    <option value="NONPROSES">NON PROSES</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/subdepartment"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
