<?php

namespace App\Livewire\Crud;

use App\Models\Customer;
use Livewire\Component;

class FormularioClientes extends Component
{
    public $customer_name = '';
    public $customer_lastname = '';
    public $customer_phone = '';
    public $customer_email = '';

    protected $rules = [
        'customer_name' => 'required|string|max:100',
        'customer_lastname' => 'required|string|max:100',
        'customer_phone' => 'required|string|max:20',
        'customer_email' => 'required|email|max:100|unique:customers,customer_email'
    ];

    protected $messages = [
        'customer_name.required' => 'El nombre es obligatorio.',
        'customer_lastname.required' => 'El apellido es obligatorio.',
        'customer_phone.required' => 'El teléfono es obligatorio.',
        'customer_email.required' => 'El email es obligatorio.',
        'customer_email.email' => 'Debe ser un email válido.',
        'customer_email.unique' => 'Este email ya está registrado.',
    ];
    public function save()
    {
        $this->validate();

        try {
            Customer::create([
                'customer_name' => $this->customer_name,
                'customer_lastname' => $this->customer_lastname,
                'customer_phone' => $this->customer_phone,
                'customer_email' => $this->customer_email
            ]);

            session()->flash('success', 'Cliente creado exitosamente.');

            return redirect()->route('customers');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el cliente: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'customer_name',
            'customer_lastname',
            'customer_phone',
            'customer_email'
        ]);
        $this->resetErrorBag();
    }
    public function render()
    {
        return view('components.livewire.crud.formulario-clientes');
    }
}
