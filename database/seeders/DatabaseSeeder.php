<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Doughter;
use App\Models\Status;
use App\Models\Transfer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Factories\TransferFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $statuses = [
            'Active',
            'Inactive',
            'Pending',
        ];

        foreach ($statuses as $status) {
            Status::factory()->create([
                'name' => $status,
            ]);
        }

        $roles = [
            'Admin',
            'Associate',
            'Commercialist',
            'Guest',
        ];

        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
                'name' => $role,
            ]);
        }

        $companyRoles = [
            'Mother',
            'Daughter',
            'Customer',
            'Supplier',
            'Customer & Supplier',
        ];

        foreach ($companyRoles as $companyRole) {
            \App\Models\CompanyRole::factory()->create([
                'name' => $companyRole,
            ]);
        }

        $companies = [
            [
                'name' => 'Sapient Graphics d.o.o.',
                'address' => 'Nehruova 2a',
                'city' => 'Beograd',
                'pib' => 105399500,
                'mbr' => 20367067,
                'status_id' => 1,
                'company_role_id' => 1
            ],
            [
                'name' => 'Outer Gear SZR',
                'address' => 'Bulevar Kralja Aleksandra 73',
                'city' => 'Beograd',
                'pib' => 123456789,
                'mbr' => 987654321,
                'status_id' => 1,
                'company_role_id' => 2
            ],
            [
                'name' => 'Foils SZR',
                'address' => 'Bulevar Kralja Aleksandra 73',
                'city' => 'Beograd',
                'pib' => 123456799,
                'mbr' => 98765432,
                'status_id' => 1,
                'company_role_id' => 2
            ]
        ];

        foreach ($companies as $company) {
            Company::factory()->create($company);
        }

        $users = [
            [
                'name' => 'Zoran Mišić',
                'email' => 'zoran@sapient.rs',
                'phone1' => '+38163245817',
                'phone2' => '+38163690024',
                'status_id' => 1,
                'password' => Hash::make('Gandi152'),
                'role_id' => 1,
                'company_id' => 1
            ],
            [
                'name' => 'Nemanja Lukić',
                'email' => 'nemanja@sapient.rs',
                'phone1' => '+38163690111',
                'status_id' => 1,
                'password' => Hash::make('password'),
                'role_id' => 3,
                'company_id' => 1
            ],
            [
                'name' => 'Vlada Milaković',
                'email' => 'vlada@outergear.rs',
                'phone1' => '+381641739477',
                'status_id' => 1,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'company_id' => 2
            ],
            [
                'name' => 'Vuk Stojisavljević',
                'email' => 'office@foils.rs',
                'phone1' => '+381656831336',
                'status_id' => 1,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'company_id' => 3
            ],
            [
                'name' => 'Bojan Ristić',
                'email' => 'bojan@foils.rs',
                'phone1' => '+38163436469',
                'status_id' => 1,
                'password' => Hash::make('password'),
                'role_id' => 2,
                'company_id' => 3
            ]
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        for($i = 2; $i < 4; $i++) {
            Doughter::factory()->create([
                'company_id' => $i
            ]);
        }

        $tranferTypes = [
            'Uplata',
            'Isplata'
        ];

        foreach ($tranferTypes as $tranferType) {
            \App\Models\TransferType::factory()->create([
                'name' => $tranferType,
            ]);
        }

        $transfers = [
            [
                'description' => 'Početno stanje',
                'ammount' => 0,
                'company_id' => 2,
                'transfer_type_id' => 1,
                'transfer_date' => '2021-08-01',
                'user_id' => 1,
                'transfer_doughter_id' => 2,
                'status' => 1
            ],
            [
                'description' => 'Početno stanje',
                'ammount' => 0,
                'company_id' => 3,
                'transfer_type_id' => 1,
                'transfer_date' => '2021-08-01',
                'user_id' => 1,
                'transfer_doughter_id' => 3,
                'status' => 1
            ]
        ];

        foreach ($transfers as $transfer) {
            Transfer::factory()->create($transfer);
        }
    }
}
