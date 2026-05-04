@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Equipos</li>
                    <li>Detalles</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right">
                    <a href="{{ route('equipos.index') }}" class="button">
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
                <span class="icon"><i class="mdi mdi-laptop"></i></span>
                Información del Equipo
            </p>
        </header>
        <div class="card-content">
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Propietario / Cliente</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input is-static" value="{{ $equipo->cliente->nombre }} ({{ $equipo->cliente->documento }})" readonly>
                            <span class="icon is-small is-left"><i class="mdi mdi-account"></i></span>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
             <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Producto</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                             <input class="input is-static" value="{{ $equipo->producto }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Detalles Técnicos</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control is-expanded">
                            <label class="label is-small">Marca</label>
                            <input class="input is-static" value="{{ $equipo->marca ?? 'N/A' }}" readonly>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control is-expanded">
                            <label class="label is-small">Modelo</label>
                            <input class="input is-static" value="{{ $equipo->modelo ?? 'N/A' }}" readonly>
                        </p>
                    </div>
                     <div class="field">
                        <p class="control is-expanded">
                            <label class="label is-small">Serial</label>
                            <input class="input is-static" value="{{ $equipo->serial ?? 'N/A' }}" readonly>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">Descripción</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <textarea class="textarea is-static" readonly>{{ $equipo->descripcion ?? 'Sin comentarios adicionales.' }}</textarea>
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
                            <input class="input is-static" value="{{ $equipo->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
