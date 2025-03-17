<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['user_id', 'email', 'recipient_name', 'phone_number', 'shipping_address', 'quantity', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'order_topping');
    }
    public function carts()
    {
        return $this->hasOne(Cart::class);
    }
}
