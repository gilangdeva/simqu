@extends('admin.header')
@section('title', 'Input Inspeksi Final - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-5">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA INSPEKSI FINAL</h3>
                <form id="final_data" class="form-horizontal" action="{{ route('final.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Tanggal</label></div>
                        <div class="col-sm-4">
                        @if(isset($id_header))
                            <input type="hidden" class="form-control" name="id_inspeksi_header" value="{{ $id_header }}">
                            @if(isset($id_departemen))
                                <input type="hidden" class="form-control" name="id_departemen_ori" value="{{ $id_departemen }}">
                            @endif

                            @if(isset($shift))
                                <input type="hidden" class="form-control" name="shift_ori" value="{{ $shift }}">
                            @endif

                            @if(isset($id_sub_departemen))
                                <input type="hidden" class="form-control" name="id_sub_departemen_ori" value="{{ $id_sub_departemen }}">
                            @endif
                        @endif

                            @if(isset($tgl_inspeksi))
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ $tgl_inspeksi }}" style="background-color: #f4f4f4;" readonly>
                            @else
                                <input type="date" class="form-control" name="tgl_inspeksi" value="{{ date('Y-m-d') }}" required>
                            @endif
                        </div>

                        <div class="col-sm-2 control-label"><label>Shift</label></div>
                        <div class="col-sm-4">
                            @if (isset($shift))
                                <select class="form-control select2" name="shift" id="shift" style="background-color: #f4f4f4;" disabled>
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

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Bagian</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_departemen))
                            <select class="form-control select2" name="id_departemen" id="id_departemen" style="background-color: #f4f4f4;" disabled>
                            @else
                            <select class="form-control select2" name="id_departemen" id="id_departemen" required>
                            @endif
                                <option>Pilih Bagian Inspeksi</option>
                                @foreach ($departemen as $dept)
                                    @if(isset($id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2 control-label"><label>Area</label></div>
                        <div class="col-sm-4">
                            @if(isset($id_sub_departemen))
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" style="background-color: #f4f4f4;" disabled>
                            @else
                                <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required>
                            @endif
                                <option>Pilih Area Inspeksi</option>
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

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Jam Mulai</label></div>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" onblur="checkHours(event)" required>
                        </div>
                        <div class="col-sm-2 control-label"><label>Jam Selesai</label></div>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" onblur="checkHours(event)" required>
                        </div>
                    </div>

                    <br>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>JOP</label></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="jop" maxlength="8" placeholder="JOP" required>
                        </div>

                        <div class="col-sm-2 control-label"><label>Nama Item</label></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="item" maxlength="200" placeholder="Nama Item" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Brg Siap</label></div>
                        <div class="col-sm-2">
                            <input type="number" class="form-control" name="qty_ready_pack" maxlength="6" min="0" placeholder="Barang Siap (Pack/Box)">
                        </div>
                        <div class="col-sm-2">
                            @if(isset($id_satuan))
                            <select class="form-control select2" name="qty_ready_pack" id="qty_ready_pack" style="background-color: #f4f4f4;" disabled>
                            @else
                            <select class="form-control select2" name="satuan_qty_ready_pack" id="satuan_qty_ready_pack" required>
                            @endif
                                <option>Satuan</option>
                                @foreach ($satuan as $sat)
                                    @if(isset($id_satuan))
                                        <option value="{{ $sat->kode_satuan }}" {{ old('id_satuan', $kode_satuan) == $sat->kode_satuan ? 'selected':''}}>{{ $sat->kode_satuan }}</option>
                                    @else
                                        <option value="{{ $sat->kode_satuan }}">{{ $sat->kode_satuan }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Qty Riil</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_sample_riil" maxlength="6" min="0" placeholder="Qty Riil" required>
                        </div>

                        <div class="col-sm-2 control-label"><label>Qty Aql</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_sample_aql" maxlength="6" min="0" placeholder="Qty Aql" required>
                        </div>
                    </div>

                    <br><br>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Defect</label></div>
                        <div class="col-sm-4">
                            <select class="form-control select2" name="id_defect">
                                <option value="0">Pilih Defect</option>
                                @foreach ($defect as $def)
                                    <option value="{{ $def->id_defect }}">{{ $def->defect }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2 control-label"><label>Kriteria</label></div>
                        <div class="col-sm-4">
                            <select id="kriteria" class="form-control select2" name="kriteria" autocomplete="false">
                                <option value="">Pilih Kriteria</option>
                                <option value="Minor">Minor</option>
                                <option value="Major">Major</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Qty Temuan</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_defect" maxlength="6" min="0" placeholder="Qty Temuan">
                        </div>

                        <div class="col-sm-2 control-label"><label>Qty Reject</label></div>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="qty_reject_all" maxlength="6" min="0" placeholder="Qty Reject">
                        </div>
                    </div>

                    <br><br>


                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label>Hasil</label></div>
                        <div class="col-sm-4">
                            <select id="status" class="form-control select2" name="status" maxlength="10" required="">
                                <option value="">Pilih Hasil</option>
                                <option value="PASS">Pass</option>
                                <option value="REJECT">Reject</option>
                            </select>
                        </div>
                        <div class="col-sm-2 control-label"><label>Rekomendasi</label></div>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="2" name="keterangan" placeholder="Rekomendasi" autocomplete="false"></textarea>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <div class="col-sm-2 control-label"><label>Catatan Verifikasi</label></div>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="2" name="hasil_verifikasi" placeholder="Verifikasi" autocomplete="false"></textarea>
                        </div>

                        <div class="col-sm-2 control-label"><label></label></div>
                        <div class="col-sm-4">

                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:5px;">
                        <div class="col-sm-2 control-label"><label>Foto</label></div>
                        <div class="col-sm-10">
                            <input type="file" id="input-file-now-custom-2" name="picture_1" style="margin-bottom:5px;"/>
                            <input type="file" id="input-file-now-custom-2" name="picture_2" style="margin-bottom:5px;"/>
                            <input type="file" id="input-file-now-custom-2" name="picture_3" style="margin-bottom:5px;"/>
                            <input type="file" id="input-file-now-custom-2" name="picture_4" style="margin-bottom:5px;"/>
                            <input type="file" id="input-file-now-custom-2" name="picture_5" style="margin-bottom:5px;"/>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:1px;">
                        <div class="col-sm-2 control-label"><label></label></div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <button type="button" onclick="resetdata()" value="reset" class="btn btn-warning waves-effect waves-light m-r-10" style="margin-left:-10px;">Reset</button>
                            {{-- <a href="/final-input"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a> --}}
                        </div>

                        <div class="col-sm-2 control-label"><label></label></div>
                        <div class="col-sm-4">

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="white-box">
                <h3 class="box-title m-b-0">DRAFT INSPEKSI</h3>
                <label class="form-final">Show
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
                            <th>Hapus</th>
                            <th data-hide="all">Item</th>
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Lama Inspeksi</th>
                            <th data-hide="all">Brg Siap (Pack)</th>
                            <th data-hide="all">Brg Siap (Pcs)</th>
                            <th data-hide="all">Qty Riil</th>
                            <th data-hide="all">Qty Aql</th>
                            <th data-hide="all">Jenis Temuan</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Jml Temuan</th>
                            <th data-hide="all">Qty Reject</th>
                            <th data-hide="all">Hasil</th>
                            <th data-hide="all">Rekomendasi</th>
                            <th data-hide="all">Verifikasi</th>
                            <th data-hide="all">Foto</th>
                            <th data-hide="all"></th>
                            <th data-hide="all"></th>
                            <th data-hide="all"></th>
                            <th data-hide="all"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($draft))
                        @foreach($draft as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->tgl_inspeksi }}</td>
                                <td>{{ $d->shift }}</td>
                                <td>{{ $d->nama_departemen }} - {{ $d->nama_sub_departemen }}</td>
                                <td>{{ $d->jop }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($d->id_inspeksi_detail) }}')"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>{{ $d->item }}</td>
                                <td>{{ $d->jam_mulai }}</td>
                                <td>{{ $d->jam_selesai }}</td>
                                <td>{{ $d->lama_inspeksi }} Menit</td>
                                <td>{{ $d->qty_ready_pack }} (Pack/Box)</td>
                                <td>{{ $d->qty_ready_pcs }} (Pcs/Lbr)</td>
                                <td>{{ $d->qty_sample_riil }}</td>
                                <td>{{ $d->qty_sample_aql }}</td>
                                <td>{{ $d->defect }}</td>
                                <td>{{ $d->kriteria }}</td>
                                <td>{{ $d->qty_defect }}</td>
                                <td>{{ $d->qty_reject_all }}</td>
                                <td>{{ $d->status }}</td>
                                <td>{{ $d->keterangan }}</td>
                                <td>{{ $d->hasil_verifikasi }}</td>
                                <td>
                                    @if(isset($d->picture_1))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_1 }}" alt="defect-img" width="200">Foto 1</a> /
                                    @endif
                                    @if(isset($d->picture_2))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_2 }}" alt="defect-img" width="200">Foto 2</a> /
                                    @endif
                                    @if(isset($d->picture_3))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_3 }}" alt="defect-img" width="200">Foto 3</a> /
                                    @endif
                                    @if(isset($d->picture_4))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_4 }}" alt="defect-img" width="200">Foto 4</a> /
                                    @endif
                                    @if(isset($d->picture_5))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_5 }}" alt="defect-img" width="200">Foto 5</a>
                                    @endif
                                </td>

                                <!-- <td><a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_1 }}" alt="defect-img" width="200">Foto 1</a> /
                                    <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_2 }}" alt="defect-img" width="200">Foto 2</a> /
                                    <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_3 }}" alt="defect-img" width="200">Foto 3</a> /
                                    <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_4 }}" alt="defect-img" width="200">Foto 4</a> /
                                    <a target="_blank" href="{{ url('/') }}/images/defect/{{ $d->picture_5 }}" alt="defect-img" width="200">Foto 5</a>
                                </td> -->
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <button type="button" class="btn btn-info waves-effect pull-right waves-light" onclick="postConfirmation()">POST</i></button>
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

    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/final-delete/'+id;
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    };

    function postConfirmation() {
        var urlsite = "http://"+window.location.hostname+':8000/final-post/';
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin menginput data ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Input Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    };

    function checkHours(e){
        var sh = $("#jam_mulai").val();
        var eh = $("#jam_selesai").val();
        t1 = parseInt(sh.slice(0,2));
        t2 = parseInt(sh.slice(3,5));
        cek_jam = parseInt(sh.slice(0,2));
        cek_menit = parseInt(sh.slice(3,5));


        if (cek_menit == 59){
            t1 = t1+1;
            t2 = "00";
        } else {
            t2 = t2+1;
        }

        if (cek_jam < 10 ){
            t1 = "0"+t1;
        }

        if (cek_menit < 10 ){
            t2 = "0"+t2;
        }

        var stt = new Date("November 13, 2013 " + sh);
        stt = stt.getTime();

        var endt = new Date("November 13, 2013 " + eh);
        endt = endt.getTime();

        if (stt >= endt) {
            alert('Jam Selesai harus lebih besar dari Jam Mulai');
            document.getElementById("jam_selesai").value = t1+":"+t2;
            document.getElementById("jam_selesai").focus();
        }
    }

    function loadHours() {
        const event = new Date();
        var h = event.getHours();
        var m = event.getMinutes();
        var m2 = event.getMinutes();

        m2 = m2+2;

        if (h < 10) {
            h = "0"+h;
        }

        if (m < 10) {
            m = "0"+m;
        }

        if (m2 < 10) {
            m2 = "0"+m2;
        }


        document.getElementById("jam_mulai").value = h+":"+m;
        document.getElementById("jam_selesai").value = h+":"+m2;
    }

    function resetdata() {
        document.getElementById("final_data").reset();
        $("select.select2").select2({ allowClear: true });
    }

</script>

<script>
    if ( window.history.replaceState ) {
       window.history.replaceState( null, null, window.location.href );
    }
</script>

@endsection
