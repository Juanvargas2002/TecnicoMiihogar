@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <ul>
            <li>Clientes</li>
        </ul>
        <div class="flex flex-wrap gap-2 justify-end">
            <a href="{{ route('clientes.create') }}" class="button green whitespace-nowrap">
                <span class="icon"><i class="mdi mdi-plus"></i></span>
                <span>Nuevo Cliente</span>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <livewire:clientes.index />
</section>
@endsection