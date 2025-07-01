<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\RouterBoardUser;
use Illuminate\Http\Request;

class RouterBoardUserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     *
     */
    function __construct()
    {
        //
    }
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
    public function show(RouterBoardUser $routerBoardUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RouterBoardUser $routerBoardUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RouterBoardUser $routerBoardUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RouterBoardUser $routerBoardUser, Request $request)
    {

        WebHelper::apiMkDelete($request->id_rb, 'ip/hotspot/user', $request->id_rb_user);

        $routerBoardUser->delete();

        return redirect()->route('router_dash', $request->id_rb)
            ->with('warning', "Registro excluido com sucesso");
    }
}
