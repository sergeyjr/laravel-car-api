<?php

namespace App\API\V1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarOptionModel extends Model
{

    protected $table = 'car_options';

    // в таблице car_options нет полей created_at и updated_at
    public $timestamps = false;

    protected $fillable = [
        'car_id',
        'brand',
        'model',
        'year',
        'body',
        'mileage',
    ];

    protected $casts = [
        'year' => 'integer',
        'mileage' => 'integer',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

}
