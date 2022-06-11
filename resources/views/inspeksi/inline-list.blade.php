@extends('admin.header')
@section('title', 'Inspeksi Inline List - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <div class="row">
                    <form action="{{ route('inline.filter') }}" id="inline_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                        <div class="col-sm-6">
                            <div class="col-sm-2"><label>Periode :</label></div>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="start_date" value="{{ date('Y-m-01') }}">
                            </div>

                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-3">
                                <select class="form-control select-option" name="type_search" id="type_search">
                                    <option value="0">Pilih Filter :</option>
                                    <option value="JOP">JOP</option>
                                    <option value="ITEM">Nama Item</option>
                                    <option value="INSPEKTOR">Inspektor</option>
                                </select>
                            </div>

                            <div class="col-sm-7">
                                    <input type="text" class="form-control" name="text_search" id="text_search" maxlength="200" placeholder="Search...">
                            </div>

                            <div class="col-sm-1">
                                <button class="btn btn-primary waves-effect pull-right waves-light" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">LIST INSPEKSI INLINE</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/inline-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div>
                </div>

                <label class="form-inline">Tampilkan 
                    <select id="demo-show-entries" class="form-control input-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20" selected>20</option>
                    </select> data
                </label>

<<<<<<< HEAD
                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="20">
=======
                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny inspeksi-list" data-page-size="8">
>>>>>>> 75a1eb2d7f42b545198cd7c1b1ee36dcd60a1d6c
                    <thead>
                        <tr>
                            <th data-toggle="true">No.</th>
                            <th>Tgl</th>
                            <th>Shift</th>
                            <th>Area</th>
                            <th>JOP</th>
                            <th>Inspektor</th>
                            <th>Hapus</th>
                            <th data-hide="all">Item</th>
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
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Keterangan</th>
                            <th data-hide="all">Foto Temuan Defect</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_inline as $li)
                            <tr height="-10px;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $li->tgl_inspeksi }}</td>
                                <td>{{ $li->shift }}</td>
                                <td>{{ $li->nama_departemen }} - {{ $li->nama_sub_departemen }}</td>
                                <td>{{ $li->jop }}</td>
                                <td>{{ $li->nama_user }}</td>
                                <td><button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($li->id_inspeksi_detail) }}')"><i class="fa fa-trash"></i></button></td>
                                <td>{{ $li->item }}</td>
                                <td>{{ $li->nama_mesin }}</td>
                                <td>{{ $li->qty_1 }}</td>
                                <td>{{ $li->qty_5 }}</td>
                                <td>{{ $li->pic }}</td>
                                <td>{{ $li->jam_mulai }}</td>
                                <td>{{ $li->jam_selesai }}</td>
                                <td>{{ $li->lama_inspeksi }} Menit</td>
                                <td>{{ $li->defect }}</td>
                                <td>{{ $li->kriteria }}</td>
                                <td>{{ $li->qty_defect }}</td>
                                <td>{{ $li->qty_ready_pcs }} (Pcs/Lbr)</td>
                                <td>{{ $li->qty_sampling }}</td>
                                <td>{{ $li->penyebab }}</td>
                                <td>{{ $li->status }}</td>
                                <td>{{ $li->keterangan }}</td>
                                <td><img src="{{ url('/') }}/images/defect/{{ $li->capt_pict }}" width="200"></td>
                                {{-- <td><a class=href="{{ url('/') }}/images/defect/">{{ $li->pict_defect }}</td> --}}
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="text-right">
                                    <ul class="pagination pagination-split m-t-30"> </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
<script>
    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/inlinelist-delete/'+id;
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
</script>
@include('admin.footer')

@endsection
