<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = [
        'name', 'description', 'image',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
