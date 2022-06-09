@extends('admin.header')
@section('title', 'Inspeksi Final List - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="white-box">
        <div class="container">
                <div class="row">
                    <form id="final_data" class="form-horizontal" method="GET" enctype="multipart/form-data">
                    <div class="col-sm-1 control-label"><label>Periode :</label></div>
                        <div class="col">
                            <div class="col-sm-2">
                                <input type="date" class="form-control" name="start_date" value="{{ date('Y-01-m') }}">
                            </div>

                            <div class="col-sm-2">
                                <input type="date" class="form-control" name="end_date" value="{{ date('Y-d-m') }}">
                            </div>

                            <div class="col-sm-2">
                                <select class="form-control select-option" name="type_search" id="type_search">
                                    <option value="0">Pilih Filter :</option>
                                    <option value="JOP">JOP</option>
                                    <option value="ITEM">Nama Item</option>
                                    <option value="INSPEKTOR">Inspektor</option>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                    <input type="text" class="form-control" name="text_search" id="text_search" maxlength="200" placeholder="Search...">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <button class="btn btn-info waves-effect  waves-light" type="submit">Cari</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="white-box">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h3 class="box-title">LIST INSPEKSI FINAL</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/final-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div>
                </div>

                <label class="form-final">Show
                    <select id="demo-show-entries" class="form-control input-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select> entries
                </label>

                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" date-page-size="8">
                        <thead>
                            <tr>
                                <th data-toggle="true">No.</th>
                                <th>Tgl</th>
                                <th>Shift</th>
                                <td>Bagian</th>
                                <th>Area</th>
                                <th>JOP</th>
                                <th>Inspektor</th>
                                <th>Hapus</th>
                                <th data-hide="all">Item</th>
                                <th data-hide="all">Jam Mulai</th>
                                <th data-hide="all">Jam Selesai</th>
                                <th data-hide="all">Lama Inspeksi</th>
                                <th data-hide="all">Brg Siap (Pack)</th>
                                <th data-hide="all">Brg Siap (Pcs)</th>
                                <th data-hide="all">Sample Aql</th>
                                <th data-hide="all">Sample Riil</th>
                                <th data-hide="all">Kendala</th>
                                <th data-hide="all">Kriteria</th>
                                <th data-hide="all">Jml Temuan</th>
                                <th data-hide="all">Jml Reject All</th>
                                <th data-hide="all">Status</th>
                                <th data-hide="all">Keterangan</th>
                                <th data-hide="all">Hasil Verifikasi</th>
                                <th data-hide="all"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_final as $lf)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lf->tgl_inspeksi }}</td>
                                <td>{{ $lf->shift }}</td>
                                <td>{{ $lf->nama_departemen }}</td>
                                <td>{{ $lf->nama_sub_departemen }}</td>
                                <td>{{ $lf->jop }}</td>
                                <td>{{ $lf->nama_user }}</td>
                                <td><button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($lf->id_inspeksi_detail) }}')"><i class="fa fa-trash"></i></button></td>
                                <td>{{ $lf->item }}</td>
                                <td>{{ $lf->jam_mulai }}</td>
                                <td>{{ $lf->jam_selesai }}</td>
                                <td>{{ $lf->lama_inspeksi }} (Menit)</td>
                                <td>{{ $lf->qty_ready_pack }} (Pack/Box)</td>
                                <td>{{ $lf->qty_ready_pcs }} (Pcs/Lbr)</td>
                                <td>{{ $lf->qty_sample_aql }}</td>
                                <td>{{ $lf->qty_sample_riil }}</td>
                                <td>{{ $lf->defect }}</td>
                                <td>{{ $lf->kriteria }}</td>
                                <td>{{ $lf->qty_defect }}</td>
                                <td>{{ $lf->qty_reject_all }}</td>
                                <td>{{ $lf->status }}</td>
                                <td>{{ $lf->keterangan }}</td>
                                <td>{{ $lf->hasil_verifikasi }}</td>
                                <td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <div class ="text-right">
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
</div>
</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
<script>
    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/finallist-delete/'+id;
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
