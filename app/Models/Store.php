<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'bio', 'image'
    ];

    public function getImagePathAttribute()
    {
        if(!$this->image){
            return asset('images/stores/defualt.png');
        }
        return asset('images/'.$this->image);
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'store_id', 'id');
    }
}
