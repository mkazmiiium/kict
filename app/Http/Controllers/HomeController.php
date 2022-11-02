<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Decentralised;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $decentraliseds_count = DB::table('decentraliseds')
        ->where('deleted', 'no')
        ->count();

        $centraliseds_count = DB::table('centraliseds')
        ->where('deleted', 'no')
        ->count();

        $pg_decentraliseds_count = DB::table('p_g_decentraliseds')
        ->where('deleted', 'no')
        ->count();

        $pg_centraliseds_count = DB::table('p_g_centraliseds')
        ->where('deleted', 'no')
        ->count();

        return view('home', compact(['decentraliseds_count', 'centraliseds_count', 'pg_decentraliseds_count', 'pg_centraliseds_count']));
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
}
