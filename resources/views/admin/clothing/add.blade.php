@extends('layouts.admin')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="text-dark">Agregar Nuevo Producto</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-clothing') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Categoría</label>
                            <input readonly value="{{ $category_name }}" type="text" class="form-control form-control-lg"
                                name="category">
                            <input type="hidden" value="{{ $id }}" name="category_id" id="category_id">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Producto</label>
                            <input required type="text" class="form-control form-control-lg" name="name">
                        </div>
                    </div>
                    @if (isset($tenantinfo->tenant) && $tenantinfo->tenant === 'fragsperfumecr')
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Casa</label>
                                <input type="text" class="form-control form-control-lg" name="casa">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Código</label>
                            <input readonly type="text" placeholder="Se completa automáticamente"
                                class="form-control form-control-lg" name="code">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Stock (Inventario)</label>
                            <input required type="number" class="form-control form-control-lg" name="stock">
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Descripción</label><br>
                            <input required type="text" class="form-control form-control-lg" name="description">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Precio</label>
                            <input required type="number" class="form-control form-control-lg" name="price">
                        </div>
                    </div>
                    @if (isset($tenantinfo->tenant) && $tenantinfo->tenant === 'torres')
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-static mb-4">
                                <label>Precio al por mayor</label>
                                <input type="number" class="form-control form-control-lg" name="mayor_price">
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Descuento (%)</label>
                            <input type="number" class="form-control form-control-lg" name="discount">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-static mb-4">
                            <label>Imagenes
                                {{ isset($tenantinfo->tenant) && $tenantinfo->tenant === 'marylu' ? '(Selecciona gran cantidad de imagenes, y crea productos masívamente si así lo deseas.)' : '(Máximo 4)' }}</label>
                            <input multiple required class="form-control form-control-lg" type="file" name="images[]">
                        </div>
                    </div>
                    @if (isset($tenantinfo->tenant) && $tenantinfo->tenant === 'marylu')
                        <div class="col-md-12 mb-3">
                            <label>Crear productos masivamente?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="masive"
                                    name="masive">
                                <label class="custom-control-label" for="customCheck1">Crear</label>
                            </div>
                        </div>
                    @endif
                    @if (isset($tenantinfo->tenant) && $tenantinfo->manage_size == 1)
                        <div class="col-md-12 mb-3">
                            <label
                                class="control-label control-label text-formulario {{ $errors->has('sizes_id[]') ? 'is-invalid' : '' }}"
                                for="sizes_id[]">Tallas (Debe identificar si la talla es adecuada para el tipo de
                                prenda.)</label><br>
                            @foreach ($sizes as $size)
                                <div class="form-check form-check-inline">
                                    <input name="sizes_id[]" class="form-check-input mb-2 size-checkbox" type="checkbox"
                                        value="{{ $size->id }}" id="sizes_id[]">
                                    <label class="form-check-label table-text mb-2" for="sizes_id[]">
                                        {{ $size->size }}
                                    </label>
                                </div>
                            @endforeach

                        </div>                        
                    @endif

                    <div class="col-md-12 mb-3">
                        <label>Es Tendencia?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="trending" name="trending">
                            <label class="custom-control-label" for="customCheck1">Trending</label>
                        </div>
                    </div>

                </div>


                <div class="col-md-12">
                    <button type="submit" class="btn btn-velvet">Agregar Producto</button>
                </div>

            </form>            
        </div>
    </div>
    <center>
        <div class="col-md-12 mt-3">
            <a href="{{ url('add-item/' . $id) }}" class="btn btn-velvet w-25">Volver</a>
        </div>
    </center>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.btnGestionar').click(function(e) {
                var tallasSeleccionadas = [];
                var checkboxes = document.getElementsByClassName("size-checkbox");

                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        tallasSeleccionadas.push(checkboxes[i].value);
                    }
                }

                var html = "";
                tallasSeleccionadas.forEach(function(talla) {
                    html += `
                        <div>
                            <label for="precio_${talla}">Talla ${talla}:</label>
                            <input type="text" id="precio_${talla}" name="precios[${talla}]" placeholder="Precio">
                            <input type="text" id="cantidad_${talla}" name="cantidades[${talla}]" placeholder="Cantidad">
                        </div>
                    `;
                });

                document.getElementById("tallasSeleccionadas").innerHTML = html;
                document.getElementById("sizeModal").style.display = "block";
            });
        });
    </script>
@endsection
