@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Clientes</li>
                    <li>Detalles</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right">
                    <a href="{{ route('clientes.index') }}" class="button">
                        <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="card mb-6">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account"></i></span>
                Información del Cliente
            </p>
        </header>
        <div class="card-content">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Nombre</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input is-static" value="{{ $cliente->nombre }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Documento</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input is-static" value="{{ $cliente->documento ?? 'No registrado' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Contacto</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input is-static" value="{{ $cliente->email ?? 'Sin email' }}" readonly>
                            <span class="icon is-small is-left"><i class="mdi mdi-email"></i></span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input is-static" value="{{ $cliente->telefono ?? 'Sin teléfono' }}" readonly>
                            <span class="icon is-small is-left"><i class="mdi mdi-phone"></i></span>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Dirección</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <textarea class="textarea is-static" readonly>{{ $cliente->direccion ?? 'Sin dirección' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Registrado</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input class="input is-static" value="{{ $cliente->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
