<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['type'];

    // Several products could belong to the same type
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
