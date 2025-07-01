<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\RouterBoardUserAtivo;
use Illuminate\Http\Request;

class RouterBoardUserAtivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RouterBoardUserAtivo $routerBoardUserAtivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RouterBoardUserAtivo $routerBoardUserAtivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RouterBoardUserAtivo $routerBoardUserAtivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RouterBoardUserAtivo $routerBoardUserAtivo, Request $request)
    {
        WebHelper::apiMkDelete($request->id_rb, 'ip/hotspot/active', $request->id_rb_user);

        $routerBoardUserAtivo->delete();

        return redirect()->route('router_dash', $request->id_rb)
            ->with('warning', "Registro excluido com sucesso");
    }
}
