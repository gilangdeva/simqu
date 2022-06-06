@extends('admin.header')
@section('title', 'Inspeksi Final List - SIMQU')

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
                        <h3 class="box-title">LIST INSPEKSI FINAL</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/final-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div>
                </div>

                <label class="form-inline">Show
                    <select id="demo-show-entries" class="form-control input-sm">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select> entries
                </label>

                <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="8">
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
                            <th data-hide="all">Jam Mulai</th>
                            <th data-hide="all">Jam Selesai</th>
                            <th data-hide="all">Lama Inspeksi</th>
                            <th data-hide="all">Kendala</th>
                            <th data-hide="all">Kriteria</th>
                            <th data-hide="all">Jml Temuan</th>
                            <th data-hide="all">Brg Siap</th>
                            <th data-hide="all">Status</th>
                            <th data-hide="all">Keterangan</th>
                            <th data-hide="all">Qty Siap</th>
                            <th data-hide="all">Sample Aql</th>
                            <th data-hide="all">Sample Riil</th>
                            <th data-hide="all">Reject All</th>
                            <th data-hide="all">Hasil Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_final as $lf)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lf->tgl_inspeksi }}</td>
                                <td>{{ $lf->shift }}</td>
                                <td>{{ $lf->nama_departemen }} - {{ $lf->nama_sub_departemen }}</td>
                                <td>{{ $lf->jop }}</td>
                                <td>{{ $lf->nama_user }}</td>
                                <td><button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($lf->id_inspeksi_detail) }}')"><i class="fa fa-trash"></i></button></td>
                                <td>{{ $lf->item }}</td>
                                <td>{{ $lf->jam_mulai }}</td>
                                <td>{{ $lf->jam_selesai }}</td>
                                <td>{{ $lf->lama_inspeksi }} (Menit)</td>
                                <td>{{ $lf->defect }}</td>
                                <td>{{ $lf->kriteria }}</td>
                                <td>{{ $lf->qty_defect }}</td>
                                <td>{{ $lf->qty_ready_pcs }} (Pcs/Lbr)</td>
                                <td>{{ $lf->status }}</td>
                                <td>{{ $lf->keterangan }}</td>
                                <td>{{ $lf->qty_ready_pack }} (Pack/Box)</td>
                                <td>{{ $lf->qty_sample_aql }}</td>
                                <td>{{ $lf->qty_sample_riil }}</td>
                                <td>{{ $lf->qty_reject_all }} (Pcs)</td>
                                <td>{{ $lf->hasil_verifikasi }}</td>
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
