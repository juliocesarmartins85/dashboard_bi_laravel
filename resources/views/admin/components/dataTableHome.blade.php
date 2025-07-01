<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Usuários Cadastrados</div>
            <div class="card-body">
                <div class="my-5">
                    <table class="dataenquete table table-striped table-hover {{-- dt-responsive --}}">
                        <thead>
                            <tr>
                                @foreach ($data['profile_header'] as $ph)
                                    <th scope="col">{{ $ph['title'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['profile_body'] as $pb)
                                <tr>
                                    <td>{{ $pb->id }}</td>
                                    <td>{{ $pb->name }}</td>
                                    <td>{{ $pb->bairro }}</td>
                                    <td>{{ $pb->telefone }}</td>
                                    <td>{{ $pb->mac_address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Dados Por Bairro</h5>
                <!-- Default Accordion -->
                <div class="accordion" id="accordionExample">
                    @foreach ($data['preguntas_bairro'] as $key => $pb)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $key }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                                    aria-controls="collapse{{ $key }}">
                                    Resposta <strong class="mx-1">{{ $pb['response'] }}</strong> para <strong
                                        class="mx-1">{{ $pb['question'] }}</strong> por bairro.
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- List group with custom content -->
                                    <ol class="list-group list-group-numbered">
                                        @foreach ($pb['count'] as $key => $count)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Bairro:</div>
                                                    {{ ucfirst($key) }}
                                                </div>
                                                <h3><span class="badge bg-primary rounded-pill">{{ $count }}</span></h3>
                                            </li>
                                        @endforeach
                                    </ol><!-- End with custom content -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!-- End Default Accordion Example -->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Historico equipamentos</div>
            <div class="card-body">
                <div class="my-5">
                    <table class="dataenquete table table-striped table-hover {{-- dt-responsive --}}">
                        <thead>
                            <tr>
                                @foreach ($data['device_header'] as $ph)
                                    <th scope="col">{{ $ph['title'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['device_body'] as $pb)
                                <tr>
                                    <td>{{ $pb->id_user }}</td>
                                    <td>{{ $pb->mac_address }}</td>
                                    <td>{{ $pb->host_name }}</td>
                                    <td>{{ $pb->ip_adress }}</td>
                                    <td>{{ $pb->server }}</td>
                                    <td>{{ $pb->hotspot }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Usuarios Blacklist</div>
            <div class="card-body">
                <div class="my-5">
                    <table class="dataenquete table table-striped table-hover {{-- dt-responsive --}}">
                        <thead>
                            <tr>
                                @foreach ($data['blacklist_header'] as $ph)
                                    <th scope="col">{{ $ph['title'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['blacklist_body'] as $pb)
                                <tr>
                                    <td>{{ $pb->id }}</td>
                                    <td>{{ $pb->nome }}</td>
                                    <td>{{ $pb->bairro }}</td>
                                    <td>{{ $pb->telefone }}</td>
                                    <td>{{ $pb->mac }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
@endpush
