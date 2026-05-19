<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'body',
    ];

}
