<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $fillable = [
        'materialtype_id',
        'brand',
        'finish_id',
        'dimension_id',
        'weight',
        'tickness',
        'description'
    ];

    public function materialtype(): BelongsTo {
        return $this->belongsTo(Materialtype::class);
    }

    public function finish() : BelongsTo {
        return $this->belongsTo(Finish::class);
    }

    public function quantities() : HasMany
    {
        return $this->hasMany(Quantity::class);
    }

    public function reservations() : HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function dimension() : BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }
}
