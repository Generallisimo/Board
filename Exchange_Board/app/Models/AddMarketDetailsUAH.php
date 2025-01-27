<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddMarketDetailsUAH extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function markets():BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
    
    public function marketsUAH():BelongsTo
    {
        return $this->belongsTo(MarketUAH::class);
    }

    public function methodPaymets(): HasMany
    {
        return $this->hasMany(MethodPayments::class);
    }}
