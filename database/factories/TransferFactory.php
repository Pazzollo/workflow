<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'ammount' => $this->faker->randomFloat(2, 10, 1000000),
            'user_id' => fake()->numberBetween(3, 5),
            'company_id' => fake()->numberBetween(4, 10),
            'transfer_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'transfer_type_id' => fake()->numberBetween(1, 2),
            'transfer_doughter_id' => null,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('created_at', 'now')
        ];
    }

    public function doughter()
    {
        return $this->state(function (array $attributes) {
            $user = $attributes['user_id'];
            if ($user === 3) {
                $doughter = 2;
            } elseif ($user === 4 || $user === 5) {
                $doughter = 3;
            } else {
                $doughter = null;
            }
            return [
                'transfer_doughter_id' => $doughter
            ];
        });
    }

    public function checkTransferType()
    {
        return $this->state(function (array $attributes) {
            $company = Company::where($attributes['company_id'])->firstOrFail();
            if ($company->company_role_id === 3) {
                return [
                    'transfer_type_id' => 1
                ];
            } elseif ($company->company_role_id === 4) {
                return [
                    'transfer_type_id' => 2
                ];
            } else {
                return [
                    'transfer_type_id' => $attributes['transfer_type_id']
                ];
            }
        });
    }
}
