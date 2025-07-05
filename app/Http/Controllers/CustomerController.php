<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $columns = [];
        $columns[] = ['name' => 'Nombre', 'field' => 'customer_name'];
        $columns[] = ['name' => 'Cédula', 'field' => 'customer_cedula'];
        $columns[] = ['name' => 'Teléfono', 'field' => 'customer_phone'];
        $columns[] = ['name' => 'Correo', 'field' => 'customer_email'];

        // Solo gerente ve la columna de estado
        if (Auth::check() && Auth::user()->isGerente()) {
            $columns[] = ['name' => 'Estado', 'field' => 'customer_status'];
        }

        $sortField = request('sort', 'customer_name');
        $sortDirection = request('direction', 'asc');
        $search = request('search');

        $query = Customer::query();

        // Filtrar por compañía del usuario
        $query->where('company_id', Auth::user()->company_id);

        if (Auth::check() && !Auth::user()->isGerente()) {
            $query->where('customer_status', true);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_lastname', 'like', "%{$search}%")
                    ->orWhere('customer_cedula', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return view("_general.customers.customers", [
            'columns' => $columns,
            'data' => $data,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create()
    {
        return view('_general.customers.customers-form');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                $this->getValidationRules(),
                $this->getValidationMessages()
            );

            // Validar cédula si fue proporcionada
            if (!empty($validated['customer_cedula']) && !$this->validarCedula($validated['customer_cedula'])) {
                return back()
                    ->withInput()
                    ->with('error', 'La cédula ingresada no es válida')
                    ->withErrors(['customer_cedula' => 'La cédula ingresada no es válida']);
            }

            $validated['company_id'] = Auth::user()->company_id;

            Customer::create($validated);
            return redirect()->route('customers')
                ->with('success', 'Cliente creado correctamente.');
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
        $customer = Customer::where('company_id', Auth::user()->company_id)->findOrFail($id);
        return view('_general.customers.customers-form', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::where('company_id', Auth::user()->company_id)->findOrFail($id);
            $isGerente = Auth::user()->isGerente();
            // Guardar el email original
            $originalEmail = $customer->customer_email;

            $validated = $request->validate(
                $this->getValidationRules($id),
                $this->getValidationMessages()
            );

            // Validar cédula si fue proporcionada
            if (!empty($validated['customer_cedula']) && !$this->validarCedula($validated['customer_cedula'])) {
                return back()
                    ->withInput()
                    ->with('error', 'La cédula ingresada no es válida')
                    ->withErrors(['customer_cedula' => 'La cédula ingresada no es válida']);
            }

            // Si no es gerente, remover el campo del request
            if (!$isGerente) {
                $request->request->remove('customer_email');
            }
            // Si no es gerente, restaurar el valor original
            if (!$isGerente) {
                $validated['customer_email'] = $originalEmail;
            }

            $customer->update($validated);

            return redirect()->route('customers')
                ->with('success', 'Cliente actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customers')
                ->with('error', 'El cliente que intentas actualizar no existe.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    public function soft_destroy(string $id)
    {
        $customer = Customer::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $customer->update(['customer_status' => !$customer->customer_status]);

        return back()->with('success', $customer->customer_status ? 'Cliente activado' : 'Cliente desactivado');
    }

    public function destroy(string $id)
    {
        $customer = Customer::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $customer->delete();
        return redirect()->route('customers')->with('success', 'Cliente eliminado');
    }

    /**
     * Obtiene los mensajes de validación comunes para Customer
     */
    private function getValidationMessages()
    {
        return [
            'customer_name.required' => 'El nombre del cliente es obligatorio',
            'customer_name.string' => 'El nombre debe ser texto válido',
            'customer_name.max' => 'El nombre no debe exceder 255 caracteres',

            'customer_lastname.required' => 'El apellido del cliente es obligatorio',
            'customer_lastname.string' => 'El apellido debe ser texto válido',
            'customer_lastname.max' => 'El apellido no debe exceder 255 caracteres',

            'customer_cedula.string' => 'La cédula debe ser texto válido',
            'customer_cedula.unique' => 'Esta cédula ya está registrada',
            'customer_cedula.digits' => 'La cédula debe tener exactamente 10 dígitos',

            'customer_phone.required' => 'El teléfono es obligatorio',
            'customer_phone.numeric' => 'El teléfono debe contener solo números',
            'customer_phone.digits' => 'El teléfono debe tener exactamente 10 dígitos',

            'customer_email.required' => 'El correo electrónico es obligatorio',
            'customer_email.email' => 'Ingresa un correo electrónico válido',
            'customer_email.unique' => 'Este correo electrónico ya está registrado',
        ];
    }

    /**
     * Obtiene las reglas de validación comunes para Customer
     */
    private function getValidationRules($id = null)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_lastname' => 'required|string|max:255',
            'customer_cedula' => 'nullable|string|digits:10|unique:customers,customer_cedula',
            'customer_phone' => 'required|numeric|digits:10',
            'customer_email' => 'required|email|unique:customers,customer_email',
        ];

        if ($id) {
            $rules['customer_cedula'] .= ',' . $id;
            $rules['customer_email'] .= ',' . $id;
        }

        return $rules;
    }

    /**
     * Valida una cédula ecuatoriana usando el algoritmo de validación oficial
     * 
     * @param string $cedula
     * @return bool
     */
    private function validarCedula($cedula)
    {
        // Limpiar espacios y validar longitud
        $cedula = trim($cedula);

        if (strlen($cedula) != 10) {
            return false;
        }

        // Validar que todos los caracteres sean números
        if (!is_numeric($cedula)) {
            return false;
        }

        // Extraer partes de la cédula
        $a = intval(substr($cedula, 0, 2));  // Primeros 2 dígitos (provincia)
        $e = intval(substr($cedula, 2, 1));  // Tercer dígito
        $i = intval(substr($cedula, 3, 6));  // Dígitos 4-9
        $o = intval(substr($cedula, 9, 1));  // Dígito verificador

        // Validar provincia (0-24)
        if ($a < 0 || $a > 24) {
            return false;
        }

        // Validar tercer dígito (0-5)
        if ($e < 0 || $e > 5) {
            return false;
        }

        // Aplicar algoritmo de validación
        $r = 0;
        $ced1 = substr($cedula, 0, 9);
        $cont = strlen($ced1);

        for ($j = 0; $j < $cont; $j++) {
            $y = ($j % 2 == 0) ? 2 : 1;
            $z = intval(substr($ced1, $j, 1));
            $u = $z * $y;

            if ($u >= 10) {
                $u = $u - 9;
            }

            $r = $r + $u;
        }

        $s = $r;

        // Calcular dígito verificador
        while ($s % 10 != 0) {
            $s = $s + 1;
        }

        $r = $s - $r;

        if ($r == 10) {
            $r = 0;
        }

        // Comparar con el dígito verificador
        return $r == $o;
    }
}
