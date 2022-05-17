@extends('admin.header')
@section('title', 'Input Mesin - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT MESIN DATA</h3>
                <form class="form-horizontal" action="{{ route('mesin.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                   
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Departemen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id_departemen}}">{{ $dept->nama_departemen}} </option>
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
                                    <option value="{{$subdept->id_sub_departemen}}">{{ $subdept->nama_sub_departemen}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Kode Mesin</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="kode_mesin" maxlength="10" placeholder="Kode Mesin" required>  
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Nama Mesin</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_mesin" maxlength="10" placeholder="Nama Mesin" required>
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom:3px">
                        <div class="col-sm-5"></div>
                            <div class="col-sm-7">
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