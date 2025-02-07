<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone2',
        'birthday',
        'company_id',
        'start_date',
        'end_date'
    ];

    public function companies() {
        return $this->belongsToMany(Company::class, 'company_contact')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }
}
