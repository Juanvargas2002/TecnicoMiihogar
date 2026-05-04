@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Órdenes de Servicio</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right m-4 pt-4">
                    <a href="{{ route('ordenes.create') }}" class="button green">
                        <span class="icon"><i class="mdi mdi-plus-box"></i></span>
                        <span>Nueva Orden</span>
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
                <span class="icon"><i class="mdi mdi-clipboard-list"></i></span>
                Listado de Órdenes
            </p>
            <a href="#" class="card-header-icon">
                <span class="icon"><i class="mdi mdi-reload"></i></span>
            </a>
        </header>
        
        <div class="card-content">
            <!-- Filtro de Estado -->
            <form method="GET" action="{{ route('ordenes.index') }}" class="mb-6 p-3">
                <div class="field has-addons">
                    <div class="control">
                        <div class="select">
                            <select name="estado" onchange="this.form.submit()">
                                <option value="">Todos los Estados</option>
                                <option value="recibido" {{ request('estado') == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="diagnosticado" {{ request('estado') == 'Diagnosticado' ? 'selected' : '' }}>Diagnosticado</option>
                                <option value="reparado" {{ request('estado') == 'Reparado' ? 'selected' : '' }}>Reparado</option>
                                <option value="entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="b-table has-pagination">
                <table class="table is-fullwidth is-striped is-hoverable is-sortable">
                    <thead>
                    <tr>
                        <th>Nº Orden</th>
                        <th>Cliente</th>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th>Fecha Recepción</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ordenes as $orden)
                    <!-- Agregamos clase a la fila según el estado de la orden -->
                    <!-- si se quieren modificar estos colores se pueden ajustar -->
                    <!-- en el bloque de estilos al final del archivo -->
                        @php
                            $filaEstadoClass = match ($orden->estado) {
                                'Diagnosticado' => 'orden-estado-diagnosticado',
                                'Reparado' => 'orden-estado-reparado',
                                'Entregado' => 'orden-estado-entregado',
                                default => 'orden-estado-recibido',
                            };
                        @endphp
                        <tr class="{{ $filaEstadoClass }}">
                            <td data-label="Nº Orden">{{ $orden->numero_orden }}</td>
                            <td data-label="Cliente">
                                <a href="{{ route('clientes.show', $orden->cliente_id) }}">
                                    <b>{{ $orden->cliente->nombre }}</b>
                                </a>
                            </td>
                            <td data-label="Equipo">
                                {{ $orden->equipo->tipo_equipo }} <small>{{ $orden->equipo->marca }}</small>
                            </td>
                            <td data-label="Estado">
                                    {{ ucfirst($orden->estado) }}
                            </td>
                            <td data-label="Fecha Recepción">
                                {{ $orden->fecha_recepcion ? \Carbon\Carbon::parse($orden->fecha_recepcion)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="actions-cell">
                                <div class="buttons nowrap">
                                    <a href="{{ route('ordenes.show', $orden->id) }}" class="button small blue" type="button">
                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                    
                                    <a href="{{ route('ordenes.edit', $orden->id) }}" class="button small orange" type="button">
                                        <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                    </a>

                                    <form action="{{ route('ordenes.destroy', $orden->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta orden?');" style="display: inline;">
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
                            <td colspan="6" class="has-text-centered">No hay órdenes registradas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-content">
                {{ $ordenes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</section>

<style>
    .table tbody tr.orden-estado-recibido td {
        background-color: #ffffff;
    }

    .table tbody tr.orden-estado-diagnosticado td {
        background-color: #fff6bf;
    }

    .table tbody tr.orden-estado-reparado td {
        background-color: #d7f5db;
    }

    .table tbody tr.orden-estado-entregado td {
        background-color: #d9ebff;
    }
</style>
@endsection