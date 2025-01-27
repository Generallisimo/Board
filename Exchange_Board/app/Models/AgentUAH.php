<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentUAH extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = false;

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function market(): HasMany
    {
        return $this->hasMany(MarketUAH::class, 'agent_id');
    }

    public function client(): HasMany
    {
        return $this->hasMany(ClientUAH::class, 'agent_id');
    }
}
