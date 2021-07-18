@extends('dashboard.main')
@section('content')
<style>
    .select2-search input { background-color: white; }
    /* .select2-search { background-color: black; } */
    .select2-results { background-color: black; }
    .select2-selection__choice__display{background-color: black}
    .myChart{
        width: 100%;
        height:500px
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
<h2 class="page-title">Dashboard REVIEW MPS VS ACTUAL</h2>
<div class="row">
    <div class="col-md-10">
        <section class="widget">
            <form id="formChart">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tglawal">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tglawal" value="{{date('Y-m-01')}}" name="tglawal">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tglakhir">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tglakhir" value="{{date('Y-m-d')}}"  name="tglakhir">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tampilan" >Tampilan</label>
                           <select class="form-control tampilan" name="tampilan" id="tampilan">
                               <option value="1">PLANT 1</option>
                               <option value="2">PLANT 2 ALL</option>
                               <option value="3">PLANT 2 UNIT 1</option>
                               <option value="4">PLANT 2 UNIT 2-3</option>
                               <option value="5">TOTAL ISP</option>
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
              <div class="chart">
                <canvas id="myChart" class="myChart"  ></canvas>
              </div>

            </div>
        </section>

    </div>
</div>
<div class="row">

    <div class="col-md-6" id="datareview">
        <section class="widget">

            <div class="body">
                <table class="table  table-bordered" data-stripe-classes="[]" id="tablereview">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-center" id="threview">REVIEW MPS VS ACTUAL MAY 2021 PLANT 1</th>
                        </tr>
                        <tr>
                            <th style="width: 100% !important">ITEM</th>
                            <th class="text-center">Target Awal</th>
                            <th class="text-center">Target Revisi</th>
                            <th class="text-center" id="thsd">Target s/d 30 May 2021</th>
                            <th class="text-center" >Actual</th>
                            <th class="text-center">Balance Target</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <td class="text-center">Total</td>
                            <td class="text-center" id="ttltargetawal">0</td>
                            <td class="text-center" id="ttltargetrevisi">0</td>
                            <td class="text-center" id="ttltargetsd">0</td>
                            <td class="text-center" id="ttlactual">0</td>
                            <td class="text-center" id="ttlbalance">0</td>
                        </tr>

                    </tfoot> --}}
                </table>

            </div>
        </section>
    </div>
    <div class="col-md-6" id="datareview">
        <section class="widget">

            <div class="body">
                <table class="table  table-bordered" data-stripe-classes="[]" id="tableactualdata">
                    <thead>
                        <tr>
                            <th colspan="6" class="text-center" id="threview">REVIEW MPS VS ACTUAL MAY 2021 PLANT 1</th>
                        </tr>
                        <tr>
                            <th style="width: 100% !important">ITEM</th>
                            <th class="text-center">Target Awal</th>
                            <th class="text-center">Target Revisi</th>
                            <th class="text-center" id="thsd">Target s/d 30 May 2021</th>
                            <th class="text-center" >Actual</th>
                            <th class="text-center">Balance Target</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>

            </div>
        </section>
    </div>
</div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('.tampilan').select2();
            // $('#datareview').hide()
            var table = $("#tablereview").DataTable({
                data:[],
                columns: [
                            { "data": "Keterangan"  },
                            { "data": "targetawal" },
                            { "data": "targetrevisi" },
                            { "data": "targetsd" },
                            { "data": "Actual" },
                            { "data": "balancetarget" },
                ],
                rowCallback: function (row, data) {},
                filter: false,
                info: false,
                ordering: false,
                processing: true,
                retrieve: true,
                paging: false,
                "rowCallback": function( row, data, index ) {
                    $('td', row).css('background-color', 'Black');
                    $('td:eq(1)',row).addClass('text-center')
                    $('td:eq(2)',row).addClass('text-center')
                    $('td:eq(3)',row).addClass('text-center')
                    $('td:eq(4)',row).addClass('text-center')
                    $('td:eq(5)',row).addClass('text-center')
                },
                "autoWidth": false,

            });

             var table2 = $("#tableactualdata").DataTable({
                data:[],
                columns: [
                            { "data": "Keterangan"  },
                            { "data": "targetawal" },
                            { "data": "targetrevisi" },
                            { "data": "targetsd" },
                            { "data": "Actual" },
                            { "data": "balancetarget" },
                ],
                rowCallback: function (row, data) {},
                filter: false,
                info: false,
                ordering: false,
                processing: true,
                retrieve: true,
                paging: false,
                "rowCallback": function( row, data, index ) {
                    $('td', row).css('background-color', 'Black');
                    $('td:eq(1)',row).addClass('text-center')
                    $('td:eq(2)',row).addClass('text-center')
                    $('td:eq(3)',row).addClass('text-center')
                    $('td:eq(4)',row).addClass('text-center')
                    $('td:eq(5)',row).addClass('text-center')
                },
                "autoWidth": false,

            });
            var ctx = document.getElementById("myChart").getContext("2d");

            function chartvs(labels,data1, data2){
                var barChartData = {
                    labels: labels,
                    datasets: [
                        {
                        label: "Target",
                        backgroundColor: "pink",
                        borderColor: "red",
                        borderWidth: 1,
                        data: data1
                        },
                        {
                        label: "Actual",
                        backgroundColor: "lightblue",
                        borderColor: "blue",
                        borderWidth: 1,
                        data: data2
                        }

                    ]
                    };

                    var chartOptions = {
                    responsive: true,
                    legend: {
                        position: "top",
                        labels: {
                            fontColor: "white",
                            fontSize: 18
                        }
                    },
                    title: {
                        display: false,

                    },
                    scales: {
                        yAxes: [{
                        ticks: {

                            fontColor: "white",
                        }
                        }],
                        xAxes: [{
                        ticks: {

                            fontColor: "white",
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



                    var chartvs = new Chart(ctx, {
                            type: "bar",
                            data: barChartData,
                         options: chartOptions
                     });

            }

            $('.btnsubmit').on('click', function(){
                var form = $('#formChart').serialize()
                var tampilan = $('#tampilan').find(':selected').text()
                $.ajax({
                    url:"{{route('mpsactual.chart')}}",
                    method:"GET",
                    data:form,
                    success:function(data){
                        var labels = []
                        var targetsd = []
                        var actual = []
                        console.log(data);
                        var ttltargetawal = 0
                        var ttltargetrevisi = 0
                        var ttltargetsd = 0
                        var ttlactual =  0
                        var ttlbalance = 0

                        data['data'].forEach(element => {
                                labels.push(element['Keterangan'])
                                targetsd.push(element['targetsd'])
                                actual.push(element['Actual'])

                                ttltargetawal += parseInt( element['targetawal'])
                                ttltargetrevisi += parseInt(element['targetrevisi'])
                                ttltargetsd += parseInt(element['targetsd'])
                                ttlactual += parseInt(element['Actual'])
                                ttlbalance += parseInt(element['balancetarget'])
                        });

                        chartvs(labels, targetsd, actual)
                        table.rows.add(data['data']).draw()
                        table2.rows.add(data['actual_data']).draw()
                        // $('#ttltargetawal').text(ttltargetawal)
                        // $('#ttltargetrevisi').text(ttltargetrevisi)
                        // $('#ttltargetsd').text(ttltargetsd)
                        // $('#ttlactual').text(ttlactual)
                        // $('#ttlbalance').text(ttlbalance)
                        $('#threview').text('REVIEW MPS VS ACTUAL '+data['date']+' '+tampilan)
                        $('#thsd').text('Target s/d '+data['day']+' '+data['date'])
                        $('#datareview').show()
                    }
                })
            })
        });
    </script>

@endpush
