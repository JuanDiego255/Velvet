@extends('layouts.front')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@php
    $font_icon = '';
    $title_service = 'Categorías';
    $btn = 'Descubrir Estilos';
    switch ($tenantinfo->kind_business) {
        case 1:
            $font_icon = 'fas fa-car'; 
            $btn = 'Ver Vehículos';          
            break;
        case 2:
            $font_icon = 'fas fa-spa';
            $title_service = 'Servicios'; 
            break;
        case 3:
            $font_icon = 'fas fa-heart';
            $title_service = 'Servicios';
            $btn = 'tratamientos'; 
            break;
        default:
            $font_icon = 'fas fa-box';            
            break;
    }
@endphp
@section('content')
    <div class="container mt-4">
        <div class="breadcrumb-nav bc3x">
            @if (isset($tenantinfo->manage_department) && $tenantinfo->manage_department != 1)
                <li class="home"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i></a></li>
                <li class="bread-standard"><a href="#"><i
                            class="{{$font_icon}} me-1"></i>{{$title_service}}</a>
                </li>
            @else
                <li class="home"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i></a></li>
                <li class="bread-standard"><a href="{{ url('departments/index') }}"><i
                            class="fas fa-shapes me-1"></i>Departamentos</a></li>
                <li class="bread-standard"><a href="#"><i
                            class="{{$font_icon}} me-1"></i>{{ $department_name }}</a>
                </li>
            @endif

        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 align-content-center card-group mt-5 mb-5">
            @foreach ($category as $item)
                <div class="col-md-3 col-sm-6 mb-2">
                    <div class="product-grid product_data">
                        <div class="product-image">
                            <img src="{{ route('file', $item->image) }}">
                            <ul class="product-links">
                                <li><a target="blank" href="{{ tenant_asset('/') . '/' . $item->image }}"><i
                                            class="fas fa-eye"></i></a></li>
                            </ul>
                            <a href="{{ url('clothes-category/' . $item->id . '/' . $department_id) }}"
                                class="add-to-cart">{{$btn}}</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a
                                    href="{{ url('clothes-category/' . $item->id . '/' . $department_id) }}">{{ $item->name }}</a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <center>
            <div class="container">
                {{ $category ?? ('')->links('pagination::simple-bootstrap-4') }}
            </div>
        </center>
    </div>
    @if (isset($tenantinfo->kind_business) && $tenantinfo->kind_business != 1)
        @include('layouts.inc.indexfooter')
    @endif
@endsection
@section('scripts')
    <script src="{{ asset('js/image-error-handler.js') }}"></script>
@endsection
