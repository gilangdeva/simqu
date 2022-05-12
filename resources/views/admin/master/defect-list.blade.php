@extends('admin.header')
@section('title', 'Defect List - PT. Bintang Cakra Kencana')

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
                        <h3 class="box-title">LIST DEFECT</h3>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="/defect-input"><button type="button" class="btn btn-info waves-effect pull-right waves-light">Add Defect</button></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tablebasic" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Defect</th>
                                <th>Temuan Defect</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($defect as $def)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $def->kode_defect }}</td>
                                <td>{{ $def->defect }}</td> 
                                <td>
                                    <a href="/defect-edit/{{ Crypt::encrypt($def->id_defect) }}"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-edit"></i> </button></a>
                                    <button type="button" class="btn btn-danger btn-circle" onclick="deleteConfirmation('{{ Crypt::encryptString($def->id_defect) }}')"><i class="fa fa-times"></i></button>
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
        var urlsite = "http://"+window.location.hostname+':8000/defect-delete/'+id;
        swal("Apakah Anda yakin akan menghapus data ini?", {
            title: 'Konfirmasi',
            icon: 'warning',
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