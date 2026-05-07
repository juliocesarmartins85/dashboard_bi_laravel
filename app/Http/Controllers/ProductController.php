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
            'placeholder' => 'Name',
            'tag' => 'input',
        ],
        [
            'title' => 'Detail',
            'type' => 'text',
            'name' => 'detail',
            'value' => 'detail',
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
        return array_map(function ($item) {
            return array_merge(['width' => ''], $item);
        }, $headers);
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
        return view('admin.page', $this->baseData([
            'breadcrumbs' => $this->breadcrumbs('Adicionar'),
            'form_create' => $this->formFields,
            'sections' => $this->section('crud.create'),
        ]));
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->validateData($request));

        return redirect()
            ->route("{$this->route}.index")
            ->with('success', 'Registro adicionado com sucesso.');
    }

    public function show(Product $product): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => $product,
            'breadcrumbs' => $this->breadcrumbs('Detalhes'),
            'form_show' => $this->formFields,
            'sections' => $this->section('crud.show'),
        ]));
    }

    public function edit(Product $product): View
    {
        return view('admin.page', $this->baseData([
            'datapage' => $product,
            'breadcrumbs' => $this->breadcrumbs('Editar'),
            'form_edit' => $this->formFields,
            'sections' => $this->section('crud.edit'),
        ]));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validateData($request));

        return redirect()
            ->route("{$this->route}.index")
            ->with('warning', 'Registro atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route("{$this->route}.index")
            ->with('error', 'Registro excluído com sucesso.');
    }
}
