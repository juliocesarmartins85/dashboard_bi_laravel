<?php

namespace App\Http\Controllers;

use App\Models\Hotspot;
use App\Models\SideBar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HotspotController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    protected $inputs_forms;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Hotspot';
        $this->title_permission = 'hotspot';
        $this->title_route = 'hotspot';
        $this->title_can = 'hotspot';
        $this->title_breadcrumbs = 'Hotspot';
        $this->breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Todos registros ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
        $this->inputs_forms = [
            [
                'title' => 'Nome hotspot',
                'type' => 'text',
                'name' => 'nome',
                'placeholder' => 'Nome hotspot',
                'tag' => 'input',
                'value' => 'nome',
            ],
            [
                'title' => 'IP Hotpost',
                'type' => 'text',
                'name' => 'host',
                'placeholder' => 'IP Hotpost',
                'tag' => 'input',
                'value' => 'host',
            ],
            [
                'title' => 'Porta',
                'type' => 'text',
                'name' => 'port',
                'placeholder' => 'Porta',
                'tag' => 'input',
                'value' => 'port',
            ],
            [
                'title' => 'Usuario',
                'type' => 'text',
                'name' => 'user',
                'placeholder' => 'Usuario',
                'tag' => 'input',
                'value' => 'user',
            ],
            [
                'title' => 'Senha',
                'type' => 'text',
                'name' => 'pass',
                'placeholder' => 'Senha',
                'tag' => 'input',
                'value' => 'pass',
            ],

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.index" => ['data' => [],]];
        $title = $this->title;
        $titlepage = $this->title;
        $datapage = Hotspot::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = [
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Ip host',
                'width' => '',
            ],
            [
                'title' => 'Port',
                'width' => '',
            ],
            [
                'title' => 'Usuario',
                'width' => '',
            ],
            [
                'title' => 'Senha',
                'width' => '',
            ],
        ];
        $body_table = [
            [
                'title' => '',
                'value' => 'nome',
                'width' => '',
            ],
            [
                'title' => '',
                'value' => 'host',
                'width' => '',
            ],
            [
                'title' => '',
                'value' => 'port',
                'width' => '',
            ],
            [
                'title' => '',
                'value' => 'user',
                'width' => '',
            ],
            [
                'title' => '',
                'value' => 'pass',
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
     */
    public function create()
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
     */
    public function store(Request $request)
    {
        request()->validate([
            'nome' => 'required',
            'host' => 'required',
            'port' => 'required',
            'user' => 'required',
            'pass' => 'required',
        ]);

        Hotspot::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotspot $hotspot)
    {
                $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $hotspot;
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
     */
    public function edit(Hotspot $hotspot)
    {
                $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $hotspot;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = $this->inputs_forms;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
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
     */
    public function update(Request $request, Hotspot $hotspot)
    {
        request()->validate([
            'nome' => 'required',
            'host' => 'required',
            'port' => 'required',
            'user' => 'required',
            'pass' => 'required',
        ]);

        $hotspot->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotspot $hotspot): RedirectResponse
    {

        $hotspot->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
