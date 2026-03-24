<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{

    protected $table = 'car';

    protected $fillable = [
        'title',
        'description',
        'price',
        'photo_url',
        'contacts',
        'created_at',
    ];

    protected $casts = [
        'price' => 'float',
        'created_at' => 'datetime',
    ];

    public function option(): HasOne
    {
        return $this->hasOne(CarOption::class, 'car_id', 'id');
    }

}
