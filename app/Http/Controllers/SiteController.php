<?php

namespace App\Http\Controllers;

use App\Models\SideBar;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SiteController extends Controller
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
        $this->title = 'Site';
        $this->title_permission = 'sites';
        $this->title_route = 'sites';
        $this->title_can = 'sites';
        $this->title_breadcrumbs = 'Site';
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
            $this->textField('Nome', 'name', 'Name'),
            $this->textField('Url', 'url'),
            $this->textField('Descrição', 'description'),
            $this->fileField('Favicon', 'favicon'),
            $this->fileField('Logo', 'logo', 'Video'),
            $this->textField('Telegram Bot', 'telegram_bot'),
            $this->textField('Telegram Grupo', 'telegram_group'),
        ];
    }

    /**
     * Campo de texto padrão do form desta entidade (input, meia largura).
     * $placeholder é opcional porque um dos campos ('Nome') usa um
     * placeholder diferente do título no original.
     */
    private function textField(string $label, string $name, ?string $placeholder = null): array
    {
        return [
            'title' => $label,
            'type' => 'text',
            'name' => $name,
            'placeholder' => $placeholder ?? $label,
            'tag' => 'input',
            'value' => $name,
            'col' => '6',
        ];
    }

    /**
     * Campo de upload de arquivo (favicon/logo), mesmo formato do
     * textField() mas com tag 'arquivo'.
     */
    private function fileField(string $label, string $name, ?string $placeholder = null): array
    {
        return array_merge($this->textField($label, $name, $placeholder), ['tag' => 'arquivo']);
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
     * Faz o upload de um arquivo enviado no request, movendo para
     * public/{$folder}. Mantém o valor atual quando nada for enviado —
     * mesma lógica usada para favicon e logo no update().
     */
    private function uploadedFileOrKeep(Request $request, string $field, string $folder, ?string $current): ?string
    {
        if (empty($request->{$field})) {
            return $current;
        }

        $fileName = time() . '.' . $request->{$field}->extension();
        $request->{$field}->move(public_path($folder), $fileName);

        return "{$folder}/{$fileName}";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => Site::all(),
            'breadcrumbs' => $this->breadcrumbs,
            'sections' => $this->section('crud.index'),
            'header_table' => [
                ['title' => 'Nome', 'width' => ''],
            ],
            'body_table' => [
                ['title' => 'Titulo', 'value' => 'name', 'width' => ''],
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
            'url' => 'required',
            'description' => 'required',
            'telegram_bot' => 'required',
            'telegram_group' => 'required',
        ]);

        Site::create($request->all());

        return $this->redirectToIndex('success', 'Registro adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\View\View
     */
    public function show(Site $site): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => $site,
            'breadcrumbs' => $this->breadcrumbsFor('Detalhes'),
            'form_show' => $this->inputs_forms,
            'sections' => $this->section('crud.show'),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\View\View
     */
    public function edit(Site $site): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => $site,
            'breadcrumbs' => $this->breadcrumbsFor('Editar'),
            'form_edit' => $this->inputs_forms,
            'sections' => $this->section('crud.edit'),
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Site $site): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',
            'telegram_bot' => 'required',
            'telegram_group' => 'required',
        ]);

        $site->update([
            'name' => $request->name,
            'url' => $request->url,
            'description' => $request->description,
            'favicon' => $this->uploadedFileOrKeep($request, 'favicon', 'favicons', $request->favicon_old),
            'logo' => $this->uploadedFileOrKeep($request, 'logo', 'logos', $request->logo_old),
            'telegram_bot' => $request->telegram_bot,
            'telegram_group' => $request->telegram_group,
        ]);

        return $this->redirectToIndex('warning', 'Registro atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Site $site): RedirectResponse
    {
        $site->delete();

        return $this->redirectToIndex('warning', 'Registro excluido com sucesso');
    }
}
