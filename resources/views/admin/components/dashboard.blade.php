
<section class="section">
    {{-- <div class="row">
        @foreach ($responseAcesspoint as $ap)
            @foreach ($ap->wireless->radios as $radio)
                <!-- Sales Card -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ap->device->hostname }} <span>|
                                    {{ $radio->bandwidth == 80 ? '5.1' : '2.4' }}</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-router-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $radio->connected_clients }}</h6>
                                    <span class="text-success small pt-1 fw-bold">{{ $radio->txpower }}</span> <span
                                        class="text-muted small pt-2 ps-1">txPower</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sales Card -->
            @endforeach
        @endforeach
    </div> --}}
    {{-- <pre>{!! print_r($responseAcesspoint) !!}</pre> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Caixa Atendimento e Torres</h5>

                    <!-- Bordered Tabs Justified -->
                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="tabela-tab" data-bs-toggle="tab"
                                data-bs-target="#bordered-justified-tabela" type="button" role="tab"
                                aria-controls="tabela" aria-selected="true"><i class="bi bi-table fs-2"></i></button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="mapa-tab" data-bs-toggle="tab"
                                data-bs-target="#bordered-justified-mapa" type="button" role="tab"
                                aria-controls="mapa" aria-selected="false"><i class="bi bi-pin-map fs-2"></i></button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                        <div class="tab-pane fade show active" id="bordered-justified-tabela" role="tabpanel"
                            aria-labelledby="tabela-tab">
                            <table class="dataenquete table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Portas Total</th>
                                        <th>Portas Ocupadas</th>
                                        <th>Portas Livres</th>
                                        <th>Endereço</th>
                                        <th>Nome Caixa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach (array_unique($portsNap, SORT_REGULAR) as $client)
                                        <tr>
                                            <td>{{ $client['portfull'] }}</td>
                                            <td>{{ $client['portfree'] }}</td>
                                            <td>{{ $client['portbusy'] }}</td>
                                            <td>{{ $client['address'] }}</td>
                                            <td>{{ $client['nap'] }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="bordered-justified-mapa" role="tabpanel"
                            aria-labelledby="mapa-tab">
                            <div style="height: 800px; width: 100%"id="map"></div>
                        </div>

                    </div><!-- End Bordered Tabs Justified -->

                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="my-3">
                        <table class="dataenquete table table-striped table-hover {{-- dt-responsive --}}">
                            <thead>
                                <tr>
                                    <th>Base</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($torreNetlight as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scriptsmap')
{{--     <script>
        function initMap() {
            // Coordenadas do centro do mapa
            var center = {
                lat: -21.557163,
                lng: -45.4401929
            };

            // Criar o mapa
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: center
            });

            /* const iconBase =
                "https://developers.google.com/maps/documentation/javascript/examples/full/images/"; */

            const icons = {

                fibra: {
                    icon: "{{ URL::asset('web/assets/img/site/ctofiber.png') }}",
                },
                torre: {
                    icon: "{{ URL::asset('web/assets/img/site/antenna.png') }}",
                },
            };

            // Array de marcadores com informações
            var markers = {{ Js::from($pointMapaNap) }};

            // Adicionar marcadores ao mapa
            markers.forEach(function(markerInfo) {
                var marker = new google.maps.Marker({
                    position: markerInfo.position,
                    icon: icons[markerInfo.type].icon,
                    map: map,
                    title: markerInfo.title
                });

                // Adicionar popup ao marcador
                var infowindow = new google.maps.InfoWindow({
                    content: /* markerInfo.content */ buildContent(markerInfo)
                });

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            });
        }

        function buildContent(property) {
            const content = document.createElement("div");

            content.classList.add("property");
            content.innerHTML = `
            <div class="card">
            <div class="card-header">
                ${property.titlewindow}
            </div>
            <div class="card-body">
                <h5 class="card-title">${property.box}</h5>
                <p class="card-text">Endereço: ${property.address}</p>
                <p class="card-text">Portas Total: ${property.portfull}.</p>
                <p class="card-text">Portas Ocupadas: ${property.portbusy}.</p>
                <p class="card-text">Portas Livres: ${property.portfree}.</p>
                <p class="card-text">Clientes:<br/> ${property.clients}.</p>
            </div>
            </div>`;
            return content;
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap">
    </script>
    <script src="{{ asset('admin/assets/js/datatableapp.js') }}"></script> --}}
@endpush
