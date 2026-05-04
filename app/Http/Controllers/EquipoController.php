<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipo::with('cliente');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        $equipos = $query->paginate(10);
        $clientes = Cliente::orderBy('nombre')->get(); // Para el filtro

        return view('equipos.index', compact('equipos', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('equipos.create', compact('clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255|unique:equipos,serial',
            'descripcion' => 'nullable|string',
        ],['serial.unique' => 'El número de serie ya está registrado.',
            'marca.required' => 'La marca es obligatoria.',
            'producto.required' => 'El producto es obligatorio.'
        ]);

        Equipo::create($validatedData);

        return redirect()->route('equipos.index')->with('success', 'Equipo registrado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipo = Equipo::with('cliente')->findOrFail($id);
        return view('equipos.show', compact('equipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipo = Equipo::findOrFail($id);
        $clientes = Cliente::orderBy('nombre')->get();
        return view('equipos.edit', compact('equipo', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipo = Equipo::findOrFail($id);

        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'serial' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('equipos', 'serial')->ignore($equipo->id),
            ],
            'descripcion' => 'nullable|string',
        ],['serial.unique' => 'El número de serie ya está registrado.',
            'marca.required' => 'La marca es obligatoria.',
            'producto.required' => 'El producto es obligatorio.'
        ]);

        $equipo->update($validatedData);

        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipo = Equipo::findOrFail($id);

        if ($equipo->ordenes()->exists()) {
            return redirect()->route('equipos.index')->with('error', 'No se puede eliminar el equipo porque tiene órdenes de servicio asociadas.');
        }

        $equipo->delete();

        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado con éxito');
    }
}