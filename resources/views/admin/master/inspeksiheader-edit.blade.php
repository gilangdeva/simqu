@extends('admin.header')
@section('title', 'Edit Inspeksi Header - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">EDIT INSPEKSI HEADER DATA</h3>
                <form class="form-horizontal" action="{{ route('inspeksiheader.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">ID USER</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_inspeksi_header" value="{{ $inspeksiheader->id_inspeksi_header }}" readonly autocomplete="false">                         
                            <input type="text" class="form-control" name="id_user" maxlength="20" placeholder="id_User" value="{{ $inspeksiheader->id_user }}" required>                         </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Tanggal Inspeksi</label>
                        <div class="col-md-12">
                            <input type="date" class="form-control" name="tgl_inspeksi" maxlength="150" placeholder="Tanggal Inspeksi" value="{{$inspeksiheader->tgl_inspeksi }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="col-md-12">ID SHIFT</label>
                    <div select class="col-md-12">
                    <select type="action" class="form-control" name="id_shift" maxlength="10" placeholder="Id Shift" value="{{ $inspeksiheader->tgl_inspeksi }}"required> 
                    <option value="1">(1)Pagi</option>
                    <option value="2">(2)Siang</option>
                    <option value="3">(3)Malam</option>
                    </select>
                    </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/inspeksiheader"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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