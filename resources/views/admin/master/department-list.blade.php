@extends('admin.header')
@section('title', 'List Departemen - SIMQU')

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
                        <h3 class="box-title">LIST DEPARTEMEN</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/department-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Departemen</th>
                                <th>Nama Departemen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($department as $departemen)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $departemen->kode_departemen }}</td>
                                <td>{{ $departemen->nama_departemen }}</td>
                                <td>
                                    <a href="/department-edit/{{ Crypt::encrypt($departemen->id_departemen) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($departemen->id_departemen) }}')"><i class="fa fa-times"></i></button>
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
        var urlsite = "http://"+window.location.hostname+':8000/department-delete/'+id;
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
