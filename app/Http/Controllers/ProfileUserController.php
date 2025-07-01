<?php

namespace App\Http\Controllers;

use App\Models\ProfileUser;
use App\Models\SideBar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileUserController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $inputs_forms;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Usuário';
        $this->title_permission = 'profileusers';
        $this->title_route = 'profileusers';
        $this->title_can = 'profileusers';
        $this->title_breadcrumbs = 'Usuário';
        $this->breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Index ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
        $this->inputs_forms = [
            [
                'title' => 'Mac address',
                'type' => 'text',
                'name' => 'mac_address',
                'placeholder' => 'Mac address',
                'tag' => 'input',
                'value' => 'mac_address',
            ],
            [
                'title' => 'Nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Nome',
                'tag' => 'input',
                'value' => 'name',
            ],
            [
                'title' => 'Telefone',
                'type' => 'text',
                'name' => 'telefone',
                'placeholder' => 'Telefone',
                'tag' => 'input',
                'value' => 'telefone',
            ],
            [
                'title' => 'Bairro',
                'type' => 'text',
                'name' => 'bairro',
                'placeholder' => 'Bairro',
                'tag' => 'input',
                'value' => 'bairro',
            ],
            [
                'title' => 'Cidade',
                'type' => 'text',
                'name' => 'cidade',
                'placeholder' => 'Cidade',
                'tag' => 'input',
                'value' => 'cidade',
            ],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.index" => ['data' => [],]];
        $title = $this->title;
        $titlepage = $this->title;
        $datapage = ProfileUser::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = [
            [
                'title' => 'Mac Address',
                'width' => '',
            ],
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Telefone',
                'width' => '',
            ],
            [
                'title' => 'Bairro',
                'width' => '',
            ],
            [
                'title' => 'Cidade',
                'width' => '',
            ],
        ];
        $body_table = [
            [
                'title' => 'mac_address',
                'value' => 'mac_address',
                'width' => '',
            ],
            [
                'title' => 'name',
                'value' => 'name',
                'width' => '',
            ],
            [
                'title' => 'telefone',
                'value' => 'telefone',
                'width' => '',
            ],
            [
                'title' => 'bairro',
                'value' => 'bairro',
                'width' => '',
            ],
            [
                'title' => 'cidade',
                'value' => 'cidade',
                'width' => '',
            ],
        ];
        return view('admin.page', compact(
            'datapage',
            'title',
            'header_table',
            'body_table',
            'route',
            'can',
            'sidebaradmin',
            'breadcrumbs',
            'titlepage',
            'sections'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Adicionar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_create = $this->inputs_forms;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.create" => ['data' => [],]];
        return view('admin.page', compact(
            'route',
            'form_create',
            'title',
            'titlepage',
            'sidebaradmin',
            'breadcrumbs',
            'sections'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        ProfileUser::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\Response
     */
    public function show(ProfileUser $profileuser): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $profileuser;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = $this->inputs_forms;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.show" => ['data' => [],]];
        return view('admin.page', compact(
            'datapage',
            'form_show',
            'route',
            'can',
            'title',
            'titlepage',
            'sidebaradmin',
            'breadcrumbs',
            'sections'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfileUser $profileuser): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $profileuser;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = $this->inputs_forms;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $sections = ["crud.edit" => ['data' => [],]];
        return view('admin.page', compact(
            'datapage',
            'form_edit',
            'route',
            'can',
            'title',
            'titlepage',
            'sidebaradmin',
            'breadcrumbs',
            'sections'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileUser $profileuser): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $profileuser->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileUser $profileuser): RedirectResponse
    {
        $profileuser->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
