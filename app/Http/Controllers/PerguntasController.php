<?php

namespace App\Http\Controllers;

use App\Models\Enquete;
use App\Models\Perguntas;
use App\Models\SideBar;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PerguntasController extends Controller
{
    protected $title;
    protected $title_can;
    protected $table_data;
    protected $title_route;
    protected $inputs_forms;
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
        $this->title = 'Pergunta';
        $this->title_permission = 'perguntas';
        $this->title_route = 'perguntas';
        $this->title_can = 'perguntas';
        $this->title_breadcrumbs = 'Pergunta';
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
                'title' => 'titulo',
                'type' => 'text',
                'name' => 'question',
                'placeholder' => 'titulo da pergunta',
                'tag' => 'input',
                'value' => 'question',
            ],
            [
                'title' => 'tipo',
                'type' => 'radio',
                'name' => 'type',
                'options' => [
                    [
                        'title' => 'texto',
                        'type' => 'text',
                    ],
                    [
                        'title' => 'opção única',
                        'type' => 'radio',
                    ],
                    [
                        'title' => 'várias opções',
                        'type' => 'checkbox',
                    ],
                ],
                'placeholder' => 'titulo da pergunta',
                'tag' => 'radio',
                'value' => 'type',
            ],
            [
                'title' => 'opções',
                'type' => 'text',
                'name' => 'options',
                'placeholder' => 'Separe as opções por " / "',
                'tag' => 'input',
                'value' => 'options',
            ],
            [
                'title' => 'status',
                'type' => 'radio',
                'name' => 'status',
                'options' => [
                    [
                        'title' => 'habilitada',
                        'type' => '1',
                    ],
                    [
                        'title' => 'desabilitada',
                        'type' => '0',
                    ],
                ],
                'placeholder' => 'titulo da pergunta',
                'tag' => 'radio',
                'value' => 'status',
            ],

            [
                'title' => 'data Inicial',
                'type' => 'text',
                'name' => 'dtinicio',
                'placeholder' => 'data Inicial',
                'tag' => 'date',
                'value' => 'dtinicio',
            ],
            [
                'title' => 'data final',
                'type' => 'text',
                'name' => 'dtfinal',
                'placeholder' => 'data final',
                'tag' => 'date',
                'value' => 'dtfinal',
            ],
            [
                'title' => 'sequência',
                'type' => 'text',
                'name' => 'nivel',
                'placeholder' => 'sequência',
                'tag' => 'input',
                'value' => 'nivel',
            ],
        ];
        $this->table_data = [
            [
                'title' => 'Pergunta',
                'value' => 'question',
                'width' => '',
            ],
            [
                'title' => 'Tipo',
                'value' => 'type',
                'width' => '',
            ],
            [
                'title' => 'Opção',
                'value' => 'options',
                'width' => '',
            ],
            [
                'title' => 'Status',
                'value' => 'status',
                'width' => '',
                'status' => true,
            ],
            [
                'title' => 'Data Inicio',
                'value' => 'dtinicio',
                'width' => '',
            ],
            [
                'title' => 'Data Final',
                'value' => 'dtfinal',
                'width' => '',
            ],
            /*             [
                'title' => 'interval',
                'value' => 'interval',
                'width' => '',
            ], */
            [
                'title' => 'Prioridade',
                'value' => 'nivel',
                'width' => '',
            ],
        ];
        try {
            if (!empty(Enquete::all()->count())) {
                foreach (Enquete::all() as $key_enqt => $enqt) {
                    $dataInicial = new DateTime($enqt->dtinicio);
                    $dataFinal = new DateTime($enqt->dtfinal);
                    //$dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtinicio)->format("Y-m-d H:i"));
                    //$dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtfinal)->format("Y-m-d H:i"));
                    $dataAtual = new DateTime();

                    if ($dataAtual < $dataInicial) {
                        //echo "O intervalo ainda não começou.";
                        Enquete::where('id', $enqt->id)->update(['status' => '0']);
                    } elseif ($dataAtual > $dataFinal) {
                        //echo "O intervalo expirou.";
                        Enquete::where('id', $enqt->id)->update(['status' => '0']);
                    } else {
                        //echo "O intervalo está em andamento.";
                        Enquete::where('id', $enqt->id)->update(['status' => '1']);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        try {
            if (!empty(Enquete::all()->count())) {
                foreach (Perguntas::all() as $key_prgt => $prgt) {
                    $dataInicial = new DateTime($enqt->dtinicio);
                    $dataFinal = new DateTime($enqt->dtfinal);
                    //$dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtinicio)->format("Y-m-d H:i"));
                    //$dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtfinal)->format("Y-m-d H:i"));
                    $dataAtual = new DateTime();

                    if ($dataAtual < $dataInicial) {
                        //echo "O intervalo ainda não começou.";
                        Perguntas::where('id', $prgt->id)->update(['status' => '0']);
                    } elseif ($dataAtual > $dataFinal) {
                        //echo "O intervalo expirou.";
                        Perguntas::where('id', $prgt->id)->update(['status' => '0']);
                    } else {
                        //echo "O intervalo está em andamento.";
                        Perguntas::where('id', $prgt->id)->update(['status' => '1']);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.index" => ['data' => [],]];
        $title = $this->title;
        $titlepage = $this->title;
        $datapage = Perguntas::all();
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $header_table = $this->table_data;
        $body_table = $this->table_data;
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
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_create = $this->inputs_forms;
        $sidebaradmin = SideBar::all();
        $breadcrumbs = $this->breadcrumbs;
        $sections = ["crud.create" => ['data' => [],]];
        return view('admin.page', compact(
            'route',
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
    public function store(Request $request, Perguntas $pergunta): RedirectResponse
    {
        /*         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Perguntas::create($request->all()); */
        //dd($request->all());
        request()->validate([
            'question' => 'required',
            'type' => 'required',
            'status' => 'required',
            'dtinicio' => 'required',
            'dtfinal' => 'required',
            //'interval' => 'required',
            'nivel' => 'required',
        ]);

        $pergunta->question = $request->question;
        $pergunta->type = $request->type;
        $pergunta->options = $request->options;
        $pergunta->status = $request->status;
        $pergunta->dtinicio = Carbon::parse($request->dtinicio[0] . ' ' . $request->dtinicio[1])->format('Y-m-d H:i');
        $pergunta->dtfinal = Carbon::parse($request->dtfinal[0] . ' ' . $request->dtfinal[1])->format('Y-m-d H:i');
        //$pergunta->interval = Carbon::parse($request->interval[0] . ' ' . $request->interval[1])->format('Y-m-d H:i');
        $pergunta->nivel = $request->nivel;

        $pergunta->save();

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perguntas  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function show(Perguntas $pergunta): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $pergunta;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_show = $this->inputs_forms;
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
     * @param  \App\Perguntas  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function edit(Perguntas $pergunta): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $pergunta;
        $route = $this->title_route;
        $can = $this->title_can;
        $title = $this->title;
        $titlepage = $this->title;
        $form_edit = $this->inputs_forms;
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
     * @param  \App\Perguntas  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perguntas $pergunta): RedirectResponse
    {
        request()->validate([
            'question' => 'required',
            'type' => 'required',
            //'options' => 'required',
            'status' => 'required',
            //'interval' => 'required',
            'dtinicio' => 'required',
            'dtfinal' => 'required',
        ]);

        $resposta = [
            'question' => $request->question,
            'type' => $request->type,
            'options' => $request->options ?? '',
            'status' => $request->status,
            'dtinicio' => Carbon::parse($request->dtinicio[0] . ' ' . $request->dtinicio[1])->format('Y-m-d H:i'),
            'dtfinal' => Carbon::parse($request->dtfinal[0] . ' ' . $request->dtfinal[1])->format('Y-m-d H:i'),
            //'interval' => Carbon::parse($request->interval[0] . ' ' . $request->interval[1])->format('Y-m-d H:i'),
            'nivel' => $request->nivel
        ];

        $pergunta->update($resposta);

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perguntas  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perguntas $pergunta): RedirectResponse
    {
        $pergunta->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
