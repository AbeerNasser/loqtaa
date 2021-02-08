<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    protected $fillable = [
        'national_id','other_phone', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
