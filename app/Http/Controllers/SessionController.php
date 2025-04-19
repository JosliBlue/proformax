<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'user_email' => 'required|email',
                'user_password' => 'required',
            ]);

            $credentials = [
                'user_email' => $request->user_email,
                'password' => $request->user_password,
            ];

            if (Auth::attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                return redirect()->route('home');
            }

            return back()->with('error', 'Credenciales incorrectas. Por favor, inténtalo de nuevo.');
        } catch (ValidationException $e) {
            // Captura los errores de validación y los convierte en toast
            $errors = $e->errors();
            $firstError = reset($errors)[0];
            return back()->with('error', $firstError);
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error inesperado. Por favor intente nuevamente.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
