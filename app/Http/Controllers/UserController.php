<?php

namespace App\Http\Controllers;

use App\Helpers\WebHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SideBar;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $table_data;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Usuario';
        $this->title_permission = 'usuario';
        $this->title_route = 'users';
        $this->title_can = 'usuario';
        $this->title_breadcrumbs = 'Usuario';
        $this->breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Todos Registros ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
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
    public function index(Request $request): View
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.index" => ['data' => [],]];
        $datauser = User::whereNotIn('funcaosis', ['developer'])->get();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $header_table = [
            [
                'title' => 'Nome',
                'width' => '',
            ],
            [
                'title' => 'Email',
                'width' => '',
            ],
            [
                'title' => 'Acesso',
                'width' => '',
            ],
        ];
        $body_table = [
            [
                'title' => 'name',
            ],
            [
                'title' => 'email',
            ],
        ];
        return view('admin.page', compact(
            'datauser',
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
        $rolesuser = Role::where('name', '!=', 'developer')->pluck('name', 'name')->all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_create = [
            [
                'title' => 'Nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Nome Completo',
                'tag' => 'input',
            ],
            [
                'title' => 'email',
                'type' => 'text',
                'name' => 'email',
                'placeholder' => 'email',
                'tag' => 'input',
            ],
            [
                'title' => 'Senha',
                'type' => 'text',
                'name' => 'password',
                'placeholder' => 'password',
                'tag' => 'input',
            ],
            [
                'title' => 'Confirmar Senha',
                'type' => 'text',
                'name' => 'confirm-password',
                'placeholder' => 'confirm-password',
                'tag' => 'input',
            ],
        ];
        $sidebaradmin = SideBar::all();
        $breadcrumbs = [];
        $sections = ["crud.create" => ['data' => [],]];
        return view('admin.page', compact(
            'route',
            'rolesuser',
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $user->update(['funcaosis' => $request->roles[0]]);

        return redirect()->route('users.index')
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = User::find($id);
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = [
            [
                'title' => 'Nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Nome Completo',
                'tag' => 'input',
            ],
            [
                'title' => 'email',
                'type' => 'text',
                'name' => 'email',
                'placeholder' => 'email',
                'tag' => 'input',
            ],
        ];
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = User::find($id);
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = [
            [
                'title' => 'Nome Completo',
                'type' => 'text',
                'name' => 'name',
                'value' => 'name',
                'placeholder' => 'Nome Completo',
                'tag' => 'input',
            ],
            [
                'title' => 'email',
                'type' => 'text',
                'name' => 'email',
                'value' => 'email',
                'placeholder' => 'email',
                'tag' => 'input',
            ],
            [
                'title' => 'password',
                'type' => 'text',
                'name' => 'password',
                'value' => '',
                'placeholder' => 'password',
                'tag' => 'input',
            ],
            [
                'title' => 'confirm-password',
                'type' => 'text',
                'name' => 'confirm-password',
                'value' => 'confirm-password',
                'placeholder' => 'confirm-password',
                'tag' => 'input',
            ],
        ];
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.edit" => ['data' => [],]];
        $roles = Role::where('name', '!=', 'developer')->pluck('name', 'name')->all();
        $userRole = $datapage->roles->where('name', '!=', 'developer')->pluck('name', 'name')->all();
        return view('admin.page', compact(
            'datapage',
            'form_edit',
            'route',
            'can',
            'title',
            'titlepage',
            'sidebaradmin',
            'breadcrumbs',
            'sections',
            'roles',
            'userRole'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        $user->update(['funcaosis' => $request->roles[0]]);

        return redirect()->route('users.index')
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('warning', "Registro excluido com sucesso");
    }
    /**
     *
     */
    public function config_user()
    {
        $title = 'perfil';
        $titlepage = ucfirst($title);
        $breadcrumbs = [
            [
                'title' => "Home",
                'url' => route("home")
            ],
        ];
        WebHelper::logdata('1',  '1',  $titlepage,  User::find(Auth::user()->id)->name . " Acessou - {$titlepage}");
        return view('admin.page', [
            'sidebaradmin' => SideBar::all(),
            'breadcrumbs' => $breadcrumbs,
            'titlepage' => 'Usuário',
            'sections' => [
                'myProfile' => [
                    'col' => '12',
                    'data' => ['user' => User::find(Auth::user()->id)],
                ],
            ]
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request, $id)
    {
        $item = User::find(Auth::user()->id);
        $item->name = $request->fullName;
        $item->email = $request->email;
        $item->funcao = $request->job;
        $item->desc = $request->about;
        $item->endereco = $request->address;
        $item->facebook = $request->facebook;
        $item->twitter = $request->twitter;
        $item->instagram = $request->instagram;
        $item->linkedin = $request->linkedin;
        $item->organizacao = $request->company;
        $item->telefone = $request->phone;
        $item->save();
        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
