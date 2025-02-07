<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Sapient Graphics d.o.o.',
            'address' => 'Nehruova 2a',
            'city' => 'Beograd',
            'pib' => 105399500,
            'mbr' => 20367067,
            'phone1' => '011/2160-234',
            'phone2' => '011/2288-434',
            'email1' => 'office@sapient.rs',
            'status_id' => 1,
            'company_role_id' => 1
        ];
    }
}
