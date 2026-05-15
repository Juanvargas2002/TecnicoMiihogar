<div>
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                Listado de Clientes
            </p>
            <div class="card-header-icon">
                <button type="button" class="button is-small" wire:click="clearFilters" title="Limpiar filtros">
                    <span class="icon"><i class="mdi mdi-filter-remove"></i></span>
                </button>
            </div>
        </header>

        <div class="card-content">
            <div class="flex flex-wrap gap-4 mb-4">
                <div class="w-full sm:w-2/3 lg:w-3/4">
                    <label class="label">Buscar</label>
                    <input type="text" class="input" placeholder="Nombre, documento, email o teléfono" wire:model.live.debounce.300ms="search">
                </div>

                <div class="w-full sm:w-1/3 lg:w-1/4">
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
                                <th role="button" wire:click="sortBy('nombre')">Nombre</th>
                                <th role="button" wire:click="sortBy('documento')">Documento</th>
                                <th role="button" wire:click="sortBy('email')">Email</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td data-label="Nombre">{{ $cliente->nombre }}</td>
                                <td data-label="Documento">{{ $cliente->documento }}</td>
                                <td data-label="Email">{{ $cliente->email ?? '-' }}</td>
                                <td data-label="Teléfono">{{ $cliente->telefono ?? '-' }}</td>
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

            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>