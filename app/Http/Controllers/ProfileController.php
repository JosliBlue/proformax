<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('_general.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'user_password' => 'required|string|min:8|confirmed',
            ], [
                'current_password.required' => 'La contraseña actual es obligatoria',
                'user_password.required' => 'La nueva contraseña es obligatoria',
                'user_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
                'user_password.confirmed' => 'Las contraseñas no coinciden',
            ]);

            // Verificar contraseña actual
            if (!Hash::check($validated['current_password'], $user->user_password)) {
                return back()
                    ->withInput()
                    ->with('error', 'La contraseña actual no es correcta');
            }

            // Actualizar contraseña
            $user->update([
                'user_password' => Hash::make($validated['user_password']),
            ]);

            return redirect()->route('profile')
                ->with('success', 'Contraseña actualizada correctamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar la contraseña: ' . $e->getMessage());
        }
    }
}
