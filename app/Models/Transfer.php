<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_doughter_id',
        'user_id',
        'transfer_type_id',
        'transfer_date',
        'description',
        'ammount',
        'company_id',
        'deleted',
        'deleted_by',
        'status',
    ];
    public static array $category = ['In', 'Out'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function statement()
    {
        return $this->hasMany(Statement::class);
    }
}
