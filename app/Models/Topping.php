<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'img'];

    public function products()
    {
        return $this->belongsToMany(Category::class, 'product_topping');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_topping');
    }
    
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_topping');
    }
}
