<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante {{ $orden->numero_orden }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0px 24px 24px 24px;
        }

        .header {
            border: 1px solid #d1d5db;
            padding: 12px;
            margin-bottom: 14px;
        }

        .company-strip {
            border: 1px solid #111827;
            margin-bottom: 12px;
            font-size: 11px;
        }

        .company-strip table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-strip td {
            padding: 6px 8px;
            border-bottom: 1px solid #111827;
            vertical-align: middle;
        }

        .company-strip tr:last-child td {
            border-bottom: none;
        }

        .company-label {
            font-weight: bold;
            font-style: italic;
            white-space: nowrap;
            width: 12%;
        }

        .company-value {
            width: 48%;
        }

        .company-value-right {
            width: 40%;
        }

        .title {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }

        .subtitle {
            margin: 4px 0 0;
            color: #4b5563;
        }

        .badge {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 8px;
            border: 1px solid #9ca3af;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }

        .section {
            border: 1px solid #d1d5db;
            margin-bottom: 12px;
        }

        .section-title {
            background: #f3f4f6;
            border-bottom: 1px solid #d1d5db;
            padding: 8px 10px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px 10px;
            vertical-align: top;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .label {
            width: 36%;
            font-weight: bold;
            color: #374151;
        }

        .value {
            color: #111827;
        }

        .box {
            border: 1px solid #e5e7eb;
            margin: 8px 10px 12px;
            padding: 8px;
            min-height: 24px;
            background: #fafafa;
            line-height: 1.45;
            height: fit-content;
        }

        .notice {
            border: 1px dashed #9ca3af;
            padding: 10px;
            font-size: 11px;
            line-height: 1.45;
            margin-bottom: 14px;
            background: #fffbeb;
        }

        .signatures {
            margin-top: 26px;
            width: 100%;
        }

        .signature-box {
            width: 47%;
            display: inline-block;
            vertical-align: top;
            margin-right: 3%;
        }

        .signature-box:last-child {
            margin-right: 0;
        }

        .signature-line {
            border-top: 1px solid #111827;
            margin-top: 55px;
            padding-top: 6px;
            text-align: center;
            font-size: 11px;
            color: #374151;
        }

        .footer {
            margin-top: 22px;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <!-- Agregar logo arriba de todo -->
    <div class="logo">
        <img src="logo_1.png" alt="company logo" style="max-width: 100px; height: auto;">
    </div>
    
    <div class="company-strip">
        <table>
            <tr>
                <td colspan="3"><strong>Centro de Servicio Autorizado:</strong> SERVICIOS TECNICOS MI HOGAR</td>
            </tr>
            <tr>
                <td class="company-label">Direccion:</td>
                <td class="company-value">Cra 12 # 31 - 04 CENTRO MONTERIA</td>
                <td class="company-value-right"><strong>Ciudad:</strong> MONTERIA (CORDOBA)</td>
            </tr>
            <tr>
                <td class="company-label">Telefono(s):</td>
                <td class="company-value">3206155009 (Marlon Tecnico) - 3192324891 (Katia Recepcion)</td>
                <td class="company-value-right"><strong>Departamento:</strong> Cordoba</td>
            </tr>
        </table>
    </div>

    <div class="header">
        <h1 class="title">Comprobante de Recepcion de Equipo</h1>
        <p class="subtitle">Documento para retirar el electrodomestico al finalizar el servicio.</p>
        <div class="badge">Orden: {{ $orden->numero_orden }}</div>
    </div>

    <div class="section">
        <div class="section-title">Datos de la Orden</div>
        <table>
            <tr>
                <td class="label">Numero de orden</td>
                <td class="value">{{ $orden->numero_orden }}</td>
            </tr>
            <tr>
                <td class="label">Fecha y hora de recepcion</td>
                <td class="value">{{ $orden->fecha_recepcion ? \Carbon\Carbon::parse($orden->fecha_recepcion)->format('d/m/Y h:i A') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Estado actual</td>
                <td class="value">{{ strtoupper($orden->estado) }}</td>
            </tr>
            <tr>
                <td class="label">Recibido por</td>
                <td class="value">{{ $orden->usuario?->name ?? 'Sin asignar' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Datos del Cliente</div>
        <table>
            <tr>
                <td class="label">Nombre</td>
                <td class="value">{{ $orden->cliente->nombre }}</td>
            </tr>
            <tr>
                <td class="label">Cedula/Documento</td>
                <td class="value">{{ $orden->cliente->documento ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Correo</td>
                <td class="value">{{ $orden->cliente->email ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Telefono</td>
                <td class="value">{{ $orden->cliente->telefono ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Direccion</td>
                <td class="value">{{ $orden->cliente->direccion ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Datos del Equipo</div>
        <table>
            <tr>
                <td class="label">Producto</td>
                <td class="value">{{ $orden->equipo->producto}}</td>
            </tr>
            <tr>
                <td class="label">Marca / Modelo</td>
                <td class="value">{{ $orden->equipo->marca}} {{ $orden->equipo->modelo ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Serial</td>
                <td class="value">{{ $orden->equipo->serial ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <div class="section-title" style="border-top: 1px solid #d1d5db;">Falla Reportada</div>
        <div class="box">{{ $orden->falla_reportada }}</div>
    </div>

    @if($orden->accesorios)
    <div class="section">
        <div class="section-title" style="border-top: 1px solid #d1d5db;">Accesorios Registrados</div>
        <div class="box">{{ $orden->accesorios }}</div>
    </div>
    @endif

    @if($orden->observaciones)
    <div class="section">
            <div class="section-title" style="border-top: 1px solid #d1d5db;">Observaciones</div>
            <div class="box">{{ $orden->observaciones }}</div>    
    </div>
    @endif

    <div class="notice">
        <strong>Condiciones aceptadas por el cliente:</strong><br>
        1. El cliente declara haber realizado una copia de seguridad de su informacion. El servicio tecnico no se hace responsable por la perdida de datos derivada del proceso de reparacion o fallas de hardware.<br><br>
        2. El cliente acepta que, durante el proceso de revision, pueden manifestarse fallas ocultas no detectadas inicialmente. En equipos con daños por liquido o golpes severos, existe el riesgo de que el dispositivo no vuelva a encender.<br><br>
        3. Transcurridos 30 dias calendario a partir de la notificacion de finalizacion del servicio, si el equipo no es retirado, se cobrara una tarifa diaria por bodegaje. Pasados 90 dias, el equipo se considerara en abandono y el taller podra disponer del mismo para recuperar costos de reparacion y almacenamiento.
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">
                Firma del cliente
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Firma y sello de recepcion
            </div>
        </div>
    </div>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y h:i A') }}
    </div>
</body>
</html>
