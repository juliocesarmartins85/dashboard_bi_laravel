@foreach ($data['data_system'] ?? [] as $key => $item)
    <!-- Sales Card -->
    <div class="col-xxl-3 col-md-6">
        <a href="{{ route('clientsconnects', $key) }}">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">{!! $item->lan->ipv4->ip_address !!}<br /></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-router"></i>
                        </div>
                        <div class="ps-3">
                            <h6 title="{{ $item->device->alias }}">{!! Str::limit($item->device->alias, 10, '...') !!}</h6>

                            <span class="text-success small pt-1 fw-bold text-capitalize">
                                @foreach ($item->wireless->radios as $itemCl)
                                    {{ $itemCl->connected_clients }} Clientes
                                    {{ $itemCl->bandwidth > 40 ? '5GHz' : ' 2.4GHz' }}<br>
                                @endforeach

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div><!-- End Sales Card -->
@endforeach
