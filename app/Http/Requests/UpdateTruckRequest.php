<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTruckRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unit_number' => 'required|string|max:255|unique:trucks,unit_number,' . $this->route('id'),
            'year'        => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'notes'       => 'nullable|string',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
