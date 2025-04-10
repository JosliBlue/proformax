@extends('appsita')

@section('content')
    <div class="md:p-6 bg-white md:rounded-xl md:shadow-md">
        @if (isset($user))
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Editar usuario</h2>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Nuevo usuario</h2>
        @endif

        <form action="{{ isset($user) ? route('sellers.update', $user->id) : route('sellers.store') }}"
            method="POST" class="space-y-6" autocomplete="on">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            {{-- Protección contra bots --}}
            <div class="hidden" aria-hidden="true">
                <label for="website">Sitio web</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Usuario --}}
                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Usuario *</label>
                    <input type="text" name="user_name" id="user_name"
                        value="{{ old('user_name', $user->user_name ?? '') }}" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('user_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="user_email" id="user_email"
                        value="{{ old('user_email', $user->user_email ?? '') }}" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('user_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="user_password" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ isset($user) ? 'Nueva Contraseña' : 'Contraseña *' }}
                    </label>
                    <input type="password" name="user_password" id="user_password"
                        {{ isset($user) ? '' : 'required' }}
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('user_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar Contraseña --}}
                <div>
                    <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ isset($user) ? 'Confirmar Nueva Contraseña' : 'Confirmar Contraseña *' }}
                    </label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation"
                        {{ isset($user) ? '' : 'required' }}
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                </div>
            </div>

            {{-- Botón Guardar --}}
            <div class="pt-4 flex justify-end space-x-3">
                <a href="{{ route('sellers') }}"
                    class="inline-flex justify-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    {{ isset($user) ? 'Actualizar Usuario' : 'Guardar Usuario' }}
                </button>
            </div>
        </form>
    </div>
@endsection
