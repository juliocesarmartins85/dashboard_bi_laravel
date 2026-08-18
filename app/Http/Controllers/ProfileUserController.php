<?php

namespace App\Http\Controllers;

use App\Models\ProfileUser;
use App\Models\SideBar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileUserController extends Controller
{
    protected string $title;
    protected string $title_can;
    protected string $title_route;
    protected array $inputs_forms;
    protected string $title_permission;
    protected string $title_breadcrumbs;
    protected array $breadcrumbs;

    function __construct()
    {
        $this->title = 'Usuário';
        $this->title_permission = 'profileusers';
        $this->title_route = 'profileusers';
        $this->title_can = 'profileusers';
        $this->title_breadcrumbs = 'Usuário';
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
        $this->middleware("permission:$this->title_permission-listar|$this->title_permission-criar|$this->title_permission-editar|$this->title_permission-deletar", ['only' => ['index', 'show']]);
        $this->middleware("permission:$this->title_permission-criar", ['only' => ['create', 'store']]);
        $this->middleware("permission:$this->title_permission-editar", ['only' => ['edit', 'update']]);
        $this->middleware("permission:$this->title_permission-deletar", ['only' => ['destroy']]);
        $this->inputs_forms = [
            $this->textField('Nome', 'name', '9'),
            $this->textField('Telefone', 'telefone', '3'),
            $this->textField('Bairro', 'bairro', '4'),
            $this->textField('Cidade', 'cidade', '4'),
            $this->textField('Mac address', 'mac_address', '4'),
        ];
    }

    /**
     * Campo de texto padrão do form desta entidade: todos os 5 campos
     * seguem o mesmo formato (input de texto, meia largura, placeholder
     * igual ao título), só variando label/nome do atributo.
     */
    private function textField(string $label, string $name, string $col): array
    {
        return [
            'title' => $label,
            'type' => 'text',
            'name' => $name,
            'placeholder' => $label,
            'tag' => 'input',
            'value' => $name,
            'col' => $col,
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => ProfileUser::all(),
            'breadcrumbs' => $this->breadcrumbs,
            'sections' => $this->section('crud.index'),
            'header_table' => [
                ['title' => 'Mac Address', 'width' => ''],
                ['title' => 'Nome', 'width' => ''],
                ['title' => 'Telefone', 'width' => ''],
                ['title' => 'Bairro', 'width' => ''],
                ['title' => 'Cidade', 'width' => ''],
            ],
            'body_table' => [
                ['title' => 'mac_address', 'value' => 'mac_address', 'width' => ''],
                ['title' => 'name', 'value' => 'name', 'width' => ''],
                ['title' => 'telefone', 'value' => 'telefone', 'width' => ''],
                ['title' => 'bairro', 'value' => 'bairro', 'width' => ''],
                ['title' => 'cidade', 'value' => 'cidade', 'width' => ''],
            ],
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
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        ProfileUser::create($request->all());

        return $this->redirectToIndex('success', 'Registro adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\View\View
     */
    public function show(ProfileUser $profileuser): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => $profileuser,
            'breadcrumbs' => $this->breadcrumbsFor('Detalhes'),
            'form_show' => $this->inputs_forms,
            'sections' => $this->section('crud.show'),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\View\View
     */
    public function edit(ProfileUser $profileuser): View
    {
        // NOTA: o breadcrumb é intencionalmente mantido como [] aqui, igual
        // ao comportamento original — breadcrumbsFor() é chamado (mutando
        // $this->breadcrumbs, mesmo side-effect de antes), mas o valor
        // efetivamente enviado à view continua vazio. Ver aviso no resumo.
        $this->breadcrumbsFor('Editar');

        return view('admin.page', $this->baseData([
            'datapage' => $profileuser,
            'breadcrumbs' => [],
            'form_edit' => $this->inputs_forms,
            'sections' => $this->section('crud.edit'),
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProfileUser $profileuser): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $profileuser->update($request->all());

        return $this->redirectToIndex('warning', 'Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfileUser  $profileuser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProfileUser $profileuser): RedirectResponse
    {
        $profileuser->delete();

        return $this->redirectToIndex('warning', 'Registro excluido com sucesso');
    }
}
