@extends('layouts.main', ['title' => 'Dashboard'])

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Dashboard</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <!-- Default box -->
    {{-- <h1 id="batas-transisi" class="mb-3"></h1> --}}
    {{-- <h1 id="demo" class="mb-5"></h1> --}}

    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$sni_wajib}}</h3>

                  <h4>SNI Wajib</h4>
                </div>
                <div class="icon">
                  <i class="fas fa-earth-asia"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$sni_sukarela}}</h3>

                  <h4>SNI Sukarela</h4>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding-heart"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{$sk_total}}</h3>

                  <h4>Total SNI</h4>
                </div>
                <div class="icon">
                  <i class="fas fa-folder-open"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="statistik-sk-penetapan-sni-pie-chart">

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="statistik-identifikasi-petugas-stacked-bar-chart">

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="statistik-pembahasan-sni-pie-chart">

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="statistik-masa-transisi-sni-pie-chart">

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Masa Transisi SNI Lama</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-hover" id="masa-transisi-sni-dt">
                <thead class="bg-info text-white">
                    <tr>
                        <th>No</th>
                        <th style="width: 23%">SNI Revisi</th>
                        <th style="width: 23%">SNI Direvisi</th>
                        <th style="width: 20%">Nomor KEPKA</th>
                        <th>Batas Transisi</th>
                        <th>Masa Berlaku</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">SNI Lama - Pencabutan</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-hover" id="sni-lama-pencabutan-dt">
                <thead class="bg-warning text-white">
                    <tr>
                        <th>No</th>
                        <th>Nomor SNI</th>
                        <th style="width: 25%">Judul SNI</th>
                        <th>Komite Teknis</th>
                        <th>Nomor KEPKA</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    
@endsection

@push('css')
    
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // $.ajax({
            //     type: "GET",
            //     url: "/dashboard/test",
            //     dataType: "JSON",
            //     success: function (response) {

            //         $('#batas-transisi').html(response.data.batas_transisi);

            //         // Set the date we're counting down to
            //         var countDownDate = new Date(response.data.batas_transisi).getTime();

            //         // Update the count down every 1 second
            //         var x = setInterval(function() {

            //             // Get today's date and time
            //             var now = new Date().getTime();

            //             // Find the distance between now and the count down date
            //             var distance = countDownDate - now;

            //             // Time calculations for years, months, days, hours, minutes and seconds
            //             var years = Math.floor(distance / (1000 * 60 * 60 * 24 * 30 * 12));
            //             var months = Math.floor(distance % (1000 * 60 * 60 * 24 * 30 * 12) / (1000 * 60 * 60 * 24 * 30));
            //             var days = Math.floor(distance % (1000 * 60 * 60 * 24 * 30) / (1000 * 60 * 60 * 24));
            //             var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            //             var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            //             var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            //             // Display the result in the element with id="demo"
            //             document.getElementById("demo").innerHTML = years + " tahun " + months + " bulan " + days + " hari " +
            //             hours + " jam " + minutes + " menit " + seconds + " detik ";

            //             // If the count down is finished, write some text
            //             if (distance < 0) {
            //                 clearInterval(x);
            //                 document.getElementById("demo").innerHTML = "EXPIRED";
            //             }
            //         }, 1000);

            //     }
            // });


            // Pie Chart SK Penetapan SNI
            Highcharts.chart('statistik-sk-penetapan-sni-pie-chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Statistik SK Penetapan SNI Revisi'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: 'SK Penetapan SNI',
                    data: [
                        { name: 'Teridentifikasi <br/> ('+{{$teridentifikasi}}+' SK )', y: {{$teridentifikasi}} },
                        { name: 'Belum Teridentifikasi <br/> ('+{{$belum_teridentifikasi}}+' SK )', y: {{$belum_teridentifikasi}} },
                    ]
                }]
            });


            //Stacked Bar Chart Identifikasi Petugas
            Highcharts.chart('statistik-identifikasi-petugas-stacked-bar-chart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Statistik Identifikasi Petugas'
                },
                xAxis: {
                    categories: [
                        @foreach ($list_pic as $pic)
                            '{{$pic->pic}}',
                        @endforeach
                    ]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Penugasan Identifikasi SK'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'gray',
                            textOutline: 'none'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [
                    {
                        name: 'Teridentifikasi',
                        data: [
                                @foreach ($list_pic as $pic)
                                    {{ $pic->teridentifikasi }},
                                @endforeach
                            ]
                    },
                    {
                        name: 'Belum Teridentifikasi',
                        data: [
                                @foreach ($list_pic as $pic)
                                    {{ $pic->belum_teridentifikasi }},
                                @endforeach
                            ]
                    },
                ]
            });

            // Pie Chart pembahasan SNI
            Highcharts.chart('statistik-pembahasan-sni-pie-chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Statistik Pembahasan SNI'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: 'Pembahsan SNI',
                    data: [
                        { name: 'Belum dibahas <br/> ('+{{$belum_dibahas}}+' judul )', y: {{$belum_dibahas}} },
                        { name: 'Sudah dibahas <br/> ('+{{$sudah_dibahas}}+' judul )', y: {{$sudah_dibahas}} },
                    ]
                }]
            });

            // Pie Chart masa transisi SNI
            Highcharts.chart('statistik-masa-transisi-sni-pie-chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Statistik Masa Transisi SNI'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: 'Masa Transisi SNI',
                    data: [
                        { name: 'Pencabutan <br/> ('+{{$pencabutan}}+' judul )', y: {{$pencabutan}} },
                        { name: 'Transisi <br/> ('+{{$transisi}}+' judul )', y: {{$transisi}} },
                    ]
                }]
            });

            masa_transisi_sni_dt();

            function masa_transisi_sni_dt() {
                $('#masa-transisi-sni-dt').DataTable({
                    language: {
                        url: "/json/id.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'excel'
                    ],
                    serverside: true,
                    ajax: {
                        url: "/dashboard/masa-transisi-sni-dt",
                        type: "GET",
                        dataType: "JSON",
                    },
                    columnDefs: [{
                        className: "my_class", "targets": [ 4 ]
                    }],
                    columns: [
                        {
                            data : 'DT_RowIndex',
                            name : 'DT_RowIndex',
                            orderable : false,
                            searchable : false,
                        },
                        {
                            data : 'nmr_sni_baru',
                            name : 'nmr_sni_baru',
                            render : function(data, type, row) {
                                return row.nmr_sni_baru + ' ' + row.jdl_sni_baru;
                            }
                        },
                        {
                            data : 'nmr_sni_lama',
                            name : 'nmr_sni_lama',
                            render : function(data, type, row) {
                                return row.nmr_sni_lama + ' ' + row.jdl_sni_lama;
                            }
                        },
                        {
                            data : 'nmr_kepka',
                            name : 'nmr_kepka',
                        },
                        {
                            data : 'batas_transisi',
                            name : 'batas_transisi',
                        },
                        {
                            data : 'masa_berlaku',
                            render :
                            function(data, type, row) {

                                // Set the date we're counting down to
                                var countDownDate = new Date(row.batas_transisi).getTime();

                                // Get today's date and time
                                var now = new Date().getTime();

                                // Find the distance between now and the count down date
                                var distance = countDownDate - now;

                                // Time calculations for years, months, days, hours, minutes and seconds
                                var years = Math.floor(distance / (1000 * 60 * 60 * 24 * 365));
                                var months = Math.floor(distance % (1000 * 60 * 60 * 24 * 365) / (1000 * 60 * 60 * 24 * 30.41));
                                var days = Math.floor(distance % (1000 * 60 * 60 * 24 * 30.41) / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));


                                // Display the result in the element with id="demo"
                                var time = document.getElementsByClassName("my_class")
                                var remaining = time.innerHTML = years + " tahun " + months + " bulan " + days + " hari";

                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    return time.innerHTML = '<h4 class="badge badge-danger">KADALUARSA</h4>';
                                }
                                else {
                                    return remaining;
                                }
                            }
                        },
                    ],
                    order : [[4, 'asc']],
                });
            }

            sni_lama_pencabutan_dt();

            function sni_lama_pencabutan_dt() {
                $('#sni-lama-pencabutan-dt').DataTable({
                    language: {
                        url: "/json/id.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        'excel'
                    ],
                    serverside: true,
                    ajax: {
                        url: "/dashboard/sni-lama-pencabutan-dt",
                        type: "GET",
                        dataType: "JSON",
                    },
                    columns: [
                        {
                            data : 'DT_RowIndex',
                            name : 'DT_RowIndex',
                            orderable : false,
                            searchable : false,
                        },
                        {
                            data : 'nmr_sni_lama',
                            name : 'nmr_sni_lama',
                        },
                        {
                            data : 'jdl_sni_lama',
                            name : 'jdl_sni_lama',
                        },
                        {
                            data : 'komtek',
                            name : 'komtek',
                        },
                        {
                            data : 'status_nodin',
                            name : 'status_nodin',
                            render : function(data, type, row) {
                                if(row.status_nodin == 0) {
                                    return '';
                                }
                                else {
                                    return row.nmr_kepka;
                                }
                            }
                        },
                    ],
                    order : [[1, 'asc']],
                });
            }
        });
    </script>
@endpush