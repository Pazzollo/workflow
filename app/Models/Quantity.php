<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quantity extends Model
{
    /** @use HasFactory<\Database\Factories\QuantityFactory> */
    use HasFactory;

    protected $fillable = [
        'material_id',
        'quantity',
        'measure',
        'transfer',
        'description',
        'company_id',
        'material_id',
    ];

    public function material() :BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function company() :BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
