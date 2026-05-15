<div>
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-laptop"></i></span>
                Listado de Equipos
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
                    <input type="text" class="input" placeholder="Producto, marca, modelo, serial o cliente" wire:model.live.debounce.300ms="search">
                </div>

                <div class="w-full sm:w-1/2 lg:w-1/3">
                    <label class="label">Cliente</label>
                    <div class="select is-fullwidth">
                        <select wire:model.live="clienteId">
                            <option value="">-- Todos --</option>
                            @foreach($clientes as $client)
                                <option value="{{ $client->id }}">{{ $client->nombre }} - {{ $client->documento }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="w-full sm:w-1/3 lg:w-1/6">
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
                    <table class="table is-fullwidth is-striped is-hoverable is-sortable">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th role="button" wire:click="sortBy('producto')">Producto</th>
                                <th role="button" wire:click="sortBy('marca')">Marca / Modelo</th>
                                <th role="button" wire:click="sortBy('serial')">Serial</th>
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
                                <td data-label="Marca / Modelo">{{ $equipo->marca }} <small>{{ $equipo->modelo }}</small></td>
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
            </div>

            <div class="mt-4">
                {{ $equipos->links() }}
            </div>
        </div>
    </div>
</div>