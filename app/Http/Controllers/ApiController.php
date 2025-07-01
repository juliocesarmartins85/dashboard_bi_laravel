<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\Api;
use App\Models\Respostas;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blacklist;
use App\Models\Blog;
use App\Models\Breadcrumbs;
use App\Models\Contact;
use App\Models\Hotspot;
use App\Models\Perguntas;
use App\Models\ProfileUser;
use App\Models\RouterBoard;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\DeviceHistory;
use App\Models\DiretivaPrivacidade;
use App\Models\Doc;
use App\Models\Endereco;
use App\Models\Enquete;
use App\Models\EnquetePergunta;
use App\Models\EnqueteResposta;
use App\Models\Features;
use App\Models\File;
use App\Models\Gallery;
use App\Models\Hero;
use App\Models\Log as ModelsLog;
use App\Models\Menu;
use App\Models\PerguntaResposta;
use App\Models\PoliticaCookie;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\ProtecaoDados;
use App\Models\RedeSocial;
use App\Models\RouterBoardUser;
use App\Models\RouterBoardUserAtivo;
use App\Models\SideBar;
use App\Models\Site;
use App\Models\Web;
use Carbon\Carbon;
use Database\Seeders\HeroSeeder;
use Spatie\Permission\Models\Permission;

class ApiController extends Controller
{
    protected $cliente;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Api $api)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Api $api)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Api $api)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Api $api)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function migrations(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function password_reset_tokens(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function users(Request $request)
    {
        try {
            return response()->json(User::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function password_resets(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function failed_jobs(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function personal_access_tokens(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function permissions(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function model_has_permissions(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function roles(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function model_has_roles(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function role_has_permissions(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function products(Request $request)
    {
        try {
            return response()->json(Product::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function breadcrumbs(Request $request)
    {
        try {
            return response()->json(Breadcrumbs::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function perguntas(Request $request)
    {
        try {
            return response()->json(Perguntas::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    //public function enquete_perguntas(Request $request)
    //{
    //    try {
    //        return response()->json(EnquetePergunta::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    public function enquetes(Request $request)
    {
        try {
            return response()->json(Enquete::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function respostas(Request $request)
    {
        try {
            return response()->json(Respostas::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    //public function enquete_respostas(Request $request)
    //{
    //    try {
    //        return response()->json(EnqueteResposta::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    public function hotspots(Request $request)
    {
        try {
            return response()->json(Hotspot::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function pergunta_respostas(Request $request)
    {
        try {
            return response()->json(PerguntaResposta::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function router_boards(Request $request)
    {
        try {
            return response()->json(RouterBoard::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function side_bars(Request $request)
    {
        try {
            return response()->json(SideBar::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function blacklists(Request $request)
    {
        try {
            return response()->json(Blacklist::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function device_histories(Request $request)
    {
        try {
            return response()->json(DeviceHistory::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    //public function files(Request $request)
    //{
    //    try {
    //        return response()->json(File::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function webs(Request $request)
    //{
    //    try {
    //        return response()->json(Web::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    public function logs(Request $request)
    {
        try {
            return response()->json(ModelsLog::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function profile_users(Request $request)
    {
        try {
            return response()->json(ProfileUser::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function enderecos(Request $request)
    {
        try {
            return response()->json(Endereco::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function sites(Request $request)
    {
        try {
            return response()->json(Site::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    //public function banners(Request $request)
    //{
    //    try {
    //        return response()->json(Banner::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function blogs(Request $request)
    //{
    //    try {
    //        return response()->json(Blog::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function contacts(Request $request)
    //{
    //    try {
    //        return response()->json(Contact::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function diretiva_privacidades(Request $request)
    //{
    //    try {
    //        return response()->json(DiretivaPrivacidade::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function docs(Request $request)
    //{
    //    try {
    //        return response()->json(Doc::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function features(Request $request)
    //{
    //    try {
    //        return response()->json(Features::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function galleries(Request $request)
    //{
    //    try {
    //        return response()->json(Gallery::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function heroes(Request $request)
    //{
    //    try {
    //        return response()->json(Hero::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function menus(Request $request)
    //{
    //    try {
    //        return response()->json(Menu::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function politica_cookies(Request $request)
    //{
    //    try {
    //        return response()->json(PoliticaCookie::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function pricings(Request $request)
    //{
    //    try {
    //        return response()->json(Pricing::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function protecao_dados(Request $request)
    //{
    //    try {
    //        return response()->json(ProtecaoDados::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    //public function rede_socials(Request $request)
    //{
    //    try {
    //        return response()->json(RedeSocial::all(), 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    public function apis(Request $request)
    {
        try {
            return response()->json([], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function router_board_user_ativos(Request $request)
    {
        try {
            return response()->json(RouterBoardUserAtivo::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function router_board_users(Request $request)
    {
        try {
            return response()->json(RouterBoardUser::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Recebe os dados via post do mikrotik
     *
     * @return \Illuminate\Http\Response
     */
    public function wifi_pro(Request $request)
    {
        $mac = $request->mac;
        return redirect()->route('wifi_free', ['mac' => $mac]);
    }
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *
     * @param Request $request
     *
     */
    public function traficorb(Request $request)
    {
        try {
            $out = WebHelper::apiMkPost($request->rb, 'interface/monitor-traffic', ['interface' => $request->interface,'duration' => '2s']);

            $rows = [];
            $rows2 = [];

            $ftx = $out[0]['tx-bits-per-second'];
            $frx = $out[0]['rx-bits-per-second'];

            $rows['name'] = 'Tx';
            $rows['data'][] = $ftx;
            $rows2['name'] = 'Rx';
            $rows2['data'][] = $frx;

            $result = [];

            array_push($result, $rows);
            array_push($result, $rows2);

            return response()->json($result, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    //public function cidadesDigitais()
    //{
    //    $data_map = json_decode('[
    //        {
    //        "title": "1 - Monitoramento de campos e quadras poliesportivos",
    //        "description": "Monitore os campos, quadras, academias de rua e identifique brigas, tráfego de drogas e vandalismo.",
    //        "how": [
    //            "Utilizamos a inteligência artificial para detecção de tumultos e movimentações suspeitas."
    //            ]
    //        },
    //        {
    //            "title": "2 - Câmeras LPR com identificação de placas",
    //            "description": "Mapeie todos os carros que estão no município, localizando rapidamente veículos roubados, com IPVA atrasado, clonados ou suspeitos, faça buscas por cor e marca de veículos, quando a vítima não teve tempo de reconhecer a placa*.",
    //            "how": [
    //                "Função Leitura automática de placas e Inteligência Artificial.",
    //                "*Estas informações são exclusivas dos órgãos de segurança integrados com o sistema Hélios."
    //            ]
    //        },
    //        {
    //            "title": "3 - Gestão de frotas",
    //            "description": "Saiba todas as movimentações dos veículos de passeio, ambulâncias, maquinas pesadas e ônibus escolares controlando gastos excessivos com manutenções, horas extras e combustíveis.",
    //            "how": [
    //                "Com nosso software exclusivo para gestão de frotas para órgãos públicos entregamos o que há de mais inovador aos gestores e prefeitos."
    //            ]
    //        },
    //        {
    //            "title": "4 - Monitoramento de acesso as estradas rurais",
    //            "description": "Monitore as principais estradas rurais do município para evitar roubos contra sítios e fazendas e abandono de veículos roubados.",
    //            "how": [
    //                "Câmeras instaladas nos principais entroncamentos para áreas rurais."
    //            ]
    //        },
    //        {
    //            "title": "5 - Objeto retirado ou abandonado",
    //            "description": "Monitore o abandono de objetos em áreas críticas, como bolsas abandonadas em calçadas.",
    //            "how": [
    //                "Abandono ou retirada de objetos."
    //            ]
    //        },
    //        {
    //            "title": "6 - Avançar sinal de Trânsito e monitoramento de infrações",
    //            "description": "Monitore áreas com sinalização para identificar infrações que acarretem acidentes. Identifique veículos envolvidos em acidentes com imagens que exibem o cenário, facilitando os serviços de segurança e trânsito.",
    //            "how": [
    //                "LPR, inteligência perimetral, linha e cerca virtual."
    //            ]
    //        },
    //        {
    //            "title": "7 - Controle de entrada e saída",
    //            "description": "Monitore todas as entradas e saídas da sua cidade ou bairro. identificando os carros e as pessoas que passam pelo local.",
    //            "how": [
    //                "Função Leitura automática de placas e inteligência Artificial."
    //            ]
    //        },
    //        {
    //            "title": "8 - Internet, telefonia e câmeras de monitoramento para escolas e postos de saúde rurais",
    //            "description": "Temos a solução de comunicação com cobertura para qualquer local onde a nossa empresa presta serviços.",
    //            "how": [
    //                "Nossa tecnologia via satélite e desta forma entregamos a conectividade aos locais mais remotos."
    //            ]
    //        },
    //        {
    //            "title": "9 - Veículo irregular",
    //            "description": "Receba alertas automáticos quando um veículo parar em uma faixa de pedestres, trafegar em uma calçada ou em uma via exclusiva para pessoas ou passar por um sinal vermelho.",
    //            "how": [
    //                "LPR, inteligência perimetral, objeto deixado e autotracking."
    //            ]
    //        },
    //        {
    //            "title": "10 - Monitoramento de Escolas e creches",
    //            "description": "Monitore movimentações de pessoas estranhas e ou veículos suspeitos nas proximidades das escolas.",
    //            "how": [
    //                "Panorâmica, Smart tracking e reconhecimento facial."
    //            ]
    //        },
    //        {
    //            "title": "11 - Localização e riscos e registro de ocorrências",
    //            "description": "Identifique atividades perigosas, à distância, antes mesmo do evento acontecer e utilize as imagens gravadas para localizar suspeitos, descobrir motivos de acidentes de trânsito ou colher detalhes importantes para solucionar crimes.",
    //            "how": [
    //                "Funções Starlight, Altíssima Resolução, Panorâmica, SVR e Super Zoom."
    //            ]
    //        },
    //        {
    //            "title": "12 - Monitoramento do nível de rios e outros tipos de correntes de águas",
    //            "description": "Gerencie através do seu painel de câmeras os níveis de rios, riachos, ribeirões ou córregos. Com este recurso, sua gestão de riscos e alertas ficará mais eficiente.",
    //            "how": [
    //                "Câmera filmando a régua de medição de nível e monitoramento centralizado."
    //            ]
    //        },
    //        {
    //            "title": "13 - Monitore parques, praças e jardins",
    //            "description": "Receba alertas quando pessoas invadirem jardins, entrarem em locais proibidos em parques ou pularem em lagos proibidos para banho.",
    //            "how": [
    //                "Inteligência perimetral, linha e cerca virtual."
    //            ]
    //        },
    //        {
    //            "title": "14 - Detecte facilmente motins e aglomerações",
    //            "description": "Seja avisado sempre que ocorrer uma briga na frente de um bar, início de manifestações na prefeitura ou atitude suspeita em frente de um banco, tudo de forma automática e inteligente.",
    //            "how": [
    //                "Inteligência artificial."
    //            ]
    //        },
    //        {
    //            "title": "15 - Rede WI-FI pública",
    //            "description": "Criação de redes WI-FI para praças, rodoviárias e locais onde há concentração de pessoas.",
    //            "how": [
    //                "Implantação de roteadores robustos."
    //            ]
    //        }
    //    ]');
//
    //    try {
    //        return response()->json($data_map, 200);
    //    } catch (\Throwable $th) {
    //        return response()->json([
    //            'status' => false,
    //            'message' => $th->getMessage()
    //        ], 500);
    //    }
    //}
    /**
     * Display a listing of the resource.
     */
    public function dataSeed(Request $request)
    {
        try {
            return response()->json(DB::table($request->tb)->get(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
