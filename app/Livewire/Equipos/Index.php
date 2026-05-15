<?php

namespace App\Livewire\Equipos;

use App\Models\Cliente;
use App\Models\Equipo;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $clienteId = '';
    public string $sortField = 'producto';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    public function updated($property): void
    {
        if (in_array($property, ['search', 'clienteId', 'perPage'], true)) {
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
        $this->reset(['search', 'clienteId', 'sortField', 'sortDirection', 'perPage']);
        $this->sortField = 'producto';
        $this->sortDirection = 'asc';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function render()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        $equipos = Equipo::query()
            ->with('cliente')
            ->when($this->clienteId !== '', fn ($query) => $query->where('cliente_id', $this->clienteId))
            ->when($this->search !== '', function ($query) {
                $term = '%' . $this->search . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('producto', 'like', $term)
                        ->orWhere('marca', 'like', $term)
                        ->orWhere('modelo', 'like', $term)
                        ->orWhere('serial', 'like', $term)
                        ->orWhereHas('cliente', function ($clienteQuery) use ($term) {
                            $clienteQuery->where('nombre', 'like', $term)
                                ->orWhere('documento', 'like', $term);
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.equipos.index', [
            'equipos' => $equipos,
            'clientes' => $clientes,
        ]);
    }
}