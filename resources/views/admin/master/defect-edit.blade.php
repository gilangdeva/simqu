@extends('admin.header')
@section('title', 'Edit Defect - PT. Bintang Cakra Kencana')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    
    <div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <h3 class="box-title">UBAH DATA DEFECT</h3>
                <form class="form-horizontal" action="{{ route('defect.update') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label class="col-md-12">Kode Defect</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control" name="id_defect" value="{{ $defect->id_defect }}" readonly autocomplete="false"> 
                            <input type="text" class="form-control" name="kode_defect" maxlength="10" placeholder="Kode Defect" value="{{ $defect->kode_defect }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Temuan Defect</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="defect" maxlength="20" placeholder="Temuan Defect" value="{{ $defect->defect }}" required> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-12">Kriteria Defect</label>
                        <div class="col-md-12">
                            <select id="kriteria_defect" class="form-control select2" name="kriteria_defect" maxlength="20" required>
                                <option value="Minor" {{ old('kriteria_defect', $defect->kriteria_defect) == "Minor" ? 'selected':''}}>Minor</option>
                                <option value="Major" {{ old('kriteria_defect', $defect->kriteria_defect) == "Major" ? 'selected':''}}>Major</option>
                                <option value="Critical" {{ old('kriteria_defect', $defect->kriteria_defect) == "Critical" ? 'selected':''}}>Critical</option>
                                {{-- <option value="Major">Major</option> --}}
                                {{-- <option value="Critical">Critical</option> --}}
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a href="/defect"><button type="button" class="btn btn-inverse waves-effect waves-light">Cancel</button></a>
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

@endsection