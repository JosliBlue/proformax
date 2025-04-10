@extends('appsita')

@section('content')
    <div class="md:p-6 bg-white md:rounded-xl md:shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-200">Mi Perfil</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Información del usuario -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información del usuario</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Nombre:</span> {{ $user->user_name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $user->user_email }}</p>
                    <p><span class="font-medium">Rol:</span> {{ ucfirst($user->user_rol->value) }}</p>
                </div>
            </div>

            <!-- Estado de la cuenta -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Estado de la cuenta</h3>
                <span class="{{ $user->user_status ? 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800' : 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800' }}">
                    {{ $user->user_status ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>

        <!-- Formulario para cambiar contraseña -->
        <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar contraseña</h3>
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contraseña actual -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña actual *</label>
                    <input type="password" name="current_password" id="current_password" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Espacio vacío para alinear -->
                <div></div>

                <!-- Nueva contraseña -->
                <div>
                    <label for="user_password" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña *</label>
                    <input type="password" name="user_password" id="user_password" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                    @error('user_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar nueva contraseña -->
                <div>
                    <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar nueva contraseña *</label>
                    <input type="password" name="user_password_confirmation" id="user_password_confirmation" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border transition duration-150 ease-in-out">
                </div>
            </div>

            <!-- Botón Guardar -->
            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="inline-flex justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out shadow-sm">
                    Actualizar contraseña
                </button>
            </div>
        </form>
    </div>
@endsection
