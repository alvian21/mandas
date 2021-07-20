@extends('dashboard.main')
@section('content')
<style>
    .select2-search input { background-color: white; }
    /* .select2-search { background-color: black; } */
    .select2-results { background-color: black; }
    .select2-selection__choice__display{background-color: black}
    .donut1{
        width: 100% !important;
        height: 80% !important
    }

    .dataTables_empty{
        background-color: black !important
    }
    .progress {
        background-color: #aaa;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
</style>
<h2 class="page-title">DASHBOARD | MAINTENANCE</h2>
<div class="row">
    <div class="col-md-10">
        <section class="widget">
            <form id="formChart">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pilih" >Tipe Periode</label>
                            <select class="form-control pilih" name="pilih"  id="pilih">
                                <option value="bulanan" @if($maintenance['tipe_periode'] == 'bulanan') selected @endif>bulanan</option>
                                <option value="harian" @if($maintenance['tipe_periode'] == 'harian') selected @endif>harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                                <div class="form-group">
                                    <label for="periode">Periode</label>
                                    <input type="month" class="form-control" value="@if($maintenance['tipe_periode'] == 'bulanan'){{DateTime::createFromFormat('Ym',$maintenance['periode'])->format('Y-m')}}@elseif($maintenance['tipe_periode'] == 'harian'){{date('Y-m-d', strtotime($maintenance['periode']))}} @endif" id="periode" name="periode">
                                </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="plant" >Plant</label>
                           <select class="form-control plant" name="plant[]" multiple id="plant">
                            @forelse ($plant as $item)
                            @if(!empty($maintenance['plant']))
                            @php
                             $status = false;
                            @endphp
                             @forelse ($maintenance['plant'] as $row)
                                  @if ($item==$row)
                                         @php
                                             $status = true
                                         @endphp
                                  @endif
                             @empty

                             @endforelse
                             @if ($status)
                             <option value="{{$item}}" selected>{{$item}}</option>
                             @else
                             <option value="{{$item}}" >{{$item}}</option>
                             @endif
                             @else
                             <option value="{{$item}}">{{$item}}</option>
                             @endif
                            @empty

                            @endforelse
                           </select>
                       </div>
                    </div>

                </div>
              </form>
        </section>

    </div>
    <div class="col-md-2 text-center">
        <section class="widget mt-5" style="height: 70px">
        <button type="button" style="margin-top: 10px !important" class="btn btn-lg btn-primary btnsubmit mt-2">Submit</button>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <section class="widget">
            <div class="body no-margin">
                <h3 class="text-center"  style="font-weight: bold">OVERALL EQUIPMENT EFFECTIVENESS</h3>
            </div>
        </section>
    </div>
</div>
<div id="columnrow">
    {{-- <div class="row">
        <div class="col-md-3">
            <section class="widget">

                <div class="body no-margin">
                  <div class="chart">
                    <canvas id="donut1" class="donut1"  ></canvas>
                  </div>

                </div>
            </section>

        </div>
        <div class="col-md-3">
            <section class="widget">

                <div class="body no-margin">
                  <div class="chart">
                    <canvas id="donut2" class="donut2"  ></canvas>
                  </div>

                </div>
            </section>

        </div>
        <div class="col-md-3">
            <section class="widget">

                <div class="body no-margin">
                  <div class="chart">
                    <canvas id="donut3" class="donut3"  ></canvas>
                  </div>

                </div>
            </section>

        </div>
        <div class="col-md-3">
            <section class="widget">

                <div class="body no-margin">
                  <div class="chart">
                    <canvas id="donut4" class="donut4"  ></canvas>
                  </div>

                </div>
            </section>

        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-md-12">
        <section class="widget">
            <div class="body no-margin">
                <h3 class="text-center" style="font-weight: bold">MACHINE OUTPUT</h3>
              <div class="chart" style="margin-top: 5%">
                <canvas id="bar1" class="bar1"  ></canvas>
              </div>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <section class="widget">
            <div class="body no-margin">
                <h3 class="text-center" style="font-weight: bold">TOP 5 BREAKDOWN (Hours)</h3>
              <div class="chart">
                <canvas id="bar2" class="bar2"  ></canvas>
              </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="widget">
            <div class="body no-margin">
                <h3 class="text-center" style="font-weight: bold">TOP 5 BREAKDOWN (Repeat)</h3>
              <div class="chart">
                <canvas id="bar3" class="bar3"  ></canvas>
              </div>
            </div>
        </section>
    </div>
</div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('.plant').select2();
            $('.kodemesin').select2();
            $('.grpmesin').select2()
            $('#divgrpmesin').hide();
            $('#output').hide();
            var pilih = $('#pilih').find(':selected').val()
            var chartbar;
            var chartbar2;
            var chartbar3;
            var dataperiode = "{{$maintenance['periode']}}"
            if(pilih == 'bulanan'){
                    $('#periode').prop('type','month')
                    if(dataperiode != ''){
                        var periode = "@if(DateTime::createFromFormat('Ym',$maintenance['periode'])){{DateTime::createFromFormat('Ym',$maintenance['periode'])->format('Y-m')}}@endif";
                    setTimeout(function(){
                            $('#periode').val(periode)
                    },1000)
                }


            }else{
                    $('#periode').prop('type','date')
                    if(dataperiode != ''){
                    var periode = "{{date('Y-m-d', strtotime($maintenance['periode']))}}";
                    setTimeout(function(){
                            $('#periode').val(periode)
                    },1000)
                }

            }
            $('#pilih').on('change', function(){
                var pilih = $(this).val()

                if(pilih == 'bulanan'){
                    $('#periode').prop('type','month')
                }else{
                    $('#periode').prop('type','date')
                }

            })
            var columnrow = $('#columnrow');
            function addcolumnrow(data){
                var content = ""
                data.forEach(function(result, i) {
                    if(i == 0){
                        content+= '<div class="row">'
                    }

                    content += '<div class="col-md-3" > <section class="widget"><div class="body no-margin"><div class="chart">   <div style="width: 100%; height: 40px; position: absolute; top: 36%; left: 0; margin-top: 4px; line-height:19px; text-align: center; z-index: 999999999999999"><h4>'+parseFloat(result['Oee1']).toFixed(2)+'%</h4></div><canvas width="300"  height="300" id="donut'+i+'" class="donut1"></canvas></div>'
                    content += '<div class="row"> <div class="col-md-3" style="margin-top:1% !important"> <h6>Available</h6> </div> <div class="col-md-9"> <div class="progress" style="margin-top: 1rem !important" >'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Avai']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Avai']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Avai']).toFixed(2)+'%</div></div> </div> </div>'
                    content += '<div class="row"> <div class="col-md-3" style="margin-bottom:2% !important"> <h6>Performance</h6> </div> <div class="col-md-9"> <div class="progress">'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Rate']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Rate']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Rate']).toFixed(2)+'%</div></div> </div> </div>'
                    content += '<div class="row"> <div class="col-md-3" style="margin-bottom:2% !important"> <h6>Quality</h6> </div> <div class="col-md-9"> <div class="progress">'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Qual']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Qual']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Qual']).toFixed(2)+'%</div></div> </div> </div>'

                    content += '</div></section></div>'

                    if(i!=0 && i%5 == 0){

                    // add end of row ,and start new row on every 5 elements
                        content += '</div><div class="row">'

                    }


                });

                content += '</div>'
                columnrow.html(content)

                data.forEach(function(result, i) {
                    chartdonut(result["kodemesin"], result["Oee1"], i)
                });


            }

            function chartdonut(label,data,i){
                var resdata = 100 - data;
                var data = {
                    labels: [label],
                    datasets: [
                        {
                        data:[data,resdata],
                        backgroundColor: [
                            "#36A2EB",
                            "rgba(0,0,0,0)"
                        ],
                        hoverBackgroundColor: [
                            "#36A2EB",
                            "rgba(0,0,0,0)"
                        ]
                        }]
                    };

                    var chartdonut = new Chart(document.getElementById('donut'+i), {
                    type: 'doughnut',
                    data: data,
                    options: {

                        legend:{
                            labels: {
                            fontColor: "white",
                            fontSize: 16,
                            boxWidth: 0
                        }
                        },
                        responsive: true,
                        plugins: {
                            datalabels: {
                                display:false
                            }
                        }
                    }
                    });

            }

            function bar1(label,data,color){
                var bar1 = document.getElementById('bar1').getContext('2d');
                if (typeof(chartbar) != "undefined") {
                    chartbar.destroy();
                }
                chartbar = new Chart(bar1, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        legend: {
                                display: false
                            },
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                            xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                         }],
                         yAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                         }],

                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: function(value, context) {
                                return Math.round(value).toLocaleString() ;
                                },
                                color: 'white',
                                font: {
                                weight: 'bold'
                                }
                            }
                        },

                    }
                });
            }


            function bar2(label,data, color){
                var bar2 = document.getElementById('bar2').getContext('2d');
                if (typeof(chartbar2) != "undefined") {
                    chartbar2.destroy();
                }
                chartbar2 = new Chart(bar2, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1,
                        }]
                    },
                    options: {
                           legend: {
                                display: false
                            },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                         }],
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: Math.round,
                                color: 'white',
                                font: {
                                weight: 'bold'
                                }
                            }
                        }
                    }
                });
            }

            function bar3(label,data, color){
                var bar3 = document.getElementById('bar3').getContext('2d');
                if (typeof(chartbar3) != "undefined") {
                    chartbar3.destroy();
                }
                chartbar3 = new Chart(bar3, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1,
                        }]
                    },
                    options: {
                           legend: {
                                display: false
                            },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                            xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                         }],
                        },
                        plugins: {
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: Math.round,
                                color: 'white',
                                font: {
                                weight: 'bold'
                                }
                            }
                        }
                    }
                });
            }


            function generateColour(){
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            }

            $.ajax({
                    url:"{{route('maintenance.chart')}}",
                    method:"GET",
                    data:{'klik':'true'},
                    success:function(data){

                        if(data['status'] == 'true'){
                            addcolumnrow(data['A'])
                            // chart bar 1
                            var kdmesinbar1 = []
                            var totberatbar1 = []
                            var oee1 = []
                            var colorbar1 = []
                            data['A'].forEach(element => {
                                kdmesinbar1.push(element['kodemesin'])
                                totberatbar1.push(element['totberat'])
                                oee1.push(element['Oee1'])
                                colorbar1.push(generateColour())
                            });

                            // chart bar 2
                            var kdmesinbar2 = []
                            var jambar2 = []
                            var colorbar2 = []
                            data['B'].forEach(element => {
                                kdmesinbar2.push(element['kodemesin'])
                                jambar2.push(element['jam'])
                                colorbar2.push(generateColour())
                            });

                            //chart bar 3
                            var kdmesin3 = []
                            var kalibar3 = []
                            var colorbar3 = []
                            data['C'].forEach(element => {
                                kdmesin3.push(element['kodemesin'])
                                kalibar3.push(element['kali'])
                                colorbar3.push(generateColour())
                            });
                            bar1(kdmesinbar1, totberatbar1,colorbar1)
                            bar2(kdmesinbar2,jambar2, colorbar2)
                            bar3(kdmesin3,kalibar3,colorbar3)
                        }

                }
            })
            $('.btnsubmit').on('click', function(){
                var form = $('#formChart').serialize()
                $.ajax({
                    url:"{{route('maintenance.chart')}}",
                    method:"GET",
                    data:form,
                    success:function(data){

                        addcolumnrow(data['A'])
                    // chart bar 1
                    var kdmesinbar1 = []
                    var totberatbar1 = []
                    var oee1 = []
                    var colorbar1 = []
                    data['A'].forEach(element => {
                        kdmesinbar1.push(element['kodemesin'])
                        totberatbar1.push(element['totberat'])
                        oee1.push(element['Oee1'])
                        colorbar1.push(generateColour())
                    });

                    // chart bar 2
                    var kdmesinbar2 = []
                    var jambar2 = []
                    var colorbar2 = []
                    data['B'].forEach(element => {
                        kdmesinbar2.push(element['kodemesin'])
                        jambar2.push(element['jam'])
                        colorbar2.push(generateColour())
                    });

                    //chart bar 3
                    var kdmesin3 = []
                    var kalibar3 = []
                    var colorbar3 = []
                    data['C'].forEach(element => {
                        kdmesin3.push(element['kodemesin'])
                        kalibar3.push(element['kali'])
                        colorbar3.push(generateColour())
                    });
                    bar1(kdmesinbar1, totberatbar1,colorbar1)
                    bar2(kdmesinbar2,jambar2, colorbar2)
                    bar3(kdmesin3,kalibar3,colorbar3)

                }
            })
        })


        });
    </script>

@endpush
