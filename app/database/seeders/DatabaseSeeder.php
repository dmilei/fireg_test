<?php

namespace Database\Seeders;

use App\Models\CustomerSite;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CustomerSite::factory(10)->create();
        EquipmentType::factory(10)->create();
    }
}
