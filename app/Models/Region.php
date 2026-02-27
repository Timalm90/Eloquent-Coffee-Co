<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['region', 'country_id'];

    // One regions belongs to one country 
    public function origin()
    {
        return $this->belongsTo(Origin::class, 'country_id');
    }

    // One region could have several products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
