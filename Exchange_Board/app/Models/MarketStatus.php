<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketStatus extends Model
{
    use HasFactory;

    protected $guarded = false;
    
    protected $casts = [
        'changed_at' => 'datetime',
    ];
    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}
