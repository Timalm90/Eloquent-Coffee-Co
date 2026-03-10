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

    // Normalize strings for presentation (preserves DB values)
    private function normalizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    // Accessor for roast
    public function getRoastAttribute($value)
    {
        return $this->normalizeString($value);
    }
}
