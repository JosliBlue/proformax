<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $columns = [
            ['name' => 'Cliente', 'field' => 'customer_name'],
            ['name' => 'Telefono', 'field' => 'customer_phone'],
            ['name' => 'Correo', 'field' => 'customer_email'],
            ['name' => 'Estado', 'field' => 'customer_status']
        ];

        $sortField = request('sort', 'customer_name');
        $sortDirection = request('direction', 'asc');
        $search = request('search');

        $query = Customer::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_lastname', 'like', "%{$search}%")
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
            'searchTerm' => $search // Pasamos el término de búsqueda a la vista
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

            Customer::create($validated);
            return redirect()->route('customers')
                ->with('success', 'Cliente creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario') // Toast de error
                ->withErrors($e->validator); // Mensajes específicos por campo

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('_general.customers.customers-form', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $validated = $request->validate(
                $this->getValidationRules($id),
                $this->getValidationMessages()
            );

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
        $customer = Customer::findOrFail($id);
        $customer->update(['customer_status' => !$customer->customer_status]);

        return back()->with('success', $customer->customer_status ? 'Cliente activado' : 'Cliente desactivado');
    }
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
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
            'customer_phone' => 'required|numeric|digits:10',
            'customer_email' => 'required|email|unique:customers,customer_email',
        ];

        if ($id) {
            $rules['customer_email'] .= ',' . $id;
        }

        return $rules;
    }

}
