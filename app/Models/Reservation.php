<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email',
        'name',
        'phone',
        'table_id',
        'total_price',
        'res_date',
        'time',
        'guest_number'
    ];

    protected $dates = [
        'res_date'
    ];

    public function tables()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'reservation_menu');
    }
}
