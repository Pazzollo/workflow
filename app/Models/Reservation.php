<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $fillable = [
        'quantity',
        'description',
        'reserved',
        'user_id',
        'material_id',
        'company_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function material() : BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
    
    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
