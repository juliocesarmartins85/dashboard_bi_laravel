<?php

namespace App\Http\Controllers;

use App\Models\SideBar;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SiteController extends Controller
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
        $this->title = 'Site';
        $this->title_permission = 'sites';
        $this->title_route = 'sites';
        $this->title_can = 'sites';
        $this->title_breadcrumbs = 'Site';
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
                'title' => 'Nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Name',
                'tag' => 'input',
                'value' => 'name',
            ],
            [
                'title' => 'Url',
                'type' => 'text',
                'name' => 'url',
                'placeholder' => 'Url',
                'tag' => 'input',
                'value' => 'url',
            ],
            [
                'title' => 'Descrição',
                'type' => 'text',
                'name' => 'description',
                'placeholder' => 'Descrição',
                'tag' => 'input',
                'value' => 'description',
            ],
            [
                'title' => 'Favicon',
                'type' => 'text',
                'name' => 'favicon',
                'placeholder' => 'Favicon',
                'tag' => 'arquivo',
                'value' => 'favicon',
            ],
            [
                'title' => 'Logo',
                'type' => 'text',
                'name' => 'logo',
                'placeholder' => 'Video',
                'tag' => 'arquivo',
                'value' => 'logo',
            ],
            [
                'title' => 'Telegram Bot',
                'type' => 'text',
                'name' => 'telegram_bot',
                'placeholder' => 'Telegram Bot',
                'tag' => 'input',
                'value' => 'telegram_bot',
            ],
            [
                'title' => 'Telegram Grupo',
                'type' => 'text',
                'name' => 'telegram_group',
                'placeholder' => 'Telegram Bot',
                'tag' => 'input',
                'value' => 'telegram_group',
            ],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.index" => ['data' => [],]];
        $title = $this->title;
        $titlepage = $this->title;
        $datapage = Site::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = [
            [
                'title' => 'Nome',
                'width' => '',
            ],
        ];
        $body_table = [
            [
                'title' => 'Titulo',
                'value' => 'name',
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

        Site::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $site;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = $this->inputs_forms;
        $breadcrumbs = $this->breadcrumbs;
        $breadcrumbs = $this->breadcrumbs;
        $sidebaradmin = SideBar::all();
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
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $site;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site): RedirectResponse
    {
        $favicon = $request->favicon_old;
        $logo =   $request->logo_old;
        request()->validate([
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',
            'telegram_bot' => 'required',
            'telegram_group' => 'required',
        ]);

        if (!empty($request->logo)) {
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('logos'), $fileName);
            $logo = 'logos/' . $fileName;
        }
        if (!empty($request->favicon)) {
            $fileNameFavi = time() . '.' . $request->favicon->extension();
            $request->favicon->move(public_path('favicons'), $fileNameFavi);
            $favicon = 'favicons/' . $fileNameFavi;
        }


        $resposta = [
            'name' => $request->name,
            'url' => $request->url,
            'description' => $request->description,
            'favicon' => $favicon,
            'logo' => $logo,
            'telegram_bot' => $request->telegram_bot,
            'telegram_group' => $request->telegram_group,
        ];

        $site->update($resposta);

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site): RedirectResponse
    {
        $site->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
