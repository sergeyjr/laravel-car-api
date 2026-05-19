<?php

namespace App\API\V1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{

    protected $table = 'cars';

    protected $fillable = [
        'title',
        'description',
        'price',
        'photo_url',
        'contacts',
        'user_id',
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
