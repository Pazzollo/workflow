<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_role_id',
        'address',
        'city',
        'pib',
        'mbr',
        'status_id',
        'phone1',
        'phone2',
        'email1',
        'email2',
    ];

    public function companyRole()
    {
        return $this->belongsTo(CompanyRole::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'company_contact')
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public function companyContacts(): HasMany
    {
        return $this->hasMany(CompanyContact::class);
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class);
    }

    public static function getBalance(int $id)
    {
        $transfers = Transfer::where('transfer_doughter_id', $id)->get();
        $balance = 0;
        foreach ($transfers as $transfer) {
            if($transfer->deleted === 1 || $transfer->status === 0){
                continue;
            }
            if ($transfer->transfer_type_id === 1) {
                $balance += $transfer->ammount;
            } else {
                $balance -= $transfer->ammount;
            }
        }
        return $balance;
    }
}
