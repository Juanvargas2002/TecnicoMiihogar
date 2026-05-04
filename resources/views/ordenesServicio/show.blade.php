@extends('layouts.admin')

@section('content')

<section class="section is-title-bar">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Órdenes de Servicio</li>
                    <li>Orden #{{ $orden->numero_orden }}</li>
                </ul>
            </div>
        </div>
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="buttons is-right">
                    <a href="{{ route('ordenes.index') }}" class="button">
                        <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                        <span>Volver</span>
                    </a>
                    <a href="{{ route('ordenes.pdf', $orden) }}" class="button green" target="_blank" rel="noopener">
                        <span class="icon"><i class="mdi mdi-file-pdf-box"></i></span>
                        <span>Descargar Comprobante</span>
                    </a>
                    <a href="{{ route('ordenes.edit', $orden->id) }}" class="button orange">
                        <span class="icon"><i class="mdi mdi-pencil"></i></span>
                        <span>Editar / Diagnosticar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="columns">
        <div class="column is-8">
            <div class="card mb-6">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-clipboard-text"></i></span>
                        Detalles de la Orden
                    </p>
                    <div class="card-header-icon">
                        <span class="tag is-medium is-{{ $orden->estado == 'entregado' ? 'success' : ($orden->estado == 'reparado' ? 'success' : ($orden->estado == 'diagnosticado' ? 'warning' : 'info')) }}">
                            {{ strtoupper($orden->estado) }}
                        </span>
                    </div>
                </header>
                <div class="card-content">
                    <div class="field">
                        <label class="label">Falla Reportada</label>
                        <div class="control">
                            <div class="box has-background-light">
                                {{ $orden->falla_reportada }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Accesorios</label>
                        <div class="control">
                            <div class="box has-background-light">
                                {{ $orden->accesorios ?? 'Ninguno' }}
                            </div>
                        </div>
                    </div>

                    @if($orden->diagnostico)
                    <div class="field">
                        <label class="label">Diagnóstico Técnico</label>
                        <div class="control">
                            <div class="box has-background-warning-light">
                                {{ $orden->diagnostico }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($orden->solucion)
                    <div class="field">
                        <label class="label">Solución Aplicada</label>
                        <div class="control">
                            <div class="box has-background-success-light">
                                {{ $orden->solucion }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($orden->observaciones)
                    <div class="field">
                        <label class="label">Observaciones</label>
                        <div class="control">
                            <p>{{ $orden->observaciones }}</p>
                        </div>
                    </div>
                    @endif

                    @if($orden->imagenes->count() > 0)
                    <hr>
                    <div class="field">
                        <label class="label">Imágenes Adjuntas</label>
                        <!-- Grid usando Tailwind CSS -->
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($orden->imagenes as $img)
                                <div class="relative group">
                                    <div class="aspect-w-4 aspect-h-3 w-full h-32 overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($img->datos_imagen, 'img/') ? asset($img->datos_imagen) : 'data:image/jpeg;base64,' . $img->datos_imagen }}" 
                                             alt="Imagen Orden" 
                                             class="w-full h-full object-cover cursor-pointer modal-button" 
                                             data-target="modal-image-{{ $img->id }}">
                                    </div>
                                    
                                    <!-- Modal personalizado (CSS al final) -->
                                    <div id="modal-image-{{ $img->id }}" class="modal">
                                        <div class="modal-background"></div>
                                        <div class="modal-content relative bg-white p-2 rounded shadow-lg" style="max-width: 90vw; max-height: 90vh;">
                                            <p class="image flex justify-center">
                                                <img src="{{ \Illuminate\Support\Str::startsWith($img->datos_imagen, 'img/') ? asset($img->datos_imagen) : 'data:image/jpeg;base64,' . $img->datos_imagen }}" alt="" style="max-height: 85vh; width: auto;">
                                            </p>
                                        </div>
                                        <button class="modal-close is-large" aria-label="close"></button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Estilos mínimos para que funcione el modal y grid sin Bulma -->
                        <style>
                            .modal {
                                display: none;
                                align-items: center;
                                justify-content: center;
                                flex-direction: column;
                                overflow: hidden;
                                position: fixed;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                top: 0;
                                z-index: 40;
                            }
                            .modal.is-active {
                                display: flex;
                            }
                            .modal-background {
                                background-color: rgba(10, 10, 10, 0.86);
                                bottom: 0;
                                left: 0;
                                position: absolute;
                                right: 0;
                                top: 0;
                            }
                            .modal-content {
                                margin: 0 auto;
                                max-height: calc(100vh - 40px);
                                width: 640px;
                                z-index: 50;
                            }
                            .modal-close {
                                background: 0 0;
                                height: 40px;
                                position: fixed;
                                right: 20px;
                                top: 20px;
                                width: 40px;
                                border: none;
                                border-radius: 50%;
                                cursor: pointer;
                                display: inline-block;
                                flex-grow: 0;
                                flex-shrink: 0;
                                font-size: 0;
                                outline: 0;
                                vertical-align: top;
                                z-index: 60;
                            }
                            .modal-close:before, .modal-close:after {
                                background-color: #fff;
                                content: "";
                                display: block;
                                left: 50%;
                                position: absolute;
                                top: 50%;
                                transform: translateX(-50%) translateY(-50%) rotate(45deg);
                                transform-origin: center center;
                            }
                            .modal-close:before { height: 2px; width: 50%; }
                            .modal-close:after { height: 50%; width: 2px; }
                        </style>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="column is-4">
            <div class="card mb-6">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-account"></i></span>
                        Cliente & Equipo
                    </p>
                </header>
                <div class="card-content">
                    <div class="field">
                        <label class="label is-small">Cliente</label>
                        <p class="is-size-5 has-text-weight-bold">{{ $orden->cliente->nombre }}</p>
                        <p class="is-size-7">{{ $orden->cliente->documento }}</p>
                        <p class="is-size-7"><a href="tel:{{ $orden->cliente->telefono }}">{{ $orden->cliente->telefono }}</a></p>
                    </div>
                    <hr>
                    <div class="field">
                        <label class="label is-small">Equipo</label>
                        <p><strong>{{ $orden->equipo->tipo_equipo }}</strong></p>
                        <p>{{ $orden->equipo->marca }} {{ $orden->equipo->modelo }}</p>
                        <p class="is-size-7 text-gray-500">S/N: {{ $orden->equipo->serial ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-calendar-clock"></i></span>
                        Tiempos
                    </p>
                </header>
                <div class="card-content">
                    <div class="field">
                        <label class="label is-small">Fecha Recepción</label>
                        <p>{{ $orden->fecha_recepcion ? \Carbon\Carbon::parse($orden->fecha_recepcion)->format('d/m/Y h:i A') : '-' }}</p>
                    </div>
                    @if($orden->fecha_entrega)
                    <div class="field">
                        <label class="label is-small">Fecha Entrega</label>
                        <p class="has-text-success">{{ \Carbon\Carbon::parse($orden->fecha_entrega)->format('d/m/Y h:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Functions to open and close a modal
        function openModal(el) {
            el.classList.add('is-active');
        }

        function closeModal(el) {
            el.classList.remove('is-active');
        }

        function closeAllModals() {
            (document.querySelectorAll('.modal') || []).forEach((modal) => {
                closeModal(modal);
            });
        }

        // Add a click event on buttons to open a specific modal
        (document.querySelectorAll('.modal-button') || []).forEach((trigger) => {
            const modal = trigger.dataset.target;
            const target = document.getElementById(modal);

            trigger.addEventListener('click', () => {
                openModal(target);
            });
        });

        // Add a click event on various child elements to close the parent modal
        (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach((close) => {
            const target = close.closest('.modal');

            close.addEventListener('click', () => {
                closeModal(target);
            });
        });

        // Add a keyboard event to close all modals
        document.addEventListener('keydown', (event) => {
            if (event.code === 'Escape') {
                closeAllModals();
            }
        });
    });
</script>
@endpush
