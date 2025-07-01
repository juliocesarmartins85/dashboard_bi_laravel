<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Hotspot;
use App\Models\SideBar;
use Illuminate\Http\Request;
use App\Models\Blacklist;
use App\Models\DeviceHistory;
use App\Models\Enquete;
use App\Models\Perguntas;
use App\Models\ProfileUser;
use App\Models\Respostas;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $responsestatusclients;
    protected $cliente;
    protected $system_status;
    protected $resource;
    protected $totalUser;
    protected $totalAtivos;
    protected $acesso_user;
    protected $log_rb;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        try {
            foreach (Hotspot::all() as $key => $value) {
                $token =  Http::post("http://{$value->host}:{$value->port}/cgi-bin/api/v3/system/login", [
                    "data" => [
                        "username" => $value->user,
                        "password" => $value->pass
                    ]
                ])['data'];
                Hotspot::findOrFail($value->id)->update(['token' => $token["Token"]]);
                $this->system_status[$value->id] =  Http::timeout(10)->withHeaders(["Authorization" => "Token {$token['Token']}"])->get("http://{$value->host}:{$value->port}/cgi-bin/api/v3/system/status")['data'];
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        try {
            foreach (Enquete::all() as $key_enqt => $enqt) {
                $dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtinicio)->format("Y-m-d H:i"));
                $dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtfinal)->format("Y-m-d H:i"));
                $dataAtual = new DateTime();

                if ($dataAtual < $dataInicial) {
                    //echo "O intervalo ainda não começou.";
                    Enquete::where('id', $enqt->id)->update(['status' => '0']);
                } elseif ($dataAtual > $dataFinal) {
                    //echo "O intervalo expirou.";
                    Enquete::where('id', $enqt->id)->update(['status' => '0']);
                } else {
                    //echo "O intervalo está em andamento.";
                    Enquete::where('id', $enqt->id)->update(['status' => '1']);
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        try {
            foreach (Perguntas::all() as $key_prgt => $prgt) {
                $dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtinicio)->format("Y-m-d H:i"));
                $dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtfinal)->format("Y-m-d H:i"));
                $dataAtual = new DateTime();

                if ($dataAtual < $dataInicial) {
                    //echo "O intervalo ainda não começou.";
                    Perguntas::where('id', $prgt->id)->update(['status' => '0']);
                } elseif ($dataAtual > $dataFinal) {
                    //echo "O intervalo expirou.";
                    Perguntas::where('id', $prgt->id)->update(['status' => '0']);
                } else {
                    //echo "O intervalo está em andamento.";
                    Perguntas::where('id', $prgt->id)->update(['status' => '1']);
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $array_grafico_enquete = [];
        $array_grafico_pergunta = [];
        $preguntas_bairro = [];
        $title = 'dashboard';
        $titlepage = ucfirst('dashboard');
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];

        try {
            foreach (Perguntas::all() as $key => $prgt) {
                $array_grafico_enquete[$prgt->id] = [];
                foreach (explode('/', $prgt->options) as $key => $opt) {
                    $array_grafico_enquete[$prgt->id][] = ['value' => Respostas::where('id_pergunta', $prgt->id)->where('resposta', $opt)->count(), 'name' => $opt];
                }
            }
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        try {
            foreach (Perguntas::all() as $key => $prgt) {
                $array_grafico_pergunta[$prgt->id] = Perguntas::where('id', $prgt->id)->first()->question;
            }
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        try {
            $users = ProfileUser::select(
                "profile_users.id",
                "profile_users.name",
                "profile_users.email",
                "profile_users.bairro",
                "respostas.resposta as resposta_user",
                "respostas.id_pergunta as resposta_id"
            )->join("respostas", "respostas.id_profile_usuario", "=", "profile_users.id")
                ->get()
                ->toArray();
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        try {
            foreach (Perguntas::where('type', 'radio')->get() as $key_prgt => $prgt) {
                foreach (explode('/', $prgt->options) as $key_opts => $opts) {
                    // Inicialize a variável $counts dentro do loop externo
                    $counts = []; // Agora a variável está definida e pode ser utilizada

                    foreach ($users as $item) {
                        if ($item["resposta_user"] === $opts && $item["resposta_id"] === $prgt->id) {
                            $bairro = $item["bairro"];
                            if (!isset($counts[$bairro])) {
                                $counts[$bairro] = 0;
                            }
                            $counts[$bairro]++;
                        }
                    }
                    $preguntas_bairro[] = [
                        'question' => $prgt->question,
                        'response' => $opts,
                        'count' => $counts
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        $profile_header = [
            [
                'title' => 'Id',
                'col' => '',
            ],
            [
                'title' => 'Nome',
                'col' => '',
            ],
            [
                'title' => 'Bairro',
                'col' => '',
            ],
            [
                'title' => 'Telefone',
                'col' => '',
            ],
            [
                'title' => 'Endereço Mac',
                'col' => '',
            ],
        ];
        $blacklist_header = [
            [
                'title' => 'Id',
                'col' => '',
            ],
            [
                'title' => 'Nome',
                'col' => '',
            ],
            [
                'title' => 'Bairro',
                'col' => '',
            ],
            [
                'title' => 'Telefone',
                'col' => '',
            ],
            [
                'title' => 'Endereço Mac',
                'col' => '',
            ],
        ];
        $device_header = [
            [
                'title' => 'Id Usuário',
                'col' => '',
            ],
            [
                'title' => 'Endereço Mac',
                'col' => '',
            ],
            [
                'title' => 'Nome Equipamento',
                'col' => '',
            ],
            [
                'title' => 'IP',
                'col' => '',
            ],
            [
                'title' => 'Servidor',
                'col' => '',
            ],
            [
                'title' => 'Hotspot',
                'col' => '',
            ]
        ];
        $sections = [
            'cardHome' => [
                'col' => '',
                'data' => [
                    'data_system' => json_decode(json_encode($this->system_status))
                ]
            ],
            'graficoHome' => [
                'col' => '6',
                'data' => [
                    'array_grafico_enquete' => $array_grafico_enquete,
                    'array_grafico_pergunta' => $array_grafico_pergunta,
                ]
            ],
            'dataTableHome' => [
                'col' => '12',
                'data' => [
                    'profile_body' => ProfileUser::all(),
                    'profile_header' => $profile_header,
                    'device_body' => DeviceHistory::all(),
                    'device_header' => $device_header,
                    'blacklist_body' => Blacklist::all(),
                    'blacklist_header' => $blacklist_header,
                    'preguntas_bairro' => $preguntas_bairro,
                ]
            ]
        ];

        return view('admin.page', compact(
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
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function clientsconnects(Request $request)
    {
        $simple_table = [];
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $titlepage = 'Dispositivos Conectados';
        $hotspot = Hotspot::findOrFail($request->id);

        try {
            $data_hotspot = Http::timeout(10)->withHeaders(["Authorization" => "Token {$hotspot->token}"])->get("http://{$hotspot->host}:{$hotspot->port}/cgi-bin/api/v3/system/status")['data'];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        try {
            foreach (json_decode(json_encode($this->system_status[$request->id]))->wireless->radios as $k => $v) {
                $simple_table[$v->id] = Http::timeout(10)->withHeaders(["Authorization" => "Token {$hotspot->token}"])->get("http://{$hotspot->host}:{$hotspot->port}/cgi-bin/api/v3/interface/wireless/{$v->id}/clients/wireless")['data'];
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        $sections = [
            'simple_table' => ['data' => json_decode(json_encode($simple_table  ?? [])),],
            'card_data' => ['data' => json_decode(json_encode($data_hotspot  ?? [])),]
        ];
        //WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou - {$titlepage}");
        return view('admin.page',  compact(
            'sidebaradmin',
            'breadcrumbs',
            'titlepage',
            'sections'
        ));
    }
}
