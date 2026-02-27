<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
        'region_id',
        'suffix_id',
        'roast_id',
        'type_id',
        'in_stock'
    ];

    protected $casts = [
        'in_stock' => 'boolean',
    ];

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
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->type) {
            return '/images/default.png';
        }

        $typeName = strtolower(str_replace(' ', '_', $this->type->type));

        $path = public_path("images/$typeName");

        $files = glob($path . '/*.png');

        if (!$files) {
            return '/images/default.png';
        }

        $file = $files[array_rand($files)];

        return str_replace(public_path(), '', $file);
    }
}
