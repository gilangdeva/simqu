@extends('admin.header')
@section('title', 'Users List - PT. Bintang Cakra Kencana')

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
                        <h3 class="box-title">LIST PENGGUNA</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/users-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Add User</button></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis User</th>
                                <th>Departemen</th>
                                <th>Sub Departemen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td><img src="{{ url('/') }}/images/users/{{ $user->picture }}" alt="user-img" width="36" class="img-circle"></td>
                                <td>{{ $user->kode_user }}</td>
                                <td>{{ $user->nama_user }}</td>
                                <td>{{ $user->jenis_user }}</td>
                                <td>{{ $user->nama_departemen }}</td>
                                <td>{{ $user->nama_sub_departemen }}</td>
                                <td>
                                    <a href="/users-edit/{{ Crypt::encrypt($user->id_user) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($user->id_user) }}')"><i class="fa fa-times"></i></button>
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
        var urlsite = "http://"+window.location.hostname+':8000/users-delete/'+id;
        swal("Apakah Anda yakin akan menghapus data ini?", {
        title: "Konfirmasi!",
        icon: "warning",
        buttons: {                 
                cancel: "Cancel",
                catch: {
                    text: "Delete",
                    value: "delete",
                },
                defeat: false,
            },
        })
        .then((value) => {
            switch (value) {
                case "delete": location.replace(urlsite);
                default: break;
            }
        });
    }
</script>
@include('admin.footer')

@endsection