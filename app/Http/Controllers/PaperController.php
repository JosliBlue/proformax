<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    public function index()
    {
        $columns = [
            ['name' => 'ID', 'field' => 'id'],
            ['name' => 'Cliente', 'field' => 'customer.customer_name'],
            ['name' => 'Total', 'field' => 'paper_total_price'],
            ['name' => 'Válido por', 'field' => 'paper_days'],
            ['name' => 'Estado', 'field' => 'paper_status'],
            ['name' => 'Fecha', 'field' => 'created_at']
        ];

        $sortField = request('sort', 'created_at');
        $sortDirection = request('direction', 'desc');
        $search = request('search');

        $query = Paper::with(['customer', 'products'])
            ->where('company_id', Auth::user()->company_id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_lastname', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return view("_general.papers.papers", [
            'columns' => $columns,
            'data' => $data,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create()
    {
        $customers = Customer::where('company_id', Auth::user()->company_id)
            ->where('customer_status', true)
            ->get();

        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('product_status', true)
            ->get();

        return view('_general.papers.papers-form', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'paper_days' => 'required|string',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.unit_price' => 'required|numeric|min:0'
            ]);

            // Calcular total
            $total = collect($request->products)->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });

            // Crear paper
            $paper = Paper::create([
                'user_id' => Auth::id(),
                'customer_id' => $request->customer_id,
                'company_id' => Auth::user()->company_id,
                'paper_total_price' => $total,
                'paper_days' => $request->paper_days,
                'paper_status' => true
            ]);

            // Adjuntar productos
            foreach ($request->products as $product) {
                $paper->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'subtotal' => $product['quantity'] * $product['unit_price']
                ]);
            }

            return redirect()->route('papers.index')
                ->with('success', 'Paper creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }
    }

    public function show($id)
    {
        $paper = Paper::with(['customer', 'products', 'user'])
            ->where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        return view('_admin.papers.papers-show', compact('paper'));
    }

    public function edit($id)
    {
        $paper = Paper::with(['products'])
            ->where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        $customers = Customer::where('company_id', Auth::user()->company_id)
            ->where('customer_status', true)
            ->get();

        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('product_status', true)
            ->get();

        return view('_admin.papers.papers-form', compact('paper', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Similar a store pero con actualización
    }

    public function destroy($id)
    {
        $paper = Paper::where('company_id', Auth::user()->company_id)
            ->findOrFail($id);

        $paper->delete();

        return back()->with('success', 'Paper eliminado');
    }
}
