<?php

namespace App\Helpers;

use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class WebHelper
{
    /** Base URL da API Moovsec (evita repetir a string em cada chamada). */
    private const MOOVSEC_BASE_URL = 'https://veicular.onotecnologia.com.br:5000';

    /** Mapa de roles -> label legível (pt-BR). Const = não é reconstruído a cada chamada. */
    private const ROLE_MAP = [
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

    /** Padrões de plataforma, na mesma ordem de prioridade do código original. */
    private const PLATFORM_PATTERNS = [
        'linux' => '/linux/i',
        'mac' => '/macintosh|mac os x/i',
        'windows' => '/windows|win32/i',
    ];

    /** Padrões de navegador, na mesma ordem de prioridade do código original. */
    private const BROWSER_PATTERNS = [
        'IE' => '/MSIE/i',
        'Firefox' => '/Firefox/i',
        'Chrome' => '/Chrome/i',
        'Safari' => '/Safari/i',
        'Opera' => '/Opera|OPR/i',
    ];

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
            $res = Http::get('https://api.macvendors.com/' . urlencode($mac));
            return $res->ok() ? $res->body() : 'n/a';
        } catch (Exception $e) {
            Log::error('Erro Mac API: ' . $e->getMessage());
            return 'n/a';
        }
    }

    /**
     * Chamada API Moovsec simplificada.
     */
    public static function apiLoginMoovsecToken()
    {
        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->timeout(30)
                ->post(self::MOOVSEC_BASE_URL . '/auth/login', [
                    'login' => env('MOOVSEC_LOGIN', 'desenvolvimentofonelight@gmail.com'),
                    'password' => env('MOOVSEC_PASSWORD', 'Fonelight@135'),
                ]);

            return $response->json('data');
        } catch (Exception $e) {
            Log::error('Erro Moovsec API: ' . $e->getMessage());
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
                'Authorization' => 'Bearer ' . self::apiLoginMoovsecToken(),
            ])
                ->timeout(60) // Espera até 60 segundos pela resposta
                ->retry(3, 100) // Tenta 3 vezes antes de desistir, com 100ms de intervalo
                ->get(self::MOOVSEC_BASE_URL . $url);

            return $response->json('data');
        } catch (Exception $e) {
            Log::error('Erro Moovsec API (Timeout ou Conexão): ' . $e->getMessage());
            return null;
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
                    'parse_mode' => 'html',
                ]);
        } catch (Exception $e) {
            Log::error('Erro Telegram: ' . $e->getMessage());
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
                'mensagem' => $mensagem,
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao salvar log DB: ' . $e->getMessage());
        }
    }

    /**
     * Busca recursiva em array.
     */
    public static function search_array($needle, array $haystack)
    {
        foreach ($haystack as $key => $value) {
            if ($value === $needle) {
                return [$key, $value];
            }
            if (is_array($value)) {
                $result = self::search_array($needle, $value);
                if ($result) {
                    return $result;
                }
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
     * Validação de JSON simplificada.
     * Usa json_validate() nativo (PHP 8.3+), que valida sem alocar a árvore
     * decodificada — mais rápido para strings grandes. Fallback idêntico ao
     * comportamento original em versões anteriores.
     */
    public static function is_json_string($json_str): bool
    {
        if (!is_string($json_str)) {
            return false;
        }

        if (function_exists('json_validate')) {
            return json_validate($json_str);
        }

        json_decode($json_str);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Tradução de Roles simplificada com Array Map.
     */
    public static function rename_role(string $str): string
    {
        $parts = explode('-', $str);
        $translated = array_map(fn($p) => self::ROLE_MAP[$p] ?? $p, $parts);

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
        $u_agent = request()->userAgent() ?? '';

        return [
            'user_agent' => $u_agent,
            'browser' => self::matchFirstPattern(self::BROWSER_PATTERNS, $u_agent),
            'os_platform' => self::matchFirstPattern(self::PLATFORM_PATTERNS, $u_agent),
            'device' => Str::contains(strtolower($u_agent), ['mobile', 'android', 'iphone']) ? 'Mobile' : 'Desktop',
        ];
    }

    /**
     * Retorna o primeiro rótulo cujo padrão (regex) casa com o valor,
     * ou 'Unknown' se nenhum casar. Substitui as cadeias de if/elseif
     * usadas para detectar navegador e plataforma.
     */
    private static function matchFirstPattern(array $patterns, string $value): string
    {
        foreach ($patterns as $label => $pattern) {
            if (preg_match($pattern, $value)) {
                return $label;
            }
        }

        return 'Unknown';
    }

    /**
     * Validação de Nome Brasileiro.
     */
    public static function nomeBrasileiroValido(string $nome): bool
    {
        $nome = trim($nome);
        if (!Str::contains($nome, ' ')) {
            return false;
        }

        return (bool) preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]{6,100}$/u', $nome);
    }
}
