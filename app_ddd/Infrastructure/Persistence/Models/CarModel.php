<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{

    protected $table = 'car';

    protected $fillable = [
        'title',
        'description',
        'price',
        'photo_url',
        'contacts',
    ];

    protected $casts = [
        'price' => 'float',
        'created_at' => 'datetime',
    ];

    public function option(): HasOne
    {
        return $this->hasOne(CarOptionModel::class, 'car_id', 'id');
    }

}
