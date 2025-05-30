<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Enums\ProductType;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $columns = [
            ['name' => 'Nombre', 'field' => 'product_name'],
            ['name' => 'Tipo', 'field' => 'product_type'],
            ['name' => 'Precio', 'field' => 'product_price'],
            ['name' => 'Estado', 'field' => 'product_status']
        ];

        $sortField = request('sort', 'product_name');
        $sortDirection = request('direction', 'asc');
        $search = request('search');

        $user = Auth::user();
        $query = Product::where('company_id', $user->company_id);

        // Solo productos activos para usuarios normales
        if (Auth::check() && !Auth::user()->isAdmin()) {
            $query->where('product_status', true);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('product_price', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return view("_admin.products.products", [
            'columns' => $columns,
            'data' => $data,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create()
    {
        $types = ProductType::cases();
        return view('_admin.products.products-form', compact('types'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                $this->getValidationRules(),
                $this->getValidationMessages()
            );

            $validated['company_id'] = Auth::user()->company_id;
            Product::create($validated);
            return redirect()->route('products')
                ->with('success', 'Producto creado correctamente.');
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
        $product = Product::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $types = ProductType::cases();
        return view('_admin.products.products-form', compact('product', 'types'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::where('company_id', Auth::user()->company_id)->findOrFail($id);

            $validated = $request->validate(
                $this->getValidationRules($id),
                $this->getValidationMessages()
            );

            $product->update($validated);

            return redirect()->route('products')
                ->with('success', 'Producto actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Por favor corrige los errores en el formulario')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('products')
                ->with('error', 'El producto que intentas actualizar no existe.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el producto: ' . $e->getMessage());
        }
    }

    public function soft_destroy(string $id)
    {
        $product = Product::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $product->update(['product_status' => !$product->product_status]);

        return back()->with('success', $product->product_status ? 'Producto activado' : 'Producto desactivado');
    }

    public function destroy(string $id)
    {
        $product = Product::where('company_id', Auth::user()->company_id)->findOrFail($id);
        $product->delete();
        return redirect()->route('products')->with('success', 'Producto eliminado');
    }

    /**
     * Mensajes de validación para Product
     */
    private function getValidationMessages()
    {
        return [
            'product_name.required' => 'El nombre del producto es obligatorio',
            'product_name.string' => 'El nombre debe ser texto válido',
            'product_name.max' => 'El nombre no debe exceder 100 caracteres',

            'product_type.required' => 'El tipo de producto es obligatorio',
            'product_type.in' => 'El tipo de producto no es válido',

            'product_price.required' => 'El precio es obligatorio',
            'product_price.numeric' => 'El precio debe ser un número válido',
            'product_price.min' => 'El precio no puede ser negativo',
        ];
    }

    /**
     * Reglas de validación para Product
     */
    private function getValidationRules($id = null)
    {
        return [
            'product_name' => 'required|string|max:100',
            'product_type' => 'required|in:' . implode(',', array_column(ProductType::cases(), 'value')),
            'product_price' => 'required|numeric|min:0',
        ];
    }
}
