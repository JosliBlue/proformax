<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            // Validar datos de entrada
            $validated = $request->validate(
                $this->getValidationRules(),
                $this->getValidationMessages()
            );

            // Preparar datos para creación
            $userData = [
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
                'user_password' => bcrypt($validated['user_password']),
                'company_id' => Auth::user()->company_id,
                'user_status' => true
            ];

            // Asignar rol basado en permisos
            $userData['user_rol'] = (Auth::user()->isGerente() && $request->filled('user_rol')) 
                ? $validated['user_rol'] 
                : UserRole::VENDEDOR->value;

            // Crear usuario
            $user = User::create($userData);
            
            return redirect()->route('sellers')
                ->with('success', '✅ Usuario "' . $user->user_name . '" creado correctamente. Ya puede iniciar sesión.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo específico de errores de validación
            $errors = $e->validator->errors();
            $errorMessage = $errors->count() === 1 
                ? $errors->first()
                : "Se encontraron {$errors->count()} errores en el formulario";
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '⚠️ ' . $errorMessage)
                ->withErrors($e->validator);
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo específico de errores de base de datos
            Log::error('Error de base de datos al crear usuario: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'company_id' => Auth::user()->company_id,
                'email' => $request->user_email
            ]);
            
            $errorMessage = str_contains($e->getMessage(), 'Duplicate entry') 
                ? 'El correo electrónico ya está registrado'
                : 'Error en la base de datos. Intenta nuevamente';
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '❌ ' . $errorMessage);
                
        } catch (\Exception $e) {
            // Manejo general de errores
            Log::error('Error inesperado al crear usuario: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'company_id' => Auth::user()->company_id,
                'request_data' => $request->except('user_password', 'user_password_confirmation')
            ]);
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '❌ Error del servidor. Intenta nuevamente en unos minutos.');
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
            
            // Si no se proporciona contraseña, no la validamos
            if (empty($request->user_password)) {
                unset($rules['user_password']);
            }

            $validated = $request->validate($rules, $this->getValidationMessages());

            // Preparar datos para actualización
            $updateData = [
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
            ];

            // Permitir cambiar el rol si es gerente
            if (Auth::user()->isGerente() && $request->filled('user_rol')) {
                $updateData['user_rol'] = $validated['user_rol'];
            }

            // Solo actualizamos la contraseña si se proporcionó una nueva
            if (!empty($validated['user_password'])) {
                $updateData['user_password'] = bcrypt($validated['user_password']);
            }

            $user->update($updateData);

            return redirect()->route('sellers')
                ->with('success', '✅ Usuario "' . $user->user_name . '" actualizado correctamente.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Manejo específico de errores de validación
            $errorCount = $e->validator->errors()->count();
            $errorMessage = $errorCount === 1 
                ? $e->validator->errors()->first()
                : "Se encontraron {$errorCount} errores en el formulario";
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '⚠️ ' . $errorMessage)
                ->withErrors($e->validator);
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('sellers')
                ->with('error', '❌ El usuario no existe o no tienes permisos para editarlo.');
                
        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo específico de errores de base de datos
            Log::error('Error de base de datos al actualizar usuario: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'target_user_id' => $id,
                'company_id' => Auth::user()->company_id
            ]);
            
            $errorMessage = str_contains($e->getMessage(), 'Duplicate entry') 
                ? 'El correo electrónico ya está en uso por otro usuario'
                : 'Error en la base de datos. Intenta nuevamente';
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '❌ ' . $errorMessage);
                
        } catch (\Exception $e) {
            Log::error('Error inesperado al actualizar usuario: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'target_user_id' => $id,
                'company_id' => Auth::user()->company_id,
                'request_data' => $request->except('user_password', 'user_password_confirmation')
            ]);
            
            return back()
                ->withInput($request->except('user_password', 'user_password_confirmation'))
                ->with('error', '❌ Error del servidor. Intenta nuevamente en unos minutos.');
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

    private function getValidationRules($id = null)
    {
        $rules = [
            'user_name' => 'required|string|min:2|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'user_email' => 'required|email|max:100|unique:users,user_email,' . $id,
            'user_rol' => 'nullable|in:' . implode(',', [UserRole::VENDEDOR->value, UserRole::PASANTE->value]),
        ];

        // Reglas de contraseña más específicas
        $passwordRules = [
            'required',
            'string',
            'min:8',
            'max:100',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ];

        if (is_null($id)) {
            // Crear: contraseña obligatoria
            $rules['user_password'] = $passwordRules;
        } else {
            // Actualizar: contraseña opcional
            $rules['user_password'] = array_merge(['nullable'], array_slice($passwordRules, 1));
        }

        return $rules;
    }
}
