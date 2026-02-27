<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $fillable = ['country'];

    // One country could have several regions
    public function regions()
    {
        return $this->hasMany(Region::class, 'country_id');
    }

    // One country could have several products
    public function products()
    {
        return $this->hasMany(Product::class, 'country_id');
    }
}
