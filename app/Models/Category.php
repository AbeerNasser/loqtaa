<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name','image',
    ];
    protected $appends = ['image_path'];

    public function getImagePathAttribute(){
        return asset('uploads/categories/'.$this->image);
    }

    public function stores()
    {
        return $this->hasMany('App\Models\Store');
    }
}
