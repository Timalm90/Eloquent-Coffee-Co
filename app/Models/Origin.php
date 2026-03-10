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

    // Normalize strings for presentation (preserves DB values)
    private function normalizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    // Accessor for country
    public function getCountryAttribute($value)
    {
        return $this->normalizeString($value);
    }
}
