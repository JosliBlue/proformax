@extends('appsita')

@section('content')
    <div class="flex items-center justify-center px-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-10 max-w-md w-full text-center">
            <div class="flex justify-center mb-6">
                <span class="iconify text-7xl text-red-500" data-icon="mdi:account-off"></span>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-3">Cuenta desactivada</h2>
            <p class="text-md text-gray-600 dark:text-gray-300 leading-relaxed">
                Tu cuenta ha sido desactivada temporalmente. Por favor, contacta con tu gerente para reactivar el acceso.
            </p>

            <a href="{{ route('profile') }}"
                class="mt-6 inline-block w-full px-6 py-3 bg-[var(--primary-color)] text-white font-semibold rounded-lg hover:bg-opacity-90 transition-all duration-300">
                Ir a mi perfil
            </a>
        </div>
    </div>
@endsection
