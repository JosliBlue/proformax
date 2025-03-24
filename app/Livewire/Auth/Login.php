<?php

namespace App\Livewire\Auth;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Login extends Component
{
    // Propiedades públicas
    public $user_email;
    public $user_password;
    public $showEmailInput = true; // Controla si se muestra el input de correo
    public $showPasswordInput = false; // Controla si se muestra el input de contraseña
    public $showBackButton = false; // Controla si se muestra la flecha hacia atrás
    public $error;



    // Método para avanzar al input de contraseña
    public function goToPassword()
    {
        // Validar el correo electrónico
        $this->validate([
            'user_email' => 'required|email',
        ]);

        // Ocultar el input de correo y mostrar el de contraseña
        $this->showEmailInput = false;
        $this->showPasswordInput = true;
        $this->showBackButton = true;
    }

    // Método para retroceder al input de correo
    public function goBackToEmail()
    {
        // Ocultar el input de contraseña y mostrar el de correo
        $this->showPasswordInput = false;
        $this->showEmailInput = true;
        $this->showBackButton = false;
    }

    // Método para manejar el login
    public function login()
    {
        // Validar el formulario completo
        $this->validate([
            'user_email' => 'required|email',
            'user_password' => 'required',
        ]);

        // Intentar autenticar al usuario
        $credentials = [
            'user_email' => $this->user_email,
            'password' => $this->user_password,
        ];

        if (Auth::attempt($credentials)) {
            // Redirigir al dashboard después del login
            return redirect()->route('home');
        } else {
            // Mostrar error si las credenciales son incorrectas
            $this->error = 'Credenciales incorrectas. Por favor, inténtalo de nuevo.';
        }
    }

    public function render()
    {
        return view('components.livewire.auth.login');
    }
}
