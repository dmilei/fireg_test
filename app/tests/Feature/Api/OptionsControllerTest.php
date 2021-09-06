<?php

namespace Tests\Feature\Api;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class OptionsControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->getJson(route('api.options.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->decodeResponseJson();

        $this->assertEquals(10, sizeof($response['customer_sites']));
        $this->assertEquals(10, sizeof($response['equipment_types']));
    }
}
