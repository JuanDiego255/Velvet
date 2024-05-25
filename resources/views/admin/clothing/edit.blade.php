@extends('layouts.admin')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@php
    $stock_array = $stocks;
@endphp
@section('content')
    <form action="{{ url('update-clothing' . '/' . $clothing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-dark">Editar Producto</h4>
                    </div>
                    <div class="card-body">

                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Producto</label>
                                    <input required value="{{ $clothing->name }}" type="text"
                                        class="form-control form-control-lg" name="name">
                                </div>
                            </div>
                            @if (isset($tenantinfo->tenant) && $tenantinfo->tenant === 'fragsperfumecr')
                                <div class="col-md-6 mb-3">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Casa</label>
                                        <input type="text" value="{{ $clothing->casa }}"
                                            class="form-control form-control-lg" name="casa">
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Código</label>
                                    <input required value="{{ $clothing->code }}" type="text"
                                        class="form-control form-control-lg" name="code">
                                </div>
                            </div>
                            <input type="hidden" name="category_id" value="{{ $clothing->category_id }}">
                            <div class="col-md-12 mb-3">

                                <label>Descripción</label><br>
                                <textarea id="editor" type="text" class="form-control form-control-lg" name="description">{!! $clothing->description !!}</textarea>
                            </div>

                            <input type="hidden" name="clothing_id" id="clothing_id" value="{{ $clothing->id }}">
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Precio</label>
                                    <input required type="number" value="{{ $clothing->price }}"
                                        class="form-control form-control-lg" name="price">
                                </div>
                            </div>
                            @if (isset($tenantinfo->tenant) && $tenantinfo->tenant === 'torres')
                                <div class="col-md-6 mb-3">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Precio al por mayor</label>
                                        <input required type="number" value="{{ $clothing->mayor_price }}"
                                            class="form-control form-control-lg" name="mayor_price">
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Descuento (%)</label>
                                    <input type="number" value="{{ $clothing->discount }}"
                                        class="form-control form-control-lg" name="discount">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Stock (El dato que se ingresa aumenta el stock ya existente en las tallas
                                        seleccionadas,
                                        siempre y cuando este sea 0)</label>
                                    <input min="1" required
                                        value="{{ $clothing->total_stock == 0 ? '1' : $clothing->total_stock }}"
                                        type="number" class="form-control form-control-lg" name="stock">
                                </div>
                            </div>

                            @if (isset($tenantinfo->kind_business) && ($tenantinfo->kind_business == 2 || $tenantinfo->kind_business == 3))
                                <div class="col-md-12 mb-3">
                                    <label>Se puede comprar?</label>
                                    <div class="form-check">
                                        <input {{ $clothing->can_buy == 1 ? 'checked' : '' }} class="form-check-input"
                                            type="checkbox" value="1" id="can_buy" name="can_buy">
                                        <label class="custom-control-label" for="customCheck1">Producto de compra</label>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12 mb-3">
                                <label>Es Tendencia?</label>
                                <div class="form-check">
                                    <input {{ $clothing->trending == 1 ? 'checked' : '' }} class="form-check-input"
                                        type="checkbox" value="1" id="trending" name="trending">
                                    <label class="custom-control-label" for="customCheck1">Trending</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                @if ($clothing->image)
                                    <img class="img-fluid img-thumbnail" src="{{ route('file', $clothing->image) }}"
                                        style="width: 150px; height:150px;" alt="image">
                                @endif
                                <label>Imágenes (Máximo 4)</label>
                                <div class="input-group input-group-static mb-4">
                                    <input multiple class="form-control form-control-lg" type="file" name="images[]">
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <button type="submit" class="btn btn-velvet">Editar Producto</button>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if (count($attributes) > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="text-dark">{{ __('Atributos') }}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="input-group input-group-static">
                                        <label>{{ __('Seleccionar atributo') }}</label>
                                        <select id="attr_id" name="attr_id"
                                            class="form-control form-control-lg @error('attr_id') is-invalid @enderror"
                                            autocomplete="attr_id" autofocus>
                                            @if (isset($stock_active->attr_id))
                                                <option selected value="{{ $stock_active->attr_id }}">
                                                    {{ $stock_active->name }}</option>
                                            @else
                                                <option value="0">{{ __('Sin atributos') }}</option>
                                            @endif

                                            <option value="0">{{ __('Sin atributos') }}</option>
                                            @foreach ($attributes as $key => $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                        @error('attr_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="hidden_id"></div>
                            <div id="attr" class="row d-none">
                                <div class="col-md-12 mb-2">
                                    <div class="input-group input-group-static">
                                        <label>{{ __('Seleccionar valor') }}</label>
                                        <select id="value" name="value"
                                            class="form-control form-control-lg @error('value') is-invalid @enderror"
                                            autocomplete="value" autofocus>

                                        </select>
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div id="divValue" class="row">

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </form>
    <center>
        <div class="col-md-12 mt-3">
            <a href="{{ url('add-item/' . $category_id) }}" class="btn btn-velvet w-25">Volver</a>
        </div>
    </center>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            createHtml();
            $('.size-checkbox').change(function(e) {
                createHtml();
            });

            function getValues(id) {
                var select = document.getElementById("value");
                var element = document.getElementById("attr");
                var divValue = document.getElementById("divValue");
                var element_hidden = document.getElementById("hidden_id");

                if (id != "0") {
                    element_hidden.innerHTML = '';
                    var htmlHidden =
                        `<input required type="hidden" value="${id}" id="attr_id_hidden" name="attr_id_hidden">`;

                    select.innerHTML = '';
                    $.ajax({
                        method: "GET",
                        url: "/get-values/" +
                            id, // Cambia esto por la ruta que devuelve los elementos del carrito
                        success: function(values) {
                            // Recorrer los elementos


                            var option = document.createElement("option");
                            option.value = 0;
                            option.text = "Sin valor";
                            option.selected = true;

                            select.appendChild(option);
                            values.forEach(function(item, index) {
                                var option1 = document.createElement("option");
                                option1.value = item.id + "-" + item.main;
                                option1.text = item.value;
                                select.appendChild(option1);
                            });

                            element.classList.remove("d-none");
                            element_hidden.innerHTML += htmlHidden;
                            element.classList.add("d-block");


                        }
                    });
                } else {
                    select.innerHTML = '';
                    element_hidden.innerHTML = '';
                    divValue.innerHTML = '';
                    element.classList.remove("d-block");
                    element.classList.add("d-none");
                }

            }

            $('#attr_id').change(function(e) {
                var selectedValue = $(this).val();
                getValues(selectedValue);
            });

            $('#value').change(function(e) {
                var selectedValueComplete = $(this).val();
                var partes = selectedValueComplete.split("-");
                var selectedValue = partes[0];
                var main_attr = partes[1];
                var selectedText = $(this).find("option:selected").text();
                var attr_id_h = $('#attr_id_hidden').val();
                var attr_main_h = $('#attr_main_hidden').val();
                var precioId = "precio_attr" + selectedValue;
                var attr_id = "attr_id" + selectedValue;
                var value_id = "value_id" + selectedValue;
                var cantidadId = "cantidad_attr" + selectedValue;
                var htmlInput = "";
                var no_main_text = " (No es un valor de un atributo principal, no permite el precio)"

                // Verificar si los elementos ya existen
                if (!document.getElementById(precioId) && !document.getElementById(cantidadId) && !document
                    .getElementById(attr_id) &&
                    selectedValue != "0") {

                    var hiddenInput = document.createElement("input");
                    hiddenInput.required = true;
                    hiddenInput.type = "hidden";
                    hiddenInput.value = attr_id_h;
                    hiddenInput.id = attr_id;
                    hiddenInput.name = `attr_id[${selectedValue}]`;
                    hiddenInput.placeholder = "Precio";

                    // Create the label element
                    var label = document.createElement("label");
                    label.setAttribute("for", precioId);
                    label.textContent = `${selectedText}:`;
                    if (main_attr == 0) {
                        label.textContent = `${selectedText}` + no_main_text;
                    }

                    // Create a line break element
                    var lineBreak = document.createElement("br");

                    // Create the first div with col-md-6 class
                    var divCol1 = document.createElement("div");
                    divCol1.className = "col-md-6";

                    // Create the first input group div
                    var inputGroup1 = document.createElement("div");
                    inputGroup1.className = "input-group input-group-static";

                    // Create the first input element
                    var inputPrecio = document.createElement("input");
                    inputPrecio.required = true;
                    inputPrecio.type = "text";
                    inputPrecio.value = "";
                    if (main_attr == 0) {
                        inputPrecio.value = "0";
                        inputPrecio.readOnly = true;
                    }
                    inputPrecio.className = "form-control form-control-lg";
                    inputPrecio.id = precioId;
                    inputPrecio.name = `precios_attr[${selectedValue}]`;
                    inputPrecio.placeholder = "Precio";

                    // Append the first input to its input group div
                    inputGroup1.appendChild(inputPrecio);

                    // Append the input group div to the first col-md-6 div
                    divCol1.appendChild(inputGroup1);

                    // Create the second div with col-md-6 class
                    var divCol2 = document.createElement("div");
                    divCol2.className = "col-md-6";

                    // Create the second input group div
                    var inputGroup2 = document.createElement("div");
                    inputGroup2.className = "input-group input-group-static";

                    // Create the second input element
                    var inputCantidad = document.createElement("input");
                    inputCantidad.required = true;
                    inputCantidad.type = "text";
                    inputCantidad.value = "";
                    inputCantidad.className = "form-control form-control-lg";
                    inputCantidad.id = cantidadId;
                    inputCantidad.name = `cantidades_attr[${selectedValue}]`;
                    inputCantidad.placeholder = "Cantidad";

                    // Append the second input to its input group div
                    inputGroup2.appendChild(inputCantidad);

                    // Append the input group div to the second col-md-6 div
                    divCol2.appendChild(inputGroup2);

                    // Assuming you have a container to append these elements to
                    var container = document.getElementById("divValue");

                    // Append all elements to the container in the correct order
                    container.appendChild(hiddenInput);
                    container.appendChild(label);
                    container.appendChild(lineBreak);
                    container.appendChild(divCol1);
                    container.appendChild(divCol2);
                }
            });

            function createHtml() {
                var attributes = <?php echo json_encode($stock_array); ?>;

                attributes.forEach(function(item, index) {
                    if (item.attr_id != null && item.attr_id != "") {
                        var selectedValueComplete = item.value_attr + "-" + item.main;
                        var partes = selectedValueComplete.split("-");
                        var selectedValue = partes[0];
                        var main_attr = partes[1];
                        var selectedText = item.value;
                        var attr_id_h = item.attr_id;
                        var precioId = "precio_attr" + selectedValue;
                        var attr_id = "attr_id" + selectedValue;
                        var value_id = "value_id" + selectedValue;
                        var cantidadId = "cantidad_attr" + selectedValue;
                        var htmlInput = "";
                        var no_main_text = " (No es un valor de un atributo principal, no permite el precio)"

                        // Verificar si los elementos ya existen
                        if (!document.getElementById(precioId) && !document.getElementById(cantidadId) && !
                            document
                            .getElementById(attr_id) &&
                            selectedValue != "0") {

                            var hiddenInput = document.createElement("input");
                            hiddenInput.required = true;
                            hiddenInput.type = "hidden";
                            hiddenInput.value = attr_id_h;
                            hiddenInput.id = attr_id;
                            hiddenInput.name = `attr_id[${selectedValue}]`;
                            hiddenInput.placeholder = "Precio";

                            // Create the label element
                            var label = document.createElement("label");
                            label.setAttribute("for", precioId);
                            label.textContent = `${selectedText}:`;
                            if (main_attr == 0) {
                                label.textContent = `${selectedText}` + no_main_text;
                            }

                            // Create a line break element
                            var lineBreak = document.createElement("br");

                            // Create the first div with col-md-6 class
                            var divCol1 = document.createElement("div");
                            divCol1.className = "col-md-6";

                            // Create the first input group div
                            var inputGroup1 = document.createElement("div");
                            inputGroup1.className = "input-group input-group-static";

                            // Create the first input element
                            var inputPrecio = document.createElement("input");
                            inputPrecio.required = true;
                            inputPrecio.type = "text";
                            inputPrecio.value = item.price;
                            if (main_attr == 0) {
                                inputPrecio.readOnly = true;
                            }
                            inputPrecio.className = "form-control form-control-lg";
                            inputPrecio.id = precioId;
                            inputPrecio.name = `precios_attr[${selectedValue}]`;
                            inputPrecio.placeholder = "Precio";

                            // Append the first input to its input group div
                            inputGroup1.appendChild(inputPrecio);

                            // Append the input group div to the first col-md-6 div
                            divCol1.appendChild(inputGroup1);

                            // Create the second div with col-md-6 class
                            var divCol2 = document.createElement("div");
                            divCol2.className = "col-md-6";

                            // Create the second input group div
                            var inputGroup2 = document.createElement("div");
                            inputGroup2.className = "input-group input-group-static";

                            // Create the second input element
                            var inputCantidad = document.createElement("input");
                            inputCantidad.required = true;
                            inputCantidad.type = "text";
                            inputCantidad.value = item.stock;
                            inputCantidad.className = "form-control form-control-lg";
                            inputCantidad.id = cantidadId;
                            inputCantidad.name = `cantidades_attr[${selectedValue}]`;
                            inputCantidad.placeholder = "Cantidad";

                            // Append the second input to its input group div
                            inputGroup2.appendChild(inputCantidad);

                            // Append the input group div to the second col-md-6 div
                            divCol2.appendChild(inputGroup2);

                            // Assuming you have a container to append these elements to
                            var container = document.getElementById("divValue");

                            // Append all elements to the container in the correct order
                            container.appendChild(hiddenInput);
                            container.appendChild(label);
                            container.appendChild(lineBreak);
                            container.appendChild(divCol1);
                            container.appendChild(divCol2);
                        }
                    }
                });
            }

            function obtenerStockYPrecioParaTalla(tallaId) {
                var cloth_id = document.getElementById("clothing_id").value;
                var stocks = <?php echo json_encode($stocks); ?>;
                var stockParaTalla = 0;
                var precioParaTalla = 0;

                stocks.forEach(function(stock) {
                    if (stock.clothing_id == cloth_id && stock.size_id == tallaId && stock.attr_id ==
                        null && stock.value_attr == null) {
                        stockParaTalla = stock.stock;
                        precioParaTalla = stock.price;
                        if (typeof precioParaTalla === 'undefined') {
                            precioParaTalla = 0;
                        }
                        return; // Salir del bucle forEach una vez que se encuentre el stock y precio para la talla
                    }
                });

                return {
                    stock: stockParaTalla,
                    price: precioParaTalla
                };
            }
            $(document).ready(function() {
                ClassicEditor
                    .create(document.querySelector('#editor'))
                    .catch(error => {
                        console.error(error);
                    });
            });
        });
    </script>
@endsection
