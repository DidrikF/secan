<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    protected $fillable = [
        'image', 'type', 'description',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
