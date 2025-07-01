@extends('layouts.admin')

@section('content')
    <section class="section dashboard">
        <div class="row">
            @foreach ($sections as $key => $item)
                @if (empty($item['col']))
                    @include("components.{$key}", ['data' => $item['data']])
                @else
                    <div class="col-12">
                        @include("components.{$key}", ['data' => $item['data']])
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
