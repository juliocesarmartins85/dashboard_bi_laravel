<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\SideBar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @param
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'perfil';
        $titlepage = ucfirst($title);
        $breadcrumbs = [
            [
                'title' => "Home",
                'url' => route("home")
            ],
/*             [
                'title' => "{$titlepage}",
                'url' => route("admin.$title")
            ], */
        ];
        //WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou - {$titlepage}");
        return view('admin.page', [
            'sidebaradmin' => SideBar::all(),
            'breadcrumbs' => $breadcrumbs,
            'titlepage' => 'Usuário',
            'sections' => [
                'my_profile' => [
                    'col' => '12',
                    'data' => ['user' => User::find(Auth::user()->id)],
                ],
            ]
        ]);
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
        $item = User::find(Auth::user()->id);
        $item->name = $request->fullName;
        $item->email = $request->email;
        $item->funcao = $request->job;
        $item->desc = $request->about;
        $item->endereco = $request->address;
        $item->facebook = $request->facebook;
        $item->twitter = $request->twitter;
        $item->instagram = $request->instagram;
        $item->linkedin = $request->linkedin;
        $item->organizacao = $request->company;
        $item->telefone = $request->phone;
        $item->save();
        return back()->with('success', 'Perfil atualizado com sucesso!');
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
