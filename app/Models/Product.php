<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'desc', 'price', 'meal_time', 'image', 'category_id'];

      // Một sản phẩm có thể xuất hiện trong nhiều giỏ hàng (quan hệ one-to-many)
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class,'product_topping');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class,'menu_product');
    }
}
