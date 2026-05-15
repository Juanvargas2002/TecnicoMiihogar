@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <ul>
            <li>Equipos</li>
        </ul>
        <div class="flex flex-wrap gap-2 justify-end">
            <a href="{{ route('equipos.create') }}" class="button green whitespace-nowrap">
                <span class="icon"><i class="mdi mdi-laptop-mac"></i></span>
                <span>Nuevo Equipo</span>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <livewire:equipos.index />
</section>
@endsection