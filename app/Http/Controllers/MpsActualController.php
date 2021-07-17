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
        return view("dashboard.mpsactual.index");
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

            $day = date('d', strtotime($tglakhir));
            $date = date('F Y', strtotime($tglakhir));

            return response()->json([
                'data' => $data,
                'day' => $day,
                'date' => $date,
                'actual_data' => $actual
            ]);
        }
    }
}
