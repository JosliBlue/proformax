<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            $query->where(function($q) use ($search) {
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
            'sortDirection' => $sortDirection
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ESTE SE ENCUENTRA EN EL COMPONENTE LIVEWIRE CRUD/FORMULARIO-CLIENTES
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
