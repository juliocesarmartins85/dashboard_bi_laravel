<?php

namespace App\Http\Controllers;

use App\Models\Breadcrumbs;
use App\Models\SideBar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BreadcrumbsController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    protected $table;
    protected $form;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Breadcrumbs';
        $this->title_permission = 'breadcrumb';
        $this->title_route = 'breadcrumbs';
        $this->title_can = 'breadcrumb';
        $this->title_breadcrumbs = 'Breadcrumbs';
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
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
        $this->table = [
            'header' => [
                [
                    'title' => 'No',
                    'width' => '',
                ],
                [
                    'title' => 'Name',
                    'width' => '',
                ],
                [
                    'title' => 'Details',
                    'width' => '',
                ],
                [
                    'title' => 'Action',
                    'width' => '160',
                ],
            ],
            'body' => [
                [
                    'title' => 'name',
                ],
                [
                    'title' => 'detail',
                ],
            ]
        ];
        $this->form = [
            [
                'title' => 'Name',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Name',
                'tag' => 'input',
                'value' => 'name',
            ],
            [
                'title' => 'Detail',
                'type' => 'text',
                'name' => 'detail',
                'placeholder' => 'Detail',
                'tag' => 'textarea',
                'value' => 'detail',
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
        $titlepage = ucfirst($this->title);
        $datapage = Breadcrumbs::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = $this->table['header'];
        $body_table = $this->table['body'];
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
        $form_create = $this->form;
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

        Breadcrumbs::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Breadcrumbs  $breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function show(Breadcrumbs $breadcrumb): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $breadcrumb;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = $this->form;
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
     * @param  \App\Breadcrumbs  $breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function edit(Breadcrumbs $breadcrumb): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $breadcrumb;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = $this->form;
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
     * @param  \App\Breadcrumbs  $breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Breadcrumbs $breadcrumb): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $breadcrumb->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Breadcrumbs  $breadcrumb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breadcrumbs $breadcrumb): RedirectResponse
    {
        $breadcrumb->delete();

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro excluido com sucesso");
    }
}
