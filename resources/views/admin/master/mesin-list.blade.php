@extends('admin.header')
@section('title', 'Mesin List - PT. Bintang Cakra Kencana')

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
                        <h3 class="box-title">LIST MESIN</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/mesin-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Add Mesin</button></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Mesin</th>
                                <th>Nama Mesin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mesin as $machine)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $machine->kode_mesin }}</td>
                                <td>{{ $machine->nama_mesin }}</td>   
                                <td>
                                    <a href="/mesin-edit/{{ Crypt::encrypt($machine->id_mesin) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($machine->id_mesin) }}')"><i class="fa fa-times"></i></button>
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
        var urlsite = "http://"+window.location.hostname+':8000/mesin-delete/'+id;
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