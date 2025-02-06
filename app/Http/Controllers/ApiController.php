<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use App\Models\Api;
use App\Models\Respostas;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Bairro;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BoxFiber;
use App\Models\Breadcrumbs;
use App\Models\CheckListCam;
use App\Models\CheckListSatlight;
use App\Models\ClientFiber;
use App\Models\ContatoAppTecnico;
use App\Models\DiretivaPrivacidade;
use App\Models\Doc;
use App\Models\Endereco;
use App\Models\Enquete;
use App\Models\Features;
use App\Models\Gallery;
use App\Models\Hero;
use App\Models\Hotspot;
use App\Models\ListaApTv;
use App\Models\LogAppTecnicos;
use App\Models\Menu;
use App\Models\Perguntas;
use App\Models\PoliticaCookie;
use App\Models\ProfileUser;
use App\Models\RouterBoard;
use App\Models\SideBar;
use App\Models\Site;
use App\Models\TorreNetlight;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RouterOS\Client;
use RouterOS\Query;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    protected $cliente;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        try {
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
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
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
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

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
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
     * Create
     * @param Request $request
     * @return
     */
    public function log_app(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'type' => 'required',
                    'titulo' => 'required',
                    'body' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = LogAppTecnicos::create([
                'type' => $request->type,
                'titulo' => $request->titulo,
                'body' => $request->body
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Log Created Successfully',
                'status' => 200,
                //'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function clienteFiberCreate(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'box' => 'required',
                    'address' => 'required',
                    'location' => 'required',
                    'tvNaFibra' => 'required',
                    'client' => 'required',
                    'connection' => 'required',
                    'interface' => 'required',
                    'manager_ip' => 'required',
                    'meters' => 'required',
                    'olt' => 'required',
                    'onu_serial' => 'required',
                    'port' => 'required',
                    'signal' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //$user = ClientFiber::create([
            //    //'name' => $request->name,
            //    //'email' => $request->email,
            //    //'password' => Hash::make($request->password),
            //    'name' => $request->name,
            //    'box' => $request->box,
            //    'address' => $request->address,
            //    'location' => $request->location,
            //    'tvNaFibra' => $request->tvNaFibra,
            //    'client' => $request->client,
            //    'connection' => $request->connection,
            //    'interface' => $request->interface,
            //    'manager_ip' => $request->manager_ip,
            //    'meters' => $request->meters,
            //    'olt' => $request->olt,
            //    'onu_serial' => $request->onu_serial,
            //    'port' => $request->port,
            //    'signal' => $request->signal,
            //]);

            ClientFiber::insert($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Client Created Successfully',
                //'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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

    /**
     * Display a listing of the resource.
     */
    public function clienteFiber(Request $request)
    {
        try {
            return response()->json(ClientFiber::all(), 200);
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
    public function boxsFiber(Request $request)
    {
        try {
            return response()->json(BoxFiber::all(), 200);
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
    public function torresNetlight(Request $request)
    {
        try {
            return response()->json(TorreNetlight::all(), 200);
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
    public function bairrosNetlight(Request $request)
    {
        try {
            return response()->json(Bairro::all(), 200);
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
    public function contatos_app(Request $request)
    {
        try {
            return response()->json(ContatoAppTecnico::all(), 200);
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
    public function checklist_satlight(Request $request)
    {
        try {
            return response()->json(CheckListSatlight::all(), 200);
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
    public function checklist_cam(Request $request)
    {
        try {
            return response()->json(CheckListCam::all(), 200);
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
    public function list_ap_tv(Request $request)
    {
        try {
            return response()->json(ListaApTv::all(), 200);
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
    public function data_banner(Request $request)
    {
        try {
            return response()->json(Banner::all(), 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
