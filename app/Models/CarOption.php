<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarOption extends Model
{

    protected $table = 'car_option';
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
        return $this->belongsTo(Car::class);
    }

}
