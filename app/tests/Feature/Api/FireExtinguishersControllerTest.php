<?php

namespace Tests\Feature\Api;

use App\Models\CustomerSite;
use App\Models\EquipmentType;
use App\Models\FireExtinguisher;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class FireExtinguishersControllerTest extends TestCase
{
    public function testIndex()
    {
        FireExtinguisher::factory(10)->create();

        $response = $this->getJson(route('api.extinguishers.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->decodeResponseJson();

        $this->assertEquals(10, sizeof($response));
    }

    public function testStore()
    {
        $payload = [
            'customer_site_id' => CustomerSite::first()->id,
            'equipment_type_id' => EquipmentType::first()->id,
            'standby_place' => '1. emelet',
            'manufacturing_number' => '123456-654321',
            'manufactured_at' => date('Y-m-d'),
            'comments' => 'Komment'
        ];

        $response = $this->postJson(route('api.extinguishers.store'), $payload)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->decodeResponseJson();

        $this->assertEquals($payload['customer_site_id'], $response[0]['customer_site_id']);
        $this->assertEquals($payload['equipment_type_id'], $response[0]['equipment_type_id']);
        $this->assertEquals($payload['standby_place'], $response[0]['standby_place']);
        $this->assertEquals($payload['manufacturing_number'], $response[0]['manufacturing_number']);
        $this->assertEquals($payload['manufactured_at'], $response[0]['manufactured_at']);
        $this->assertEquals($payload['comments'], $response[0]['comments']);
    }

    public function testStoreMultipleReplicas()
    {
        $payload = [
            'customer_site_id' => CustomerSite::first()->id,
            'equipment_type_id' => EquipmentType::first()->id,
            'standby_place' => '1. emelet',
            'manufacturing_number' => '123456-654321',
            'manufactured_at' => date('Y-m-d'),
            'comments' => 'Komment',
            'replicas' => 3,
        ];

        $response = $this->postJson(route('api.extinguishers.store'), $payload)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->decodeResponseJson();

        $this->assertEquals($payload['replicas'], sizeof($response));
        $this->assertEquals($payload['replicas'], sizeof(FireExtinguisher::all()));
        $this->assertEquals($payload['manufacturing_number'], $response[0]['manufacturing_number']);
        $this->assertEquals($payload['manufacturing_number'], $response[1]['manufacturing_number']);
        $this->assertEquals($payload['manufacturing_number'], $response[2]['manufacturing_number']);
    }

    public function testUpdateMaintenanceDate()
    {
        $fireExtinguisher = FireExtinguisher::factory(1)->create()->first();

        $payload = [
            'action_type' => FireExtinguisher::MAINTENANCE,
            'date' => date('Y-m-d'),
            'comments' => 'Komment',
        ];

        $this->putJson(route('api.extinguishers.update', $fireExtinguisher->id), $payload)
            ->assertStatus(JsonResponse::HTTP_OK);

        $fireExtinguisher->refresh();

        $this->assertEquals($payload['date'], $fireExtinguisher->maintenance_date);
    }

    public function testUpdatePeriodicCheckDate()
    {
        $fireExtinguisher = FireExtinguisher::factory(1)->create()->first();

        $payload = [
            'action_type' => FireExtinguisher::PERIODIC_CHECK,
            'date' => date('Y-m-d'),
            'comments' => 'Komment',
        ];

        $this->putJson(route('api.extinguishers.update', $fireExtinguisher->id), $payload)
            ->assertStatus(JsonResponse::HTTP_OK);

        $fireExtinguisher->refresh();

        $quarter = Carbon::createFromFormat('Y-m-d', $payload['date'])->quarter;
        $this->assertEquals($payload['date'], $fireExtinguisher->toArray()["q{$quarter}_check"]);
    }

    public function testDestroy()
    {
        $fireExtinguisherId = FireExtinguisher::factory(1)->create()->first()->id;

        $this->deleteJson(route('api.extinguishers.destroy', $fireExtinguisherId))
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertNull(FireExtinguisher::find($fireExtinguisherId));
    }
}
