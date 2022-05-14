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
                        <label class="col-sm-5 control-label">ID Departemen</label>
                        <div class="col-sm-7">
                            <select id="id_departemen" class="form-control select2" name="id_departemen" maxlength="20" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-5 control-label">ID Sub Departemen</label>
                        <div class="col-sm-7">
                            <select id="id_sub_departemen" class="form-control select2" name="id_sub_departemen" maxlength="20" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-5 control-label">Kode Mesin</label>
                        <div class="col-sm-7">
                            <select id="kode_mesin" class="form-control select2" name="kode_mesin" maxlength="10" required> 
                                <option value="AB">AB</option>
                                <option value="BC">BC</option>
                                <option value="SC">SC</option>
                                <option value="JK">JK</option>
                                <option value="JP">JP</option>
                            </select>  
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-5 control-label">Nama Mesin</label>
                        <div class="col-sm-7">
                            <select class="form-control select2" name="form-control select2" required> 
                            <option value="0">Nama Mesin</option>
                            @foreach ($mesin  as $machine) 
                                <option value="{{ $machine->id_mesin }}" {{ old('id_mesin', $machine->id_mesin) == $dept->$id_mesin ? 'selected':''}}>{{ $dept->nama_mesin </option>   
                            @endforeach
                            </select>
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