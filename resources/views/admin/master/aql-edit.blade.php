@extends('admin.header')
@section('title', 'Edit AQL - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA AQL</h3>
                <form class="form-horizontal" action="{{ route('aql.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-3 control-label">Level</label>
                        <div class="col-sm-7">
                            <input type="hidden" class="form-control" name="id_aql" value="{{ $aql->id_aql }}" readonly autocomplete="false">
                            <input type="text" class="form-control" name="level_aql" maxlength="3" placeholder="Level" value="{{ $aql->level_aql }}" readonly>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Kode AQL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="kode_aql" maxlength="50" placeholder="Kode AQL" value="{{ $aql->kode_aql }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Brg Siap Min</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="qty_lot_min" maxlength="50" placeholder="Brg Siap Min" value="{{ $aql->qty_lot_min }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Brg Siap Max</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="qty_lot_max" maxlength="50" placeholder="Brg Siap Max" value="{{ $aql->qty_lot_max }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Qty Sample AQL</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="qty_sample_aql" maxlength="50" placeholder="Qty Sample AQL" value="{{ $aql->qty_sample_aql }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Qty Accept Minor</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="qty_accept_minor" maxlength="50" placeholder="Qty Accept Minor" value="{{ $aql->qty_accept_minor }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom 3px;">
                        <label class="col-sm-3 control-label">Qty Accept Major</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="qty_accept_major" maxlength="50" placeholder="Qty Accept Major" value="{{ $aql->qty_accept_major }}" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-7">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/aql"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
