<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'notes',
        'status',
        'created_by',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION — ITEMS (detail produk)
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(StockOpnameItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION — USER PEMBUAT
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION — USER PENYELESAI
    |--------------------------------------------------------------------------
    */

    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — label badge status
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'       => 'Draft',
            'in_progress' => 'In Progress',
            'completed'   => 'Completed',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'       => 'gray',
            'in_progress' => 'yellow',
            'completed'   => 'green',
            default       => 'gray',
        };
    }
}