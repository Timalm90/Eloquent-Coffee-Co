<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roast extends Model
{

    protected $fillable = ['roast'];

    // Several products could have one level of roast
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
