@extends('layouts.admin')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@section('content')
    <div class="container">

        <h2 class="text-center font-title"><strong>{{ __('Gestiona los anuncios en el sitio web') }} </strong>
        </h2>

        <hr class="hr-servicios">

        <button type="button" data-bs-toggle="modal" data-bs-target="#add-advert-modal"
            class="btn btn-velvet">{{ __('Nuevo anuncio') }}</button>

        @include('admin.adverts.add')
        <div class="card mt-3 mb-4">
            <div class="card-body">
                <div class="row w-100">
                    <div class="col-md-6">
                        <div class="input-group input-group-lg input-group-static my-3 w-100">
                            <label>Filtrar</label>
                            <input value="" placeholder="Escribe para filtrar...." type="text"
                                class="form-control form-control-lg" name="searchfor" id="searchfor">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-lg input-group-static my-3 w-100">
                            <label>Mostrar</label>
                            <select id="recordsPerPage" name="recordsPerPage" class="form-control form-control-lg"
                                autocomplete="recordsPerPage">
                                <option value="5">5 Registros</option>
                                <option value="10">10 Registros</option>
                                <option selected value="15">15 Registros</option>
                                <option value="50">50 Registros</option>
                            </select>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card p-2">
            <div class="table-responsive">
                <table id="table" class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                {{ __('Acciones') }}</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                {{ __('Sección') }}</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                {{ __('Anuncio') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adverts as $item)
                            <tr>
                                <td class="align-middle">
                                    <center>

                                        <form method="post" action="{{ url('/delete/advert/' . $item->id) }}"
                                            style="display:inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" data-bs-toggle="modal"
                                                onclick="return confirm('Deseas borrar este anuncio?')"
                                                class="btn btn-admin-delete" style="text-decoration: none;">Borrar</button>
                                        </form>
                                    </center>

                                </td>
                                <td class="align-middle text-xxs text-center">
                                    <p class=" font-weight-bold mb-0">{{ $item->section }}</p>
                                </td>
                                <td class="align-middle text-xxs text-center">
                                    <p class=" font-weight-bold mb-0">{{ $item->content }}</p>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/datatables.js') }}"></script>
@endsection
