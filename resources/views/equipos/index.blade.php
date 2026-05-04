@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Equipos</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right m-4 pt-4">
                    <a href="{{ route('equipos.create') }}" class="button green">
                        <span class="icon"><i class="mdi mdi-laptop-mac"></i></span>
                        <span>Nuevo Equipo</span>
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
            {{ session('error') }}
        </div>
    @endif

    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-laptop"></i></span>
                Listado de Equipos
            </p>
            <a href="#" class="card-header-icon">
                <span class="icon"><i class="mdi mdi-reload"></i></span>
            </a>
        </header>
        
        <div class="card-content">
            <!-- Filtro de Clientes -->
            <form method="GET" action="{{ route('equipos.index') }}" class="mb-6 p-3">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <div class="select is-fullwidth">
                            <select name="cliente_id" onchange="this.form.submit()">
                                <option value="">-- Filtrar por Cliente (Todos) --</option>
                                @foreach($clientes as $client)
                                    <option value="{{ $client->id }}" {{ request('cliente_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nombre }} - {{ $client->documento }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="b-table has-pagination">
                <table class="table is-fullwidth is-striped is-hoverable is-sortable">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Marca / Modelo</th>
                        <th>Serial</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($equipos as $equipo)
                        <tr>
                            <td data-label="Cliente">
                                <a href="{{ route('clientes.show', $equipo->cliente->id) }}">
                                    <b>{{ $equipo->cliente->nombre }}</b>
                                </a>
                                <br>
                                <small class="text-gray-500">{{ $equipo->cliente->documento }}</small>
                            </td>
                            <td data-label="Producto">{{ $equipo->producto }}</td>
                            <td data-label="Marca / Modelo">
                                {{ $equipo->marca }} <small>{{ $equipo->modelo }}</small>
                            </td>
                            <td data-label="Serial">{{ $equipo->serial ?? '-' }}</td>
                            <td class="actions-cell">
                                <div class="buttons nowrap">
                                    <a href="{{ route('equipos.show', $equipo->id) }}" class="button small blue" type="button">
                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                    
                                    <a href="{{ route('equipos.edit', $equipo->id) }}" class="button small orange" type="button">
                                        <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                    </a>

                                    <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este equipo?');" style="display: inline;">
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
                            <td colspan="5" class="has-text-centered">No hay equipos registrados.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-content">
                {{ $equipos->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>
@endsection