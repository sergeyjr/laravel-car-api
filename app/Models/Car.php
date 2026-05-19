<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{

    protected $table = 'cars';

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

}
