<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_opname_id',
        'product_id',
        'system_stock',
        'physical_stock',
        'difference',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION — HEADER OPNAME
    |--------------------------------------------------------------------------
    */

    public function stockOpname()
    {
        return $this->belongsTo(StockOpname::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION — PRODUK
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}