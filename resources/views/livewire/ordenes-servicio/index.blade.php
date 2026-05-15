<div>
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-clipboard-list"></i></span>
                Listado de Órdenes
            </p>
            <div class="card-header-icon">
                <button type="button" class="button is-small" wire:click="clearFilters" title="Limpiar filtros">
                    <span class="icon"><i class="mdi mdi-filter-remove"></i></span>
                </button>
            </div>
        </header>

        <div class="card-content">
            <div class="flex flex-wrap gap-4 mb-4">
                <div class="w-full sm:w-1/2 lg:w-1/3">
                    <label class="label">Buscar</label>
                    <input type="text" class="input" placeholder="Orden, cliente, equipo o usuario" wire:model.live.debounce.300ms="search">
                </div>

                <div class="w-full sm:w-1/3 lg:w-1/6">
                    <label class="label">Estado</label>
                    <div class="select is-fullwidth">
                        <select wire:model.live="estado">
                            <option value="">Todos</option>
                            <option value="Recibido">Recibido</option>
                            <option value="Diagnosticado">Diagnosticado</option>
                            <option value="Reparado">Reparado</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>
                </div>

                <div class="w-full sm:w-1/6 lg:w-1/6">
                    <label class="label">Por página</label>
                    <div class="select is-fullwidth">
                        <select wire:model.live="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="b-table has-pagination overflow-x-auto">
                <div class="table-wrapper has-mobile-cards overflow-x-auto">
                    <table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
                        <thead>
                            <tr>
                                <th role="button" wire:click="sortBy('numero_orden')">Nº Orden</th>
                                <th>Cliente</th>
                                <th>Equipo</th>
                                <th role="button" wire:click="sortBy('estado')">Estado</th>
                                <th role="button" wire:click="sortBy('fecha_recepcion')">Fecha Recepción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($ordenes as $orden)
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
                                    {{ $orden->equipo->producto ?? $orden->equipo->tipo_equipo ?? '-' }} <small>{{ $orden->equipo->marca }}</small>
                                </td>
                                <td data-label="Estado">{{ $orden->estado }}</td>
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
            </div>

            <div class="mt-4">
                {{ $ordenes->links() }}
            </div>
        </div>
    </div>
</div>

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