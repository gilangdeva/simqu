@extends('admin.header')
@section('title', 'Dashboard - SIMQU')

@section('content')

<!-- container-fluid -->
<div class="container-fluid">
    <!-- row -->
    <br>
    <div class="row">

        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Grafik Defect Tahun {{ date('Y') }}</h3>
                <ul class="list-inline text-right">
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #b8edf0;"></i>Minor</h5> </li>
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #b4c1d7;"></i>Major</h5> </li>
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #fcc9ba;"></i>Critical</h5> </li>
                </ul>
                <div>
                    <div id="morris-bar-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">TOT. INSPEKSI THN {{ date('Y') }}</h3>
                <ul class="list-inline two-part">
                    <li><i class="mdi mdi-marker-check text-success"></i></li>
                    <li class="text-right">
                        <span class="counter">
                            @if(isset($inspeksi_thn[0]))
                                {{ $inspeksi_thn[0]->total }}
                            @else 
                                0
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">TOT. INSPEKSI BLN {{ date('M Y') }}</h3>
                <ul class="list-inline two-part">
                    <li><i class="mdi mdi-clipboard-check text-info"></i></li>
                    <li class="text-right">
                        <span class="counter">
                            @if(isset($inspeksi_bln[0]))
                                {{ $inspeksi_bln[0]->total }}
                            @else 
                                0
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">TOT. INLINE</h3>
                <ul class="list-inline two-part">
                    <li><i class="mdi mdi-sync text-danger"></i></li>
                    <li class="text-right">
                        <span class="counter">
                            @if(isset($inspeksi_tot[0]))
                                {{ $inspeksi_tot[0]->total_inline }}
                            @else 
                                0
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">TOT. FINAL</h3>
                <ul class="list-inline two-part">
                    <li><i class="mdi mdi-wallet-giftcard text-warning"></i></li>
                    <li class="text-right">
                        <span class="counter">
                            @if(isset($inspeksi_tot[0]))
                                {{ $inspeksi_tot[0]->total_final }}
                            @else 
                                0
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end row -->

    {{-- Row --}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Grafik Inspeksi Tahun {{ date('Y') }}</h3>
                <ul class="list-inline text-right">
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #ff7676;"></i>Final</h5> </li>
                    <li><h5><i class="fa fa-circle m-r-5" style="color: #2cabe3;"></i>Inline</h5> </li>
                </ul>
                <div>
                    <div class="ct-sm-line-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Perbandingan Status Inline</h3>
                <div id="status-inline" style="height:300px;"></div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Perbandingan Status Final</h3>
                <div id="status-final" style="height:300px;"></div>
            </div>
        </div>
    </div>

    <input type="hidden" width="500px" id="bln" value="{{ $bulan }}">
    <input type="hidden" width="500px" id="inl" value="{{ $inline }}">
    <input type="hidden" width="500px" id="fin" value="{{ $final }}">
    {{-- End Row --}}
</div>
<!-- end container-fluid -->

@include('admin.footer')
<script>
    var status_inline = @json(json_encode($inspeksi_inline));
    var status_final = @json(json_encode($inspeksi_final));
    var defect = @json(json_encode($defect));

    var bln = document.getElementById('bln').value;
    var inl = document.getElementById('inl').value;
    var fin = document.getElementById('fin').value;

    $(document).ready(function () {
        // // Morris status
        Morris.Donut({
            element: 'status-inline',
            data: JSON.parse(status_inline),
            resize: true,
            colors:['#F90716', '#590696', '#30AADD', '#FBCB0A', '#14C38E', '#247881']
        });

        Morris.Donut({
            element: 'status-final',
            data: JSON.parse(status_final),
            resize: true,
            colors:['#FBCB0A','#F90716', '#14C38E', '#247881', '#30AADD', '#590696']
        });

        // Morris Defect
        Morris.Bar({
            element: 'morris-bar-chart',
            data: JSON.parse(defect),
            xkey: 'month',
            ykeys: ['minor', 'major', 'critical'],
            labels: ['Minor', 'Major', 'Critical'],
            barColors:['#b8edf0', '#b4c1d7', '#fcc9ba'],
            hideHover: 'auto',
            gridLineColor: '#eef0f2',
            resize: true
        });

        // Chartist Status
        new Chartist.Line('.ct-sm-line-chart', {
            labels: JSON.parse(bln),
            series: [JSON.parse(inl), JSON.parse(fin)]
            }, {
            fullWidth: true,
            
            plugins: [
                Chartist.plugins.tooltip()
            ],
            chartPadding: {
                right: 40
            }
        });
    });
</script>


@endsection