<?php

namespace App\Http\Requests\API\MasterData\PlantCategory;

use App\Http\Requests\API\BaseRequestValidation;

class IndexPlantCategoryValidation extends BaseRequestValidation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string',
            'sort_by' => 'sometimes|string',
            'sort_direction' => 'sometimes|string|in:asc,desc',
        ];
    }
}
