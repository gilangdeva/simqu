@extends('admin.header')
@section('title', 'Input Mesin - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">INPUT DATA MESIN</h3>
                <form class="form-horizontal" action="{{ route('mesin.save') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Kode Mesin</label>
                        <div class="col-sm-8">
                            @if (isset($select->kode_mesin))
                                <input type="text" class="form-control" name="kode_mesin" maxlength="4" value="{{ $select->kode_mesin }}" required>
                            @else
                                <input type="text" class="form-control" name="kode_mesin" maxlength="4" placeholder="Kode Mesin" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Departemen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_departemen" required>
                                <option value="0">Pilih Departemen</option>
                                @foreach ($departemen as $dept)
                                    @if (isset($select->id_departemen))
                                        <option value="{{ $dept->id_departemen }}" {{ old('id_departemen', $select->id_departemen) == $dept->id_departemen ? 'selected':''}}>{{ $dept->nama_departemen }}</option>
                                    @else
                                        <option value="{{ $dept->id_departemen }}">{{ $dept->nama_departemen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Sub Dept</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="id_sub_departemen" id="id_sub_departemen" required>
                                @if(isset($sub_dept))
                                    <option value="">Pilih Sub Departemen</option>
                                    @foreach ($sub_dept as $s)
                                        <option value="{{ $s->id_sub_departemen }}">{{ $s->nama_sub_departemen }}</option>
                                    @endforeach
                                @else
                                    <option value="">Pilih Sub Departemen</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <label class="col-sm-4 control-label">Nama Mesin</label>
                        <div class="col-sm-8">
                            @if (isset($select->kode_mesin))
                                <input type="text" class="form-control" name="nama_mesin" maxlength="20" value="{{ $select->kode_mesin }}" required>
                            @else 
                                <input type="text" class="form-control" name="nama_mesin" maxlength="20" placeholder="Nama Mesin" required>
                            @endif
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom:3px;">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/mesin"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    </div>
<!-- end container-fluid -->

@include('admin.footer')

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="id_departemen"]').on('change', function() {
            var departemenID = $(this).val();
            if(departemenID) {
                $.ajax({
                    url: '/mesin-sub/'+departemenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (data){
                            $('select[name="id_sub_departemen"]').empty();
                            $('select[name="id_sub_departemen"]').append('<option value="0" selected>Pilih Sub Departemen</option>');
                            // Remove options
                            $('#id_sub_departemen').select2();
                            for (var i=0;i<data.length;i++) {
                                $('select[name="id_sub_departemen"]').append('<option value="'+ data[i].id_sub_departemen +'">'+ data[i].nama_sub_departemen +'</option>');
                            };
                        } else {
                            $('select[name="id_sub_departemen"]').empty();
                        }
                    }
                });
            }else{
                $('select[name="id_sub_departemen"]').empty();
            }
        });
    });
</script>

@endsection
