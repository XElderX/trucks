<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB; // Import the DB facade

class AddSubunitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this according to your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'main_truck' => 'required|exists:trucks,id',
            'subunit'    => [
                'required',
                'exists:trucks,id',
                'different:main_truck',
                function ($attribute, $value, $fail) {
                    if ($this->isSubunitInvalid($this->main_truck, $value, $this->start_date, $this->end_date)) {
                        $fail('The subunit dates overlap with an existing assignment for the main truck.');
                    }
                    if ($this->isSubunitCurrentlyAssigned($value, $this->start_date, $this->end_date)) {
                        $fail('The subunit truck cannot be assigned during these dates because it is currently assigned as a subunit for another truck.');
                    }
                },
            ],
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }

    /**
     * Check if the main truck can have the subunit without overlapping dates.
     *
     * @param int $mainTruckId
     * @param int $subunitId
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    protected function isSubunitInvalid($mainTruckId, $subunitId, $startDate, $endDate)
    {
        $overlappingSubunits = DB::table('truck_subunits')
            ->where(function ($query) use ($mainTruckId, $startDate, $endDate) {
                $query->where('main_truck_id', $mainTruckId)
                    ->where(function ($subQuery) use ($startDate, $endDate) {
                        $subQuery->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    });
            })
            ->exists();

        $isMainTruckAssignedAsSubunit = DB::table('truck_subunits')
            ->where('subunit_truck_id', $mainTruckId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();

        return $overlappingSubunits || $isMainTruckAssignedAsSubunit;
    }


    /**
     * Check if the subunit truck has its own assignments during the specified dates.
     *
     * @param int $subunitId
     * @param string $startDate
     * @param string|null $endDate
     * @return bool
     */
    protected function isSubunitCurrentlyAssigned($subunitId, $startDate, $endDate)
    {
        $overlappingSubunits = DB::table('truck_subunits')
            ->where(function ($query) use ($subunitId, $startDate, $endDate) {
                $query->where('main_truck_id', $subunitId)
                    ->where(function ($subQuery) use ($startDate, $endDate) {
                        $subQuery->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate);
                    });
            })
            ->exists();

        $isMainTruckAssignedAsSubunit = DB::table('truck_subunits')
            ->where('subunit_truck_id', $subunitId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();

        return $overlappingSubunits || $isMainTruckAssignedAsSubunit;
    }
}
