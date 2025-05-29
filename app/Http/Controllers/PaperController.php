<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaperController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Definir columnas para ordenamiento
        $columns = [
            ['name' => 'Fecha', 'field' => 'created_at'],
            ['name' => 'Cliente', 'field' => 'customer_name'],
            ['name' => 'Total', 'field' => 'paper_total_price'],
            ['name' => 'Días', 'field' => 'paper_days']
        ];

        // Obtener parámetros de ordenamiento y búsqueda
        $sortField = request('sort', 'created_at');
        $sortDirection = request('direction', 'desc');
        $search = request('search');

        // Construir la consulta base
        $query = Paper::query()
            ->with(['customer', 'products', 'user'])
            ->where('papers.company_id', $user->company_id);

        // Aplicar filtros de búsqueda
        if ($search) {
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_lastname', 'like', "%{$search}%");
            })->orWhere('paper_total_price', 'like', "%{$search}%")
              ->orWhere('paper_days', 'like', "%{$search}%");
        }

        // Aplicar ordenamiento
        // Aplicar JOIN con customers si es necesario
        if ($sortField === 'customer_name' || $search) {
            $query->join('customers', 'papers.customer_id', '=', 'customers.id');
        }

        // Aplicar ordenamiento
        switch ($sortField) {
            case 'customer_name':
                $query->orderBy('customers.customer_name', $sortDirection);
                break;
            default:
                $query->orderBy('papers.' . $sortField, $sortDirection);
                break;
        }

        // Asegurarse de seleccionar solo los campos de papers
        $query->select('papers.*');

        $papers = $query->paginate(15);

        return view('_general.papers.papers', [
            'papers' => $papers,
            'columns' => $columns,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $customers = Customer::forCompany($user->company_id)->active()->get();
        $products = Product::forCompany($user->company_id)->active()->get();

        return view('_general.papers.papers-create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validación de datos
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'paper_days' => 'required|integer|min:1',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calcular total
        $total = collect($validated['products'])->sum(function ($product) {
            return $product['quantity'] * $product['unit_price'];
        });

        // Crear paper
        $paper = Paper::create([
            'user_id' => $user->id,
            'customer_id' => $validated['customer_id'],
            'company_id' => $user->company_id,
            'paper_days' => $validated['paper_days'],
            'paper_total_price' => $total
        ]);

        // Adjuntar productos al paper
        foreach ($validated['products'] as $productData) {
            $paper->products()->attach($productData['id'], [
                'quantity' => $productData['quantity'],
                'unit_price' => $productData['unit_price'],
                'subtotal' => $productData['quantity'] * $productData['unit_price'],
            ]);
        }

        return redirect()->route('papers')->with('success', 'Documento creado correctamente');
    }
    public function edit(Paper $paper)
    {
        $user = Auth::user();

        // Verificar que el paper pertenezca a la compañía del usuario
        if ($paper->company_id !== $user->company_id) {
            abort(403, 'No autorizado');
        }

        $customers = Customer::forCompany($user->company_id)->active()->get();
        $products = Product::forCompany($user->company_id)->active()->get();

        // Preparar los productos seleccionados para la vista
        $selectedProducts = $paper->products->map(function ($product) {
            return [
                'id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price
            ];
        })->toArray();

        return view('_general.papers.papers-create', compact('paper', 'customers', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Paper $paper)
    {
        $user = Auth::user();

        // Verificar que el paper pertenezca a la compañía del usuario
        if ($paper->company_id !== $user->company_id) {
            abort(403, 'No autorizado');
        }

        // Validación de datos (igual que en store)
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'paper_days' => 'required|integer|min:1',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calcular total
        $total = collect($validated['products'])->sum(function ($product) {
            return $product['quantity'] * $product['unit_price'];
        });

        // Actualizar paper
        $paper->update([
            'customer_id' => $validated['customer_id'],
            'paper_days' => $validated['paper_days'],
            'paper_total_price' => $total
        ]);

        // Sincronizar productos (elimina los antiguos y añade los nuevos)
        $productsData = [];
        foreach ($validated['products'] as $productData) {
            $productsData[$productData['id']] = [
                'quantity' => $productData['quantity'],
                'unit_price' => $productData['unit_price'],
                'subtotal' => $productData['quantity'] * $productData['unit_price']
            ];
        }

        $paper->products()->sync($productsData);

        return redirect()->route('papers')->with('success', 'Documento actualizado correctamente');
    }

    public function destroy(Paper $paper)
    {
        $paper->delete();

        return redirect()->route('papers')->with('success', 'Documento eliminado correctamente');
    }
}
