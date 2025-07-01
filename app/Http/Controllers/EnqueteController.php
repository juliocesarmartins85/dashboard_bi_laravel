<?php

namespace App\Http\Controllers;

use App\Models\Enquete;
use App\Models\Log;
use App\Models\Perguntas;
use App\Models\RouterBoard;
use App\Models\SideBar;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnqueteController extends Controller
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
     * Display a listing of the resource.s
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->title = 'Enquete';
        $this->title_permission = 'enquete';
        $this->title_route = 'enquetes';
        $this->title_can = 'enquete';
        $this->title_breadcrumbs = 'Enquete';
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
        $this->inputs_forms = [
            [
                'title' => 'nome',
                'type' => 'text',
                'name' => 'name',
                'placeholder' => 'name',
                'tag' => 'input',
                'value' => 'name',
            ],
            [
                'title' => 'status',
                'type' => 'text',
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
                'placeholder' => 'status',
                'tag' => 'select',
                'value' => 'status',
                'status' => true,
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
                'title' => 'Questões',
                'type' => 'text',
                'name' => 'questions',
                'options' => Perguntas::where('status', '1')->get(),
                'placeholder' => 'questions',
                'tag' => 'multipleselect',
                'value' => 'questions',
                'id' => true,
            ],
            [
                'title' => 'Routers',
                'type' => 'text',
                'name' => 'routers',
                'options' => RouterBoard::all(),
                'placeholder' => 'routers',
                'tag' => 'multipleselect',
                'value' => 'routers',
                'id' => true,
            ],
            [
                'title' => 'Video',
                'type' => 'text',
                'name' => 'video',
                'placeholder' => 'Video',
                'tag' => 'arquivo',
                'value' => '',
            ],
            [
                'title' => 'nivel',
                'type' => 'text',
                'name' => 'nivel',
                'placeholder' => 'nivel',
                'tag' => 'input',
                'value' => 'nivel',
            ],
        ];
        $this->table_data = [
            [
                'title' => 'Titulo',
                'value' => 'name',
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
            [
                'title' => 'Id Perguntas',
                'value' => 'questions',
                'width' => '',
            ],
            [
                'title' => 'Nivel',
                'value' => 'nivel',
                'width' => '',
            ],
        ];
        try {
            foreach (Enquete::all() as $key_enqt => $enqt) {
                $dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtinicio)->format("Y-m-d H:i"));
                $dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $enqt->dtfinal)->format("Y-m-d H:i"));
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
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        try {
            foreach (Perguntas::all() as $key_prgt => $prgt) {
                $dataInicial = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtinicio)->format("Y-m-d H:i"));
                $dataFinal = new DateTime(DateTime::createFromFormat('Y-m-d H:i', $prgt->dtfinal)->format("Y-m-d H:i"));
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
        $datapage = Enquete::all();
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
        $titlepage = $this->title;
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
    public function store(Request $request, Enquete $enquete): RedirectResponse
    {

        request()->validate([
            'name' => 'required',
            'status' => 'required',
            'dtinicio' => 'required',
            'dtfinal' => 'required',
            'questions' => 'required',
            'routers' => 'required',
            'nivel' => 'required',
            //'file' => 'required|mimes:mp4|max:20048',
        ]);

        if ($request->status) {
            foreach (Enquete::all() as $key => $value) {
                echo $value->id;
                Enquete::where('id', $value->id)->update(['status' => false]);
            }
        }

        //dd(empty($request->file));
        if (!empty($request->file)) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('videos_enquete'), $fileName);
        }


        $enquete->name = $request->name;
        $enquete->status = $request->status;
        $enquete->dtinicio = Carbon::parse($request->dtinicio[0] . ' ' . $request->dtinicio[1])->format('Y-m-d H:i');
        $enquete->dtfinal = Carbon::parse($request->dtfinal[0] . ' ' . $request->dtfinal[1])->format('Y-m-d H:i');
        $enquete->questions = json_encode($request->questions);
        $enquete->routers = json_encode($request->routers);
        $enquete->video = $fileName ?? '';
        $enquete->nivel = $request->nivel;
        $enquete->nivel = $request->nivel;

        $enquete->save();

        return redirect()->route("$this->title_route.index")
            ->with('success', "Registro adicionado com sucesso.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enquete  $enquete
     * @return \Illuminate\Http\Response
     */
    public function show(Enquete $enquete): View
    {
        $this->breadcrumbs[] = [
            'title' => 'Detalhes ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $enquete;
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
     * @param  \App\Enquete  $enquete
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquete $enquete): View
    {
        $this->breadcrumbs[] =             [
            'title' => 'Editar ' . $this->title_breadcrumbs,
            'url' => '#',
        ];
        $datapage = $enquete;
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
     * @param  \App\Enquete  $enquete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enquete $enquete): RedirectResponse
    {

        request()->validate([
            'name' => 'required',
            'status' => 'required',
            'dtinicio' => 'required',
            'dtfinal' => 'required',
            'questions' => 'required',
            'routers' => 'required',
            'nivel' => 'required',
        ]);

        //dd(empty($request->file));
        if (!empty($request->file)) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('videos_enquete'), $fileName);
        }

        if ($request->status) {
            foreach (Enquete::all() as $key => $value) {
                echo $value->id;
                Enquete::where('id', $value->id)->update(['status' => false]);
            }
        }

        $resposta = [
            'name' => $request->name,
            'status' => $request->status,
            'dtinicio' => Carbon::parse($request->dtinicio[0] . ' ' . $request->dtinicio[1])->format('Y-m-d H:i'),
            'dtfinal' => Carbon::parse($request->dtfinal[0] . ' ' . $request->dtfinal[1])->format('Y-m-d H:i'),
            //'interval' => Carbon::parse($request->interval[0] . ' ' . $request->interval[1])->format('Y-m-d H:i'),
            'questions' => json_encode($request->questions),
            'routers' => json_encode($request->routers),
            'video' => $fileName ?? '',
            'nivel' => $request->nivel
        ];
        //dd($resposta);

        $enquete->update($resposta);

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enquete  $enquete
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquete $enquete): RedirectResponse
    {
        $enquete->delete();

        return redirect()->route("$this->title_route.index")
            ->with('warning', "Registro excluido com sucesso");
    }
}
