<?php

namespace App\Http\Controllers;



use App\Models\Breadcrumbs;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SideBar;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

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
        $sidebaradmin = SideBar::all();
        $breadcrumbs = Breadcrumbs::all();

        return view('admin.home', compact(
            'sidebaradmin',
            'breadcrumbs'
        ));
    }


    /**
     * Limpar cache laravel.
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

            return back();
        } catch (\Exception $e) {
            return Log::info($e->getMessage());
        }
    }

    /**
     * Gerar Controller, Models e Migrate.
     */
    public function mcrsf(Request $request)
    {
        $nome = ucfirst($request->nome);
        try {
            $exitCode = Artisan::call("make:model $nome -mcrsf");
            Log::info('Arquivos gerados com sucesso');

            return back();
        } catch (\Exception $e) {
            return Log::info($e->getMessage());
        }
    }

    /**
     * Carregar Banco de dados
     */
    public function db()
    {
        try {
            $exitCode = Artisan::call('db:wipe');
            $exitCode = Artisan::call('migrate --seed');
            Log::info('Database gerados com sucesso');

            return back();
        } catch (\Exception $e) {
            return Log::info($e->getMessage());
        }
    }
}
