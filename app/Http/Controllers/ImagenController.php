<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imagen = Imagen::findOrFail($id);

        if (!empty($imagen->datos_imagen)) {
            $ruta = $imagen->datos_imagen;

            if (str_starts_with($ruta, 'img/')) {
                $ruta = substr($ruta, 4);
            }

            Storage::disk('public_img')->delete($ruta);
        }

        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
