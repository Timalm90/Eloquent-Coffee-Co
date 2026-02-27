<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'region_id', 'suffix_id', 'roast_id', 'type_id', 'in_stock'];

    public function origin()
    {
        return $this->belongsTo(Origin::class, 'country_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function suffix()
    {
        return $this->belongsTo(Suffix::class);
    }
    public function roast()
    {
        return $this->belongsTo(Roast::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
