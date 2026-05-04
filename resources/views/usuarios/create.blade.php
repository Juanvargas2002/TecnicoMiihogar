@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-plus"></i></span>
            Registrar Nuevo Usuario
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            <div class="field">
                <label class="label">Nombre Completo</label>
                <div class="control">
                    <input class="input" type="text" name="name" placeholder="Ej: Juan Pérez" value="{{ old('name') }}" required>
                </div>
                @error('name')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" name="email" placeholder="juan@ejemplo.com" value="{{ old('email') }}" required>
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-email"></i>
                    </span>
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" name="password" placeholder="********" required>
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-lock"></i>
                    </span>
                </div>
                @error('password')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Confirmar Contraseña</label>
                <div class="control has-icons-left">
                    <input class="input" type="password" name="password_confirmation" placeholder="********" required>
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
                            <option value="recepcionista" {{ old('rol') == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                            <option value="tecnico" {{ old('rol') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
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
                        Guardar Usuario
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