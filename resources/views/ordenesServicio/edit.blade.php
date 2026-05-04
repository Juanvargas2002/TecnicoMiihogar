@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-pencil-box"></i></span>
            Gestionar Orden #{{ $orden->numero_orden }}
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('ordenes.update', $orden->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Cliente</label>
                        <div class="control">
                            <input class="input is-static" value="{{ $orden->cliente->nombre }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Producto</label>
                        <div class="control">
                            <input class="input is-static" value="{{ $orden->equipo->producto }} - {{ $orden->equipo->marca }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                 <label class="label">Falla Reportada Inicialmente</label>
                 <div class="control">
                     <textarea class="textarea is-static" readonly>{{ $orden->falla_reportada }}</textarea>
                 </div>
            </div>

            <div class="field">
                <label class="label">Accesorios</label>
                <div class="control">
                    <textarea class="textarea is-static" readonly>{{ $orden->accesorios ?? 'No hay accesorios registrados.' }}</textarea>
                </div>
            </div>
            
            <div class="field">
                <label class="label">Observaciones adicionales</label>
                <div class="control">
                    <textarea class="textarea is-static" readonly>{{ $orden->observaciones ?? 'No hay observaciones adicionales.' }}</textarea>
                </div>
            </div>

            <hr>
            <h4 class="title is-4">Diagnóstico y Solución</h4>

            <div class="field">
                <label class="label">Estado Actual</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select name="estado" required>
                            <option value="Recibido" {{ old('estado', $orden->estado) == 'Recibido' ? 'selected' : '' }}>Recibido</option>
                            <option value="Diagnosticado" {{ old('estado', $orden->estado) == 'Diagnosticado' ? 'selected' : '' }}>Diagnosticado</option>
                            <option value="Reparado" {{ old('estado', $orden->estado) == 'Reparado' ? 'selected' : '' }}>Reparado</option>
                            <option value="Entregado" {{ old('estado', $orden->estado) == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Diagnóstico Técnico</label>
                <div class="control">
                    <textarea class="textarea" name="diagnostico" placeholder="Diagnóstico técnico del equipo...">{{ old('diagnostico', $orden->diagnostico) }}</textarea>
                </div>
            </div>

            <div class="field">
                <label class="label">Solución / Reparación Realizada</label>
                <div class="control">
                    <textarea class="textarea" name="solucion" placeholder="Piezas cambiadas, procedimientos realizados...">{{ old('solucion', $orden->solucion) }}</textarea>
                </div>
            </div>

            <hr>

            <div class="field">
                <label class="label">Imágenes Adjuntas</label>
                @if($orden->imagenes->count() > 0)
                    <!-- Grid usando Tailwind CSS -->
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($orden->imagenes as $img)
                            <div class="relative group">
                                <div class="card h-full flex flex-col">
                                    <div class="card-image w-full h-32 overflow-hidden">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($img->datos_imagen, 'img/') ? asset($img->datos_imagen) : 'data:image/jpeg;base64,' . $img->datos_imagen }}" 
                                             alt="Imagen Orden" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <footer class="card-footer mt-auto p-2 text-center bg-white border-t">
                                         <button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold button-delete-image" data-id="{{ $img->id }}">
                                            Eliminar
                                         </button>
                                    </footer>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mb-4">No hay imágenes adjuntas.</p>
                @endif
            </div>

            <div class="field">
                <label class="label">Agregar Nuevas Imágenes</label>
                <div class="control">
                    <div class="file has-name is-fullwidth">
                        <label class="file-label flex items-center p-2 border rounded cursor-pointer bg-white hover:bg-gray-50">
                            <input class="file-input hidden" type="file" name="imagenes[]" multiple accept="image/*">
                            <span class="file-cta flex items-center mr-2 text-gray-700">
                                <span class="file-icon mr-2">
                                    <i class="mdi mdi-upload"></i>
                                </span>
                                <span class="file-label font-bold">
                                    Seleccionar imágenes…
                                </span>
                            </span>
                            <span class="file-name text-gray-500 italic text-sm">
                                No se han seleccionado archivos
                            </span>
                        </label>
                    </div>
                    @if($errors->has('imagenes'))
                        <p class="help is-danger">{{ $errors->first('imagenes') }}</p>
                    @endif
                    @if($errors->has('imagenes.*'))
                        <ul class="help is-danger">
                            @foreach($errors->get('imagenes.*') as $messages)
                                @foreach($messages as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <hr>

            <div class="field grouped">
                <div class="control">
                    <button type="submit" class="button green">
                        Actualizar Orden
                    </button>
                </div>
                <div class="control">
                    <a href="{{ route('ordenes.index') }}" class="button red">
                        Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($orden->imagenes as $img)
    <form id="delete-image-{{ $img->id }}" action="{{ route('imagenes.destroy', $img->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.button-delete-image');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                if(confirm('¿Estás seguro de eliminar esta imagen?')) {
                    const id = button.getAttribute('data-id');
                    document.getElementById('delete-image-' + id).submit();
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.querySelector('.file-input');
        if (fileInput) {
            fileInput.onchange = () => {
                if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('.file-name');
                    fileName.textContent = fileInput.files.length + ' archivos seleccionados';
                }
            };
        }
    });
</script>
