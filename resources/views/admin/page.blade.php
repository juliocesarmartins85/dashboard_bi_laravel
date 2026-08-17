@extends('layouts.admin')

@section('content')
    <section class="section dashboard py-3">
        <div class="row g-4">
            @foreach ($sections as $key => $item)
                @php
                    // Define a coluna dinamicamente ou aplica 'col-12' como fallback
                    $colClass = !empty($item['col']) ? "col-12 col-md-{$item['col']}" : 'col-12';
                @endphp

                <div class="{{ $colClass }}">
                    @include("admin.components.{$key}", ['data' => $item['data']])
                </div>
            @endforeach
        </div>
    </section>
@endsection
