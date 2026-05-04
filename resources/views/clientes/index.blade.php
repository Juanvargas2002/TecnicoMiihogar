@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Clientes</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center m-4 pt-4">
            <div class="flex-shrink-0">
                <div class="buttons">
                    <a href="{{ route('clientes.create') }}" class="button green">
                        <span class="icon"><i class="mdi mdi-plus"></i></span>
                        <span>Nuevo Cliente</span>
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
                Listado de Clientes
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
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td data-label="Nombre">{{ $cliente->nombre }}</td>
                                <td data-label="Documento">{{ $cliente->documento }}</td>
                                <td data-label="Email">{{ $cliente->email }}</td>
                                <td data-label="Teléfono">{{ $cliente->telefono }}</td>
                                <td class="actions-cell">
                                    <div class="buttons nowrap">
                                        <a href="{{ route('clientes.show', $cliente->id) }}" class="button small blue" type="button">
                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                        </a>

                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="button small orange" type="button">
                                            <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                        </a>

                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.');" style="display: inline;">
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
                                <td colspan="5" class="has-text-centered">No hay clientes registrados.</td>
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