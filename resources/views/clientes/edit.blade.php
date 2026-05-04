@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-edit"></i></span>
            Editar Cliente
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label">Nombre Completo</label>
                <div class="control">
                    <input class="input" value="{{ $cliente->nombre }}" type="text" name="nombre" placeholder="Ej: Juan Pérez" required>
                </div>
                @error('nombre')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Documento de Identidad</label>
                <div class="control">
                    <input class="input" value="{{ $cliente->documento }}" type="text" name="documento" placeholder="Cédula">
                </div>
                @error('documento')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" value="{{ $cliente->email }}" type="email" name="email" placeholder="juan@ejemplo.com">
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-email"></i>
                    </span>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Teléfono</label>
                <div class="control has-icons-left">
                    <input class="input" value="{{ $cliente->telefono }}" type="tel" name="telefono" placeholder="+57 300 123 4567">
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-phone"></i>
                    </span>
                </div>
                @error('telefono')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Dirección</label>
                <div class="control has-icons-left">
                    <input class="input" value="{{ $cliente->direccion }}" type="text" name="direccion" placeholder="Calle 123 # 45-67">
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-map-marker"></i>
                    </span>
                </div>
                @error('direccion')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <div class="field grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        Editar Cliente
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('clientes.index') }}" class="button red">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
