@foreach ($data as $key => $item0)
    <div class="row">
        <!-- Top Selling -->
        <div class="col-12">
            <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                    <h5 class="card-title">Clientes Conectados <span>| Hoje</span></h5>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Nome Equipamento</th>
                                <th scope="col">CCQ</th>
                                <th scope="col">BitCount</th>
                                <th scope="col">RX Rate</th>
                                <th scope="col">TX Rate</th>
                                <th scope="col">Noise</th>
                                <th scope="col">Singal</th>
                                <th scope="col">IP</th>
                                <th scope="col">Frequência</th>
                                <th scope="col">Mac Address</th>
                                <th scope="col">Uptime</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item0->clients as $item1)
                                @php
                                    $dias = floor(intval($item1->uptime ?? 0) / 86400); // obtém o número inteiro de dias
                                    $segundos_restantes = intval($item1->uptime ?? 0) % 86400; // obtém o restante dos segundos que não foram convertidos em dias
                                    $horas = floor($segundos_restantes / 3600); // obtém o número inteiro de horas
                                    $minutos = floor(($segundos_restantes / 60) % 60); // obtém o número inteiro de minutos

                                    // formata a string de retorno com o número de dias, horas e minutos
                                    $uptime = sprintf('%d Dias %02d:%02d Horas', $dias, $horas, $minutos);
                                @endphp
                                <tr>
                                    <td>{{ $item1->hostname }}</td>
                                    <td>{{ $item1->ccq }}</td>
                                    <td>{{ $item1->rxbytecount }}</td>
                                    <td>{{ number_format(round($item1->rxrate / 1024 / 1024, 2), 2) . ' mbps' }}</td>
                                    <td>{{ number_format(round($item1->txrate / 1024 / 1024, 2), 2) . ' mbps' }}</td>
                                    <td>{{ $item1->noise }}</td>
                                    <td>{{ $item1->signal }}</td>
                                    <td>{{ $item1->ip_address[0] }}</td>
                                    <td>{{ $item1->phymode > 'a/n/ac' ? '5GHz' : ' 2.4GHz' }}</td>
                                    <td>{{ $item1->mac_address }}</td>
                                    <td>{{ $uptime }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Top Selling -->
    </div>
@endforeach
