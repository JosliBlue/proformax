<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $user = Auth::user();

        // Solo mostrar usuarios de la misma compañía, excepto el usuario actual y los gerentes
        $query = User::where('company_id', $user->company_id)
            ->where('id', '!=', $user->id)
            ->where('user_rol', '!=', UserRole::GERENTE->value);
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

            // Permitir elegir rol solo si es gerente
            if (Auth::user()->isGerente() && isset($request->user_rol)) {
                $validated['user_rol'] = $request->user_rol;
            } else {
                $validated['user_rol'] = UserRole::VENDEDOR->value;
            }
            $validated['company_id'] = Auth::user()->company_id;
            $validated['user_password'] = bcrypt($validated['user_password']);

            User::create($validated);
            return redirect()->route('sellers')
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
        $user = User::where('company_id', Auth::user()->company_id)
            ->findOrFail($id);
        $roles = UserRole::cases();
        return view('_admin.users.users-form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::where('company_id', Auth::user()->company_id)
                ->findOrFail($id);

            $rules = $this->getValidationRules($id);
            if (empty($request->user_password)) {
                unset($rules['user_password']);
            }

            $validated = $request->validate($rules, $this->getValidationMessages());

            $updateData = [
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
            ];

            // Permitir cambiar el rol si es gerente
            if (Auth::user()->isGerente() && isset($request->user_rol)) {
                $updateData['user_rol'] = $request->user_rol;
            }

            // Solo actualizamos la contraseña si se proporcionó una nueva
            if (!empty($validated['user_password'])) {
                $updateData['user_password'] = bcrypt($validated['user_password']);
            }

            $user->update($updateData);

            return redirect()->route('sellers')
                ->with('success', 'Usuario actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('sellers')
                ->with('error', 'El usuario que intentas actualizar no existe.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function soft_destroy(string $id)
    {
        $current = Auth::user();
        // Permitir desactivar/activar solo si es gerente
        if (!$current->isGerente()) {
            abort(403, 'No tienes permisos para desactivar usuarios.');
        }
        $user = User::where('company_id', $current->company_id)
            ->findOrFail($id);
        // No permitir desactivar a sí mismo
        if ($user->id == $current->id) {
            abort(403, 'No puedes desactivarte a ti mismo.');
        }
        $user->update(['user_status' => !$user->user_status]);
        return back()->with('success', $user->user_status ? 'Usuario activado' : 'Usuario desactivado');
    }

    public function destroy(string $id)
    {
        $current = Auth::user();
        // Solo el gerente puede eliminar usuarios
        if (!$current->isGerente()) {
            abort(403, 'Solo el gerente puede eliminar usuarios.');
        }
        $user = User::findOrFail($id);
        // No permitir eliminarse a sí mismo
        if ($user->id == $current->id) {
            abort(403, 'No puedes eliminarte a ti mismo.');
        }
        $user->delete();
        return redirect()->route('sellers')->with('success', 'Usuario eliminado');
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
