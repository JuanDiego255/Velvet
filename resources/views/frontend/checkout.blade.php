@extends('layouts.front')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@php
    $address_tenant = '';
    $sinpe_name = '';
    switch ($tenantinfo->tenant) {
        case 'abril7cr':
        case 'aycfashion':
            $address_tenant = '(Envío dentro de la GAM ₡2500)';
            $sinpe_name = 'Sharlin Patricia Espinoza';
            break;

        default:
            break;
    }
@endphp
@section('content')
    <div class="container mt-4 mb-4">
        <div class="breadcrumb-nav bc3x">
            @if (isset($tenantinfo->manage_department) && $tenantinfo->manage_department != 1)
                <li class="home"><a href="{{ url('/') }}"><i class="fas fa-{{ $icon->home }} me-1"></i></a></li>
                <li class="bread-standard"><a href="{{ url('category/') }}"><i
                            class="fas fa-{{ $icon->categories }} me-1"></i>Categorías</a></li>
                <li class="bread-standard"><a href="{{ url('/view-cart') }}"><i
                            class="fas fa-{{ $icon->cart }} me-1"></i>Carrito</a>
                </li>
                <li class="bread-standard"><a href="#"><i class="fab fa-cc-mastercard me-1"></i>Finalizar Compra</a>
                </li>
            @else
                <li class="home"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i></a></li>
                <li class="bread-standard"><a href="{{ url('departments/index') }}"><i
                            class="fas fa-shapes me-1"></i>Departamentos</a></li>
                <li class="bread-standard"><a href="{{ url('/view-cart') }}"><i
                            class="fas fa-{{ $icon->cart }} me-1"></i>Carrito</a>
                </li>
                <li class="bread-standard"><a href="#"><i class="fab fa-cc-mastercard me-1"></i>Finalizar Compra</a>
                </li>
            @endif

        </div>


        <div class="row row-cols-1 row-cols-md-2 g-4 align-content-center card-group mt-1">
            <div class="col bg-transparent">
                <div id="sinpeContent" class="bg-transparent">
                    <div class="card card-frame">
                        <h3 class="ps-3 mt-2 text-center">
                            Detalles Básicos
                        </h3>

                        <div class="card-body">
                            <form action="{{ url('payment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="0" name="delivery" id="delivery">
                                <input type="hidden" value="{{ $delivery }}" name="total_delivery"
                                    id="total_delivery">
                                <input type="hidden" value="V" name="kind_of" id="kind_of">
                                <div class="row checkout-form">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Nombre</label>
                                            <input value="{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}"
                                                required type="text" name="name"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>E-mail</label>
                                            <input value="{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}"
                                                required type="text" name="email"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Teléfono (WhatsApp)</label>
                                            <input
                                                value="{{ isset(Auth::user()->telephone) ? Auth::user()->telephone : '' }}"
                                                required type="text" name="telephone"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>
                                                @if ($tenant == 'mandicr')
                                                    Dirección Exacta
                                                @else
                                                    Dirección 1
                                                @endif
                                            </label>
                                            <input value="{{ isset($user_info->address) ? $user_info->address : '' }}"
                                                required type="text" name="address"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    @if ($tenant != 'mandicr')
                                        <div class="col-md-6 mt-2">
                                            <div class="input-group input-group-static mb-4">
                                                <label>Dirección 2</label>
                                                <input
                                                    value="{{ isset($user_info->address_two) ? $user_info->address_two : '' }}"
                                                    type="text" name="address_two" class="form-control float-left w-100">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Ciudad</label>
                                            <input value="{{ isset($user_info->city) ? $user_info->city : '' }}" required
                                                type="text" name="city" class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Provincia</label>
                                            <input value="{{ isset($user_info->province) ? $user_info->province : '' }}"
                                                required type="text" name="province"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>País</label>
                                            <input
                                                value="{{ isset($user_info->country) ? $user_info->country : 'Costa Rica' }}"
                                                required readonly value="Costa Rica" type="text" name="country"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Código Postal</label>
                                            <input
                                                value="{{ isset($user_info->postal_code) ? $user_info->postal_code : '' }}"
                                                required type="text" name="postal_code"
                                                class="form-control float-left w-100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>comprobante (SINPE Móvil)</label>
                                            <input required class="form-control" type="file" name="image">
                                        </div>
                                    </div>
                                    <span class="text-muted">SINPE Móvil:
                                        {{ isset($tenantinfo->sinpe) ? $tenantinfo->sinpe : '' }}
                                        {{ isset($tenantinfo->count) ? '| Cuenta bancaria: ' . $tenantinfo->count : '' }}</span>
                                    <h5 class="text-muted-normal mt-2">Realiza una transferencia bancaria, o cancela por
                                        medio de
                                        SINPE Móvil, debes adjuntar el comprobante para que su compra sea aprobada</h5>

                                    <button id="btnSinpe" type="submit" class="btn btn-add_to_cart d-block h8">Pagar
                                        ₡<span id="btnPay">{{ number_format($total_price) }}</span></button>
                                    @if (!Auth::check())
                                        <h5 class="text-muted-normal">
                                            Una vez que te <a class="text-info"
                                                href="{{ route('register') }}">registres</a>
                                            no
                                            deberás
                                            completar los detalles de entrega, e
                                            información personal. Además de encontrar increíbles descuentos, y promociones.

                                        </h5>
                                    @else
                                        <h5 class="text-muted-normal">
                                            Para cambiar la dirección de entrega ve a
                                            <a class="text-info" href="{{ url('address') }}">direcciones</a> y selecciona
                                            la que desees.

                                        </h5>
                                    @endif

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="cardContent" style="display: none;">
                    <div class="col col-12 ps-md-5 p-0">
                        <div class="box-left">
                            <p class="fw-bold h7">Nuestro método de pago por medio de tarjeta se encuentra deshabilitado.
                            </p>

                            <div class="">

                                {{-- <div class="btn-add_to_cart" id="paypal-button-container">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col bg-transparent">
                <div>
                    <div class="col col-12 ps-md-5 p-0">
                        <div class="box-left">
                            <p class="fw-bold h7">Detalles de la compra</p>
                            <div class="h8">
                                <div class="row m-0 border mb-3">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $precio = $item->price;
                                            if (
                                                isset($tenantinfo->custom_size) &&
                                                $tenantinfo->custom_size == 1 &&
                                                $item->stock_price > 0
                                            ) {
                                                $precio = $item->stock_price;
                                            }
                                            $descuentoPorcentaje = $item->discount;
                                            // Calcular el descuento
                                            $descuento = ($precio * $descuentoPorcentaje) / 100;
                                            // Calcular el precio con el descuento aplicado
                                            $precioConDescuento = $precio - $descuento;
                                            $attributesValues = explode(', ', $item->attributes_values);
                                        @endphp
                                        <div class="d-flex justify-content-lg-start justify-content-center p-2">

                                            <span class="ps-3 textmuted"><i
                                                    class="material-icons my-auto textmuted">done</i>
                                                {{ $item->name }} | Cant: {{ $item->quantity }} | Atributos
                                                @foreach ($attributesValues as $attributeValue)
                                                    @php
                                                        // Separa el atributo del valor por ": "
                                                        [$attribute, $value] = explode(': ', $attributeValue);
                                                    @endphp

                                                    {{ $attribute }}: {{ $value }}
                                                @endforeach

                                                |
                                                Precio:
                                                ₡{{ $item->discount > 0 ? $precioConDescuento * $item->quantity : ($tenantinfo->custom_size == 1 ? $item->stock_price * $item->quantity : $item->price * $item->quantity) }}
                                            </span>
                                        </div>
                                        <hr class="dark horizontal my-0">
                                    @endforeach
                                </div>
                                <div class="d-flex h7">
                                    <p class="">Total + I.V.A</p>
                                    <p class="ms-auto"></span>₡<span
                                            id="totalIva">{{ number_format($total_price) }}</span></p>
                                </div>
                                <p class="fw-bold h7">Tarifa de envío por correos de C.R ₡{{ $delivery }}
                                    {{ $address_tenant }}</p>
                                <p class="fw-bold h7">SINPE Móvil:
                                    {{ isset($tenantinfo->sinpe) ? $tenantinfo->sinpe : '' }}
                                    {{ '(' . $sinpe_name . ')' }}
                                </p>
                                <div class="h8">
                                    <label for="checkboxSubmit">
                                        <div class="form-check">
                                            <input id="envio" class="form-check-input" type="checkbox"
                                                value="" name="envio" onchange="checkEnvio();">
                                            <label class="form-check-label mb-2" for="envio">
                                                Realizar Envío
                                            </label>
                                        </div>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class=" mt-4">
                    <div class="col col-12 ps-md-5 p-0">
                        <div class="box-left">
                            <p class="fw-bold h7">Métodos de pago</p>
                            <div class="h8">

                                <label for="checkboxSubmit">
                                    <div class="form-check">
                                        <input id="sinpe" class="form-check-input" type="checkbox" value=""
                                            name="sinpe" checked onchange="togglePaypalButton();">
                                        <label class="form-check-label mb-2" for="sinpe">
                                            Pagar Por SINPE o Transferencia bancaria
                                        </label>
                                    </div>

                                </label>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('layouts.inc.indexfooter')
@endsection
@section('scripts')
    @if (isset($advert))
        <script>
            // Verifica si la alerta ya ha sido mostrada en esta sesión
            if (!sessionStorage.getItem('alertShown')) {
                // Muestra la alerta
                var advertContent = @json($advert->content);

                // Muestra la alerta
                Swal.fire({
                    title: 'Anuncio importante!',
                    html: advertContent,
                    icon: "info",
                    showCloseButton: true,
                    focusConfirm: false,
                    confirmButtonText: `
                        <i class="fa fa-thumbs-up"></i> Entendido!
                    `,
                    confirmButtonAriaLabel: "Thumbs up, great!"
                });
                // Marca que la alerta ha sido mostrada
                sessionStorage.setItem('alertShown', 'true');
            }
        </script>
    @endif
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&components=buttons,funding-eligibility">
    </script>
    <script>
        /*  paypal.Buttons({
                                                                            locale: 'es',
                                                                            fundingSource: paypal.FUNDING.CARD,
                                                                            createOrder: function(data, actions) {
                                                                                return actions.order.create({

                                                                                    payer: {
                                                                                        email_address: '{{ isset(Auth::user()->email) ? Auth::user()->email : '' }}',
                                                                                        name: {
                                                                                            given_name: '{{ isset(Auth::user()->name) ? Auth::user()->name : '' }}',
                                                                                            surname: ''
                                                                                        },
                                                                                        address: {
                                                                                            country_code: "CR",
                                                                                        }
                                                                                    },
                                                                                    purchase_units: [{
                                                                                        amount: {
                                                                                            value: {{ $paypal_amount }}
                                                                                        }
                                                                                    }]
                                                                                });
                                                                            },

                                                                            onApprove(data) {
                                                                                return fetch("/paypal/process/" + data.orderID)
                                                                                    .then((response) => response.json())
                                                                                    .then((orderData) => {
                                                                                        if (!orderData.success) {
                                                                                            swal({
                                                                                                title: orderData.status,
                                                                                                icon: orderData.icon,
                                                                                            }).then((value) => {
                                                                                                // Esta función se ejecuta cuando el usuario hace clic en el botón "Ok"
                                                                                                if (value) {
                                                                                                    // Recargar la página
                                                                                                    window.location.href = '{{ url('/') }}';
                                                                                                }
                                                                                            });
                                                                                        }
                                                                                        swal({
                                                                                            title: orderData.status,
                                                                                            icon: orderData.icon,
                                                                                        }).then((value) => {
                                                                                            // Esta función se ejecuta cuando el usuario hace clic en el botón "Ok"
                                                                                            if (value) {
                                                                                                // Recargar la página
                                                                                                window.location.href = '{{ url('/') }}';
                                                                                            }
                                                                                        });
                                                                                    });
                                                                            },
                                                                            onError: function(err) {
                                                                                alert(err);
                                                                            }
                                                                        }).render('#paypal-button-container'); */

        function togglePaypalButton() {
            var checkBox = document.getElementById("sinpe");
            var paypalButton = document.getElementById("paypal-button-container");
            var sinpeContent = document.getElementById("sinpeContent");
            var cardContent = document.getElementById("cardContent");

            if (checkBox.checked != true) {
                //paypalButton.style.display = "block";
                sinpeContent.style.display = "none";
                cardContent.style.display = "block";
            } else {
                //paypalButton.style.display = "none";
                sinpeContent.style.display = "block";
                cardContent.style.display = "none";
            }
        }

        function checkEnvio() {
            var envio = parseFloat(document.getElementById("total_delivery").value);
            var checkBox = document.getElementById("envio");
            var labelTotal = document.getElementById("totalIva");
            var labelBtnPay = document.getElementById("btnPay");
            var inputTotal = document.getElementById("delivery");
            var cardContent = document.getElementById("cardContent");
            var numericTotalIva = parseFloat(labelTotal.textContent.replace(',', ''));

            if (checkBox.checked) {
                labelTotal.textContent = `${(numericTotalIva + envio).toLocaleString()}`;
                labelBtnPay.textContent = `${(numericTotalIva + envio).toLocaleString()}`;
                inputTotal.value = envio;
            } else {
                labelTotal.textContent = `${(numericTotalIva - envio).toLocaleString()}`;
                labelBtnPay.textContent = `${(numericTotalIva - envio).toLocaleString()}`;
                inputTotal.value = 0;
            }
        }
    </script>
@endsection
