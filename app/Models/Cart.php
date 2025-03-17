<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price', 'note'];
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function carts()
    {
        return $this->belongsTo(User::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'cart_topping');
    }
}
