@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Usuarios</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center m-4 pt-4">
            <div class="flex-shrink-0">
                <div class="buttons is-right">
                    <a href="{{ route('usuarios.create') }}" class="button green">
                        <span class="icon"><i class="mdi mdi-plus"></i></span>
                        <span>Nuevo Usuario</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    @if(session('success'))
        <div class="notification green">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="notification red">
            <button class="delete"></button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                Listado de Usuarios
            </p>
            <a href="#" class="card-header-icon">
                <span class="icon"><i class="mdi mdi-reload"></i></span>
            </a>
        </header>
        <div class="card-content">
            <div class="b-table has-pagination">
                <div class="table-wrapper has-mobile-cards">
                    <table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td data-label="Nombre">{{ $usuario->name }}</td>
                                <td data-label="Email">{{ $usuario->email }}</td>
                                <td data-label="Rol">{{ ucfirst($usuario->rol) }}</td>
                                <td class="actions-cell">
                                    <div class="buttons nowrap">
                                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="button small blue" type="button">
                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                        </a>

                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="button small orange" type="button">
                                            <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                        </a>

                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button small red">
                                                <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="has-text-centered">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection