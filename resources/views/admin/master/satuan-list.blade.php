@extends('admin.header')
@section('title', 'Satuan List - SIMQU')

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
                        <h3 class="box-title">LIST SATUAN</h3>
                    </div>
                    {{-- <div class="col-sm-6 col-xs-12">
                        <a href="/satuan-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Tambah Data</button></a>
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Satuan</th>
                                <th>Nama Satuan</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($satuan as $sat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sat->kode_satuan }}</td>
                                <td>{{ $sat->nama_satuan }}</td>
                                {{-- <td>
                                    <a href="/satuan-edit/{{ Crypt::encrypt($sat->id_satuan) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($sat->id_satuan) }}')"><i class="fa fa-times"></i></button>
                                </td> --}}
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
{{-- <script>
    function deleteConfirmation(id) {
        var urlsite = "http://"+window.location.hostname+':8000/satuan-delete/'+id;
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
</script> --}}
@include('admin.footer')

@endsection
