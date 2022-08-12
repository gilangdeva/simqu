@extends('admin.header')
@section('title', 'Input AQL - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA AQL</h3>
                <form class="form-horizontal" action="{{ route('aql.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Level</label>
                        <div class="col-sm-3">
                            @if (isset($select))
                                <input type="number" class="form-control" name="level_aql" maxlength="3" min="1" max="999" value="{{ $select->level_aql }}" required>
                            @else
                                <input type="number" class="form-control" name="level_aql" maxlength="3" min="1" max="999" placeholder="Level" required>
                            @endif
                        </div>

                        <label class="col-sm-2 control-label">Kode AQL</label>
                        <div class="col-sm-4">
                            @if (isset($select))
                                <input type="text" class="form-control" name="kode_aql" maxlength="50" value="{{ $select->kode_aql }}" required>
                            @else
                                <input type="text" class="form-control" name="kode_aql" maxlength="50" placeholder="Kode AQL" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Qty Sample</label>
                        <div class="col-sm-3">
                            @if (isset($select))
                                <input type="number" class="form-control" name="qty_sample_aql" maxlength="50" min="1" value="{{ $select->qty_sample_aql }}" required>
                            @else
                                <input type="number" class="form-control" name="qty_sample_aql" maxlength="50" min="1" placeholder="Qty Sample AQL" required>    
                            @endif
                            
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Qty Lot Min</label>
                        <div class="col-sm-3">
                            @if (isset($select))
                                <input type="number" class="form-control" name="qty_lot_min" maxlength="50" min="1" value="{{ $select->qty_lot_min }}" required>
                            @else
                                <input type="number" class="form-control" name="qty_lot_min" maxlength="50" min="1" placeholder="Qty Lot Min" required>
                            @endif
                        </div>

                        <label class="col-sm-2 control-label">Lot Max</label>
                        <div class="col-sm-4">
                            @if (isset($select))
                                <input type="number" class="form-control" name="qty_lot_max" maxlength="50" min="1" value="{{ $select->qty_lot_max }}" required>
                            @else
                                <input type="number" class="form-control" name="qty_lot_max" maxlength="50" min="1" placeholder="Qty Lot Max" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <label class="col-sm-3 control-label">Accept Minor</label>
                        <div class="col-sm-3">
                            @if (isset($select))
                                <input type="number" class="form-control" name="qty_accept_minor" maxlength="50" min="1" value="{{ $select->qty_accept_minor }}" required>
                            @else
                                <input type="number" class="form-control" name="qty_accept_minor" maxlength="50" min="1" placeholder="Qty Accept Minor" required>
                            @endif
                        </div>

                        <label class="col-sm-2 control-label">Major</label>
                        <div class="col-sm-4">
                            @if (isset($select))
                                <input type="number" class="form-control" name="qty_accept_major" maxlength="50" min="1" value="{{ $select->qty_accept_major }}" required>
                            @else
                                <input type="number" class="form-control" name="qty_accept_major" maxlength="50" min="1" placeholder="Qty Accept Major" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px";>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
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
