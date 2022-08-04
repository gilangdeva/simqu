<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>

    <style>
        td,
        th {
            font-size: 10.5pt;
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

    </style>

<div class="row">
    <div class="col-md-8">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3 class="box-title">REPORT QTY DEFECT INLINE  |  <b style="color: red"> DEPT :
                        @if(isset($report_qty_defect_inline[0]))
                            {{ $report_qty_defect_inline[0]->nama_departemen }} / {{ $bulan }}
                        @endif
                        </b>
                    </h3>
                </div>
            </div>

            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tahun</th>
                        <th>Nama Defect</th>
                        <th>Qty Defect</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report_qty_defect_inline as $rqdi)
                        <tr height="-10px;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rqdi->tahun }}</td>
                            <td>{{ $rqdi->defect }}</td>
                            <td>{{ $rqdi->qty }}</td>
                        </tr>
                    @endforeach

                </tbody>

                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<br><br><br><br><br>
<div class="row">
    <div class="col-md-8">
        <div class="white-box">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <h3 class="box-title">REPORT QTY DEFECT FINAL  |  <b style="color: red"> DEPT :
                        @if(isset($report_qty_defect_final[0]))
                            {{ $report_qty_defect_final[0]->nama_departemen }} / {{ $bulan }}
                        @endif
                        </b>
                    </h3>
                </div>
            </div>

            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tahun</th>
                        <th>Nama Defect</th>
                        <th>Qty Defect</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report_qty_defect_final as $rqdf)
                        <tr height="-10px;">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rqdf->tahun }}</td>
                            <td>{{ $rqdf->defect }}</td>
                            <td>{{ $rqdf->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>
<!-- end row -->
</div>
<!-- end container-fluid -->
