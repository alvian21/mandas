<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MpsActualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('mpsactual')) {
            $mpsactual = session('mpsactual');
        } else {
            $mpsactual = [
                'tglawal' => '',
                'tglakhir' => '',
                'tampilan' => ''
            ];
        }
        return view("dashboard.mpsactual.index", ['mpsactual' => $mpsactual]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chart(Request $request)
    {
        if ($request->ajax()) {
            $tglawal = $request->get('tglawal');
            $tglakhir = $request->get('tglakhir');
            $tampilan = $request->get('tampilan');
            $mpsactual = [
                'tglawal' => $tglawal,
                'tglakhir' => $tglakhir,
                'tampilan' => $tampilan
            ];

            session(['mpsactual' => $mpsactual]);

            $data = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_review_mps_vs_actual :Param1, :Param2, :Param3"), [
                ':Param1' => $tglawal,
                ':Param2' => $tglakhir,
                ':Param3' => $tampilan
            ]);
            $actual = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_review_mps_vs_actual_data :Param1, :Param2, :Param3"), [
                ':Param1' => $tglawal,
                ':Param2' => $tglakhir,
                ':Param3' => $tampilan
            ]);
            $actualtotal = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_review_mps_vs_actual_total :Param1, :Param2"), [
                ':Param1' => $tglawal,
                ':Param2' => $tglakhir
            ]);

            $arr = [];
            foreach ($actualtotal as $key => $value) {
                if ($value->total == null) {
                    $x['total'] = 0;
                } else {
                    $x['total'] = $value->total;
                }
                if ($value->deviasi == null) {
                    $x['deviasi'] = 0;
                } else {
                    $x['deviasi'] = $value->deviasi;
                }
                $x['plant'] = $value->plant;
                $x['targetsd'] = round($value->targetsd);
                $persen = ($x['total'] / $value->targetsd) * 100;
                $x['persen'] = round($persen, 2);
                array_push($arr, $x);
            }
            $actualtotal = $arr;
            $day = date('d', strtotime($tglakhir));
            $date = date('F Y', strtotime($tglakhir));

            return response()->json([
                'data' => $data,
                'day' => $day,
                'date' => $date,
                'actual_data' => $actual,
                'actual_total' => $actualtotal
            ]);
        }
    }
}
