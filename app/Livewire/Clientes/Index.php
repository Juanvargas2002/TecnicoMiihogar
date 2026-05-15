<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'nombre';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    public function updated($property): void
    {
        if (in_array($property, ['search', 'perPage'], true)) {
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
        $this->reset(['search', 'sortField', 'sortDirection', 'perPage']);
        $this->sortField = 'nombre';
        $this->sortDirection = 'asc';
        $this->perPage = 10;
        $this->resetPage();
    }

    public function render()
    {
        $clientes = Cliente::query()
            ->when($this->search !== '', function ($query) {
                $term = '%' . $this->search . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery
                        ->where('nombre', 'like', $term)
                        ->orWhere('documento', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('telefono', 'like', $term)
                        ->orWhere('direccion', 'like', $term);
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.clientes.index', [
            'clientes' => $clientes,
        ]);
    }
}