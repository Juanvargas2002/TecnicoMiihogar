<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdenServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrdenServicio::with(['cliente', 'equipo', 'usuario']);

        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
        }

        $ordenes = $query->latest()->paginate(10);
        return view('ordenesServicio.index', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $equipos = collect();
        $clienteId = $request->input('cliente_id', old('cliente_id'));

        if (!empty($clienteId)) {
            $equipos = Equipo::where('cliente_id', $clienteId)->get();
        }

        return view('ordenesServicio.create', compact('clientes', 'equipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $metodoRegistro = $request->input('metodo_registro', 'orden_existente');

        if ($metodoRegistro === 'registro_completo') {
            $request->validate([
                'metodo_registro' => 'required|in:orden_existente,registro_completo',
                'nombre' => 'required|string|max:255',
                'documento' => 'required|string|max:50|unique:clientes,documento',
                'email' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:50',
                'direccion' => 'nullable|string|max:255',
                'producto' => 'required|string|max:255',
                'marca' => 'required|string|max:255',
                'modelo' => 'nullable|string|max:255',
                'serial' => 'nullable|string|max:255|unique:equipos,serial',
                'descripcion' => 'nullable|string',
                'accesorios' => 'nullable|string',
                'falla_reportada' => 'required|string',
                'observaciones' => 'nullable|string',
                // forma de cargar imagenes sin validar como 'image' para evitar problemas con AVIF en algunas versiones de PHP/GD
                'imagenes.*' => 'mimes:jpeg,png,jpg,gif,webp,avif',
            ], [
                'documento.unique' => 'La cédula ya está registrada para otro cliente.',
                'documento.required' => 'La cédula es obligatoria.',
                'serial.unique' => 'El serial ya está registrado para otro equipo.',
                'producto.required' => 'El producto es obligatorio.',
                'marca.required' => 'La marca es obligatoria.',
                'falla_reportada.required' => 'La falla reportada es obligatoria.',
            ]);

            DB::transaction(function () use ($request) {
                $cliente = Cliente::create([
                    'nombre' => $request->nombre,
                    'documento' => $request->documento,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                ]);

                $equipo = Equipo::create([
                    'cliente_id' => $cliente->id,
                    'producto' => $request->producto,
                    'marca' => $request->marca,
                    'modelo' => $request->modelo,
                    'serial' => $request->serial,
                    'descripcion' => $request->descripcion,
                ]);

                $orden = $this->crearOrdenServicio(
                    $cliente->id,
                    $equipo->id,
                    $request->falla_reportada,
                    $request->observaciones,
                    $request->accesorios
                );

                $this->procesarYGuardarImagenes($request, $orden);
            });

            return redirect()->route('ordenes.index')->with('success', 'Cliente, equipo y orden registrados con éxito.');
        }

        $request->validate([
            'metodo_registro' => 'required|in:orden_existente,registro_completo',
            'cliente_id' => 'required|exists:clientes,id',
            'equipo_id' => 'required|exists:equipos,id',
            'falla_reportada' => 'required|string',
            'observaciones' => 'nullable|string',
            'accesorios' => 'nullable|string',
            // forma de cargar imagenes sin validar como 'image' para evitar problemas con AVIF en algunas versiones de PHP/GD
            'imagenes.*' => 'mimes:jpeg,png,jpg,gif,webp,avif',
        ]);

        $equipo = Equipo::findOrFail($request->equipo_id);
        if ((int) $equipo->cliente_id !== (int) $request->cliente_id) {
            return back()->withErrors(['equipo_id' => 'El equipo seleccionado no pertenece al cliente.'])->withInput();
        }

        $orden = $this->crearOrdenServicio(
            $request->cliente_id,
            $request->equipo_id,
            $request->falla_reportada,
            $request->observaciones,
            $request->accesorios
        );

        // Guardar imágenes optimizadas
        $this->procesarYGuardarImagenes($request, $orden);

        return redirect()->route('ordenes.index')->with('success', 'Orden de servicio creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orden = OrdenServicio::with(['cliente', 'equipo', 'usuario'])->findOrFail($id);
        return view('ordenesServicio.show', compact('orden'));
    }

    /**
     * Descarga un comprobante PDF de recepción de la orden.
     */
    public function descargarPdf(OrdenServicio $orden)
    {
        $orden->loadMissing(['cliente', 'equipo', 'usuario']);

        $pdf = Pdf::loadView('ordenesServicio.pdf.comprobante', [
            'orden' => $orden,
        ])->setPaper('a4');

        $nombreArchivo = 'comprobante-' . ($orden->numero_orden ?: ('OS-' . $orden->id)) . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orden = OrdenServicio::findOrFail($id);
        return view('ordenesServicio.edit', compact('orden'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orden = OrdenServicio::findOrFail($id);

        $request->validate([
            'estado' => 'required|in:Recibido,Diagnosticado,Reparado,Entregado',
            'diagnostico' => 'nullable|string',
            'solucion' => 'nullable|string',
            // Quitamos 'image' ya que puede fallar con AVIF en algunas versiones de PHP/GD
            'imagenes.*' => 'mimes:jpeg,png,jpg,gif,webp,avif|max:10240'
        ]);

        $orden->estado = $request->estado;
        $orden->diagnostico = $request->diagnostico;
        $orden->solucion = $request->solucion;

        if ($request->estado == 'Entregado' && !$orden->fecha_entrega) {
            $orden->fecha_entrega = now();
        }

        $orden->save();

        $this->procesarYGuardarImagenes($request, $orden);

        return redirect()->route('ordenes.index')->with('success', 'Orden actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orden = OrdenServicio::findOrFail($id);
        $orden->delete();

        return redirect()->route('ordenes.index')->with('success', 'Orden eliminada con éxito.');
    }

    /**
     * Guarda imágenes en public/img y persiste su ruta en base de datos.
     */
    private function procesarYGuardarImagenes(Request $request, OrdenServicio $orden)
    {
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                if ($file->isValid()) {
                    try {
                        $storedFileName = $file->store('', 'public_img');

                        Imagen::create([
                            'orden_id' => $orden->id,
                            'datos_imagen' => 'img/' . $storedFileName,
                        ]);

                    } catch (\Exception $e) {
                        // Si falla el guardado, continuamos con la siguiente.
                        continue;
                    }
                }
            }
        }
    }

    /**
     * Crea la orden inicial y genera el número definitivo basado en ID.
     */
    private function crearOrdenServicio(int $clienteId, int $equipoId, string $fallaReportada, ?string $observaciones, ?string $accesorios): OrdenServicio
    {
        $orden = new OrdenServicio();
        // Asignamos un temporal único para poder guardar y obtener el ID
        $orden->numero_orden = (string) Str::uuid();
        $orden->cliente_id = $clienteId;
        $orden->equipo_id = $equipoId;
        $orden->usuario_id = Auth::id();
        $orden->estado = 'Recibido';
        $orden->accesorios = $accesorios;
        $orden->falla_reportada = $fallaReportada;
        $orden->observaciones = $observaciones;
        $orden->fecha_recepcion = now();
        $orden->save();

        // Actualizamos con el formato OS-00001 basado en el ID real
        $orden->numero_orden = 'OS-' . str_pad($orden->id, 5, '0', STR_PAD_LEFT);
        $orden->save();

        return $orden;
    }
}
