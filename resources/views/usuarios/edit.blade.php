@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-edit"></i></span>
            Editar Usuario
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label class="label">Nombre Completo</label>
                <div class="control">
                    <input class="input" type="text" name="name" placeholder="Ej: Juan Pérez" value="{{ old('name', $usuario->name) }}" required>
                </div>
                @error('name')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="juan@ejemplo.com" value="{{ old('email', $usuario->email) }}" required>
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-email"></i>
                    </span>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Contraseña (Dejar en blanco para mantener la actual)</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" name="password" placeholder="********">
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-lock"></i>
                    </span>
                </div>
                @error('password')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Confirmar Nueva Contraseña</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" name="password_confirmation" placeholder="********">
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-lock-check"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Rol</label>
                <div class="control">
                    <div class="select">
                        <select name="rol" required>
                            <option value="Recepcionista" {{ old('rol', $usuario->rol) == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                            <option value="Tecnico" {{ old('rol', $usuario->rol) == 'Tecnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="Administrador" {{ old('rol', $usuario->rol) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>
                </div>
                @error('rol')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <hr>

            <div class="field grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        Actualizar Usuario
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('usuarios.index') }}" class="button red">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection