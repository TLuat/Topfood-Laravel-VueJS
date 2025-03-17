<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $menus = Menu::with('products')->get();
        $orders = Order::with('products')->where('user_id', $user->id)->get();
        $carts = Cart::with('products', 'toppings')->where('user_id', $user->id)->get();
        
        return Inertia::render('Menu', compact('menus', 'orders', 'carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/AddMenu');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $imagePath = $request->file('image')->store('menus', 'public');

        $menu = new Menu;
        $menu->name = $request->input('name');
        $menu->desc = $request->input('desc');
        $menu->price = $request->input('price');
        $menu->taste = $request->input('taste');
        $menu->nutritionNeeds = $request->input('nutritionNeeds');
        $preferences = $request->input('preferences');
        $preferences = array_filter($preferences, fn ($value) => $value !== null);
        $preferencesAsString = implode(', ', $preferences);
        $menu->preferences =  $preferencesAsString;
        $menu->occasion = $request->input('occasion');
        $menu->type = $request->input('type');
        $menu->meal_time = $request->input('meal_time');
        $menu->diners = $request->input('diners');
        $menu->img = $imagePath;
        
        $menu->save();

        if ($request->has('products')) {
            $products = $request->products;
            foreach ($products as $product) {
                $id = $product['id'];
                $menu->products()->attach($id);
            }
        }
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
