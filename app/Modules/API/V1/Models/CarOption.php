<?php

namespace Modules\API\V1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarOption extends Model
{

    protected $table = 'car_option';

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
