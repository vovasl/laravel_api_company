<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyVersionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'version' => 1,
            'name' => $this->faker->company(),
            'edrpou' => $this->faker->numerify('########'),
            'address' => $this->faker->address(),
        ];
    }
}
