<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Topping;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Reservation;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->get();
        $toppings = Topping::all(['*']);
        $categories = Category::all(['*']);
        $reservations = Reservation::with('tables')->get();
        $menus = Menu::all(['*']);
        $tables = Table::all(['*']);

        $orders = Order::with('products', 'toppings')->get();

        $shippedOrders = Order::where('status', 'shipped')->get();
        
        $todayRevenue = $shippedOrders->where('created_at', '>=', Carbon::today())->sum('total_price');
        $weeklyRevenue = $shippedOrders->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
        $monthlyRevenue = Order::where('status', 'shipped')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->sum('total_price');

        return Inertia::render('Admin/Index', compact('products', 'toppings', 'reservations', 'menus', 'tables', 'categories', 'orders', 'todayRevenue', 'weeklyRevenue', 'monthlyRevenue'));
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
