<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $columns = [
            ['name' => 'Nombre', 'field' => 'user_name'],
            ['name' => 'Email', 'field' => 'user_email'],
            ['name' => 'Rol', 'field' => 'user_rol'],
            ['name' => 'Estado', 'field' => 'user_status']
        ];

        $sortField = request('sort', 'user_name');
        $sortDirection = request('direction', 'asc');
        $search = request('search');

        $query = User::where('user_rol', 'user'); // Solo usuarios normales

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                    ->orWhere('user_email', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return view("_admin.users.users", [
            'columns' => $columns,
            'data' => $data,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create()
    {
        // Solo mostramos el rol 'user' en el formulario
        $roles = UserRole::cases();
        return view('_admin.users.users-form', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                $this->getValidationRules(),
                $this->getValidationMessages()
            );

            // Forzamos el rol a 'user' y hasheamos la contraseña
            $validated['user_rol'] = 'user';
            $validated['user_password'] = bcrypt($validated['user_password']);

            User::create($validated);
            return redirect()->route('users')
                ->with('success', 'Usuario creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::where('user_rol', 'user')->findOrFail($id); // Solo usuarios normales
        $roles = [UserRole::USER]; // Solo mostramos el rol 'user'
        return view('_admin.users.users-form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::where('user_rol', 'user')->findOrFail($id); // Solo usuarios normales

            $rules = $this->getValidationRules($id);
            // Si no se proporciona contraseña, eliminamos la regla de validación
            if (empty($request->user_password)) {
                unset($rules['user_password']);
            }

            $validated = $request->validate($rules, $this->getValidationMessages());

            // Actualizamos solo los campos proporcionados
            $updateData = [
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
            ];

            // Solo actualizamos la contraseña si se proporcionó una nueva
            if (!empty($validated['user_password'])) {
                $updateData['user_password'] = bcrypt($validated['user_password']);
            }

            $user->update($updateData);

            return redirect()->route('users')
                ->with('success', 'Usuario actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('users')
                ->with('error', 'El usuario que intentas actualizar no existe.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function soft_destroy(string $id)
    {
        $user = User::where('user_rol', 'user')->findOrFail($id); // Solo usuarios normales
        $user->update(['user_status' => !$user->user_status]);

        return back()->with('success', $user->user_status ? 'Usuario activado' : 'Usuario desactivado');
    }

    public function destroy(string $id)
    {
        $user = User::where('user_rol', 'user')->findOrFail($id); // Solo usuarios normales
        $user->delete();
        return redirect()->route('users')->with('success', 'Usuario eliminado');
    }

    private function getValidationMessages()
    {
        return [
            'user_name.required' => 'El nombre del usuario es obligatorio',
            'user_name.string' => 'El nombre debe ser texto válido',
            'user_name.max' => 'El nombre no debe exceder 100 caracteres',

            'user_email.required' => 'El email es obligatorio',
            'user_email.email' => 'El email debe ser una dirección válida',
            'user_email.unique' => 'Este email ya está registrado',
            'user_email.max' => 'El email no debe exceder 100 caracteres',

            'user_password.required' => 'La contraseña es obligatoria',
            'user_password.string' => 'La contraseña debe ser texto válido',
            'user_password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'user_password.confirmed' => 'Las contraseñas no coinciden',
        ];
    }

    private function getValidationRules($id = null)
    {
        $rules = [
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|max:100|unique:users,user_email,' . $id,
        ];

        // Solo requerimos contraseña al crear o si se proporciona al editar
        if (is_null($id)) {
            $rules['user_password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['user_password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }
}
