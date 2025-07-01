<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\SideBar;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Log';
        $this->title_permission = 'logs';
        $this->title_route = 'logs';
        $this->title_can = 'log';
        $this->title_breadcrumbs = 'Log';
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Index ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
        $sections = ["log_page" => ['data' => [],]];
        $title = 'Logs';
        $titlepage = ucfirst('Logs');
        $datapage = Log::latest()->paginate(5);
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
/*         $header_table = [
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
        ];
        $body_table = [
            [
                'title' => 'name',
            ],
            [
                'title' => 'detail',
            ],
        ]; */
        return view('admin.page', compact(
            'datapage',
            'title',
            /* 'header_table', */
            /* 'body_table', */
            'route',
            'can',
            'sidebaradmin',
            'breadcrumbs',
            'titlepage',
            'sections'
        ))->with('i', (request()->input('page', 1) - 1) * 5);
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
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        //
    }
}
