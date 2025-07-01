<section class="section">
    <div class="row align-items-top">
        <div class="col-lg-12">
            <!-- Card with header and footer -->
            <div class="card">
                <div class="card-header">Detalhes</div>
                <div class="card-body">
                    <h5 class="card-title">Informações do Hotspot</h5>

                    <!-- List group with custom content -->
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Nome do Hotspot</div>
                                {!! $data->wan->ipv4->hostname !!}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Endereço IPV4</div>
                                {!! $data->lan->ipv4->ip_address !!}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Gateway</div>
                                {!! $data->lan->ipv4->gateway !!}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Uptime</div>
                                {!! $data->device->uptime !!} min
                            </div>
                        </li>
                        @foreach ($data->wireless->radios as $v)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Rede Wifi: {{ $v->id }}</div>
                                    <p>Canal: {!! $v->channel !!}</p>
                                    <p>Banda: {!! $v->bandwidth !!}</p>
                                    <p>Potência: {!! $v->txpower !!}</p>
                                    <p>Usuário Conectados: {!! $v->connected_clients !!}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol><!-- End with custom content -->
                </div>
                {{-- <div class="card-footer">
                    Footer
                </div> --}}
            </div><!-- End Card with header and footer -->
        </div>
    </div>
</section>
