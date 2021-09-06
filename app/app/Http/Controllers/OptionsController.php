<?php

namespace App\Http\Controllers;

use App\Models\CustomerSite;
use App\Models\EquipmentType;
use Symfony\Component\HttpFoundation\JsonResponse;

class OptionsController extends Controller
{
    public function index(): JsonResponse
    {
        $response['customer_sites'] = CustomerSite::all();
        $response['equipment_types'] = EquipmentType::all();

        return response()->json($response, JsonResponse::HTTP_OK);
    }
}
