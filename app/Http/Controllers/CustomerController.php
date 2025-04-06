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

        return view("_general.customers", [
            'columns' => $columns,
            'data' => $data,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search // Pasamos el término de búsqueda a la vista
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_lastname' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|max_digits:10',
            'customer_email' => 'required|email|unique:customers,customer_email',
        ]);

        Customer::create($validated);

        return redirect()->route('customers')->with('success', 'Cliente creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_lastname' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255'
        ]);

        $customer->update($validated);

        return redirect()->route('customers')->with('success', 'Cliente actualizado correctamente');
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
}
