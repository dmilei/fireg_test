<?php

namespace Database\Factories;

use App\Models\CustomerSite;
use App\Models\EquipmentType;
use App\Models\FireExtinguisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class FireExtinguisherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FireExtinguisher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_site_id' => CustomerSite::factory(1)->create()->first()->id,
            'equipment_type_id' => EquipmentType::factory(1)->create()->first()->id,
            'standby_place' => $this->faker->randomNumber(1).'. emelet',
            'manufacturing_number' => $this->faker->randomNumber(6).'-'.$this->faker->randomNumber(6),
            'manufactured_at' => date('Y-m-d'),
            'comments' => null,
            'q1_check' => null,
            'q2_check' => null,
            'q3_check' => null,
            'q4_check' => null,
            'maintenance_date' => null
        ];
    }
}
