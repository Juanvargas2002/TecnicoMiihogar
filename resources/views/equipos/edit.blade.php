@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-laptop"></i></span>
            Editar Equipo
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('equipos.update', $equipo->id) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label">Cliente</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="cliente_id" required>
                            <option value="">Seleccione un cliente --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ (old('cliente_id', $equipo->cliente_id) == $cliente->id) ? 'selected' : '' }}>
                                    {{ $cliente->nombre }} - {{ $cliente->documento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('cliente_id')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Producto</label>
                <div class="control">
                    <input class="input" type="text" name="producto" value="{{ old('producto', $equipo->producto) }}" placeholder="Ej: Laptop, Impresora, Desktop" required>
                </div>
                @error('producto')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Marca</label>
                <div class="control">
                    <input class="input" type="text" name="marca" value="{{ old('marca', $equipo->marca) }}" placeholder="Ej: HP">
                </div>
            </div>

            <div class="field">
                <label class="label">Modelo</label>
                <div class="control">
                    <input class="input" type="text" name="modelo" value="{{ old('modelo', $equipo->modelo) }}" placeholder="Ej: Pavilion 15">
                </div>
            </div>

            <div class="field">
                <label class="label">Serial / Nº de Serie</label>
                <div class="control">
                    <input class="input" type="text" name="serial" value="{{ old('serial', $equipo->serial) }}" placeholder="Ej: 5CD12345X">
                </div>
                 @error('serial')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Descripción / Observaciones</label>
                <div class="control">
                    <textarea class="textarea" name="descripcion" placeholder="Detalles adicionales del equipo...">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                </div>
                 @error('descripcion')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <div class="field grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        Actualizar Equipo
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('equipos.index') }}" class="button red">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
