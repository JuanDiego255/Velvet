@php
    $index = 0;
@endphp

<div class="row">

    <div class="col-md-12">
        <div class="input-group input-group-lg input-group-outline {{ isset($item->title) ? 'is-filled' : '' }} my-3">
            <label class="form-label">Empresa</label>
            <input value="{{ isset($item->title) ? $item->title : '' }}" required type="text"
                class="form-control form-control-lg @error('title') is-invalid @enderror" name="title" id="title">
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->title_discount) ? 'is-filled' : '' }} my-3">

            <textarea placeholder="Descripción descuento: Esta descripción se mostrará en la sección de descuentos del cliente"
                value="{{ isset($item->title_discount) ? $item->title_discount : '' }}" type="text"
                class="form-control form-control-lg @error('title_discount') is-invalid @enderror" name="title_discount"
                id="title_discount"></textarea>
            @error('title_discount')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->title_instagram) ? 'is-filled' : '' }} my-3">

            <textarea
                placeholder="Descripción instagram: Esta descripción se mostrará en la sección de Instagram en la página principal"
                value="{{ isset($item->title_instagram) ? $item->title_instagram : '' }}" type="text"
                class="form-control form-control-lg @error('title_instagram') is-invalid @enderror" name="title_instagram"
                id="title_instagram"></textarea>
            @error('title_instagram')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="input-group input-group-lg input-group-outline {{ isset($item->mision) ? 'is-filled' : '' }} my-3">

            <textarea placeholder="Misión: Esta misión se mostrará en la sección de Misión en la página principal"
                value="{{ isset($item->mision) ? $item->mision : '' }}" required type="text"
                class="form-control form-control-lg @error('mision') is-invalid @enderror" name="mision" id="mision"></textarea>
            @error('mision')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->title_trend) ? 'is-filled' : '' }} my-3">

            <textarea
                placeholder="Descripción Tendencia: Esta descripción se mostrará en la sección de artículos en tendencia en la página principal"
                value="{{ isset($item->title_trend) ? $item->title_trend : '' }}" type="text"
                class="form-control form-control-lg @error('title_trend') is-invalid @enderror" name="title_trend" id="title_trend"></textarea>
            @error('title_trend')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->title_suscrib_a) ? 'is-filled' : '' }} my-3">
            <label class="form-label">Título suscripción: este título es el enlace directo para ir a suscribirse</label>
            <input value="{{ isset($item->title_suscrib_a) ? $item->title_suscrib_a : '' }}" type="text"
                class="form-control form-control-lg @error('title_suscrib_a') is-invalid @enderror"
                name="title_suscrib_a" id="title_suscrib_a">
            @error('title_suscrib_a')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->description_suscrib) ? 'is-filled' : '' }} my-3">
            <label class="form-label">Descripción suscripción: esta descripción es el cuerpo del mensaje que incita al
                usuario a suscribirse</label>
            <input value="{{ isset($item->description_suscrib) ? $item->description_suscrib : '' }}"
                type="text" class="form-control form-control-lg @error('description_suscrib') is-invalid @enderror"
                name="description_suscrib" id="description_suscrib">
            @error('description_suscrib')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->footer) ? 'is-filled' : '' }} my-3">
            <label class="form-label">Pie de página: esta descripción es el pie de página, normalmente es una frase llamativa</label>
            <input value="{{ isset($item->footer) ? $item->footer : '' }}"
                type="text" class="form-control form-control-lg @error('footer') is-invalid @enderror"
                name="footer" id="footer">
            @error('footer')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Logo</label>
        <div class="input-group input-group-static mb-4">
            <input required class="form-control" type="file" name="logo">
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Logo</label>
        <div class="input-group input-group-static mb-4">
            <input required class="form-control" type="file" name="login_image">
        </div>
    </div>
    <div class="col-md-6">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->whatsapp) ? 'is-filled' : '' }} my-3">
            <label class="form-label">WhatsApp</label>
            <input required value="{{ isset($item->whatsapp) ? $item->whatsapp : '' }}" type="text"
                class="form-control form-control-lg @error('whatsapp') is-invalid @enderror"
                name="whatsapp" id="whatsapp">
            @error('whatsapp')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->sinpe) ? 'is-filled' : '' }} my-3">
            <label class="form-label">SINPE Móvil</label>
            <input required value="{{ isset($item->sinpe) ? $item->sinpe : '' }}" type="text"
                class="form-control form-control-lg @error('sinpe') is-invalid @enderror"
                name="sinpe" id="sinpe">
            @error('sinpe')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div
            class="input-group input-group-lg input-group-outline {{ isset($item->email) ? 'is-filled' : '' }} my-3">
            <label class="form-label">E-mail</label>
            <input placeholder="Este E-mail es para recibir correos cuando se realiza una compra" value="{{ isset($item->email) ? $item->email : '' }}" type="email"
                class="form-control form-control-lg @error('email') is-invalid @enderror"
                name="email" id="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>Campo Requerido</strong>
                </span>
            @enderror
        </div>
    </div>

    <center>
        <input class="btn btn-velvet" type="submit" value="{{ $Modo == 'crear' ? 'Agregar' : 'Guardar Cambios' }}">
    </center>

</div>
