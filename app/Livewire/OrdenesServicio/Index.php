<?php

namespace App\Livewire\OrdenesServicio;

use App\Models\OrdenServicio;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $estado = '';
    public string $sortField = 'fecha_recepcion';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    public function updated($property): void
    {
        if (in_array($property, ['search', 'estado', 'perPage'], true)) {
            $this->resetPage();
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            return;
        }

        $this->sortField = $field;
        $this->sortDirection = 'asc';
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'estado', 'sortField', 'sortDirection', 'perPage']);
        $this->sortField = 'fecha_recepcion';
        $this->sortDirection = 'desc';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function render()
    {
        $ordenes = OrdenServicio::query()
            ->with(['cliente', 'equipo', 'usuario'])
            ->when($this->estado !== '', fn ($query) => $query->where('estado', $this->estado))
            ->when($this->search !== '', function ($query) {
                $term = '%' . $this->search . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('numero_orden', 'like', $term)
                        ->orWhere('estado', 'like', $term)
                        ->orWhereHas('cliente', function ($clienteQuery) use ($term) {
                            $clienteQuery->where('nombre', 'like', $term)
                                ->orWhere('documento', 'like', $term);
                        })
                        ->orWhereHas('equipo', function ($equipoQuery) use ($term) {
                            $equipoQuery->where('producto', 'like', $term)
                                ->orWhere('marca', 'like', $term)
                                ->orWhere('modelo', 'like', $term)
                                ->orWhere('serial', 'like', $term);
                        })
                        ->orWhereHas('usuario', function ($usuarioQuery) use ($term) {
                            $usuarioQuery->where('name', 'like', $term);
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.ordenes-servicio.index', [
            'ordenes' => $ordenes,
        ]);
    }
}