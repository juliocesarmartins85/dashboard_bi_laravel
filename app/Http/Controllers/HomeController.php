<?php

namespace App\Http\Controllers;


use App\Helpers\WebHelper;
use App\Models\Breadcrumbs;
use App\Models\Driver;
use App\Models\Route;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SideBar;
use App\Models\Stop;
use App\Models\Street;
use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        WebHelper::updateVehicleMoovsec();
        $sidebaradmin = SideBar::all();
        $drivers = Driver::all();
        $vehicles = Vehicle::all();
        $routes = Route::all();
        $stops = Stop::all();
        $streets = Street::all();
        $breadcrumbs = Breadcrumbs::all();

        return view('admin.home', compact(
            'sidebaradmin',
            'breadcrumbs',
            'drivers',
            'vehicles',
            'routes',
            'stops',
            'streets'
        ));
    }

    public function updateVehicle(Request $request)
    {
        $request->validate([
            'route_id'   => 'required|exists:routes,id',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        try {
            DB::beginTransaction();

            $route = Route::findOrFail($request->route_id);
            $vehicle = Vehicle::findOrFail($request->vehicle_id);

            // 1. Atualizar o Veículo (Vínculo direto)
            $vehicle->update(['route_id' => $route->id]);

            // 2. Buscar as paradas que batem com o nome da linha (Ex: "Linha 02")
            $stops = Stop::where('linha', trim($route->short_name))->get();

            if ($stops->isEmpty()) {
                return redirect()->back()->with('error', "Nenhuma parada encontrada para '{$route->short_name}'");
            }

            // 3. Atualizar cada parada individualmente para forçar o banco a aceitar
            foreach ($stops as $stop) {
                $stop->vehicle_id = $vehicle->id;
                $stop->route_id = $route->id;
                $stop->save();
            }

            DB::commit();

            return redirect()->back()->with('success', "Sucesso! " . $stops->count() . " paradas da {$route->short_name} vinculadas ao veículo {$vehicle->plate}.");
        } catch (\Exception $e) {
            DB::rollBack();
            // O getMessage() vai nos dizer se a coluna 'vehicle_id' ou 'route_id' realmente não existe
            return redirect()->back()->with('error', "Erro ao gravar no banco: " . $e->getMessage());
        }
    }

    /**
     * Limpar cache laravel.
     *
     * @return \Illuminate\Http\Response
     */
    public function clear_cache()
    {
        try {
            // 1. Limpa caches de aplicação, views e caches antigos
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');

            // 2. Otimiza: Limpa e gera novos caches de Configuração e Rotas em um só comando
            // Isso é equivalente a config:cache e route:cache juntos
            Artisan::call('optimize');

            Log::info('Sistema: Cache limpo e otimização gerada com sucesso.');

            return redirect()->back()->with('status', 'Sistema limpo e otimizado!');
        } catch (Exception $e) {
            Log::error('Falha ao otimizar sistema: ' . $e->getMessage());

            return redirect()->back()->withErrors('Erro ao processar a limpeza: ' . $e->getMessage());
        }
    }
    /**
     * Gerar Controller, Models e Migrate.
     *
     * @return \Illuminate\Http\Response
     */
    public function mcrsf(Request $request)
    {
        // 1. Sanitização e Formatação
        // Str::studly garante que "nome_do_projeto" vire "NomeDoProjeto", padrão do Laravel
        //$nome = Str::studly($request->nome);

        //if (empty($nome)) {
        //    return redirect()->back()->withErrors('O nome do modelo é obrigatório.');
        //}

        //try {
        //    // 2. Execução do comando
        //    // O uso de arrays no Artisan::call é mais seguro contra injeção de comandos
        //    $exitCode = Artisan::call('make:model', [
        //        'name' => $nome,
        //        '-m' => true, // Migration
        //        '-c' => true, // Controller
        //        '-r' => true, // Resource (Controller)
        //        '-s' => true, // Seeder
        //        '-f' => true, // Factory
        //    ]);

        //    Log::info("Arquivos para o modelo {$nome} gerados com sucesso.");

        //    return redirect()->back()->with('success', "Modelo {$nome} e dependências criados!");
        //} catch (Exception $e) {
        //    Log::error("Erro ao gerar arquivos para {$nome}: " . $e->getMessage());

        //    return redirect()->back()->withErrors('Falha ao gerar arquivos. Verifique as permissões de pasta.');
        //}
    }
    /**
     * Carregar Banco de dados
     *
     * @return \Illuminate\Http\Response
     */
    public function db()
    {
        //try {
        //    // 1. Bloqueio de Segurança: Nunca rodar isso em produção acidentalmente
        //    if (App::environment('production')) {
        //        return redirect()->back()->withErrors('Ação não permitida em ambiente de produção!');
        //    }
        //
        //    // 2. migrate:fresh substitui o db:wipe + migrate
        //    // O parâmetro --seed já executa o DatabaseSeeder principal
        //    Artisan::call('migrate:fresh', ['--seed' => true]);
        //
        //    // 3. Seeder específico (se ele já não estiver dentro do DatabaseSeeder)
        //    Artisan::call('db:seed', ['--class' => 'CreateAdminUserSeeder']);
        //
        //    Log::info('Banco de dados resetado e semeado com sucesso.');
        //
        //    return redirect()->back()->with('success', 'Banco de dados reiniciado e Administrador criado!');
        //} catch (Exception $e) {
        //    Log::error('Falha ao resetar banco de dados: ' . $e->getMessage());
        //
        //    return redirect()->back()->withErrors('Erro ao processar banco de dados. Verifique os logs.');
        //}
    }
}
