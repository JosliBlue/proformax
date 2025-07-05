<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Paper;
use App\Models\Product;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\ProductType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con las estadísticas
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        
        // Obtener estadísticas generales
        $totalCustomers = Customer::where('company_id', $companyId)->count();
        $totalPapers = Paper::where('company_id', $companyId)->count();
        $totalProducts = Product::where('company_id', $companyId)->count();
        $totalUsers = User::where('company_id', $companyId)->count();
        
        // Obtener estadísticas de productos por tipo
        $productosCount = Product::where('company_id', $companyId)
            ->where('product_type', ProductType::PRODUCTO)
            ->count();
        
        $serviciosCount = Product::where('company_id', $companyId)
            ->where('product_type', ProductType::SERVICIO)
            ->count();
        
        // Obtener estadísticas de proformas por vigencia
        $today = Carbon::now()->startOfDay();
        
        $papersVigentes = Paper::where('company_id', $companyId)
            ->whereRaw('DATE_ADD(paper_date, INTERVAL paper_days DAY) >= ?', [$today])
            ->where('is_draft', false)
            ->count();
        
        $papersVencidas = Paper::where('company_id', $companyId)
            ->whereRaw('DATE_ADD(paper_date, INTERVAL paper_days DAY) < ?', [$today])
            ->where('is_draft', false)
            ->count();
        
        $papersBorradores = Paper::where('company_id', $companyId)
            ->where('is_draft', true)
            ->count();
        
        // Obtener estadísticas detalladas de usuarios por rol
        $vendedores = User::where('company_id', $companyId)
            ->where('user_rol', UserRole::VENDEDOR)
            ->count();
        
        $pasantes = User::where('company_id', $companyId)
            ->where('user_rol', UserRole::PASANTE)
            ->count();
        
        $gerentes = User::where('company_id', $companyId)
            ->where('user_rol', UserRole::GERENTE)
            ->count();
        
        $statistics = [
            'customers' => $totalCustomers,
            'papers' => [
                'total' => $totalPapers,
                'vigentes' => $papersVigentes,
                'vencidas' => $papersVencidas,
                'borradores' => $papersBorradores
            ],
            'products' => [
                'total' => $totalProducts,
                'productos' => $productosCount,
                'servicios' => $serviciosCount
            ],
            'users' => [
                'total' => $totalUsers,
                'vendedores' => $vendedores,
                'pasantes' => $pasantes,
                'gerentes' => $gerentes
            ]
        ];
        
        return view('_general.home', compact('statistics'));
    }
}
