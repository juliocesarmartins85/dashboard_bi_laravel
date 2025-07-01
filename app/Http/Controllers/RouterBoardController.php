<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\ProfileUser;
use App\Models\RouterBoard;
use App\Models\RouterBoardUser;
use App\Models\RouterBoardUserAtivo;
use App\Models\SideBar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouterBoardController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    protected $inputs_forms;
    protected $resource;
    protected $totalUser;
    protected $totalAtivos;
    protected $acesso_user;
    protected $log_rb;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'RouterBoard';
        $this->title_permission = 'routerboard';
        $this->title_route = 'routerboard';
        $this->title_can = 'routerboard';
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
                'title' => 'nome',
                'type' => 'text',
                'name' => 'nome',
                'placeholder' => 'nome',
                'tag' => 'input',
                'value' => 'nome',
            ],
            [
                'title' => 'IP Host',
                'type' => 'text',
                'name' => 'host',
                'placeholder' => 'host',
                'tag' => 'input',
                'value' => 'host',
            ],
            [
                'title' => 'port',
                'type' => 'text',
                'name' => 'port',
                'placeholder' => 'port',
                'tag' => 'input',
                'value' => 'port',
            ],
            [
                'title' => 'user',
                'type' => 'text',
                'name' => 'user',
                'placeholder' => 'user',
                'tag' => 'input',
                'value' => 'user',
            ],
            [
                'title' => 'pass',
                'type' => 'text',
                'name' => 'pass',
                'placeholder' => 'pass',
                'tag' => 'input',
                'value' => 'pass',
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
        $datapage = RouterBoard::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $header_table = [
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'IP Host',
                'width' => '',
            ],
            [
                'title' => 'Porta',
                'width' => '',
            ],
            [
                'title' => 'Usuário',
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
            'nome' => 'required',
            'host' => 'required',
            'port' => 'required',
            'user' => 'required',
            'pass' => 'required',
        ]);

        RouterBoard::create($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RouterBoard  $routerboard
     * @return \Illuminate\Http\Response
     */
    public function show(RouterBoard $routerboard): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $routerboard;
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
     * @param  \App\RouterBoard  $routerboard
     * @return \Illuminate\Http\Response
     */
    public function edit(RouterBoard $routerboard): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $routerboard;
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
     * @param  \App\RouterBoard  $routerboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RouterBoard $routerboard): RedirectResponse
    {
        request()->validate([
            'nome' => 'required',
            'host' => 'required',
            'port' => 'required',
            'user' => 'required',
            'pass' => 'required',
        ]);

        $routerboard->update($request->all());

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RouterBoard  $routerboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(RouterBoard $routerboard): RedirectResponse
    {
        $routerboard->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
    /**
     *
     *
     */
    public function router_dash(Request $request)
    {
        $idRb = $request->id;
        try {
            $data = WebHelper::apiMkGet($idRb, 'ip/hotspot/user');
            $user = collect($data)->except(['0'])->toArray();
            $ativo = WebHelper::apiMkGet($idRb, 'ip/hotspot/active');
            $interfaceRb = WebHelper::apiMkGet($idRb, 'interface');
            $this->acesso_user = WebHelper::apiMkGet($idRb, 'ip/dns/cache');
            $this->log_rb = WebHelper::apiMkGet($idRb, 'log');
            $this->resource = WebHelper::apiMkGet($idRb, 'system/resource');
            $this->totalUser = count($user);
            $this->totalAtivos = count($ativo);

            DB::table("router_board_users")->truncate();
            $router_board_users = [];
            foreach ($user as $key => $item) {
                array_push($router_board_users, [
                    'id_rb' => $item->{".id"},
                    'server' => $item->server,
                    'name' => /* $item->name */ProfileUser::where('mac_address', $item->{"mac-address"})->first()->name??'',
                    'mac_address' => $item->{"mac-address"},
                    'profile' => $item->profile,
                    'limit_uptime' => ''/* $item->{"limit-uptime"} */,
                    'uptime' => $item->uptime,
                    'bytes_in' => WebHelper::formatBytes($item->{"bytes-in"}),
                    'bytes_out' => WebHelper::formatBytes($item->{"bytes-out"}),
                    'packets_in' => WebHelper::formatBytes($item->{"packets-in"}),
                    'packets_out' => WebHelper::formatBytes($item->{"packets-out"}),
                    'dynamic' => $item->dynamic,
                    'disabled' => $item->disabled,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            RouterBoardUser::insert($router_board_users);

            DB::table("router_board_user_ativos")->truncate();
            $router_board_user_ativos = [];
            //dd($ativo);
            foreach ($ativo as $key => $itemativo) {
                array_push($router_board_user_ativos, [
                    'id_rb' => $item->{".id"},
                    'server' => $item->server,
                    'user' => /* $itemativo->user */ProfileUser::where('mac_address', $itemativo->{"mac-address"})->first()->name??'',
                    'address' => $itemativo->address,
                    'mac_address' => $itemativo->{"mac-address"},
                    'login_by' => $itemativo->{"login-by"},
                    'uptime' => $itemativo->uptime,
                    'session_time_left' => $itemativo->{"session-time-left"},
                    'idle_time' => $itemativo->{"idle-time"},
                    'keepalive_timeout' => $itemativo->{"keepalive-timeout"},
                    'bytes_in' => WebHelper::formatBytes($itemativo->{"bytes-in"}),
                    'bytes_out' => WebHelper::formatBytes($itemativo->{"bytes-out"}),
                    'packets_in' => WebHelper::formatBytes($itemativo->{"packets-in"}),
                    'packets_out' => WebHelper::formatBytes($itemativo->{"packets-out"}),
                    'radius' => $itemativo->radius,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            RouterBoardUserAtivo::insert($router_board_user_ativos);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        /* dd(WebHelper::formatBytes('123123')); */
        $routerboardusers = RouterBoardUser::all()/* latest()->paginate(15) */;
        $profileUsers = ProfileUser::all()/* latest()->paginate(15) */;
        //dd($routerboardusers);
        $routerboardusersativos = RouterBoardUserAtivo::all()/* latest()->paginate(15) */;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Dados RouterBoard ' . ''/* $this->title_breadcrumbs */,
                'url' => "#",
            ]
        ];
        $sections = ["routerboard.index" => ['data' => [],]];
        $title = 'Router';
        $titlepage = ucfirst('RouterBoard');
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $resource = $this->resource;
        $totalUser = $this->totalUser;
        $totalAtivos = $this->totalAtivos;
        $acesso_user = $this->acesso_user;
        $log_rb = $this->log_rb;

        $header_table = [
            [
                'title' => 'Id',
                'width' => '',
            ],
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Mac',
                'width' => '',
            ],
            [
                'title' => 'UpTime',
                'width' => '',
            ],
            [
                'title' => 'Dados Download',
                'width' => '',
            ],
            [
                'title' => 'Dados Upload',
                'width' => '',
            ],
            [
                'title' => 'Ação',
                'width' => '50',
            ],
        ];
        $body_table = [
            [
                'title' => 'id',
                'type' => 'string',
            ],
            [
                'title' => 'name',
                'type' => 'string',
            ],
            [
                'title' => 'mac_address',
                'type' => 'string',
            ],
            [
                'title' => 'uptime',
                'type' => 'bytes',
            ],
            [
                'title' => 'bytes_in',
                'type' => 'bytes',
            ],
            [
                'title' => 'bytes_out',
                'type' => 'bytes',
            ],
        ];
        $header_table_ativos = [
            [
                'title' => 'Id',
                'width' => '',
            ],
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Ip',
                'width' => '',
            ],
            [
                'title' => 'UpTime',
                'width' => '',
            ],
            [
                'title' => 'Expira',
                'width' => '',
            ],
            [
                'title' => 'Velocidade Download',
                'width' => '',
            ],
            [
                'title' => 'Velocidade Upload',
                'width' => '',
            ],
            [
                'title' => 'Pacotes Download',
                'width' => '',
            ],
            [
                'title' => 'Pacotes Upload',
                'width' => '',
            ],
            [
                'title' => 'Ação',
                'width' => '50',
            ],
        ];
        $body_table_ativos = [
            [
                'title' => 'id',
                'type' => 'string',
            ],
            [
                'title' => 'user',
                'type' => 'string',
            ],
            [
                'title' => 'address',
                'type' => 'bytes',
            ],
            [
                'title' => 'uptime',
                'type' => 'bytes',
            ],
            [
                'title' => 'session_time_left',
                'type' => 'bytes',
            ],
            [
                'title' => 'bytes_in',
                'type' => 'bytes',
            ],
            [
                'title' => 'bytes_out',
                'type' => 'bytes',
            ],
            [
                'title' => 'packets_in',
                'type' => 'bytes',
            ],
            [
                'title' => 'packets_out',
                'type' => 'bytes',
            ],
        ];
        return view('admin.page', compact(
            /* 'datapage', */
            'routerboardusers',
            'acesso_user',
            'log_rb',
            'routerboardusersativos',
            'title',
            'header_table',
            'body_table',
            'header_table_ativos',
            'body_table_ativos',
            'route',
            'can',
            'sidebaradmin',
            'breadcrumbs',
            'titlepage',
            'resource',
            'totalUser',
            'totalAtivos',
            'sections',
            'idRb',
            'interfaceRb',
            'profileUsers'
        ));
    }
    /**
     *
     */
    public function ipBindingAdd(ProfileUser $profile, Request $request): RedirectResponse
    {
        //dd($request->cmd);
        $profile = ProfileUser::where('id', $request->id)->first();

        $res =  WebHelper::apiMkPost($request->idrb, 'ip/hotspot/ip-binding/add', [
            'mac-address' => $profile->mac_address,
            'server' => 'all',
            'type' => $request->cmd,
            'comment' => "Adicionado Pelo Sistema " . strtoupper($profile->name) . " - " . date('Y-m-d H:i:s')
        ]);

        if ($res->status() == 200) {
            ProfileUser::where('id', $request->id)->update(['status' => $request->cmd]);
            return redirect()->route("router_dash", $request->idrb)
                ->with('success', "Registro de MAC adicionado com sucesso.");
        } else {
            return redirect()->route("router_dash", $request->idrb)
                ->with('error', "Erro na solicitação.");
        }


        //dd($response->status());

        //deletar hotspot do ip-bindings
        //$response = Http::withBasicAuth('admin', 'fonelight135')->delete("http://192.168.170.2:80/rest/ip/hotspot/ip-binding/*5C");

        // buscar Lista de ip-binding
        //$response = Http::withBasicAuth('admin', 'fonelight135')->get("http://192.168.170.2:80/rest/ip/hotspot/ip-binding");
        //$dados = mb_convert_encoding($response->body(), "UTF-8", "auto");

        //ProfileUser::where('id', $request->id)->update(['status' => 'bypassed']);

        //return redirect()->route("hotspot.index")
        //    ->with('success', "Registro de MAC adicionado com sucesso.");
    }
    /**
     *
     */
    public function ipBindingRemove(ProfileUser $profile, Request $request): RedirectResponse
    {
        $resDel = 0;
        $profile = ProfileUser::where('id', $request->id)->first();
        $res =  WebHelper::apiMkGet($request->idrb, 'ip/hotspot/ip-binding');

        foreach ($res as $key => $vlr) {
            if (isset($vlr->{'mac-address'})) {
                if ($vlr->{'mac-address'} == $profile->mac_address) {
                    $response = WebHelper::apiMkDelete(1, 'ip/hotspot/ip-binding', $vlr->{'.id'});
                    $resDel = $response->status();
                }
            }
        }
        if ($resDel == 204) {
            ProfileUser::where('id', $request->id)->update(['status' => '']);
            return redirect()->route("router_dash", $request->idrb)
                ->with('success', "Registro de MAC removido com sucesso.");
        } else {
            return redirect()->route("router_dash", $request->idrb)
                ->with('error', "Erro na solicitação.");
        }
    }
}
