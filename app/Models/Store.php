<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
      'location','description','notes','category_id','user_id','temp_disable'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function ads()
    {
        return $this->hasMany('App\Models\Ad');
    }
}
