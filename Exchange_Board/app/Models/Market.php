<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Market extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agents(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function marketDetails():HasMany
    {
        return $this->hasMany(AddMarketDetails::class);
    }
}
