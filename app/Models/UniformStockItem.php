<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniformStockItem extends Model
{
    protected $fillable = [
        'name',
        'category',
        'size',
        'unit',
        'stock_qty',
        'reserved_qty',
        'distributed_qty',
        'minimum_qty',
        'notes',
        'created_by_user_id',
        'updated_by_user_id',
    ];

    protected $casts = [
        'stock_qty' => 'integer',
        'reserved_qty' => 'integer',
        'distributed_qty' => 'integer',
        'minimum_qty' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

    public function getAvailableQtyAttribute(): int
    {
        return max(0, $this->stock_qty - $this->reserved_qty - $this->distributed_qty);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->available_qty <= $this->minimum_qty;
    }
}
