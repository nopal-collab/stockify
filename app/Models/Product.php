<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'stock',
        'harga_beli',
        'harga_jual',
        'min_stock',
        'description',
        'image',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION CATEGORY
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION SUPPLIER
    |--------------------------------------------------------------------------
    */

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION STOCK TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION ATTRIBUTE VALUES (nilai atribut untuk produk ini)
    |--------------------------------------------------------------------------
    */

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION ATTRIBUTES (via pivot product_attribute_values)
    |--------------------------------------------------------------------------
    */

    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_values')
                    ->withPivot('value')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — apakah stok di bawah atau sama dengan batas minimum?
    |--------------------------------------------------------------------------
    */

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->min_stock;
    }
}