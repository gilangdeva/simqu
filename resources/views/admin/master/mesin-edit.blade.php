@extends('admin.header')
@section('title', 'Edit Mesin - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA MESIN</h3>
                <form class="form-horizontal" action="{{ route('mesin.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label"> Departemen </label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_departemen" required> 
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $mesin->id_departemen)==$dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Sub Departemen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_sub_departemen" required> 
                                <option value="0">Pilih Sub Departemen</option>
                                @foreach ($subdepartemen as $subdept)
                                    <option value="{{ $subdept->id_sub_departemen }}"{{old('id_sub_departemen', $mesin->id_sub_departemen) == $subdept->id_sub_departemen ? 'selected':''}}>{{ $subdept->nama_sub_departemen }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4">Kode Mesin</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_mesin" value="{{ $mesin->id_mesin }}" readonly autocomplete="false"> 
                            <input type="text" class="form-control" name="kode_mesin" maxlength="3" placeholder="Kode Mesin" value="{{ $mesin->kode_mesin }}" required> 
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Nama Mesin</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_mesin" maxlength="30" placeholder="Nama Mesin" value="{{ $mesin->nama_mesin }}" required>
                        </div>
                    </div>


                    <div class="form-group" style="margin-bottom:3px;">
                            <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/mesin"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
