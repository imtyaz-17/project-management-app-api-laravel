<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tickets():HasMany
    {
        return $this->hasMany(Ticket::class)->orderBy('rank');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
