<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'width',
        'length',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
