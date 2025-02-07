<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyContact extends Model
{
    use HasFactory;

    protected $table = 'company_contact';

    protected $fillable = [
        'contact_id',
        'company_id',
        'start_date',
        'end_date',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
