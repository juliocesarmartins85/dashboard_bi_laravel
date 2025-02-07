<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SideBar;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $title;
    protected $title_can;
    protected $title_route;
    protected $title_permission;
    protected $title_breadcrumbs;
    protected $breadcrumbs;
    protected $table;
    protected $form;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Usuário';
        $this->title_permission = 'usuario';
        $this->title_route = 'users';
        $this->title_can = 'usuario';
        $this->title_breadcrumbs = 'Usuario';
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
        $this->breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Index ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
        $this->table = [
            'header' => [
                [
                    'title' => 'No',
                    'width' => '',
                ],
                [
                    'title' => 'Nome',
                    'width' => '',
                ],
                [
                    'title' => 'Email',
                    'width' => '',
                ],
                [
                    'title' => 'Ações',
                    'width' => '160',
                ],
            ],
            'body' => [
                [
                    'title' => 'name',
                ],
                [
                    'title' => 'email',
                ],
            ]
        ];
        $this->form = [
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
        $title = $this->title;
        $titlepage = ucfirst($this->title);
        $datapage = User::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = $this->table['header'];
        $body_table = $this->table['body'];
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
        $rolesuser = Role::pluck('name', 'name')->all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_create = $this->form;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
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

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $user;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = $this->form;
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
    public function edit(User $user): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $user;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = $this->form;
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

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso');
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
            ->with('success', 'Usuário excluído com sucesso');
    }
}
