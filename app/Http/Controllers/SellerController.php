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

        $data = User::where('company_id', $user->company_id)
            ->where('id', '!=', $user->id)
            ->where('user_rol', '!=', UserRole::GERENTE->value)
            ->when($search, fn($q) =>
            $q->where(fn($query) => $query->where('user_name', 'like', "%{$search}%")
                ->orWhere('user_email', 'like', "%{$search}%")))
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        return view("_admin.users.users", compact('columns', 'data', 'sortField', 'sortDirection') + ['searchTerm' => $search]);
    }

    public function create()
    {
        $roles = UserRole::cases();
        return view('_admin.users.users-form', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->getValidationRules(), $this->getValidationMessages());

            $userData = [
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
                'user_password' => bcrypt($validated['user_password']),
                'company_id' => Auth::user()->company_id,
                'user_status' => true,
                'user_rol' => (Auth::user()->isGerente() && $request->filled('user_rol'))
                    ? $validated['user_rol'] : UserRole::VENDEDOR->value
            ];

            User::create($userData);
            return redirect()->route('sellers')->with('success', 'Usuario creado correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            $errorMessage = $errors->count() === 1 ? $errors->first() : "Se encontraron {$errors->count()} errores en el formulario";
            return back()->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', $errorMessage)->withErrors($e->validator);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = str_contains($e->getMessage(), 'Duplicate entry')
                ? 'El correo electrónico ya está registrado' : 'Error en la base de datos. Intenta nuevamente';
            return back()->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', $errorMessage);
        } catch (\Exception $e) {
            return back()->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', 'Error del servidor. Intenta nuevamente en unos minutos.');
        }
    }
    public function soft_destroy(string $id)
    {
        $current = Auth::user();
        if (!$current->isGerente()) abort(403, 'No tienes permisos para desactivar usuarios.');

        $user = User::where('company_id', $current->company_id)->findOrFail($id);
        if ($user->id == $current->id) abort(403, 'No puedes desactivarte a ti mismo.');

        $user->update(['user_status' => !$user->user_status]);
        return back()->with('success', $user->user_status ? 'Usuario activado' : 'Usuario desactivado');
    }

    public function switchRole(string $id)
    {
        $current = Auth::user();
        $user = User::where('company_id', $current->company_id)->findOrFail($id);

        if ($user->id == $current->id) return back()->with('error', 'No puedes cambiar tu propio rol.');
        if ($user->isGerente()) return back()->with('error', 'No puedes cambiar el rol de un gerente.');

        $newRole = $user->isVendedor() ? UserRole::PASANTE : UserRole::VENDEDOR;
        $user->update(['user_rol' => $newRole->value]);

        $message = $newRole === UserRole::PASANTE ? 'Rol cambiado a Pasante.' : 'Rol cambiado a Vendedor.';
        return back()->with('success', $message);
    }

    public function destroy(string $id)
    {
        $current = Auth::user();
        if (!$current->isGerente()) abort(403, 'Solo el gerente puede eliminar usuarios.');

        $user = User::findOrFail($id);
        if ($user->id == $current->id) abort(403, 'No puedes eliminarte a ti mismo.');

        $user->delete();
        return redirect()->route('sellers')->with('success', 'Usuario eliminado');
    }

    private function getValidationMessages()
    {
        return [
            'user_name.required' => 'El nombre del usuario es obligatorio',
            'user_name.string' => 'El nombre debe contener solo texto válido',
            'user_name.max' => 'El nombre no puede tener más de 100 caracteres',
            'user_name.min' => 'El nombre debe tener al menos 2 caracteres',

            'user_email.required' => 'El correo electrónico es obligatorio',
            'user_email.email' => 'Ingresa un correo electrónico válido (ejemplo@dominio.com)',
            'user_email.unique' => 'Este correo ya está registrado. Usa uno diferente',
            'user_email.max' => 'El correo no puede tener más de 100 caracteres',

            'user_password.required' => 'La contraseña es obligatoria',
            'user_password.string' => 'La contraseña debe ser texto válido',
            'user_password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'user_password.confirmed' => 'Las contraseñas no coinciden',
            'user_password.regex' => 'La contraseña debe contener al menos: 1 mayúscula, 1 minúscula y 1 número',

            'user_rol.required' => 'Selecciona un rol para el usuario',
            'user_rol.in' => 'El rol seleccionado no es válido',
        ];
    }

    private function getValidationRules()
    {
        return [
            'user_name' => 'required|string|min:2|max:100',
            'user_email' => 'required|email|max:100|unique:users,user_email',
            'user_rol' => 'nullable|in:' . implode(',', [UserRole::VENDEDOR->value, UserRole::PASANTE->value]),
            'user_password' => [
                'required',
                'string',
                'min:8',
                'max:100',
                'confirmed',
            ]
        ];
    }
}
