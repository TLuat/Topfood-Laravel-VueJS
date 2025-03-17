<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'meal_time', 'desc', 'price', 'taste', 'nutritionNeeds', 'preferences', 'occasion', 'type', 'diners', 'img'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'menu_product');
    }
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_menu');
    }
    
}
