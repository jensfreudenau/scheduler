<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Event
 * @package App\Models
 *
 * @mixin Builder
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * @return BelongsTo
     */
    public function hisotry(): BelongsTo
    {
        return $this->belongsTo(Color::class)->withTrashed();
    }
}
