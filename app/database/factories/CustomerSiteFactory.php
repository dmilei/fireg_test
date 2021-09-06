<?php

namespace Database\Factories;

use App\Models\CustomerSite;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerSiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerSite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company().' telephely',
        ];
    }
}
