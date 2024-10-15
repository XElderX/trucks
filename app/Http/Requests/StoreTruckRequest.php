<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'unit_number' => 'required|string|max:255|unique:trucks,unit_number',
            'year'        => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes'       => 'nullable|string',
        ];
    }
}
