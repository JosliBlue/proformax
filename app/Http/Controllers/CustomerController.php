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
        $columns = ["Cliente", "Telefono", "Correo", "Estado"];

        $data = Customer::select(
            'customer_name',
            'customer_lastname',
            'customer_phone',
            'customer_email',
            'customer_status'
        )->paginate(10);

        // Convertimos los modelos a arrays asociativos
        $rows = $data->getCollection()->map(function ($item) {
            return [
                'Cliente' => "{$item->customer_name} {$item->customer_lastname}",
                'Telefono' => $item->customer_phone,
                'Correo' => $item->customer_email,
                'Estado' => $item->customer_status
            ];
        });

        return view("customers", [
            'columns' => $columns,
            'rows' => $rows,
            'paginator' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
