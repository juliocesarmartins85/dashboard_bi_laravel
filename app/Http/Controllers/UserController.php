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
    protected $form;

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
        $this->form = [
            [
                'title' => 'nome completo',
                'type' => 'text',
                'name' => 'name',
                'value' => 'name',
                'col' => '12',
                'placeholder' => 'nome completo',
                'tag' => 'input',
            ],
            [
                'title' => 'email',
                'type' => 'text',
                'name' => 'email',
                'value' => 'email',
                'col' => '6',
                'placeholder' => 'email',
                'tag' => 'input',
            ],
            [
                'title' => 'Senha',
                'type' => 'text',
                'name' => 'password',
                'value' => '',
                'col' => '3',
                'placeholder' => 'senha',
                'tag' => 'input',
            ],
            [
                'title' => 'Confirmar Senha',
                'type' => 'text',
                'name' => 'confirm-password',
                'value' => 'confirm-password',
                'col' => '3',
                'placeholder' => 'confirmar senha',
                'tag' => 'input',
            ],
        ];
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
    }

    /**
     * Dados comuns a toda página administrativa desta entidade
     * (title/route/can + sidebar), reaproveitados por todas as actions.
     */
    private function baseData(array $extra = []): array
    {
        return array_merge([
            'title' => $this->title,
            'titlepage' => $this->title,
            'route' => $this->title_route,
            'can' => $this->title_can,
            'sidebaradmin' => SideBar::all(),
        ], $extra);
    }

    /**
     * Acrescenta o breadcrumb da ação atual e retorna a lista acumulada
     * (mesmo comportamento de mutação de $this->breadcrumbs do original).
     */
    private function breadcrumbsFor(string $action): array
    {
        $this->breadcrumbs[] = [
            'title' => "{$action} {$this->title_breadcrumbs}",
            'url' => '#',
        ];

        return $this->breadcrumbs;
    }

    private function section(string $name, array $data = []): array
    {
        return [$name => ['data' => $data]];
    }

    private function redirectToIndex(string $status, string $message): RedirectResponse
    {
        return redirect()
            ->route("{$this->title_route}.index")
            ->with($status, $message);
    }

    /**
     * Roles disponíveis para atribuição, exceto 'developer' — usado tanto
     * em create() ('rolesuser') quanto em edit() ('roles').
     */
    private function assignableRoles(): array
    {
        return Role::where('name', '!=', 'developer')->pluck('name', 'name')->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        return view('admin.page', $this->baseData([
            'datauser' => User::whereNotIn('funcaosis', ['developer'])->get(),
            'breadcrumbs' => $this->breadcrumbs,
            'sections' => $this->section('crud.index'),
            'header_table' => [
                ['title' => 'Nome', 'width' => ''],
                ['title' => 'Email', 'width' => ''],
                ['title' => 'Acesso', 'width' => ''],
            ],
            'body_table' => [
                ['title' => 'name'],
                ['title' => 'email'],
            ],
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        // NOTA: breadcrumbsFor() é chamado pelo side-effect de acumular em
        // $this->breadcrumbs, mas — igual ao comportamento original — o
        // valor efetivamente enviado à view é [] mesmo assim. Ver aviso no
        // resumo da refatoração.
        $this->breadcrumbsFor('Adicionar');

        return view('admin.page', $this->baseData([
            'rolesuser' => $this->assignableRoles(),
            'breadcrumbs' => [],
            'form_create' => $this->form,
            'sections' => $this->section('crud.create'),
        ]));
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

        return $this->redirectToIndex('success', 'Registro adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => User::find($id),
            'breadcrumbs' => $this->breadcrumbsFor('Detalhes'),
            // Só nome/email — nunca senha/confirmar-senha aqui: essa página
            // é somente leitura e chegou a expor o HASH da senha na tela
            // quando usava $this->form (que inclui os campos de senha do
            // create/edit).
            'form_show' => array_filter($this->form, fn($frm) => !str_contains($frm['name'], 'password')),
            'sections' => $this->section('crud.show'),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $datapage = User::find($id);

        return view('admin.page', $this->baseData([
            'datapage' => $datapage,
            'breadcrumbs' => $this->breadcrumbsFor('Editar'),
            'form_edit' => $this->form,
            'sections' => $this->section('crud.edit'),
            'roles' => $this->assignableRoles(),
            'userRole' => $datapage->roles->where('name', '!=', 'developer')->pluck('name', 'name')->all(),
        ]));
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

        return $this->redirectToIndex('warning', 'Registro atualizado com sucesso.');
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

        return $this->redirectToIndex('warning', 'Registro excluido com sucesso');
    }

    /**
     * Página "Meu perfil" do usuário autenticado.
     */
    public function config_user(): View
    {
        $user = User::find(Auth::user()->id);
        $titlepage = ucfirst('perfil');

        WebHelper::logdata('1', '1', $titlepage, "{$user->name} Acessou - {$titlepage}");

        return view('admin.page', [
            'sidebaradmin' => SideBar::all(),
            'breadcrumbs' => [
                ['title' => 'Home', 'url' => route('home')],
            ],
            'titlepage' => 'Usuário',
            'sections' => [
                'myProfile' => [
                    'col' => '12',
                    'data' => ['user' => $user],
                ],
            ],
        ]);
    }

    /**
     * Atualiza o perfil do usuário autenticado.
     *
     * NOTA: preserva o comportamento original — o {id} da rota
     * (/update_user/{id}) não é usado; a atualização sempre é feita em
     * cima de Auth::user()->id. Ver aviso no resumo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request, $id): RedirectResponse
    {
        $item = User::find(Auth::user()->id);

        $item->fill([
            'name' => $request->fullName,
            'email' => $request->email,
            'funcao' => $request->job,
            'desc' => $request->about,
            'endereco' => $request->address,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'organizacao' => $request->company,
            'telefone' => $request->phone,
        ])->save();

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
