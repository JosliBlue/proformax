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
            // Determinar qué estamos actualizando basado en el botón presionado
            $updateType = $request->input('update_type');

            if ($updateType === 'name') {
                return $this->updateName($request, $user);
            } else {
                return $this->updatePassword($request, $user);
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar: ' . $e->getMessage());
        }
    }

    private function updateName(Request $request, $user)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
        ], [
            'user_name.required' => 'El nombre es obligatorio',
            'user_name.max' => 'El nombre no puede tener más de 100 caracteres',
        ]);

        $user->update(['user_name' => $validated['user_name']]);

        return redirect()->route('home')->with('success', 'Nombre actualizado correctamente.');
    }

    private function updatePassword(Request $request, $user)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'user_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'user_password.required' => 'La nueva contraseña es obligatoria',
            'user_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'user_password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if (!Hash::check($validated['current_password'], $user->user_password)) {
            return back()
                ->withInput()
                ->with('error', 'La contraseña actual no es correcta');
        }

        $user->update(['user_password' => Hash::make($validated['user_password'])]);

        return redirect()->route('home')->with('success', 'Contraseña actualizada correctamente.');
    }
}
