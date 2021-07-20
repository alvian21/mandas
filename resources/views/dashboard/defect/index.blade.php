@extends('dashboard.main')
@section('content')
<style>
    .select2-search input { background-color: white; }
    /* .select2-search { background-color: black; } */
    .select2-results { background-color: black; }
    .select2-selection__choice__display{background-color: black}
    .myChart{
        width: 118% !important;
        height:500px  !important;
    }

    .dataTables_empty{
        background-color: black !important
    }
    .progress {
        background-color: #aaa;
        -webkit-box-shadow: none;
        box-shadow: none;
        }
        .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        }
        .vertical-center-right {
        margin: 0;
        position: relative;
        top: 50% !important;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        }
    .verticaltext_content {
     -webkit-transform: rotate(-90deg);
     -moz-transform: rotate(-90deg);
     -ms-transform: rotate(-90deg);
     -o-transform: rotate(-90deg);
     /* filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); */
     left: -40px;
     /* top: 35px; */
     position: absolute;
     color: #FFF;
     text-transform: uppercase;
     /* font-size: 26px; */
     font-weight: bold;
 }

 .verticaltext_content_right {
     -webkit-transform: rotate(-90deg);
     -moz-transform: rotate(-90deg);
     -ms-transform: rotate(-90deg);
     -o-transform: rotate(-90deg);
     /* filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); */
     left: 120%;
     top: 220px;
     text-align: right;
     position: absolute;
     color: #FFF;
     text-transform: uppercase;
     /* font-size: 26px; */
     font-weight: bold;
 }
</style>
<h2 class="page-title">DASHBOARD | QUALITY</h2>
<div class="row">
    <div class="col-md-10">
        <section class="widget">
            <form id="formChart">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pilih" >Tipe Periode</label>
                                    <select class="form-control pilih" name="pilih"  id="pilih">
                                        <option value="bulanan" @if($defect['tipe_periode'] == 'bulanan') selected @endif>bulanan</option>
                                        <option value="harian" @if($defect['tipe_periode'] == 'harian') selected @endif>harian</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="periode">Periode</label>
                                    <input type="month" class="form-control" value="@if($defect['tipe_periode'] == 'bulanan'){{DateTime::createFromFormat('Ym',$defect['periode'])->format('Y-m')}}@elseif($defect['tipe_periode'] == 'harian'){{date('Y-m-d', strtotime($defect['periode']))}} @endif" id="periode" name="periode">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="plant" >Plant</label>
                           <select class="form-control plant" name="plant[]" multiple id="plant">
                               @forelse ($plant as $item)
                               @if(!empty($defect['plant']))
                               @php
                                $status = false;
                               @endphp
                                @forelse ($defect['plant'] as $row)
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

                               {{-- <option value="2">2</option>
                               <option value="3">3</option>
                               <option value="4">4</option> --}}
                           </select>
                       </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tpmesin" >Tipe Mesin</label>
                           <select class="form-control tpmesin" name="tpmesin"  id="tpmesin">
                               <option value="kodemesin" @if($defect['tipe_mesin'] == 'kodemesin') selected @endif >Kode Mesin</option>
                               <option value="grpmesin" @if($defect['tipe_mesin'] == 'grpmesin') selected @endif>Grup Mesin</option>
                           </select>
                       </div>
                    </div>
                    <div class="col-md-3" id="divkodemesin">
                        <div class="form-group">
                         <label for="kodemesin" >Kode Mesin</label>
                        <select class="form-control kodemesin" name="kodemesin" id="kodemesin">
                            <option value="">Pilih Kode Mesin</option>
                            @forelse ($data as $item)
                                <option value="{{$item->MACHINEcode}}" @if($defect['kodemesin'] == $item->MACHINEcode) selected @endif >{{$item->MACHINEcode}}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    </div>
                    <div class="col-md-3" id="divgrpmesin">
                        <div class="form-group">
                         <label for="grpmesin" >Grup Mesin</label>
                        <select class="form-control grpmesin" name="grpmesin" id="grpmesin">
                            <option value="">Pilih Grup Mesin</option>
                            @forelse ($data2 as $item)
                                <option value="{{$item->groupmachine}}" @if($defect['grpmesin'] == $item->groupmachine) selected @endif >{{$item->groupmachine}}</option>
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
                <h4 class="text-center" style="font-weight: bold" id="textdatabar" >TOP 5 DEFECT</h4>
               <div class="row">
                   <div class="col-md-1 vertical-center ">
                    <h4 class="verticaltext_content">QUANTITY(Pcs)</h4>
                   </div>
                   <div class="col-md-10">

                    <div class="chart" style="margin-left: 2%">
                      <canvas id="myChart" class="myChart"  ></canvas>
                    </div>
                   </div>
                   <div class="col-md-1 vertical-center-right">
                    <h4 class="verticaltext_content_right" >CUMULATIF(%)</h4>
                   </div>
               </div>

            </div>
        </section>

    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <section class="widget">

            <div class="body no-margin">
              <div class="chart">
                <div style="width: 100%; height: 40px; position: absolute; top: 27%; left: 0; margin-top: 4px; line-height:19px; text-align: center; z-index: 999999999999999"><h1 style="color: red; font-weight: bold" id="textng"></h1></div>
                <canvas id="pieChart" width="400"  height="440" ></canvas>
              </div>
              <div id="output">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <table class="table table-responsive">
                                <tbody>
                                  <tr>
                                      <td><h4 style="color: white; font-weight:bold">Total Output</h4></td>
                                      <td><h4 style="color: white; font-weight:bold" >:</h4></td>
                                      <td><h4  style="color: white; font-weight:bold" id="totaloutput" class="text-right">0</h4></td>
                                  </tr>
                                  <tr>
                                      <td><h4 style="color: white; font-weight:bold" >Total OK</h4></td>
                                      <td><h4 style="color: white; font-weight:bold" >:</h4></td>
                                      <td><h4  style="color: white; font-weight:bold" id="totalok" class="text-right">0</h4></td>
                                  </tr>
                                  <tr>
                                      <td><h4 style="color: white; font-weight:bold" >Total NG</h4></td>
                                      <td><h4 style="color: white; font-weight:bold" >:</h4></td>
                                      <td><h4 style="color: white; font-weight:bold"   id="totalng" class="text-right">0</h4></td>
                                  </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                  {{-- <h4 class="text-center" id="totaloutput">Total Output = 0</h4>
                  <h4 class="text-center" id="totalok">Total OK = 0</h4>
                  <h4 class="text-center" id="totalng">Total NG = 0</h4> --}}
              </div>
            </div>
        </section>

    </div>
    <div class="col-md-8">
        <section class="widget">

            <div class="body">
                <table class="table  table-bordered" data-stripe-classes="[]" id="tabledefect">
                    <thead>
                    <tr>
                        <th >Defect</th>
                        <th class="text-center">Quantity(PCS)</th>
                        <th>Persentase(%)</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center">Total</td>
                            <td class="text-center" id="totalpcs">0</td>
                            <td id="totalpersen">0</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">Total Output (PCS)</td>

                            <td id="totaloutputpcs">0</td>
                        </tr>
                    </tfoot>
                </table>

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
            var chartbar;
            var table = $("#tabledefect").DataTable({
                data:[],
                columns: [
                            { "data": "defect"  },
                            { "data": "pcs" },
                            { "data": "persen" }
                ],
                rowCallback: function (row, data) {},
                filter: false,
                info: false,
                ordering: false,
                processing: true,
                retrieve: true,
                "rowCallback": function( row, data, index ) {
                    $('td', row).css('background-color', 'Black');
                    var datahtml = '<div class="progress">'+'<div class="progress-bar" role="progressbar" style="width:'+data['persen']+'%;" aria-valuenow="'+data['persen']+'" aria-valuemin="0" aria-valuemax="100">'+data['persen']+'%</div></div>';
                    $('td:eq(2)',row).html(datahtml)
                    $('td:eq(1)',row).addClass('text-center')
                }
            });
            var dataperiode = "{{$defect['periode']}}"
            var pilih = $('#pilih').find(':selected').val()
            var tpmesin = $('#tpmesin').find(':selected').val()
            if(pilih == 'bulanan'){

                    $('#periode').prop('type','month')
                    if(dataperiode != ''){
                        var periode = "@if(DateTime::createFromFormat('Ym',$defect['periode'])){{DateTime::createFromFormat('Ym',$defect['periode'])->format('Y-m')}}@endif";
                    setTimeout(function(){
                            $('#periode').val(periode)
                    },1000)
                }
            }else{
                    $('#periode').prop('type','date')
                    if(dataperiode != ''){
                    var periode = "{{date('Y-m-d', strtotime($defect['periode']))}}";
                    setTimeout(function(){
                            $('#periode').val(periode)
                    },1000)
                }
            }
            if(tpmesin == 'kodemesin'){
                    $('#divgrpmesin').hide();
                    $('#divkodemesin').show();
                }else{
                    $('#divgrpmesin').show();
                    $('#divkodemesin').hide();
                }
            $('#pilih').on('change', function(){
                var pilih = $(this).val()

                if(pilih == 'bulanan'){
                    $('#periode').prop('type','month')
                }else{
                    $('#periode').prop('type','date')
                }

            })

            $('#tpmesin').on('change', function(){
                var pilih = $(this).val()


                if(pilih == 'kodemesin'){
                    $('#divgrpmesin').hide();
                    $('#divkodemesin').show();
                }else{
                    $('#divgrpmesin').show();
                    $('#divkodemesin').hide();
                }
            })
            var doughnutctx = document.getElementById('pieChart');
            function loadScript(label2, data2){

                var myChartdoughnut = new Chart(doughnutctx, {
                    type: 'doughnut',
                    data: {
                        labels: label2,
                        datasets: [{
                        label: '# of Tomatoes',
                        data: data2,
                        backgroundColor: [
                            '#1fff2e',
                            'rgba(255, 8, 8, 1)',

                        ],
                        borderColor: [
                            '#1fff2e',
                            'rgba(255, 8, 8, 1)',

                        ],
                        borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                        position: 'bottom',
                        labels: {
                            fontColor: "white",
                            fontSize: 16
                        }
                        },
                        title: {
                        display: false,
                        text: 'Chart.js Doughnut Chart'
                        },
                        animation: {
                        animateScale: true,
                        animateRotate: true
                        },
                        tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];

                            return currentValue + "%";
                            }
                        }
                        },
                        plugins: {
                            datalabels: {
                              labels:{
                                  display:false
                              }

                            }
                        },
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
                    url:"{{route('defect.chart')}}",
                    method:"GET",
                    data:{'klik':'true'},
                    success:function(data){

                    if(data['status'] == 'true'){
                        var defect = []
                        var persen = []
                        var pcs = []
                        var totalpcs = 0
                        var totalpersen = 0
                        var colordata1 = []
                        data['data1'].forEach(element => {
                                defect.push(element['defect'])
                                persen.push(element['persentotal'])
                                pcs.push(element['pcs'])

                                totalpcs += parseInt(element['pcs'])
                                totalpersen += element['persen']
                                colordata1.push(generateColour())
                        });

                        var label2 = []
                        var data2 = []
                        var totaloutputpcs = 0
                        var totalok = 0
                        var totalng = 0
                        var persenng =0

                        data['data2'].forEach(element => {
                            label2.push(element['Keterangan'])
                            data2.push(element['persen'])
                            totaloutputpcs += parseInt(element['Pcs'])

                            if(element['Keterangan'] == "OK"){
                                totalok = element['Pcs']
                            }else{
                                totalng = element['Pcs']
                                persenng = element['persen']
                            }
                        });

                        table.clear().draw();
                        table.rows.add(data['data1']).draw();

                        $('#totalpcs').text(totalpcs.toLocaleString())
                        $('#totaloutputpcs').text(totaloutputpcs.toLocaleString())
                        $('#totaloutput').text(totaloutputpcs.toLocaleString()+" Pcs")
                        $('#totalok').text(parseInt(totalok).toLocaleString()+" Pcs")
                        $('#totalng').text(totalng.toLocaleString()+" Pcs")
                        $('#totalpersen').text("100%")
                        $('#textng').text(parseFloat(persenng).toFixed(2)+"%")
                        $('#output').show();
                        var canvas = document.getElementById('myChart');
                        if (typeof(chartbar) != "undefined") {
                             chartbar.destroy();
                        }
                        chartbar =   new Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels: defect,
                            datasets: [ {
                            label: 'persen',
                            type: 'line',
                            yAxisID: 'B',
                            data: persen,
                            backgroundColor:'rgba(0, 255, 141, 0.27)',
                            },{
                            label: 'PCS',
                            yAxisID: 'A',
                            data:pcs,
                            backgroundColor:colordata1,

                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            scales: {
                            yAxes: [{
                                id: 'A',
                                type: 'linear',
                                position: 'left',
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                            }, {
                                id: 'B',
                                type: 'linear',
                                position: 'right',
                                ticks: {
                                max: 100,
                                min: 0,
                                fontColor: "white",
                                    fontSize: 14,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 12,

                                }
                            }]
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


                         loadScript(label2, data2)
                    }
                }
            })

            $('.btnsubmit').on('click', function(){
                var form = $('#formChart').serialize()
                table.clear().draw();

                $.ajax({
                    url:"{{route('defect.chart')}}",
                    method:"GET",
                    data:form,
                    success:function(data){

                        var defect = []
                        var persen = []
                        var pcs = []
                        var totalpcs = 0
                        var totalpersen = 0
                        var colordata1 = []
                        data['data1'].forEach(element => {
                                defect.push(element['defect'])
                                persen.push(element['persentotal'])
                                pcs.push(element['pcs'])

                                totalpcs += parseInt(element['pcs'])
                                totalpersen += element['persen']
                                colordata1.push(generateColour())
                        });

                        var label2 = []
                        var data2 = []
                        var totaloutputpcs = 0
                        var totalok = 0
                        var totalng = 0
                        var persenng =0
                       
                        data['data2'].forEach(element => {
                            label2.push(element['Keterangan'])
                            data2.push(element['persen'])
                            totaloutputpcs += parseInt(element['Pcs'])

                            if(element['Keterangan'] == "OK"){
                                totalok = element['Pcs']
                            }else{
                                totalng = element['Pcs']
                                persenng = element['persen']
                            }
                        });

                        table.clear().draw();
                        table.rows.add(data['data1']).draw();

                        $('#totalpcs').text(totalpcs.toLocaleString())
                        $('#totaloutputpcs').text(totaloutputpcs.toLocaleString())
                        $('#totaloutput').text(totaloutputpcs.toLocaleString()+" Pcs")
                        $('#totalok').text(parseInt(totalok).toLocaleString()+" Pcs")
                        $('#totalng').text(totalng.toLocaleString()+" Pcs")
                        $('#totalpersen').text("100%")
                        $('#textng').text(parseFloat(persenng).toFixed(2)+"%")
                        $('#output').show();
                        var canvas = document.getElementById('myChart');
                        if (typeof(chartbar) != "undefined") {
                             chartbar.destroy();
                        }
                        chartbar =   new Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels: defect,
                            datasets: [ {
                            label: 'persen',
                            type: 'line',
                            yAxisID: 'B',
                            data: persen,
                            backgroundColor:'rgba(0, 255, 141, 0.27)',
                            },{
                            label: 'PCS',
                            yAxisID: 'A',
                            data:pcs,
                            backgroundColor:colordata1,

                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            scales: {
                            yAxes: [{
                                id: 'A',
                                type: 'linear',
                                position: 'left',
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 14,

                                }
                            }, {
                                id: 'B',
                                type: 'linear',
                                position: 'right',
                                ticks: {
                                max: 100,
                                min: 0,
                                fontColor: "white",
                                    fontSize: 14,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    fontColor: "white",
                                    fontSize: 12,

                                }
                            }]
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


                loadScript(label2, data2)
                }
            })
        })


        });
    </script>

@endpush
