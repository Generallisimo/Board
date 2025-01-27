<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }

}
