<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plant = [1, 2, 3, 4];
        if (session()->has('maintenance')) {
            $maintenance = session('maintenance');
        } else {
            $maintenance = [
                'tipe_periode' => '',
                'periode' => '',
                'plant' => []
            ];
        }

        return view("dashboard.maintenance.index", ['plant' => $plant, 'maintenance' => $maintenance]);
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
            if ($pilih == 'bulanan') {
                $periode = date('Ym', strtotime($periode));
            } else {
                $periode = date('Ymd', strtotime($periode));
            }

            $sesi = [
                'tipe_periode' => $pilih,
                'periode' => $periode,
                'plant' => $plant
            ];
            session(['maintenance' => $sesi]);
            $resplan = "";
            foreach ($plant as $key => $value) {
                $resplan .= $value . ';';
            }
            $A = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_oee :Param1, :Param2"), [
                ':Param1' => $periode,
                ':Param2' => $resplan
            ]);

            $B = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_breakdown_menit :Param1, :Param2, :Param3"), [
                ':Param1' => $periode,
                ':Param2' => $resplan,
                ':Param3' => '-'
            ]);

            $C = DB::select(DB::raw("SET NOCOUNT ON ; exec p_mandas_breakdown_kali :Param1, :Param2, :Param3"), [
                ':Param1' => $periode,
                ':Param2' => $resplan,
                ':Param3' => '-'
            ]);
            return response()->json([
                'A' => $A,
                'B' => $B,
                'C' => $C
            ]);
        }
    }
}
