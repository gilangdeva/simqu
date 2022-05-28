@extends('admin.header')
@section('title', 'Input Inspeksi Inline - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA INSPEKSI INLINE</h3>
                <form class="form-horizontal" action="{{ route('inline.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-6">
                            <div class="col-sm-4"><label>Tanggal</label></div>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="tgl_inspeksi" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="col-sm-4"><label>Shift</label></div>
                            <div class="col-sm-8">
                                <select id="shift" class="form-control select2" name="shift" required>
                                    <option value="0">Pilih Shift</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-6">
                            <div class="col-sm-4"><label>Area</label></div>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_departemen" id="id_departemen" required autocomplete="false">
                                    <option>Pilih Area Inspeksi</option>
                                    @foreach ($departemen as $dept)
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-sm-4 control-label"></label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required autocomplete="false">
                                    <option>Pilih Bagian Inspeksi</option>
                                    @foreach ($subdepartemen as $subdept)
                                        <option value="{{ $subdept->id_sub_departemen }}">{{ $subdept->nama_sub_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4">Mesin</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_mesin" >
                                <option value="0">Pilih Mesin</option>
                                @foreach ($mesin as $machine)
                                    <option value="{{ $machine->id_mesin }}">{{ $machine->nama_mesin }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Output per 1 Menit</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="qty_1" maxlength="10" placeholder="Output per 1 Menit" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >PIC</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="pic" maxlength="10" placeholder="PIC (Operator)" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Jam Mulai</label>
                        <div class="col-sm-8">
                            <input type="time" class="form-control" name="jam_mulai" maxlength="10" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Jam Selesai</label>
                        <div class="col-sm-8">
                            <input type="time" class="form-control" name="jam_selesai" maxlength="10" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >JOP</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jop" maxlength="10" placeholder="JOP" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Item</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="item" maxlength="10" placeholder="Item" required>
                        </div>
                    </div> {{-- Nanti diubah --}}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Defect</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_defect">
                                <option value="0">Pilih Defect</option>
                                @foreach ($defect as $def)
                                    <option value="{{ $def->id_defect }}">{{ $def->defect }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Kriteria</label>
                        <div class="col-sm-8">
                            <select id="kriteria" class="form-control select2" name="kriteria" maxlength="20" required autocomplete="false">
                                <option value="0">Pilih Kriteria</option>
                                <option value="Minor">Minor</option>
                                <option value="Major">Major</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Jumlah Temuan Defect</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="qty_defect" maxlength="3" placeholder="Jumlah Temuan Defect" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Barang Siap (pcs/lbr)</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="qty_ready_pcs" maxlength="20" placeholder="Barang Siap (pcs/lbr)" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Jumlah Sampling</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="qty_sampling" maxlength="4" placeholder="Jumlah Sampling" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Penyebab</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="penyebab" maxlength="50" placeholder="Penyebab" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Status</label>
                        <div class="col-sm-8">
                            <select id="status" class="form-control select2" name="status" maxlength="50" required>
                                <option value="0">Pilih Status</option>
                                <option value="OK">OK</option>
                                <option value="Hold">Hold</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" autocomplete="false" required >
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/inline"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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
