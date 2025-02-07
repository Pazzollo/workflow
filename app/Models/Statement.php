<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'ammount',
        'statement_date'
    ];
    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }
}
