@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Usuarios</li>
                    <li>Detalles</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right">
                    <a href="{{ route('usuarios.index') }}" class="button">
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
                {{ $usuario->name }}
            </p>
        </header>
        <div class="card-content">
            <div class="field">
                <label class="label">Nombre Completo</label>
                <div class="control">
                    <input class="input" type="text" value="{{ $usuario->name }}" readonly>
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                    <input class="input" type="email" value="{{ $usuario->email }}" readonly>
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-email"></i>
                    </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Rol</label>
                <div class="control">
                    <input class="input" type="text" value="{{ ucfirst($usuario->rol) }}" readonly>
                </div>
            </div>

            <div class="field">
                <label class="label">Fecha de Registro</label>
                <div class="control has-icons-left">
                    <input class="input" type="text" value="{{ $usuario->created_at->format('d/m/Y H:i') }}" readonly>
                    <span class="icon is-small is-left">
                        <i class="mdi mdi-calendar"></i>
                    </span>
                </div>
            </div>
            
            <hr>
            
            <div class="field grouped">
                 <div class="control">
                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="button orange">
                        <span class="icon"><i class="mdi mdi-pencil"></i></span>
                        <span>Editar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection