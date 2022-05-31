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
                                @if(isset($id_sub_departemen))
                                    @foreach ($subdepartemen as $subdept)
                                        <option value="{{ $subdept->id_sub_departemen }}" {{ old('id_sub_departemen', $id_sub_departemen) == $subdept->id_sub_departemen ? 'selected':''}}>{{ $subdept->nama_sub_departemen }}</option>
                                    @endforeach
                                @else
                                    {{-- <option value="{{ $subdept->id_sub_departemen }}">{{ $subdept->nama_sub_departemen }}</option> --}}
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Mesin</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_mesin" id="id_mesin" required>
                                <option value="0">Pilih Mesin</option>
                                @if(isset($mesin))
                                    @foreach ($mesin as $machine)
                                        <option value="{{ $machine->id_mesin }}">{{ $machine->nama_mesin }}</option>
                                    @endforeach
                                @endif
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
                <h3 class="box-title m-b-0">DRAFT INPEKSI</h3>
                <label class="form-inline">Show
                    <select id="demo-show-entries" class="form-control input-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select> entries 
                </label>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="5">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Tgl</th>
                            <th>Shift</th>
                            <th>Area</th>
                            <th>JOP</th>
                            <th data-hide="all">Item</th>
                            <th data-hide="all">Mesin</th>
                            <th data-hide="all">Output/1 mnt</th>
                            <th data-hide="all">PIC</th>
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Kendala</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Jml Temuan</th>
                            <th data-hide="all">Brg Siap</th>
                            <th data-hide="all">Jml Sampling</th>
                            <th data-hide="all">Penyebab</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($draft as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->tgl_inspeksi }}</td>
                            <td>{{ $d->shift }}</td>
                            <td>{{ $d->nama_departemen }} - {{ $d->nama_sub_departemen }}</td>
                            <td>{{ $d->jop }}</td>
                            <td>{{ $d->item }}</td>
                            <td>{{ $d->nama_mesin }}</td>
                            <td>{{ $d->qty_1 }}</td>
                            <td>{{ $d->pic }}</td>
                            <td>{{ $d->jam_mulai }}</td>
                            <td>{{ $d->jam_selesai }}</td>
                            <td>{{ $d->defect }}</td>
                            <td>{{ $d->kriteria }}</td>
                            <td>{{ $d->qty_defect }}</td>
                            <td>{{ $d->qty_ready_pcs }} (Pcs/Lbr)</td>
                            <td>{{ $d->qty_sampling }}</td>
                            <td>{{ $d->penyebab }}</td>
                            <td>{{ $d->status }}</td>
                            <td>{{ $d->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <!-- end row -->
</div>
<!-- end container-fluid -->

@include('admin.footer')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/users-sub/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_sub_departemen"]').empty();
                            $('select[name="id_sub_departemen"]').append('<option value="0" selected>Pilih Bagian Inspeksi</option>');
                            // Remove options
                            $('#id_sub_departemen').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_sub_departemen"]').append('<option value="'+ data[i].id_sub_departemen +'">'+ data[i].nama_sub_departemen +'</option>');
                            };
                        } else {
                            $('select[name="id_sub_departemen"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_sub_departemen"]').empty();
            }
        });

        $('select[name="id_sub_departemen"]').on('change', function() {
            var subDepartemenID = $(this).val();
            if(subDepartemenID) {
                $.ajax({
                    url: '/mesin-dropdown/'+subDepartemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_mesin"]').empty();
                            $('select[name="id_mesin"]').append('<option value="0" selected>Pilih Mesin</option>');
                            // Remove options
                            $('#id_mesin').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_mesin"]').append('<option value="'+ data[i].id_mesin +'">'+ data[i].nama_mesin +'</option>');
                            };
                        } else {
                            $('select[name="id_mesin"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_mesin"]').empty();
            }
        });
    });
</script>

@endsection
