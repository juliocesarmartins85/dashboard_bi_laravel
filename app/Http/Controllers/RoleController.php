<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SideBar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    protected string $title;
    protected string $title_can;
    protected string $title_route;
    protected array $table_data;
    protected string $title_permission;
    protected string $title_breadcrumbs;
    protected array $breadcrumbs;
    protected array $inputs_forms;

    function __construct()
    {
        $this->title = 'Acesso';
        $this->title_permission = 'funcao';
        $this->title_route = 'roles';
        $this->title_can = 'funcao';
        $this->title_breadcrumbs = 'Acesso';
        $this->breadcrumbs = [
            [
                'title' => 'Home',
                'url' => '/home',
            ],
            [
                'title' => 'Todos registros ' . $this->title_breadcrumbs,
                'url' => "/{$this->title_route}",
            ]
        ];
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
        $this->inputs_forms = [
            [
                'title' => 'Nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'Nome',
                'tag' => 'input',
                'col' => '6',
                'value' => 'name',
            ],
        ];
        $this->table_data = [
            [
                'title' => 'Nome',
                'value' => 'name',
                'width' => '',
            ],
        ];
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
     * IDs de permissão vindos do checkbox do form (roles[]/permission[]),
     * convertidos para int de verdade. O spatie/laravel-permission só trata
     * um item como ID (findById) quando é is_int(); como toda entrada de
     * request HTTP chega como string, sem esse cast o pacote tentava achar
     * uma permissão pelo NOME "9" e falhava.
     */
    private function permissionIds(Request $request): array
    {
        return array_map('intval', $request->input('permission', []));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => Role::where('name', '!=', 'developer')->get(),
            'breadcrumbs' => $this->breadcrumbs,
            'sections' => $this->section('crud.index'),
            'header_table' => $this->table_data,
            'body_table' => $this->table_data,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.page', $this->baseData([
            'breadcrumbs' => $this->breadcrumbsFor('Adicionar'),
            'form_create' => $this->inputs_forms,
            'sections' => $this->section('crud.create'),
            'permission' => Permission::get(),
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($this->permissionIds($request));

        return $this->redirectToIndex('success', "{$this->title} adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $role = Role::find($id);

        return view('admin.page', $this->baseData([
            'datapage' => $role,
            'breadcrumbs' => $this->breadcrumbsFor('Detalhes'),
            'form_show' => $this->inputs_forms,
            'sections' => $this->section('crud.show'),
            // ?-> preserva o comportamento original (coleção vazia, sem
            // exceção) quando $id não corresponde a nenhum role.
            'rolePermissions' => $role?->permissions ?? collect(),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
        $role = Role::find($id);

        return view('admin.page', $this->baseData([
            'datapage' => $role,
            'breadcrumbs' => $this->breadcrumbsFor('Editar'),
            'form_edit' => $this->inputs_forms,
            'sections' => $this->section('crud.edit'),
            'permission' => Permission::get(),
            'rolePermissions' => $role?->permissions->pluck('id', 'id')->all() ?? [],
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($this->permissionIds($request));

        return $this->redirectToIndex('success', "{$this->title} atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        Role::destroy($id);

        return $this->redirectToIndex('success', "{$this->title} excluido com sucesso");
    }
}
