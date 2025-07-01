@push('meta')
@endpush
<div class="col-lg-12">
    <div class="row">
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Total User <span>| Hoje</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalUser }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Sales Card -->
        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">User Online <span>| Hoje</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $totalAtivos }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Revenue Card -->
        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">CPU Load <span>| Agora</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cpu"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $resource->{'cpu-load'} ?? '' }} %</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Customers Card -->
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Conectados Hoje</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <table class="dataenquete table table-striped table-hover">
                    <thead>
                        <tr>
                            @foreach ($header_table as $hdr)
                                <th width="{{ $hdr['width'] }}px">{{ $hdr['title'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @isset($routerboardusers)
                            @foreach ($routerboardusers as $key => $dt)
                                <tr>
                                    @foreach ($body_table as $bdy)
                                        <td>{{ $dt->{$bdy['title']} }}</td>
                                    @endforeach
                                    <td>
                                        <form action="{{ route('routerboarduser.destroy', $dt->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id_rb" value="{{ $idRb }}">
                                            <input type="hidden" name="id_rb_user" value="{{ $dt->id_rb }}">
                                            @can("$can-deletar")
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="bi bi-trash-fill fs-3"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Equipamentos conectados</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <table class="dataenquete table table-striped table-hover">
                    <thead>
                        <tr>
                            @foreach ($header_table_ativos as $hdr)
                                <th width="{{ $hdr['width'] }}px">{{ $hdr['title'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @isset($routerboardusersativos)
                            @foreach ($routerboardusersativos as $key => $dt)
                                <tr>
                                    @foreach ($body_table_ativos as $bdy)
                                        <td>{{ $dt->{$bdy['title']} }}</td>
                                    @endforeach
                                    <td>
                                        <form action="{{ route('routerboarduserativo.destroy', $dt->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id_rb" value="{{ $idRb }}">
                                            <input type="hidden" name="id_rb_user" value="{{ $dt->id_rb }}">
                                            @can("$can-deletar")
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="bi bi-trash-fill fs-3"></i></button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Logs Mikrotik</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <table class="dataenquete table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Mensagem</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Intervalo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($log_rb ?? [] as $pb)
                            <tr>
                                <td>{{ $pb->message }}</td>
                                <td>{{ $pb->topics }}</td>
                                <td>{{ $pb->time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>DNS Acessados</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <table class="dataenquete table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">IP</th>
                            <th scope="col">Endereço DNS</th>
                            <th scope="col">Duração</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acesso_user ?? [] as $pb)
                            <tr>
                                <td>{{ $pb->data ?? '' }}</td>
                                <td>{{ $pb->name ?? '' }}</td>
                                <td>{{ $pb->ttl ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Liberar Acesso Usuário</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <table class="dataenquete table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-capitalize" scope="col">#</th>
                            <th class="text-capitalize" scope="col">Mac Address</th>
                            <th class="text-capitalize" scope="col">Nome</th>
                            <th class="text-capitalize" scope="col">Função</th>
                            <th class="text-capitalize" scope="col">Permissão</th>
                            <th class="text-capitalize" scope="col">Status</th>
                            <th class="text-capitalize" scope="col" width="200px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profileUsers as $htsp)
                            <tr>
                                <th scope="row">{{ $htsp->id }}</th>
                                <td>{{ $htsp->mac_address }}</td>
                                <td>{{ $htsp->name }}</td>
                                <td>{{ $htsp->funcao }}</td>
                                <td>{{ $htsp->funcaosis }}</td>
                                <td>{{ $htsp->status }}</td>
                                <td>
                                    <a href="{{ route('ipBindingAdd', ['id' => $htsp->id, 'idrb' => $idRb, 'cmd' => 'bypassed']) }}"
                                        type="button" class="btn btn-success"><i
                                            class="bi bi-check-circle-fill fs-2"></i></a>
                                    <a href="{{ route('ipBindingRemove', ['id' => $htsp->id, 'idrb' => $idRb]) }}"
                                        type="button" class="btn btn-danger"><i class="bi bi-trash3 fs-2"></i></a>
                                    <a href="{{ route('ipBindingAdd', ['id' => $htsp->id, 'idrb' => $idRb, 'cmd' => 'blocked']) }}"
                                        type="button" class="btn btn-danger"><i
                                            class="bi bi-x-circle-fill fs-2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4>Tráfego Mikrotik</h4>
        </div>
        <div class="card-body">
            <div class="my-3">
                <div id="realTimeChart" style="min-height: 400px;" class="echart"></div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
    <script>
        function kbpsToMbps(kbps) {
            return (kbps / 1024) / 1024;
        }

        var chartDom = document.getElementById('realTimeChart');
        var myChart = echarts.init(chartDom);
        var option;
        var data = [];
        let tx = [];
        let rx = [];
        let count = [];
        let counter = 0;

        option = {
            legend: {
                data: [
                    "Tx", "Rx",
                ]
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: count
            },
            yAxis: {
                axisLabel: {
                    formatter: function(value) {
                        // Arredondar o valor para 2 casas decimais
                        return value.toFixed(0); // Aqui você pode mudar o número de casas decimais
                    }
                },
                type: 'value'
            },
            series: [{
                name: 'tx',
                type: 'line',
                smooth: true,
                symbol: 'none',
                stack: 'a',
                areaStyle: {
                    normal: {}
                },
                data: data
            }, {
                name: 'rx',
                type: 'line',
                smooth: true,
                symbol: 'none',
                stack: 'a',
                areaStyle: {
                    normal: {}
                },
                data: data
            }]
        };
        myChart.showLoading();
        setInterval(function() {
            fetch({{ Js::from(url('api/traficorb/' . $idRb . '/' . $interfaceRb[0]->name)) }})
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Sem dados");
                    }
                    return response.json();
                })
                .then(data => {

                    myChart.hideLoading();

                    tx.push(kbpsToMbps(data[0].data[0]));
                    rx.push(kbpsToMbps(data[1].data[0]));

                    if (tx.length >= 30) {
                        tx.shift()
                    }

                    if (rx.length >= 30) {
                        rx.shift()
                    }
                    // Configuração do gráfico
                    counter += 1;
                    count.push(counter);
                    if (count.length >= 30) {
                        count.shift()
                    }
                    myChart.setOption({
                        xAxis: {
                            data: count
                        },
                        series: [{
                                name: "Tx",
                                data: tx
                            },
                            {
                                name: "Rx",
                                data: rx
                            }
                        ]
                    });
                });

        }, 1000);

        option && myChart.setOption(option);
    </script>
@endpush
