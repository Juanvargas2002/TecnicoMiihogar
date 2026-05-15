<div>
    <div class="card has-table">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                Listado de Usuarios
            </p>
            <div class="card-header-icon">
                <button type="button" class="button is-small" wire:click="clearFilters" title="Limpiar filtros">
                    <span class="icon"><i class="mdi mdi-filter-remove"></i></span>
                </button>
            </div>
        </header>

        <div class="card-content">
            <div class="columns is-variable is-4 is-multiline mb-4">
                <div class="column is-5-desktop is-6-tablet">
                    <label class="label">Buscar</label>
                    <input type="text" class="input" placeholder="Nombre, email o rol" wire:model.live.debounce.300ms="search">
                </div>

                <div class="column is-2-desktop is-6-tablet">
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

            <div class="b-table has-pagination">
                <div class="table-wrapper has-mobile-cards">
                    <table class="table is-fullwidth is-striped is-hoverable is-sortable is-fullwidth">
                        <thead>
                            <tr>
                                <th role="button" wire:click="sortBy('name')">Nombre</th>
                                <th role="button" wire:click="sortBy('email')">Email</th>
                                <th role="button" wire:click="sortBy('rol')">Rol</th>
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

            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>