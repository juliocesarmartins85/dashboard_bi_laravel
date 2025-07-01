@extends('layouts.admin')
@section('content')
    <section class="section dashboard">
        <div class="row">
            @foreach ($sections as $key => $item)
                @if (empty($item['col']))
                    @include("admin.components.{$key}", ['data' => $item['data']])
                @else
                    <div class="col-12">
                        @include("admin.components.{$key}", ['data' => $item['data']])
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
