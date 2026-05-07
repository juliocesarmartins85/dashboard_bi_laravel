<?php

namespace App\Helpers;

use App\Models\Log as ModelsLog;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class WebHelper
{
    /**
     * Retorna a data atual formatada.
     */
    public static function changeDateNow(): string
    {
        return Carbon::now()->format('d/m/Y');
    }

    /**
     * Caminho da imagem do produto.
     */
    public static function productImagePath(string $imageName): string
    {
        return public_path("images/products/{$imageName}");
    }

    /**
     * Busca fornecedor pelo MAC.
     */
    public static function apiMacGet(string $mac): string
    {
        try {
            $res = Http::get("https://api.macvendors.com/" . urlencode($mac));
            return $res->ok() ? $res->body() : 'n/a';
        } catch (Exception $e) {
            Log::error("Erro Mac API: " . $e->getMessage());
            return 'n/a';
        }
    }

    /**
     * Chamada API Moovsec simplificada.
     */
    public static function apiLoginMoovsecToken()
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)
                ->post('https://veicular.onotecnologia.com.br:5000/auth/login', [
                    'login' => 'desenvolvimentofonelight@gmail.com',
                    'password' => 'Fonelight@135',
                ]);

            return $response->json('data');
        } catch (Exception $e) {
            Log::error("Erro Moovsec API: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Chamada API Moovsec simplificada.
     */
    public static function apiGetMoovsec(string $url)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . self::apiLoginMoovsecToken()
            ])
                ->timeout(60) // Espera até 60 segundos pela resposta
                ->retry(3, 100) // Tenta 3 vezes antes de desistir, com 100ms de intervalo
                ->get('https://veicular.onotecnologia.com.br:5000' . $url);

            return $response->json('data');
        } catch (Exception $e) {
            Log::error("Erro Moovsec API (Timeout ou Conexão): " . $e->getMessage());
            return null;
        }
    }

    /**
     * Atualiza informações dos veículos com dados da API Moovsec.
     */
    public static function updateVehicleMoovsec()
    {

        $vehicles = WebHelper::apiGetMoovsec('/vehicle/all/true');

        // 1. Verifica se é null OU se não é um array (caso a API mude o formato)
        if (!is_array($vehicles)) {
            Log::warning("Dados de veículos inválidos ou API indisponível. Conteúdo: " . json_encode($vehicles));
            return; // Interrompe a execução para não chegar no foreach
        }

        // 2. Se chegou aqui, temos um array (mesmo que vazio, o foreach não quebra)
        foreach ($vehicles as $v) {
            $idMoovsec = $v['_id'] ?? null;

            if ($idMoovsec) {
                Vehicle::where('idMoovsec', $idMoovsec)->update([
                    'dataMoovsec' => $v
                ]);
            }
        }
    }

    /**
     * Notificação Telegram.
     */
    public static function apiTelegramNotification(string $token, string $chatId, string $msg)
    {
        try {
            return Http::withoutVerifying()
                ->timeout(5)
                ->get("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $msg,
                    'parse_mode' => 'html'
                ]);
        } catch (Exception $e) {
            Log::error("Erro Telegram: " . $e->getMessage());
        }
    }

    /**
     * Registro de Log no Banco de Dados.
     */
    public static function logdata(string $tipo, string $nivel, string $page, string $mensagem): void
    {
        try {
            ModelsLog::create([
                'tipo' => $tipo,
                'nivel' => $nivel,
                'page' => $page,
                'mensagem' => $mensagem
            ]);
        } catch (Exception $e) {
            Log::error("Erro ao salvar log DB: " . $e->getMessage());
        }
    }

    /**
     * Busca recursiva em array.
     */
    public static function search_array($needle, array $haystack)
    {
        foreach ($haystack as $key => $value) {
            if ($value === $needle) return [$key, $value];
            if (is_array($value)) {
                $result = self::search_array($needle, $value);
                if ($result) return $result;
            }
        }
        return false;
    }

    /**
     * URL amigável usando Helper nativo do Laravel.
     */
    public static function seo_friendly_url(string $string): string
    {
        return Str::slug($string);
    }

    /**
     * Validação de JSON simplificada (PHP 8.3+ pode usar json_validate).
     */
    public static function is_json_string($json_str): bool
    {
        if (!is_string($json_str)) return false;
        json_decode($json_str);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Tradução de Roles simplificada com Array Map.
     */
    public static function rename_role(string $str): string
    {
        $map = [
            'breadcrumb' => 'indicador',
            'srvcfeatured' => 'serviço destaque',
            'feature' => 'recursos',
            'footer' => 'rodape',
            'ctrpricing' => 'planos cartão',
            'movelpricing' => 'planos movel',
            'pricing' => 'planos',
            'sectionpage' => 'seção pagina',
            'sidebar' => 'barra Lateral',
            'tip' => 'dica',
            'usuario' => 'administradores',
            'profileusers' => 'usuario',
            'route' => 'rotas',
            'vehicle' => 'veículos',
            'driver' => 'motoristas',
            'stop' => 'paradas',
            'street' => 'ruas',
        ];

        $parts = explode('-', $str);
        $translated = array_map(fn($p) => $map[$p] ?? $p, $parts);

        return implode(' ', array_map('ucfirst', $translated));
    }

    /**
     * Obtém IP do usuário via Request do Laravel (mais seguro).
     */
    public static function getUserIpAddr(): string
    {
        return request()->ip() ?? 'UNKNOWN';
    }

    /**
     * Informações do Browser. 
     * DICA: Considere usar o pacote 'jenssegers/agent' para algo profissional.
     */
    public static function getBrowserInfo(): array
    {
        $u_agent = request()->userAgent();
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "?";

        if (preg_match('/linux/i', $u_agent)) $platform = 'linux';
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) $platform = 'mac';
        elseif (preg_match('/windows|win32/i', $u_agent)) $platform = 'windows';

        if (preg_match('/MSIE/i', $u_agent)) $bname = 'IE';
        elseif (preg_match('/Firefox/i', $u_agent)) $bname = 'Firefox';
        elseif (preg_match('/Chrome/i', $u_agent)) $bname = 'Chrome';
        elseif (preg_match('/Safari/i', $u_agent)) $bname = 'Safari';
        elseif (preg_match('/Opera|OPR/i', $u_agent)) $bname = 'Opera';

        return [
            'user_agent' => $u_agent,
            'browser' => $bname,
            'os_platform' => $platform,
            'device' => Str::contains(strtolower($u_agent), ['mobile', 'android', 'iphone']) ? 'Mobile' : 'Desktop'
        ];
    }

    /**
     * Validação de Nome Brasileiro.
     */
    public static function nomeBrasileiroValido(string $nome): bool
    {
        $nome = trim($nome);
        if (!Str::contains($nome, ' ')) return false;

        return preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]{6,100}$/u', $nome);
    }
}
