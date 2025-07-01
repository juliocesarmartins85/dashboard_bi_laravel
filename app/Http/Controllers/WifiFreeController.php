<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\DeviceHistory;
use App\Models\Endereco;
use App\Models\Enquete;
use App\Models\Perguntas;
use App\Models\ProfileUser;
use App\Models\Respostas;
use App\Models\RouterBoard;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Models\RouterBoardUser;
use App\Models\RouterBoardUserAtivo;
use App\Models\Site;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use stdClass;

class WifiFreeController extends Controller
{
    /**
     *
     *
     * @param
     * @return void
     */
    public function __construct()
    {
        foreach (RouterBoard::all() as $k => $rb) {
            try {
                $data = WebHelper::apiMkGet($rb->id, 'ip/hotspot/user');
                $user = collect($data)->except(['0'])->toArray();
                $ativo = WebHelper::apiMkGet($rb->id, 'ip/hotspot/active');
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            try {
                DB::table("router_board_users")->truncate();
                $router_board_users = [];
                $device_user_ativos = [];
                foreach ($user as $key => $item) {
                    array_push($router_board_users, [
                        'id_rb' => $item->{".id"},
                        'server' => $item->server,
                        'name' => $item->name,
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
            } catch (\Throwable $e) {
                Log::info($e->getMessage());
            }

            try {
                DB::table("router_board_user_ativos")->truncate();
                $router_board_user_ativos = [];
                foreach ($ativo as $key => $itemativo) {
                    array_push($router_board_user_ativos, [
                        'id_rb' => $item->{".id"},
                        'server' => $item->server,
                        'user' => $itemativo->user,
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
            } catch (\Throwable $e) {
                Log::info($e->getMessage());
            }

            try {
                foreach (WebHelper::apiMkGet($rb->id, 'ip/dhcp-server/lease') as $key => $vlrLease) {
                    if (isset($vlrLease->{'host-name'})) {
                        if (empty(DeviceHistory::where('mac_address', $vlrLease->{"mac-address"})->first())) {
                            DeviceHistory::create([
                                'id_user' => $vlrLease->{"mac-address"} ?? '',
                                'mac_address' => $vlrLease->{"mac-address"} ?? '',
                                'host_name' => $vlrLease->{"host-name"} .'-'. WebHelper::apiMacGet($vlrLease->{"mac-address"}) ?? WebHelper::apiMacGet($vlrLease->{"mac-address"}),
                                'ip_adress' => $vlrLease->{"active-address"} ?? '',
                                'server' => $vlrLease->{"server"} ?? '',
                                'hotspot' => $vlrLease->{"host-name"} .'-'. WebHelper::apiMacGet($vlrLease->{"mac-address"}) ?? WebHelper::apiMacGet($vlrLease->{"mac-address"}),
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            } catch (\Throwable $th) {
                Log::info($e->getMessage());
            }
        }
    }
    /**
     *
     */
    public function wifi_free(Request $request)
    {
        $now_date = Carbon::parse(date('Y-m-d H:i:s'))->format('d/m/Y H:i');
        $userAgent = $request->header('User-Agent');
        try {
            foreach (RouterBoard::all() as $k => $rb) {
                foreach (WebHelper::apiMkGet($rb->id, 'ip/dhcp-server/lease') as $key => $vlrLease) {
                    if ($request->mac == $vlrLease->{"mac-address"}) {
                        $mac_address = $vlrLease->{"mac-address"} ?? '';
                        $host_name = $vlrLease->{"host-name"} ?? '';
                        $ip_adress = $vlrLease->{"active-address"} ?? '';
                        $server = $vlrLease->{"server"} ?? '';
                        $hotspot = $vlrLease->{"host-name"} ?? '';
                        WebHelper::apiTelegramNotification(Site::first()->telegram_bot, Site::first()->telegram_group, "
                            <b>Dispositivo Conectou ao Hostspot - " . Site::first()->name . "</b>
                            <i>Mac:</i> <code>$mac_address</code>
                            <i>Nome Equipamento:</i> <code>$host_name</code>
                            <i>IP:</i> <code>$ip_adress</code>
                            <i>Servidor:</i> <code>$server</code>
                            <i>Dispositivo:</i> <code>$userAgent</code>
                            <i>Data:</i> <code>$now_date</code>
                            ");
                    }
                }
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
        } catch (\Throwable $e) {
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
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }

        if (filter_var($request->mac, FILTER_VALIDATE_MAC)) {
            if (empty(ProfileUser::where('mac_address', $request->mac)->first())) {
                $enquete = new stdClass;
                $bairros = Endereco::orderBy('bairro', 'ASC')->get();
                $video_enquete = Enquete::where('status', true)->first()->video ?? '';
                try {
                    if (!empty(Enquete::where('status', true)->first())) {
                        foreach (json_decode(Enquete::where('status', true)->first()->questions) ?? [] as $key => $enquete_vlr) {
                            $p = Perguntas::findOrFail($enquete_vlr);
                            $enquete->$key = new stdClass;
                            $enquete->$key->id_enquete = Enquete::where('status', true)->first()->id;
                            $enquete->$key->id = $p->id;
                            $enquete->$key->question = $p->question;
                            $enquete->$key->type = $p->type;
                            $enquete->$key->options = $p->options;
                            $enquete->$key->status = $p->status;
                            $enquete->$key->interval = $p->interval;
                            $enquete->$key->nivel = $p->nivel;
                        }
                    }
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                }

                $res_mac_address = $request->mac;
                $form = [
                    [
                        'title' => 'Nome',
                        'type' => 'text',
                        'name' => 'name',
                        'placeholder' => 'name',
                        'tag' => 'input',
                        'value' => '',
                    ],
                    [
                        'title' => 'Sobrenome',
                        'type' => 'text',
                        'name' => 'sobrenome',
                        'placeholder' => 'sobrenome',
                        'tag' => 'input',
                        'value' => '',
                    ],
                    [
                        'title' => 'Telefone',
                        'type' => 'tel',
                        'name' => 'telefone',
                        'placeholder' => 'sobrenome',
                        'tag' => 'input',
                        'value' => '',
                    ],
                    [
                        'title' => 'Bairro',
                        'type' => 'text',
                        'name' => 'bairro',
                        'placeholder' => 'bairro',
                        'tag' => 'dropdown',
                        'value' => '',
                    ],
                ];
                return view('form_enquete', compact('form', 'res_mac_address', 'enquete', 'bairros', 'video_enquete'));
            } else {
                try {
                    $perguntaslogado = ProfileUser::where('mac_address', $request->mac)->first();
                    $now_date = Carbon::parse(date('Y-m-d H:i:s'))->format('d/m/Y H:i');
                    WebHelper::apiTelegramNotification(Site::first()->telegram_bot, Site::first()->telegram_group, "
                        <b>Usuário reconectou ao Wifi-Free - " . Site::first()->name . "</b>
                        <i>Nome:</i> <code>$perguntaslogado->name</code>
                        <i>Telefone:</i> <code>$perguntaslogado->telefone</code>
                        <i>Cidade:</i> <code>$perguntaslogado->cidade</code>
                        <i>Bairro:</i> <code>$perguntaslogado->bairro</code>
                        <i>Mac:</i> <code>$perguntaslogado->mac_address</code>
                        <i>Data:</i> <code>$now_date</code>
                        ");
                } catch (\Throwable $e) {
                    Log::info($e->getMessage());
                }
                return redirect()->to("http://teste.com/login?dst=&username=T-$request->mac");
            }
        }
    }

    /**
     *
     */
    public function wifi_free_conectar(Request $request, ProfileUser $profile_user, Respostas $respostas): RedirectResponse
    {
        $mac = $request->mac;
        $name = ucfirst($request->name) . ' ' . ucfirst($request->sobrenome);
        $telefone = preg_replace('/[^0-9]/', '', $request->telefone);
        $bairro = Endereco::findOrFail($request->bairro)->bairro;
        $cidade = Endereco::findOrFail($request->bairro)->cidade;
        $id_enquete = $request->id_enquete;
        $pergunta = $request->pergunta;

        if (WebHelper::nomeBrasileiroValido($name) == false) {
            return redirect()->back()->with('warning', "Digite um nome válido!");
        }

        if (empty(ProfileUser::where('mac_address', $mac)->first())) {
            $profile_user->mac_address = $mac;
            $profile_user->name = $name;
            $profile_user->telefone = $telefone;
            $profile_user->bairro = $bairro;
            $profile_user->cidade = $cidade;
            $profile_user->save();
            if (isset($pergunta)) {
                foreach ($pergunta as $keypergunta => $perguntavlr) {
                    if (count($perguntavlr) == 1) {
                        Respostas::create([
                            'mac' => $mac,
                            'resposta' => $perguntavlr[0],
                            'id_enquete' => $id_enquete,
                            'id_pergunta' => $keypergunta,
                            'id_profile_usuario' => $profile_user->id,
                        ]);
                    } else {
                        Respostas::create([
                            'mac' => $mac,
                            'resposta' => json_encode($perguntavlr),
                            'id_enquete' => $id_enquete,
                            'id_pergunta' => $keypergunta,
                            'id_profile_usuario' => $profile_user->id,
                        ]);
                    }
                }
            }
            try {
                $perguntaslogado = ProfileUser::where('mac_address', $mac)->first();
                $now_date = Carbon::parse(date('Y-m-d H:i:s'))->format('d/m/Y H:i');
                WebHelper::apiTelegramNotification(Site::first()->telegram_bot, Site::first()->telegram_group, "
                    <b>Respondeu Enquete - " . Site::first()->name . "</b>
                    <i>Nome:</i> <code>$perguntaslogado->name</code>
                    <i>Telefone:</i> <code>$perguntaslogado->telefone</code>
                    <i>Cidade:</i> <code>$perguntaslogado->cidade</code>
                    <i>Bairro:</i> <code>$perguntaslogado->bairro</code>
                    <i>Mac:</i> <code>$perguntaslogado->mac_address</code>
                    <i>Data:</i> <code>$now_date</code>
                    ");
            } catch (\Throwable $e) {
                Log::info($e->getMessage());
            }
            return redirect()->to("http://teste.com/login?dst=&username=T-$mac");
        }
        return redirect()->back();
    }
    /**
     * Limpar cache laravel.
     *
     *
     */
    public function clear_cache()
    {
        try {
            $exitCode = Artisan::call('view:clear');
            $exitCode = Artisan::call('view:cache');
            $exitCode = Artisan::call('config:clear');
            $exitCode = Artisan::call('config:cache');
            $exitCode = Artisan::call('event:clear');
            $exitCode = Artisan::call('event:cache');
            $exitCode = Artisan::call('route:clear');
            $exitCode = Artisan::call('clear-compiled');
            $exitCode = Artisan::call('optimize:clear');
            Log::info('Cache apagado com sucesso ' . $exitCode);
            return redirect()->route('login');
        } catch (\Exception $e) {
            return Log::info($e->getMessage());
        }
    }
    /**
     * Gerar Controller, Models e Migrate.
     *
     *
     */
    //public function mcrsf(Request $request)
    //{
    //    $nome = ucfirst($request->nome);
    //    try {
    //        $exitCode = Artisan::call("make:model $nome -mcrsf");
    //        Log::info('Arquivos gerados com sucesso');
    //        return redirect()->route('login');
    //    } catch (\Exception $e) {
    //        return Log::info($e->getMessage());
    //    }
    //}
    /**
     * Carregar Banco de dados
     *
     *
     */
    //public function db()
    //{
    //    try {
    //        $exitCode = Artisan::call('db:wipe');
    //        $exitCode = Artisan::call('migrate --seed');
    //        Log::info('Database gerados com sucesso');
    //        return redirect()->route('login');
    //    } catch (\Exception $e) {
    //        return Log::info($e->getMessage());
    //    }
    //}
}
