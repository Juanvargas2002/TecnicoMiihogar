@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex justified-between items-center">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li>Panel de Control</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="p-6">
    @if (auth()->check())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @if (auth()->user()->rol === 'Administrador')
            <a href="{{ route('usuarios.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 rounded-full group-hover:bg-blue-200 transition-colors">
                        <i class="mdi mdi-account text-3xl text-blue-600"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-blue-700 transition-colors">Usuarios</h5>
                        <p class="font-normal text-sm text-gray-600">Gestión de usuarios del sistema</p>
                    </div>
                </div>
            </a>
        @endif

        @if (auth()->user()->rol === 'Administrador' || auth()->user()->rol === 'Recepcionista')
            <a href="{{ route('clientes.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 rounded-full group-hover:bg-green-200 transition-colors">
                        <i class="mdi mdi-account-multiple text-3xl text-green-600"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-green-700 transition-colors">Clientes</h5>
                        <p class="font-normal text-sm text-gray-600">Administración de clientes</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('equipos.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-yellow-100 rounded-full group-hover:bg-yellow-200 transition-colors">
                        <i class="mdi mdi-laptop text-3xl text-yellow-600"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-yellow-700 transition-colors">Equipos</h5>
                        <p class="font-normal text-sm text-gray-600">Gestión de equipos</p>
                    </div>
                </div>
            </a>
        @endif

        <a href="{{ route('ordenes.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-indigo-100 rounded-full group-hover:bg-indigo-200 transition-colors">
                    <i class="mdi mdi-file-document-box-multiple text-3xl text-indigo-600"></i>
                </div>
                <div>
                    <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-indigo-700 transition-colors">Órdenes de Servicio</h5>
                    <p class="font-normal text-sm text-gray-600">Ver y crear órdenes de servicio</p>
                </div>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-50 transition duration-300 transform hover:-translate-y-1 hover:shadow-xl cursor-pointer">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gray-100 rounded-full group-hover:bg-gray-200 transition-colors">
                    <i class="mdi mdi-account-circle text-3xl text-gray-600"></i>
                </div>
                <div>
                    <h5 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 group-hover:text-gray-700 transition-colors">Perfil</h5>
                    <p class="font-normal text-sm text-gray-600">Configuración de cuenta</p>
                </div>
            </div>
        </a>

    </div>
    @endif
</section>

@endsection

