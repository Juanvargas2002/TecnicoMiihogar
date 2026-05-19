<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Mi Hogar</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo_1.png') }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo_32_21.png') }}"/>
 
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: #f8fafc;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #e3e3e0;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1b1b18;
        }
        .numero-orden {
            font-size: 18px;
            color: #3b82f6;
            font-weight: 600;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1b1b18;
            margin-bottom: 15px;
            border-left: 4px solid #10b981;
            padding-left: 12px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e3e3e0;
            font-size: 14px;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
        }
        .info-value {
            color: #1b1b18;
            text-align: right;
            max-width: 50%;
            word-break: break-word;
        }
        .estado-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .estado-recibido {
            background: #dbeafe;
            color: #1e40af;
        }
        .estado-diagnostico {
            background: #fef3c7;
            color: #92400e;
        }
        .estado-reparacion {
            background: #fed7aa;
            color: #9a3412;
        }
        .estado-completado {
            background: #dcfce7;
            color: #166534;
        }
        .estado-entregado {
            background: #d1fae5;
            color: #065f46;
        }
        .estado-cancelado {
            background: #fee2e2;
            color: #991b1b;
        }
        .back-link {
            text-align: center;
            margin-top: 30px;
        }
        .back-link a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .imágenes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }
        .imagen-item {
            border: 1px solid #e3e3e0;
            border-radius: 4px;
            overflow: hidden;
            background: #f8fafc;
        }
        .imagen-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Estado de tu Orden</h1>
            <div class="numero-orden">{{ $orden->numero_orden }}</div>
        </div>

        <!-- Información General -->
        <div class="section">
            <div class="section-title">Información de la Orden</div>
            <div class="info-row">
                <span class="info-label">Estado Actual:</span>
                <span class="info-value">
                    <span class="estado-badge estado-{{ strtolower(str_replace(' ', '-', $orden->estado)) }}">
                        {{ $orden->estado }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Recepción:</span>
                <span class="info-value">{{ $orden->fecha_recepcion ? $orden->fecha_recepcion : 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Entrega:</span>
                <span class="info-value">{{ $orden->fecha_entrega ? $orden->fecha_entrega : 'En proceso' }}</span>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="section">
            <div class="section-title">Datos del Cliente</div>
            <div class="info-row">
                <span class="info-label">Nombre:</span>
                <span class="info-value">{{ $orden->cliente->nombre }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cédula:</span>
                <span class="info-value">{{ $orden->cliente->documento }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $orden->cliente->telefono ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $orden->cliente->email ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Información del Equipo -->
        <div class="section">
            <div class="section-title">Equipo a Reparar</div>
            <div class="info-row">
                <span class="info-label">Producto:</span>
                <span class="info-value">{{ $orden->equipo->producto }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Marca:</span>
                <span class="info-value">{{ $orden->equipo->marca }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Modelo:</span>
                <span class="info-value">{{ $orden->equipo->modelo ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Serial:</span>
                <span class="info-value">{{ $orden->equipo->serial ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Detalles de la Reparación -->
        <div class="section">
            <div class="section-title">Detalles de la Reparación</div>
            <div class="info-row" style="display: block;">
                <span class="info-label">Falla Reportada:</span>
                <div style="color: #1b1b18; margin-top: 8px; font-size: 14px;">{{ $orden->falla_reportada }}</div>
            </div>
            @if ($orden->diagnostico)
                <div class="info-row" style="display: block; border-top: 1px solid #e3e3e0; padding-top: 12px; margin-top: 12px;">
                    <span class="info-label">Diagnóstico:</span>
                    <div style="color: #1b1b18; margin-top: 8px; font-size: 14px;">{{ $orden->diagnostico }}</div>
                </div>
            @endif
            @if ($orden->solucion)
                <div class="info-row" style="display: block; border-top: 1px solid #e3e3e0; padding-top: 12px; margin-top: 12px;">
                    <span class="info-label">Solución Realizada:</span>
                    <div style="color: #1b1b18; margin-top: 8px; font-size: 14px;">{{ $orden->solucion }}</div>
                </div>
            @endif
            @if ($orden->accesorios)
                <div class="info-row" style="display: block; border-top: 1px solid #e3e3e0; padding-top: 12px; margin-top: 12px;">
                    <span class="info-label">Accesorios:</span>
                    <div style="color: #1b1b18; margin-top: 8px; font-size: 14px;">{{ $orden->accesorios }}</div>
                </div>
            @endif
            @if ($orden->observaciones)
                <div class="info-row" style="display: block; border-top: 1px solid #e3e3e0; padding-top: 12px; margin-top: 12px;">
                    <span class="info-label">Observaciones:</span>
                    <div style="color: #1b1b18; margin-top: 8px; font-size: 14px;">{{ $orden->observaciones }}</div>
                </div>
            @endif
        </div>

        <!-- Imágenes -->
        @if ($orden->imagenes && $orden->imagenes->count() > 0)
            <div class="section">
                <div class="section-title">Imágenes del Equipo</div>
                <div class="imágenes-grid">
                    @foreach ($orden->imagenes as $imagen)
                        <div class="imagen-item">
                            <img src="{{ asset($imagen->datos_imagen) }}" alt="Imagen de la orden">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="back-link">
            <a href="{{ route('ordenes.seguimiento') }}">← Realizar otra búsqueda</a>
        </div>
    </div>
</body>
</html>
