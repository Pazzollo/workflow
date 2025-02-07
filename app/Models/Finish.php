<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Finish extends Model
{
    /** @use HasFactory<\Database\Factories\FinishFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function materials() : HasMany {
        return $this->hasMany(Material::class);
    }
}
