@extends('admin.header')
@section('title', 'Inspeksi Approval List - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="box-title">LIST APPROVAL INSPEKSI INLINE</h1>
                    </div>
                    <form action="{{ route('inspeksi.approval-list') }}" id="f_approval" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-6">
                            <div class="col-sm-5"><label></label></div>
                            <div class="col-sm-6">
                                    <input type="text" class="form-control" name="text_search" id="text_search" maxlength="200" placeholder="Search...">
                            </div>

                            <div class="col-sm-1">
                                <button class="btn btn-primary waves-effect pull-right waves-light" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>

                <table id="demo-foo-row-toggler" class="table toggle-circle table-hover">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Tgl</th>
                            <th data-hide="phone">Shift</th>
                            <th data-hide="phone">Area</th>
                            <th>JOP</th>
                            <th data-hide="phone">Item</th>
                            <th data-hide="phone">Diajukan Tgl</th>
                            <th data-hide="phone">Status</th>
                            <th data-hide="all">Inspektor</th>
                            <th data-hide="all">Mesin</th>
                            <th data-hide="all">Output/1 mnt</th>
                            <th data-hide="all">Output/5 mnt</th>
                            <th data-hide="all">PIC</th>
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Lama Inspeksi</th>
                            <th data-hide="all">Kendala</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Jml Temuan</th>
                            <th data-hide="all">Brg Siap</th>
                            <th data-hide="all">Jml Sampling</th>
                            <th data-hide="all">Penyebab</th>
                            <th data-hide="all">Keterangan</th>
                            <th data-hide="all">Foto</th>
                            <th data-hide="all">Video</th>
                            <th data-hide="phone">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_approval_inline as $lai)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lai->tgl_inspeksi }}</td>
                                <td>{{ $lai->shift }}</td>
                                <td>{{ $lai->nama_departemen }} - {{ $lai->nama_sub_departemen }}</td>
                                <td>{{ $lai->jop }}</td>
                                <td>{{ $lai->item }}</td>
                                <td>{{ date('d/m/Y', strtotime($lai->created_at)) }}</td>
                                <td>{{ $lai->status }}</td>
                                <td>{{ $lai->nama_user }}</td>
                                <td>{{ $lai->nama_mesin }}</td>
                                <td>{{ $lai->qty_1 }}</td>
                                <td>{{ $lai->qty_5 }}</td>
                                <td>{{ $lai->pic }}</td>
                                <td>{{ $lai->jam_mulai }}</td>
                                <td>{{ $lai->jam_selesai }}</td>
                                <td>{{ $lai->lama_inspeksi }} Menit</td>
                                <td>{{ $lai->defect }}</td>
                                <td>{{ $lai->kriteria }}</td>
                                <td>{{ $lai->qty_defect }}</td>
                                <td>{{ $lai->qty_ready_pcs }} (Pcs/Lbr)</td>
                                <td>{{ $lai->qty_sampling }}</td>
                                <td>{{ $lai->penyebab }}</td>
                                <td>{{ $lai->keterangan }} </td>
                                <td>
                                    @if(isset($lai->picture_1))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $lai->picture_1 }}" width="200">Picture 1</a>
                                    @endif

                                    @if(isset($lai->picture_2))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $lai->picture_2 }}" width="200">Picture 2</a>
                                    @endif

                                    @if(isset($lai->picture_3))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $lai->picture_3 }}" width="200">Picture 3</a>
                                    @endif

                                    @if(isset($lai->picture_4))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $lai->picture_4 }}" width="200">Picture 4</a>
                                    @endif

                                    @if(isset($lai->picture_5))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $lai->picture_5 }}" width="200">Picture 5</a>
                                    @endif

                                    @if((isset($lai->picture_1)) || (isset($lai->picture_2)) || (isset($lai->picture_3)) || (isset($lai->picture_4)) || (isset($lai->picture_5)))
                                        | <button alt="default" data-toggle="modal" data-target="#myModal" onclick="checkPic('{{ $lai->picture_1 }}','{{ $lai->picture_2 }}', '{{ $lai->picture_3 }}', '{{ $lai->picture_4 }}', '{{ $lai->picture_5 }}')">Lihat</button>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($lai->video_1))
                                        <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $lai->video_1 }}" width="200">Video 1</a>
                                    @endif

                                    @if(isset($lai->video_2))
                                        / <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $lai->video_2 }}" width="200">Video 2</a>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-circle" onclick="deleteConfirmationInline('{{ Crypt::encryptString($lai->id_inspeksi_detail) }}')"><i class="fa fa-check"></i></button>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="keepConfirmationInline('{{ Crypt::encryptString($lai->id_inspeksi_detail) }}')"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <div class="text-right">
                                    <ul class="pagination pagination-split m-t-30"> </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Preview Gambar Temuan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel-wrapper p-b-10 collapse in">
                                    <div id="owl-demo" class="owl-carousel owl-theme">
                                        <div class="item"><img src="" id="img_1" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_2" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_3" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_4" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_5" style="max-width: 100%;" alt="Owl Image"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="col-sm-6 col-xs-12">
                    <h1 class="box-title">LIST APPROVAL INSPEKSI FINAL</h1>
                </div>
                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="10">
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Tgl</th>
                            <th data-hide="phone">Shift</th>
                            <th data-hide="phone">Area</th>
                            <th>JOP</th>
                            <th data-hide="phone">Item</th>
                            <th data-hide="phone">Diajukan Tgl</th>
                            <th data-hide="phone">Status</th>
                            <th data-hide="all">Inspektor</th>
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Lama Inspeksi</th>
                            <th data-hide="all">Brg Siap (Pack)</th>
                            <th data-hide="all">Brg Siap (Pcs)</th>
                            <th data-hide="all">Qty Riil</th>
                            <th data-hide="all">Qty Aql</th>
                            <th data-hide="all">Kendala</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Qty Reject</th>
                            <th data-hide="all">Keterangan</th>
                            <th data-hide="all">Verifikasi</th>
                            <th data-hide="all">Foto</th>
                            <th data-hide="all">Video</th>
                            <th data-hide="phone">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_approval_final as $laf)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laf->tgl_inspeksi }}</td>
                                <td>{{ $laf->shift }}</td>
                                <td>{{ $laf->nama_departemen }} - {{ $laf->nama_sub_departemen }}</td>
                                <td>{{ $laf->jop }}</td>
                                <td>{{ $laf->item }}</td>
                                <td>{{ date('d/m/Y', strtotime($laf->created_at)) }}</td>
                                <td>{{ $laf->status }}</td>
                                <td>{{ $laf->nama_user }}</td>
                                <td>{{ $laf->jam_mulai }}</td>
                                <td>{{ $laf->jam_selesai }}</td>
                                <td>{{ $laf->lama_inspeksi }} Menit</td>
                                <td>{{ $laf->qty_ready_pack }}</td>
                                <td>{{ $laf->qty_ready_pcs }}</td>
                                <td>{{ $laf->qty_sample_riil }}</td>
                                <td>{{ $laf->qty_sample_aql }}</td>
                                <td>{{ $laf->defect }}</td>
                                <td>{{ $laf->kriteria }}</td>
                                <td>{{ $laf->qty_reject_all }}</td>
                                <td>{{ $laf->keterangan }}</td>
                                <td>{{ $laf->hasil_verifikasi }} </td>
                                <td>
                                    @if(isset($laf->picture_1))
                                        <a target="_blank" href="{{ url('/') }}/images/defect/{{ $laf->picture_1 }}" width="200">Picture 1</a>
                                    @endif

                                    @if(isset($laf->picture_2))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $laf->picture_2 }}" width="200">Picture 2</a>
                                    @endif

                                    @if(isset($laf->picture_3))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $laf->picture_3 }}" width="200">Picture 3</a>
                                    @endif

                                    @if(isset($laf->picture_4))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $laf->picture_4 }}" width="200">Picture 4</a>
                                    @endif

                                    @if(isset($laf->picture_5))
                                        / <a target="_blank" href="{{ url('/') }}/images/defect/{{ $laf->picture_5 }}" width="200">Picture 5</a>
                                    @endif

                                    @if((isset($laf->picture_1)) || (isset($laf->picture_2)) || (isset($laf->picture_3)) || (isset($laf->picture_4)) || (isset($laf->picture_5)))
                                        | <button alt="default" data-toggle="modal" data-target="#myModal" onclick="checkPic('{{ $laf->picture_1 }}','{{ $laf->picture_2 }}', '{{ $laf->picture_3 }}', '{{ $laf->picture_4 }}', '{{ $laf->picture_5 }}')">Lihat</button>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($laf->video_1))
                                        <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $laf->video_1 }}" width="200">Video 1</a>
                                    @endif

                                    @if(isset($laf->video_2))
                                        / <a target="_blank" href="{{ url('/') }}/videos/defect/{{ $laf->video_2 }}" width="200">Video 2</a>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-circle" onclick="deleteConfirmationFinal('{{ Crypt::encryptString($laf->id_inspeksi_detail) }}')"><i class="fa fa-check"></i></button>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="keepConfirmationFinal('{{ Crypt::encryptString($laf->id_inspeksi_detail) }}')"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="11">
                                <div class="text-right">
                                    <ul class="pagination pagination-split m-t-30"> </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">Preview Gambar Temuan</h4> </div>
                            <div class="modal-body">
                                <div class="panel-wrapper p-b-10 collapse in">
                                    <div id="owl-demo" class="owl-carousel owl-theme">
                                        <div class="item"><img src="" id="img_1" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_2" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_3" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_4" style="max-width: 100%;" alt="Owl Image"></div>
                                        <div class="item"><img src="" id="img_5" style="max-width: 100%;" alt="Owl Image"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end container-fluid -->
<script>
    function deleteConfirmationInline(id) {
        var urlsite = "http://"+window.location.hostname+':8000/approval-inline-delete/'+id;
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
    }

    function keepConfirmationInline(id) {
        var urlsite = "http://"+window.location.hostname+':8000/approval-inline-keep/'+id;
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin tetap menyimpan data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    }

    function deleteConfirmationFinal(id) {
        var urlsite = "http://"+window.location.hostname+':8000/approval-final-delete/'+id;
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
    }

    function keepConfirmationFinal(id) {
        var urlsite = "http://"+window.location.hostname+':8000/approval-final-keep/'+id;
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin tetap menyimpan data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result) {
                if (result.isConfirmed) {
                    location.replace(urlsite);
                }
            }
        })
    }

    function checkPic(pic_1, pic_2, pic_3, pic_4, pic_5){
        var p1 = pic_1;
        var p2 = pic_2;
        var p3 = pic_3;
        var p4 = pic_4;
        var p5 = pic_5;

        if (p1 == '') {
            p1 = 'Blank.jpg';
        }

        if (p2 == '') {
            p2 = 'Blank.jpg';
        }

        if (p3 == '') {
            p3 = 'Blank.jpg';
        }

        if (p4 == '') {
            p4 = 'Blank.jpg';
        }

        if (p5 == '') {
            p5 = 'Blank.jpg';
        }

        $("#img_1").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p1);
        $("#img_2").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p2);
        $("#img_3").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p3);
        $("#img_4").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p4);
        $("#img_5").attr("src","http://"+window.location.hostname+":8000/images/defect/"+p5);
    }
</script>
@include('admin.footer')

@endsection
