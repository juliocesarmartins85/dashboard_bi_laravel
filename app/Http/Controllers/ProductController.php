<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SideBar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    private string $title = 'Produto';
    private string $route = 'products';
    private string $permission = 'product';
    private string $can = 'product';

    private array $formFields = [
        [
            'title' => 'Name',
            'type' => 'text',
            'name' => 'name',
            'value' => 'name',
            'col' => '6',
            'placeholder' => 'Name',
            'tag' => 'input',
        ],
        [
            'title' => 'Detail',
            'type' => 'text',
            'name' => 'detail',
            'value' => 'detail',
            'col' => '6',
            'placeholder' => 'Detail',
            'tag' => 'textarea',
        ],
    ];

    public function __construct()
    {
        $this->middleware("permission:{$this->permission}-listar|{$this->permission}-criar|{$this->permission}-editar|{$this->permission}-deletar")
            ->only(['index', 'show']);

        $this->middleware("permission:{$this->permission}-criar")->only(['create', 'store']);
        $this->middleware("permission:{$this->permission}-editar")->only(['edit', 'update']);
        $this->middleware("permission:{$this->permission}-deletar")->only(['destroy']);
    }

    private function baseData(array $extra = []): array
    {
        return array_merge([
            'title' => $this->title,
            'titlepage' => $this->title,
            'route' => $this->route,
            'can' => $this->can,
            'sidebaradmin' => SideBar::all(),
        ], $extra);
    }

    private function breadcrumbs(?string $action = null): array
    {
        $breadcrumbs = [
            ['title' => 'Home', 'url' => '/home'],
            ['title' => "Index {$this->title}", 'url' => route("{$this->route}.index")],
        ];

        if ($action) {
            $breadcrumbs[] = [
                'title' => "{$action} {$this->title}",
                'url' => '#',
            ];
        }

        return $breadcrumbs;
    }

    private function section(string $name, array $data = []): array
    {
        return [
            $name => [
                'data' => $data
            ]
        ];
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string',
            'detail' => 'required|string',
        ]);
    }

    private function normalizeHeaders(array $headers): array
    {
        return array_map(fn(array $item) => array_merge(['width' => ''], $item), $headers);
    }

    /**
     * Monta a view de create/show/edit, que só variam pela ação do
     * breadcrumb, pela section do CRUD, pela chave do form e (opcionalmente)
     * pelo registro sendo exibido/editado.
     */
    private function formView(string $action, string $sectionKey, string $formKey, ?Product $product = null): View
    {
        return view('admin.page', $this->baseData(array_filter([
            'datapage' => $product,
            'breadcrumbs' => $this->breadcrumbs($action),
            $formKey => $this->formFields,
            'sections' => $this->section($sectionKey),
        ])));
    }

    /**
     * Redireciona para o index com a mensagem flash de status, usada por
     * store/update/destroy.
     */
    private function redirectToIndex(string $status, string $message): RedirectResponse
    {
        return redirect()
            ->route("{$this->route}.index")
            ->with($status, $message);
    }

    public function index(): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => Product::all(),
            'breadcrumbs' => $this->breadcrumbs(),
            'sections' => $this->section('crud.index'),
            'header_table' => $this->normalizeHeaders([
                ['title' => 'Name'],
                ['title' => 'Details'],
            ]),
            'body_table' => [
                ['value' => 'name'],
                ['value' => 'detail'],
            ],
        ]));
    }

    public function create(): View
    {
        return $this->formView('Adicionar', 'crud.create', 'form_create');
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->validateData($request));

        return $this->redirectToIndex('success', 'Registro adicionado com sucesso.');
    }

    public function show(Product $product): View
    {
        return $this->formView('Detalhes', 'crud.show', 'form_show', $product);
    }

    public function edit(Product $product): View
    {
        return $this->formView('Editar', 'crud.edit', 'form_edit', $product);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validateData($request));

        return $this->redirectToIndex('warning', 'Registro atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return $this->redirectToIndex('error', 'Registro excluído com sucesso.');
    }
}
