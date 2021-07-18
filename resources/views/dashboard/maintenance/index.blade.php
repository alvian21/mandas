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
<h2 class="page-title">Dashboard Maintenance</h2>
<div class="row">
    <div class="col-md-10">
        <section class="widget">
            <form id="formChart">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pilih" >Tipe Periode</label>
                            <select class="form-control pilih" name="pilih"  id="pilih">
                                <option value="bulanan">bulanan</option>
                                <option value="harian">harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                                <div class="form-group">
                                    <label for="periode">Periode</label>
                                    <input type="month" class="form-control" id="periode" name="periode">
                                </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="plant" >Plant</label>
                           <select class="form-control plant" name="plant[]" multiple id="plant">
                               <option value="1">1</option>
                               <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option>
                           </select>
                       </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="baris" >Baris</label>
                           <select class="form-control baris" name="baris"  id="baris">
                               <option value="-">-</option>
                               <option value="all">All</option>

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
              <div class="chart">
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
              <div class="chart">
                <canvas id="bar2" class="bar2"  ></canvas>
              </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="widget">
            <div class="body no-margin">
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
                    content += '<div class="progress" style="margin-top: 1rem !important" >'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Avai']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Avai']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Avai']).toFixed(2)+'%</div></div>'
                    content += '<div class="progress">'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Rate']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Rate']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Rate']).toFixed(2)+'%</div></div>'
                    content += '<div class="progress">'+'<div class="progress-bar" role="progressbar" style="width:'+parseFloat(result['Qual']).toFixed(2)+'%;" aria-valuenow="'+parseFloat(result['Qual']).toFixed(2)+'" aria-valuemin="0" aria-valuemax="100">'+parseFloat(result['Qual']).toFixed(2)+'%</div></div>'

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

                var data = {
                    labels: [label],
                    datasets: [
                        {
                        data:[data],
                        backgroundColor: [
                            "#36A2EB",
                        ],
                        hoverBackgroundColor: [
                            "#36A2EB",
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
                            fontSize: 16
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

            function bar1(label,data,i){
                var bar1 = document.getElementById('bar1').getContext('2d');
                var chartbar = new Chart(bar1, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: "yellow",
                            borderColor: "blue",
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


            function bar2(label,data){
                var bar2 = document.getElementById('bar2').getContext('2d');
                var chartbar2 = new Chart(bar2, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: "lightblue",
                            borderColor: "blue",
                            borderWidth: 1,
                        }]
                    },
                    options: {
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

            function bar3(label,data){
                var bar3 = document.getElementById('bar3').getContext('2d');
                var chartbar3 = new Chart(bar3, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: '# of Votes',
                            data: data,
                            backgroundColor: "green",
                            borderColor: "green",
                            borderWidth: 1,
                        }]
                    },
                    options: {
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
            // bar2()
            // bar3()
            $('.btnsubmit').on('click', function(){
                var form = $('#formChart').serialize()
                $.ajax({
                    url:"{{route('maintenance.chart')}}",
                    method:"GET",
                    data:form,
                    success:function(data){
                        console.log(data);
                        addcolumnrow(data['A'])
                    // chart bar 1
                    var kdmesinbar1 = []
                    var totberatbar1 = []
                    var oee1 = []

                    data['A'].forEach(element => {
                        kdmesinbar1.push(element['kodemesin'])
                        totberatbar1.push(element['totberat'])
                        oee1.push(element['Oee1'])

                    });

                    // chart bar 2
                    var kdmesinbar2 = []
                    var jambar2 = []
                    data['B'].forEach(element => {
                        kdmesinbar2.push(element['kodemesin'])
                        jambar2.push(element['jam'])
                    });

                    //chart bar 3
                    var kdmesin3 = []
                    var kalibar3 = []
                    data['C'].forEach(element => {
                        kdmesin3.push(element['kodemesin'])
                        kalibar3.push(element['kali'])
                    });
                    bar1(kdmesinbar1, totberatbar1)
                    bar2(kdmesinbar2,jambar2)
                    bar3(kdmesin3,kalibar3)

                }
            })
        })


        });
    </script>

@endpush
