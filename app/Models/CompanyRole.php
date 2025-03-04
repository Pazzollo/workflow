<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyRole extends Model
{
    use HasFactory;

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
