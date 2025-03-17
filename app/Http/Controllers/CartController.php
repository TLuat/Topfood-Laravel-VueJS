<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Topping;
use Illuminate\Http\Request;
use Inertia\Inertia;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::with('products')->where('user_id', $user->id)->get();
       
        // return Inertia::render('Cart', [
        //     'carts' => $cart
        // ]);

        return Inertia::render('Cart', compact('carts'));
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
       
        $productId = $request->productId;
        $quantity = $request->quantity;
        $cart = Cart::where('user_id', auth()->user()->id)->first();
        $existingCartItem = Cart::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save(); 
        }
        else {
            $cart = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->productId,
            'quantity' => $request->quantity,
            'total_price' => $request->totalPrice,
            'note' => $request->note,
         ]);
        }
        $toppings = $request->input('toppings', []);
        foreach ($toppings as $topping) {
            if (!$cart->toppings->contains($topping['id'])) {
                $cart->toppings()->attach($topping['id']);
            }
        }
    }

    public function show(string $id)
    {
        //
        return "aaaa";
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
        $cartItem = Cart::findOrFail($id);

        $newQuantity = $request->input('new_quantity');
        $cartItem->quantity = $newQuantity;
        $cartItem->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::findOrFail($id)->delete();

        return redirect()->back();
    }
}
