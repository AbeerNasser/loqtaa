<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
       'image','description','urlink',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(){
        return asset('uploads/ads/'.$this->image);
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }
}
