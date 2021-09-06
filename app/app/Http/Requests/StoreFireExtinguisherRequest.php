<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFireExtinguisherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_site_id' => 'required|numeric|exists:customer_sites,id',
            'equipment_type_id' => 'required|numeric|exists:equipment_types,id',
            'standby_place' => 'required|string',
            'manufacturing_number' => 'required|string',
            'manufactured_at' => 'required|date',
            'comments' => 'nullable|string',
            'replicas' => 'nullable|numeric|gte:2'
        ];
    }
}
