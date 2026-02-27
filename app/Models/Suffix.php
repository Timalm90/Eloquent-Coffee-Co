<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suffix extends Model
{
    protected $fillable = ['suffix'];

    // Several products could have the same suffix
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
