<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Pagination\LengthAwarePaginator;

class PaperController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Definir columnas para ordenamiento
        $columns = [
            ['name' => 'Fecha', 'field' => 'paper_date'],
            ['name' => 'Cliente', 'field' => 'customer_name'],
            ['name' => 'Total', 'field' => 'paper_total_price'],
            ['name' => 'Días', 'field' => 'paper_days']
        ];

        // Obtener parámetros de ordenamiento y búsqueda
        $sortField = request('sort', 'paper_date');
        $sortDirection = request('direction', 'desc');
        $search = request('search');

        // Construir la consulta base
        $query = Paper::query()
            ->with(['customer', 'products', 'user'])
            ->where('papers.company_id', $user->company_id);

        // Aplicar filtros de búsqueda
        if ($search) {
            // Filtrar por cliente solo para papers con cliente asignado
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($q2) use ($search) {
                    $q2->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_lastname', 'like', "%{$search}%");
                })
                    ->orWhere('paper_total_price', 'like', "%{$search}%")
                    ->orWhere('paper_days', 'like', "%{$search}%");
            });
        }

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

        // Obtener todos los papers y separarlos en borradores y no borradores
        $allPapers = $query->get();
        $drafts = Paper::where('company_id', $user->company_id)
            ->where('is_draft', true)
            ->get();
        $papersList = $allPapers->where('is_draft', false)->values();

        // Paginación normal con los que son is_draft false
        $perPage = 10;
        $currentPage = request('page', 1);
        $paginatedPapers = new LengthAwarePaginator(
            $papersList->forPage($currentPage, $perPage),
            $papersList->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Pasar borradores y paginados a la vista
        return view('_general.papers.papers', [
            'papers' => $paginatedPapers,
            'drafts' => $drafts,
            'columns' => $columns,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'searchTerm' => $search
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $customers = Customer::forCompany($user->company_id)->active()->get();
        $products = Product::forCompany($user->company_id)->active()->get();

        $selectedProducts = [];
        $copyPaper = null;
        $copyCustomerId = null;
        $copyPaperDays = null;
        $copyPaperDate = null;

        if ($request->has('copy_from')) {
            $copyPaper = Paper::where('company_id', $user->company_id)
                ->where('id', $request->input('copy_from'))
                ->with('products')
                ->first();
            if ($copyPaper) {
                $copyCustomerId = $copyPaper->customer_id;
                $copyPaperDays = 7; // Siempre 7 días para copias
                $copyPaperDate = now()->format('Y-m-d'); // Fecha actual para copias
                $selectedProducts = $copyPaper->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'quantity' => $product->pivot->quantity,
                        'unit_price' => $product->pivot->unit_price
                    ];
                })->toArray();
            }
        }

        return view('_general.papers.papers-create', [
            'customers' => $customers,
            'products' => $products,
            'selectedProducts' => $selectedProducts,
            'copyCustomerId' => $copyCustomerId,
            'copyPaperDays' => $copyPaperDays,
            'copyPaperDate' => $copyPaperDate
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        try {
            $rules = $this->getValidationRules();
            $rules['customer_id'] = !$request->has('save_draft') ? 'required|exists:customers,id' : 'nullable|exists:customers,id';
            $validated = $request->validate($rules, $this->getValidationMessages());

            // Si no es borrador y no hay cliente, forzar error manualmente
            if (!$request->has('save_draft') && empty($validated['customer_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Por favor selecciona un cliente')
                    ->withErrors(['customer_id' => 'El cliente es obligatorio']);
            }

            // Calcular total
            $total = collect($validated['products'])->sum(function ($product) {
                return $product['quantity'] * $product['unit_price'];
            });

            // Crear paper
            $paper = Paper::create([
                'user_id' => $user->id,
                'customer_id' => $validated['customer_id'] ?? null,
                'company_id' => $user->company_id,
                'paper_days' => $validated['paper_days'],
                'paper_total_price' => $total,
                'is_draft' => $request->has('save_draft'),
                'paper_date' => $validated['paper_date'],
            ]);

            // Adjuntar productos al paper
            foreach ($validated['products'] as $productData) {
                $paper->products()->attach($productData['id'], [
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['unit_price'],
                    'subtotal' => $productData['quantity'] * $productData['unit_price'],
                ]);
            }

            // Redireccionar según si es borrador o no
            if ($request->has('save_draft')) {
                return redirect()->route('papers')->with('success', 'Borrador guardado correctamente');
            } else {
                return redirect()->route('papers.pdf', $paper->id)->with('success', 'Proforma creada correctamente');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->with('error', 'Cliente o producto no válido')
                ->withErrors($e->validator);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage());
        }
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

        // Calcular la fecha límite basándose en los días de validez
        $paperValidUntil = null;
        if ($paper->paper_date && $paper->paper_days) {
            $paperValidUntil = \Carbon\Carbon::parse($paper->paper_date)->addDays($paper->paper_days)->format('Y-m-d');
        }

        return view('_general.papers.papers-create', compact('paper', 'customers', 'products', 'selectedProducts', 'paperValidUntil'));
    }

    public function update(Request $request, Paper $paper)
    {
        $user = Auth::user();
        try {
            // Verificar que el paper pertenezca a la compañía del usuario
            if ($paper->company_id !== $user->company_id) {
                abort(403, 'No autorizado');
            }

            // Validación de datos (igual que en store)
            $rules = $this->getValidationRules($paper->id);
            if (!$request->has('save_draft')) {
                $rules['customer_id'] = 'required|exists:customers,id';
            } else {
                $rules['customer_id'] = 'nullable|exists:customers,id';
            }
            $validated = $request->validate($rules, $this->getValidationMessages());

            // Calcular total
            $total = collect($validated['products'])->sum(function ($product) {
                return $product['quantity'] * $product['unit_price'];
            });

            $paper->update([
                'customer_id' => $validated['customer_id'] ?? null,
                'paper_days' => $validated['paper_days'],
                'paper_total_price' => $total,
                'is_draft' => $request->has('save_draft'),
                'paper_date' => $validated['paper_date'],
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

            // Redireccionar según si es borrador o no
            if ($request->has('save_draft')) {
                return redirect()->route('papers')->with('success', 'Borrador actualizado correctamente');
            } else {
                return redirect()->route('papers.pdf', $paper->id)->with('success', 'Documento actualizado correctamente');
            }
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

    public function destroy(Paper $paper)
    {
        $user = Auth::user();

        // Verificar que el paper pertenezca a la compañía del usuario
        if ($paper->company_id !== $user->company_id) {
            abort(403, 'No autorizado');
        }

        $paper->delete();

        return redirect()->route('papers')->with('success', 'Documento eliminado correctamente');
    }

    /**
     * Mensajes de validación para Paper
     */
    private function getValidationMessages()
    {
        return [
            'paper_days.required' => 'Los días de validez son obligatorios',
            'paper_days.integer' => 'Los días de validez deben ser un número entero',
            'paper_days.min' => 'Debe haber al menos 1 día de validez',
            'products.required' => 'Debe agregar al menos un producto',
            'products.array' => 'El formato de productos no es válido',
            'products.*.id.required' => 'Debe seleccionar un producto',
            'products.*.id.exists' => 'El producto seleccionado no existe',
            'products.*.quantity.required' => 'La cantidad es obligatoria',
            'products.*.quantity.integer' => 'La cantidad debe ser un número entero',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1',
            'products.*.unit_price.required' => 'El precio unitario es obligatorio',
            'products.*.unit_price.numeric' => 'El precio unitario debe ser un número',
            'products.*.unit_price.min' => 'El precio unitario no puede ser negativo',
            'paper_date.required' => 'La fecha es obligatoria',
            'paper_date.date' => 'La fecha no es válida',
            'customer_id.required' => 'El cliente es obligatorio',
            'customer_id.exists' => 'El cliente seleccionado no existe',
        ];
    }

    /**
     * Reglas de validación para Paper
     */
    private function getValidationRules($id = null)
    {
        $rules = [
            'paper_days' => 'required|integer|min:1',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'paper_date' => 'required|date',
        ];
        return $rules;
    }
}
