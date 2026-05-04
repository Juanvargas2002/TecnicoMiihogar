@extends('layouts.admin')

@section('content')
<section class="section is-title-bar">
    <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <ul>
                    <li><span class="text-gray-500">Admin</span> <span class="mx-2">/</span> <span class="font-semibold text-gray-800">Perfil</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="p-6 space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</section>
@endsection
