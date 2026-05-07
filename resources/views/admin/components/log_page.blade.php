{{-- <div class="row">
    <div class="col-lg-12">
        <!-- Card with header and footer -->
        <div class="card">
            <div class="card-header">Registros de log</div>
            <div class="card-body my-5">
                <div class="list-group">
                    @foreach ($datapage as $item)
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $item->page }}</h5>
                                <small
                                    class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-1">{{ $item->mensagem }}</p>
                            <small class="text-muted">{{ $item->device }}</small>
                        </a>
                    @endforeach
                </div><!-- End List group Advanced Content -->
            </div>
            <div class="card-footer">
                {!! $datapage->links('pagination::bootstrap-5') !!}
            </div>
        </div><!-- End Card with header and footer -->
    </div>
</div> --}}
<div class="row">
    <div class="col-lg-12">
        <!-- Card with header and footer -->
        <div class="card">
            <div class="card-header">Registros de log</div>
            <div class="card-body">
                <div class="my-5">
                    <table class="dataTableAdmin table table-striped table-hover {{-- dt-responsive --}}">
                        <thead>
                            <tr>
                                <th scope="col">Usuário/Pagina</th>
                                <th scope="col">Equipamento</th>
                                <th scope="col">Data</th>
                                {{-- @foreach ($data['blacklist_header'] as $ph)
                                    <th scope="col">{{ $ph['title'] }}</th>
                                @endforeach --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datapage as $pb)
                                <tr>
                                    <td>{{ $pb->mensagem }}</td>
                                    <td>{{ $pb->device }}</td>
                                    <td>{{ Carbon\Carbon::parse($pb->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer">
                {!! $datapage->links('pagination::bootstrap-5') !!}
            </div> --}}
        </div><!-- End Card with header and footer -->
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/datatableapp.js') }}"></script>
@endpush