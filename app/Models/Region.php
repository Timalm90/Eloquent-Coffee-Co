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

    // Normalize strings for presentation (preserves DB values)
    private function normalizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    // Accessor for region
    public function getRegionAttribute($value)
    {
        return $this->normalizeString($value);
    }
}
