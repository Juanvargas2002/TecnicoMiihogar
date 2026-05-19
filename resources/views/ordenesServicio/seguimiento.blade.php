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
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1b1b18;
        }
        .header p {
            color: #6b7280;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1b1b18;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e3e3e0;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-group input:focus {
            outline: none;
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }
        .btn-buscar {
            width: 100%;
            padding: 12px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-buscar:hover {
            background: #059669;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Seguimiento de Orden</h1>
            <p>Ingresa el número de tu orden y cédula para ver el estado</p>
        </div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">{{ $error }}</div>
            @endforeach
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('ordenes.buscar') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="numero_orden">Número de Orden</label>
                <input 
                    type="text" 
                    id="numero_orden" 
                    name="numero_orden" 
                    placeholder="OS-00001, 00001 o 1"
                    value="{{ old('numero_orden') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="cedula">Cédula del Cliente</label>
                <input 
                    type="text" 
                    id="cedula" 
                    name="cedula" 
                    placeholder="Ej: 1234567890"
                    value="{{ old('cedula') }}"
                    required
                >
            </div>

            <button type="submit" class="btn-buscar">Buscar Orden</button>
        </form>

        <div class="back-link">
            <a href="{{ route('welcome') }}">← Volver al inicio</a>
        </div>
    </div>
</body>
</html>
