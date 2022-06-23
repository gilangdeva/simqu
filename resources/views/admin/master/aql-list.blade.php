@extends('admin.header')
@section('title', 'AQL List - SIMQU')

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
                        <h3 class="box-title">LIST AQL</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/aql-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Level</th>
                                <th>Kode AQL</th>
                                <th>Brg Siap Min</th>
                                <th>Brg Siap Max</th>
                                <th>Qty Sample AQL</th>
                                <th>Qty Accept Minor</th>
                                <th>Qty Accept Major</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aql as $e_aql)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $e_aql->level_aql }}</td>
                                <td>{{ $e_aql->kode_aql }}</td>
                                <td>{{ $e_aql->qty_lot_min }}</td>
                                <td>{{ $e_aql->qty_lot_max }}</td>
                                <td>{{ $e_aql->qty_sample_aql }}</td>
                                <td>{{ $e_aql->qty_accept_minor }}</td>
                                <td>{{ $e_aql->qty_accept_major }}</td>
                                <td>
                                    <a href="/aql-edit/{{ Crypt::encrypt($e_aql->id_aql) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($e_aql->id_aql) }}')"><i class="fa fa-times"></i></button>
                                </td>
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
<script>
    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/aql-delete/'+id;
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
