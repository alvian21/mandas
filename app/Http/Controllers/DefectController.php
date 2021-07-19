<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DefectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('MSMACHINESFC_CTTARGET')->select('MACHINEcode')->orderBy('MACHINEcode')->get();
        $data2 = DB::table('MSMACHINESFC')->select('groupmachine')->distinct()->orderBy('groupmachine')->get();

        if (session()->has('defect')) {
            $defect = session('defect');
        } else {
            $defect = [
                'tipe_periode' => '',
                'periode' => '',
                'plant' => [],
                'tipe_mesin' => '',
                'kodemesin' => '',
                'grpmesin' => ''
            ];
        }

        $plant = [1,2,3,4];
        // dd($defect);
       
        return view("dashboard.defect.index", ['data' => $data, 'data2' => $data2, 'defect' => $defect,'plant'=>$plant]);
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
            $pilih = $request->get('pilih');
            $periode = $request->get('periode');
            $plant = $request->get('plant');
            $kodemesin = $request->get('kodemesin');
            $grpmesin = $request->get('grpmesin');
            if ($pilih == 'bulanan') {
                $periode = date('Ym', strtotime($periode));
            } else {
                $periode = date('Ymd', strtotime($periode));
            }


            $kodemesin = '';
            $resplan = "";

            $sesi = [
                'tipe_periode' => $pilih,
                'periode' => $periode,
                'plant' => $plant,
                'tipe_mesin' => $request->get('tpmesin'),
                'kodemesin' => $kodemesin,
                'grpmesin' => $grpmesin
            ];

            session(['defect' => $sesi]);
            foreach ($plant as $key => $value) {
                $resplan .= $value . ';';
            }
            // return response()->json($periode);
            $data1 = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_ng :Param1, :Param2, :Param3, :Param4"), [
                ':Param1' => $periode,
                ':Param2' => $resplan,
                ':Param3' => $kodemesin,
                ':Param4' => $grpmesin
            ]);
            $data2 = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_ok_vs_ng :Param1, :Param2, :Param3, :Param4"), [
                ':Param1' => $periode,
                ':Param2' => $resplan,
                ':Param3' => $kodemesin,
                ':Param4' => $grpmesin
            ]);

            $arr = [];
            foreach ($data1 as $key => $value) {
                $x['defect'] = $value->defect;
                $x['pcs'] = $value->pcs;
                $x['persen'] = round($value->persen, 2);
                array_push($arr, $x);
            }

            $data1 = $arr;
            return response()->json([
                'data1' => $data1,
                'data2' => $data2
            ]);
        }
    }
}
