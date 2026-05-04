@extends('layouts.admin')

@section('content')
@php
    $metodoRegistro = old('metodo_registro', 'orden_existente');
    $clienteSeleccionadoId = old('cliente_id', request('cliente_id'));
    $clienteSeleccionado = $clientes->firstWhere('id', (int) $clienteSeleccionadoId);
    $clientesBuscador = $clientes->map(function ($cliente) {
        return [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'documento' => (string) $cliente->documento,
        ];
    })->values();
@endphp

<div class="card mb-6">
    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-plus-box"></i></span>
            Nueva Orden de Servicio
        </p>
    </header>
    <div class="card-content">
        <form method="POST" action="{{ route('ordenes.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="metodo_registro" id="metodo_registro" value="{{ $metodoRegistro }}">

            <div class="field mb-5">
                <label class="label">Método de Registro</label>
                <div class="buttons has-addons">
                    <button type="button" class="button blue js-metodo-btn {{ $metodoRegistro === 'orden_existente' ? 'is-info is-selected' : '' }}" data-metodo="orden_existente">
                        Solo registrar orden
                    </button>
                    <button type="button" class="button orange js-metodo-btn {{ $metodoRegistro === 'registro_completo' ? 'is-info is-selected' : '' }}" data-metodo="registro_completo">
                        Registrar cliente + equipo + orden
                    </button>
                </div>
                <p class="help">Elige "solo orden" si el cliente y equipo ya existen. Elige "registro completo" para crear todo en una sola acción.</p>
            </div>

            <div id="seccion-orden-existente" style="display: {{ $metodoRegistro === 'orden_existente' ? 'block' : 'none' }};">
                <div class="field">
                    <label class="label">1. Seleccione Cliente</label>
                    <div class="control">
                        <input type="hidden" name="cliente_id" id="cliente_id" value="{{ $clienteSeleccionadoId }}">
                        <input
                            type="text"
                            id="cliente_search"
                            class="input"
                            placeholder="Escriba al menos 3 dígitos de la cédula"
                            autocomplete="off"
                            value="{{ $clienteSeleccionado ? $clienteSeleccionado->nombre . ' - ' . $clienteSeleccionado->documento : '' }}"
                        >
                        <p class="help" id="cliente_hint">Escriba 3 o más dígitos de la cédula para buscar.</p>
                        <div id="cliente_options" class="box mt-2" style="display: none; max-height: 240px; overflow-y: auto; padding: 0;">
                            <div id="cliente_results"></div>
                        </div>
                    </div>
                    @error('cliente_id')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">2. Seleccione Equipo</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="equipo_id" {{ $equipos->isEmpty() ? 'disabled' : '' }}>
                                <option value="">
                                    @if(request('cliente_id') || old('cliente_id'))
                                        {{ $equipos->isEmpty() ? '-- Este cliente no tiene equipos registrados --' : '-- Seleccionar Equipo --' }}
                                    @else
                                        -- Primero seleccione un cliente --
                                    @endif
                                </option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id }}" {{ old('equipo_id') == $equipo->id ? 'selected' : '' }}>
                                        {{ $equipo->producto }} - {{ $equipo->marca }} {{ $equipo->modelo }} ({{ $equipo->serial ?? 'S/N' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if((request('cliente_id') || old('cliente_id')) && $equipos->isEmpty())
                            <p class="help is-warning">
                                <a href="{{ route('equipos.create', ['cliente_id' => request('cliente_id', old('cliente_id'))]) }}">Registrar un equipo para este cliente</a>
                            </p>
                        @endif
                    </div>
                    @error('equipo_id')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="seccion-registro-completo" style="display: {{ $metodoRegistro === 'registro_completo' ? 'block' : 'none' }};">
                <div class="notification light">
                    El sistema registrará en este orden: cliente, luego equipo y finalmente la orden de servicio.
                </div>

                <h2 class="label">1. Datos del Cliente</h2>
                @include('ordenesServicio.RegistroCompleto.cliente')

                <br>

                <h2 class="label">2. Datos del Equipo</h2>
                @include('ordenesServicio.RegistroCompleto.equipo')
                
            </div>
            
            <br>

            <div class="field">
                <label class="label">3. Falla Reportada</label>
                <div class="control">
                    <textarea class="textarea" name="falla_reportada" placeholder="Describe el problema que presenta el equipo..." required>{{ old('falla_reportada') }}</textarea>
                </div>
                @error('falla_reportada')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="label">Accesorios (Opcional)</label>
                <div class="control">
                    <textarea class="textarea" name="accesorios" placeholder="Cargador, mouse, teclado, control etc.">{{ old('accesorios') }}</textarea>
                </div>
            </div>
            
            <div class="field">
                <label class="label">Observaciones Adicionales (Opcional)</label>
                <div class="control">
                    <textarea class="textarea" name="observaciones" placeholder="pantalla rayada, Stickers pegados, etc.">{{ old('observaciones') }}</textarea>
                </div>
            </div>

            <div class="field">
                <label class="label">Imágenes (Opcional)</label>
                <div class="control">
                    <div class="file has-name is-fullwidth">
                        <label class="file-label">
                            <input class="file-input" type="file" name="imagenes[]" multiple accept="image/*">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="mdi mdi-upload"></i>
                                </span>
                                <span class="file-label">
                                    Seleccionar imágenes…
                                </span>
                            </span>
                            <span class="file-name">
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
                        Crear Orden
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
@endsection
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const metodoInput = document.getElementById('metodo_registro');
        const seccionOrdenExistente = document.getElementById('seccion-orden-existente');
        const seccionRegistroCompleto = document.getElementById('seccion-registro-completo');
        const metodoButtons = document.querySelectorAll('.js-metodo-btn');
        const clientes = @json($clientesBuscador);
        const ordenesCreateUrl = '{{ route('ordenes.create') }}';

        const clienteIdInput = document.getElementById('cliente_id');
        const clienteSearch = document.getElementById('cliente_search');
        const clienteOptions = document.getElementById('cliente_options');
        const clienteResults = document.getElementById('cliente_results');
        const clienteHint = document.getElementById('cliente_hint');
        const equipoSelect = document.querySelector('select[name="equipo_id"]');
        const nombreCliente = document.querySelector('input[name="nombre"]');
        const producto = document.querySelector('input[name="producto"]');

        const ocultarOpcionesClientes = () => {
            if (clienteOptions) {
                clienteOptions.style.display = 'none';
            }
        };

        const limpiarResultadosClientes = () => {
            if (clienteResults) {
                clienteResults.innerHTML = '';
            }
        };

        const renderizarResultadosClientes = (items) => {
            limpiarResultadosClientes();

            if (!clienteResults) {
                return;
            }

            items.forEach((cliente) => {
                const opcion = document.createElement('button');
                opcion.type = 'button';
                opcion.className = 'button is-white is-fullwidth has-text-left';
                opcion.style.justifyContent = 'flex-start';
                opcion.style.borderRadius = '0';
                opcion.textContent = `${cliente.nombre} - ${cliente.documento}`;

                opcion.addEventListener('click', () => {
                    if (clienteIdInput) {
                        clienteIdInput.value = cliente.id;
                    }

                    if (clienteSearch) {
                        clienteSearch.value = `${cliente.nombre} - ${cliente.documento}`;
                    }

                    ocultarOpcionesClientes();
                    window.location.href = `${ordenesCreateUrl}?cliente_id=${cliente.id}`;
                });

                clienteResults.appendChild(opcion);
            });
        };

        const filtrarClientesPorCedula = (limpiarSeleccion = true) => {
            if (!clienteSearch) {
                return;
            }

            const query = clienteSearch.value.trim();
            const soloDigitos = query.replace(/\D/g, '');

            if (limpiarSeleccion && clienteIdInput) {
                clienteIdInput.value = '';
            }

            if (soloDigitos.length < 3) {
                limpiarResultadosClientes();
                ocultarOpcionesClientes();
                if (clienteHint) {
                    clienteHint.textContent = 'Escriba 3 o más dígitos de la cédula para buscar.';
                }
                return;
            }

            const clientesFiltrados = clientes
                .filter((cliente) => cliente.documento.includes(soloDigitos))
                .slice(0, 25);

            if (clienteHint) {
                clienteHint.textContent = clientesFiltrados.length
                    ? `Se encontraron ${clientesFiltrados.length} cliente(s). Seleccione uno de la lista.`
                    : 'No se encontraron clientes con esa cédula.';
            }

            if (!clientesFiltrados.length) {
                limpiarResultadosClientes();
                ocultarOpcionesClientes();
                return;
            }

            renderizarResultadosClientes(clientesFiltrados);
            if (clienteOptions) {
                clienteOptions.style.display = 'block';
            }
        };

        const actualizarMetodo = (metodo) => {
            metodoInput.value = metodo;
            const esOrdenExistente = metodo === 'orden_existente';

            seccionOrdenExistente.style.display = esOrdenExistente ? 'block' : 'none';
            seccionRegistroCompleto.style.display = esOrdenExistente ? 'none' : 'block';

            if (clienteSearch) {
                clienteSearch.required = esOrdenExistente;
            }

            if (equipoSelect) {
                equipoSelect.required = esOrdenExistente;
            }

            if (nombreCliente) {
                nombreCliente.required = !esOrdenExistente;
            }

            if (producto) {
                producto.required = !esOrdenExistente;
            }

            metodoButtons.forEach((button) => {
                const activo = button.dataset.metodo === metodo;
                button.classList.toggle('is-info', activo);
                button.classList.toggle('is-selected', activo);
            });
        };

        metodoButtons.forEach((button) => {
            button.addEventListener('click', () => {
                actualizarMetodo(button.dataset.metodo);
            });
        });

        if (clienteSearch) {
            clienteSearch.addEventListener('input', () => filtrarClientesPorCedula(true));
            clienteSearch.addEventListener('focus', () => filtrarClientesPorCedula(false));
        }

        document.addEventListener('click', (event) => {
            if (!clienteSearch || !clienteOptions) {
                return;
            }

            const hizoClickEnInput = clienteSearch.contains(event.target);
            const hizoClickEnOpciones = clienteOptions.contains(event.target);

            if (!hizoClickEnInput && !hizoClickEnOpciones) {
                ocultarOpcionesClientes();
            }
        });

        actualizarMetodo(metodoInput.value || 'orden_existente');

        const fileInput = document.querySelector('.file-input');
        if (fileInput) {
            fileInput.onchange = () => {
                if (fileInput.files.length > 0) {
                    const fileName = document.querySelector('.file-name');
                    const cantidad = fileInput.files.length;
                    fileName.textContent = cantidad + (cantidad === 1 ? ' archivo seleccionado' : ' archivos seleccionados');
                }
            };
        }
    });
</script>
