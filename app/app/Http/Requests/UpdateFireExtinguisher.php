<?php

namespace App\Http\Requests;

use App\Models\FireExtinguisher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFireExtinguisher extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action_type' => ['required','string', Rule::in(FireExtinguisher::UPDATE_ACTION_TYPES)],
            'date' => 'required|date',
            'comments' => 'nullable|string',
        ];
    }
}
