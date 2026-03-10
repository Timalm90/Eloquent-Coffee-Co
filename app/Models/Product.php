<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Type;

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
        'inventory',
        'price',
        'in_stock',
        'image',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->in_stock = $product->inventory > 0;

            // Assign a random image once, using type_id
            if (!$product->image && $product->type_id) {
                $type = Type::find($product->type_id);
                if ($type) {
                    $typeName = strtolower(str_replace(' ', '_', $type->type));
                    $path = public_path("images/$typeName");
                    $files = glob($path . '/*.png');

                    if ($files) {
                        $product->image = str_replace(public_path(), '', $files[array_rand($files)]);
                    } else {
                        $product->image = '/images/default.png';
                    }
                }
            }
        });

        static::updating(function ($product) {
            $product->in_stock = $product->inventory > 0;
        });
    }

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

    // Normalize strings for presentation (preserves DB values)
    private function normalizeString(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    // Accessor for product name
    public function getNameAttribute($value)
    {
        return $this->normalizeString($value);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ?? '/images/default.png';
    }
}
