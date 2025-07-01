<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\Blacklist;
use App\Models\ProfileUser;
use App\Models\SideBar;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlacklistController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $brwsr;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Blacklist';
        $this->title_permission = 'blacklist';
        $this->title_route = 'blacklists';
        $this->title_can = 'blacklist';
        $this->title_breadcrumbs = 'Blacklist';
        $this->brwsr = WebHelper::getBrowserInfo();
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
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
        $sections = ["crud.index" => ['data' => [],]];
        $title = $this->title;
        $titlepage = ucfirst($this->title);
        $datapage = ProfileUser::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = [
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Name',
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
                'title' => 'Mac',
                'width' => '',
            ],

        ];
        $body_table = [
            [
                'title' => 'name',
                'value' => 'name',
            ],
            [
                'title' => 'telefone',
                'value' => 'telefone',
            ],
            [
                'title' => 'bairro',
                'value' => 'bairro',
            ],
            [
                'title' => 'cidade',
                'value' => 'cidade',
            ],
            [
                'title' => 'mac_address',
                'value' => 'mac_address',
            ],
        ];
        WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou - {$titlepage}", "{$this->brwsr['browser']} {$this->brwsr['browser_version']} / {$this->brwsr['device']} - {$this->brwsr['os_platform']}");
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
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_create = [
            [
                'title' => 'Name',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Name',
                'tag' => 'input',
            ],
            [
                'title' => 'Detail',
                'type' => 'text',
                'name' => 'detail',
                'placeholder' => 'Detail',
                'tag' => 'textarea',
            ],
        ];
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $sections = ["crud.create" => ['data' => [],]];
        WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou adicionar - {$titlepage}", "{$this->brwsr['browser']} {$this->brwsr['browser_version']} / {$this->brwsr['device']} - {$this->brwsr['os_platform']}");
        return view('page', compact(
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
    public function store(Request $request, ProfileUser $profile): RedirectResponse
    {

        request()->validate([
            'id' => 'required',
        ]);

        $profile = ProfileUser::find($request->id);

        if (empty(Blacklist::where('mac', $profile->mac_address)->first()->mac)) {
            $profile_add = [
                'nome' => $profile->name,
                'email' => $profile->email ?? '',
                'telefone' => $profile->telefone,
                'bairro' => $profile->bairro,
                'cidade' => $profile->cidade,
                'mac' => $profile->mac_address,
            ];

            Blacklist::create($profile_add);

            WebHelper::logdata('1',  '1',  $this->title,  User::find(Auth::user()->id)->name . " Adicionou {$this->title} - {$profile->name} {$profile->mac_address}", "{$this->brwsr['browser']} {$this->brwsr['browser_version']} / {$this->brwsr['device']} - {$this->brwsr['os_platform']}");

            return redirect()->route("$this->title_route.index")
                ->with('success', "Registro adicionado com sucesso.");
        } else {
            return redirect()->route("$this->title_route.index")
                ->with('error', "Registro já foi adicionado.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function show(Blacklist $blacklist): View
    {
        $datapage = $blacklist;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = [
            [
                'title' => 'Name',
                'name' => 'name',
            ],
            [
                'title' => 'Detail',
                'name' => 'detail',
            ],
        ];
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $sections = ["crud.show" => ['data' => [],]];
        WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou Detalhes - {$titlepage}", "{$this->brwsr['browser']} {$this->brwsr['browser_version']} / {$this->brwsr['device']} - {$this->brwsr['os_platform']}");
        return view('page', compact(
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
     * @param  \App\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Blacklist $blacklist): View
    {
        $datapage = $blacklist;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = [
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
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $sections = ["crud.edit" => ['data' => [],]];
        return view('page', compact(
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
     * @param  \App\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blacklist $blacklist): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $blacklist->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blacklist  $blacklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blacklist $blacklist): RedirectResponse
    {
        $blacklist->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
