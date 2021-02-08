<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'product','store_id','image','price',
    ];
    protected $appends = ['image_path'];

    public function getImagePathAttribute(){
        return asset('uploads/offers/'.$this->image);
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }
}
