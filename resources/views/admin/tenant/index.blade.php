@extends('layouts.admin')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@section('content')
    <div class="container">

        <h2 class="text-center font-title"><strong>Administra los inquilinos desde acá</strong>
        </h2>

        <hr class="hr-servicios">

        <button type="button" data-bs-toggle="modal" data-bs-target="#add-tenant-modal" class="btn btn-velvet">Nuevo
            Inquilino</button>

        <center>

            @include('admin.tenant.add')
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
                            <option selected value="10">10 Registros</option>
                            <option value="25">25 Registros</option>
                            <option value="50">50 Registros</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="card w-100 mb-4">
                <div class="table-responsive">
                    <table id="sizes" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Inquilino</th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Dominio</th>
                                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tenants as $tenant)
                                <tr>

                                    <td class="align-middle text-xxs text-center">
                                        <p class=" font-weight-bold mb-0">{{ $tenant->id }}</p>
                                    </td>
                                    <td class="align-middle text-xxs text-center">
                                        <p class=" font-weight-bold mb-0">{{ $tenant->domains->first()->domain ?? '' }}</p>
                                    </td>

                                    <td class="align-middle">
                                        <center>
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#edit-tenant-modal{{ $tenant->id }}"
                                                class="btn btn-velvet" style="text-decoration: none;">Editar</button>

                                            <form method="post" action="{{ url('/delete/tenants/' . $tenant->id) }}"
                                                style="display:inline">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" data-bs-toggle="modal"
                                                    onclick="return confirm('Deseas borrar este inquilino?')"                                                   
                                                    class="btn btn-velvet" style="text-decoration: none;">Borrar</button>
                                            </form>
                                            <form method="post" action="{{ url('/domain/tenants/' . $tenant) }}"
                                                style="display:inline">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="tenant_id" value="{{$tenant->id}}">
                                              
                                                <button type="submit" class="btn btn-velvet" style="text-decoration: none;">Dominio</button>
                                            </form>
                                        </center>

                                    </td>
                                    @include('admin.tenant.edit')
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </center>
    </div>
@endsection
@section('script')
    <script>
        var dataTable = $('#sizes').DataTable({
            searching: true,
            lengthChange: false,

            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "<<",
                    "sLast": "Último",
                    "sNext": ">>",
                    "sPrevious": "<<"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $('#recordsPerPage').on('change', function() {
            var recordsPerPage = parseInt($(this).val(), 10);
            dataTable.page.len(recordsPerPage).draw();
        });

        // Captura el evento input en el campo de búsqueda
        $('#searchfor').on('input', function() {
            var searchTerm = $(this).val();
            dataTable.search(searchTerm).draw();
        });
    </script>
@endsection
