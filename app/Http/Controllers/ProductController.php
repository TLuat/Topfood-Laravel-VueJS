<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Topping;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories', 'toppings', 'menus')->get();
        $categories = Category::all();
        $toppings = Topping::all();
        $comments = Comment::with('users')->get();
        $ratings = Rating::with('products')->get();
        $user = Auth::user();

        $orders = Order::with('products.toppings')->where('user_id', $user->id)->get();

        $carts = Cart::with('products', 'toppings')->where('user_id', $user->id)->get();

        $url = "https://api.openweathermap.org/data/2.5/forecast?id=1586203&appid=6052faefddc28fcd47bce9c4cea209ec&lang=vi";
        $response = Http::get($url);
        $weatherData = $response->json();
        $todayDate = date('Y-m-d');
        $weather = [];
        
        foreach ($weatherData['list'] as $forecast) {
            if (substr($forecast['dt_txt'], 0, 10) === $todayDate) {
                $weather[] = $forecast;
            }
        }

        return Inertia::render('index', compact('products', 'toppings', 'categories', 'carts', 'orders', 'comments', 'ratings', 'weather'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $toppings = Topping::all();

        return Inertia::render('Admin/CreateProduct', compact('categories', 'toppings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input('categories'));
        $image = $request->file('image')->store('products', 'public');

        $product = new Product;
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->meal_time = $request->input('meal_time');
        $product->image = $image;
        $product->category_id = $request->categories;
        $product->save();

        

        if ($request->has('toppings')) {
            $product->toppings()->attach($request->toppings);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('ProductDetail', ['product' => $product]);
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
