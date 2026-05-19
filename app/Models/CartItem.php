<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{

    use HasFactory;

    protected $fillable = [
        'cart_id',
        'car_id',
        'qty',
        'price',
    ];

    /**
     * Cart relation
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Car relation
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Total price for item
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->qty;
    }

}
