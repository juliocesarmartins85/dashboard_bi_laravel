<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\SideBar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnderecoController extends Controller
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
        $this->title = 'Endereço';
        $this->title_permission = 'enderecos';
        $this->title_route = 'enderecos';
        $this->title_can = 'enderecos';
        $this->title_breadcrumbs = 'Endereço';
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
            [
                'title' => 'Estado',
                'type' => 'text',
                'name' => 'estado',
                'placeholder' => 'Estado',
                'tag' => 'input',
                'value' => 'estado',
            ],
            [
                'title' => 'Sigla',
                'type' => 'text',
                'name' => 'sigla',
                'placeholder' => 'Sigla',
                'tag' => 'input',
                'value' => 'sigla',
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
        $datapage = Endereco::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = [
            [
                'title' => 'Bairro',
                'width' => '',
            ],
            [
                'title' => 'Cidade',
                'width' => '',
            ],
            [
                'title' => 'Estado',
                'width' => '',
            ],
            [
                'title' => 'Sigla',
                'width' => '',
            ],
        ];
        $body_table = [
            [
                'title' => 'bairro',
                'value' => 'bairro',
            ],
            [
                'title' => 'cidade',
                'value' => 'cidade',
            ],
            [
                'title' => 'estado',
                'value' => 'estado',
            ],
            [
                'title' => 'sigla',
                'value' => 'sigla',
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

        Endereco::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function show(Endereco $endereco): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $endereco;
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
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function edit(Endereco $endereco): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $endereco;
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
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endereco $endereco): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $endereco->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endereco  $endereco
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endereco $endereco): RedirectResponse
    {
        $endereco->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
