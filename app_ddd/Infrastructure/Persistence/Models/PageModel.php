<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{

    protected $table = 'pages';

    protected $fillable = [
        'code',
        'title',
        'content',
        'is_active',
    ];

}
