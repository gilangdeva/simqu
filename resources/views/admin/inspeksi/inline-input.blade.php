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
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_inspeksi_header" value="{{ $id_header[0]->id_inspeksi_header }}" readonly autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id_inspeksi_detail" value="{{ $id_detail[0]->id_inspeksi_detail }}" readonly autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Tanggal</label>
                        <div class="col-sm-8">
                            @if(isset($id_header))
                                <input type="hidden" class="form-control" name="id_inspeksi_header" value="{{ $id_header }}">    
                                <input type="hidden" class="form-control" name="id_departemen_ori" value="{{ $id_departemen }}">
                                <input type="hidden" class="form-control" name="shift_ori" value="{{ $shift }}">
                                <input type="hidden" class="form-control" name="id_sub_departemen_ori" value="{{ $id_sub_departemen }}">
                            @endif

                            @if(isset($tgl_inspeksi))
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ $tgl_inspeksi }}" readonly>
                            @else
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ date('Y-m-d') }}" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Shift</label>
                        <div class="col-sm-8">
                            @if (isset($shift))
                                <select class="form-control select2" name="shift" id="shift" disabled>
                                    <option value="">Pilih Shift</option>
                                    <option value="A" {{ old('shift', $shift) == "A" ? 'selected':''}}>A</option>
                                    <option value="B" {{ old('shift', $shift) == "B" ? 'selected':''}}>B</option>
                                    <option value="C" {{ old('shift', $shift) == "C" ? 'selected':''}}>C</option>
                                </select>
                            @else 
                                <select class="form-control select2" name="shift" id="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4 control-label"><label>Area</label></div>
                        <div class="col-sm-8">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen" disabled>
                            @else 
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option>Pilih Area Inspeksi</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else 
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                            @if(isset($id_sub_departemen))
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" disabled>
                            @else
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required>
                            @endif
                                <option>Pilih Bagian Inspeksi</option>
                                @foreach ($subdepartemen as $subdept)
                                    @if(isset($id_sub_departemen))
                                        <option value="{{ $subdept->id_sub_departemen }}" {{ old('id_sub_departemen', $id_sub_departemen) == $subdept->id_sub_departemen ? 'selected':''}}>{{ $subdept->nama_sub_departemen }}</option>
                                    @else
                                        <option value="{{ $subdept->id_sub_departemen }}">{{ $subdept->nama_sub_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Mesin</label>
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
                        <label class="col-sm-4 control-label" >Qty/1 Mnt</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty_1" maxlength="6" placeholder="Qty/1 Mnt" required>
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
                            <input type="text" class="form-control" name="jop" maxlength="8" placeholder="JOP" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Item</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="item" maxlength="200" placeholder="Nama Item" required>
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
                            <select id="kriteria" class="form-control select2" name="kriteria" required autocomplete="false">
                                <option value="0">Pilih Kriteria</option>
                                <option value="Minor">Minor</option>
                                <option value="Major">Major</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Qty Temuan</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty_defect" maxlength="6" placeholder="Jumlah Temuan Defect" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Brg Siap (pcs/lbr)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty_ready_pcs" maxlength="6" placeholder="Barang Siap (pcs/lbr)" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label" >Jml Sampling</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="qty_sampling" maxlength="6" placeholder="Jumlah Sampling" required>
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
                            <a href="/inline-input"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="white-box">
                <h3 class="box-title">DRAFT HEADER INLINE</h3>
                    <div class="table-responsive">
                        <table id="tablebasic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Inspektor</th>
                                    <th>Tanggal</th>
                                    <th>Shift</th>
                                    <th>Area</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($draftheader as $draftheader)
                                <tr>
                                    <td align="center">{{ $loop->iteration }}</td>
                                    <td>{{ $draftheader->nama_user }}</td>
                                    <td>{{ $draftheader->tgl_inspeksi }}</td>
                                    <td>{{ $draftheader->shift }}</td>
                                    <td>{{ $draftheader->nama_departemen }} / {{ $draftheader->nama_sub_departemen }}</td>
                                    {{-- <td>
                                        <a href="/inline-edit/{{ Crypt::encrypt($inspekinl->id_inspeksi_header) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                        <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($inspekinl->id_inspeksi_header) }}')"><i class="fa fa-times"></i></button>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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