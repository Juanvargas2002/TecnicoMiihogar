@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <ul>
            <li>Órdenes de Servicio</li>
        </ul>
        <div class="flex flex-wrap gap-2 justify-end">
            <a href="{{ route('ordenes.create') }}" class="button green whitespace-nowrap">
                <span class="icon"><i class="mdi mdi-plus-box"></i></span>
                <span>Nueva Orden</span>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <livewire:ordenes-servicio.index />
</section>
@endsection