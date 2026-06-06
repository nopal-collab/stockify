<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'options',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST — options disimpan sebagai JSON, otomatis jadi array
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'options' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION — satu atribut bisa punya banyak nilai (dari berbagai produk)
    |--------------------------------------------------------------------------
    */

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION — produk yang menggunakan atribut ini
    |--------------------------------------------------------------------------
    */

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values')
                    ->withPivot('value')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — label tipe untuk tampilan
    |--------------------------------------------------------------------------
    */

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'text'   => 'Teks',
            'number' => 'Angka',
            'color'  => 'Warna',
            'select' => 'Pilihan',
            default  => $this->type,
        };
    }
}