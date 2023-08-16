<?php

namespace App\Http\Requests;

use App\Rules\WithinTourDateRange;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $tourId = $this->input('tour_id');

        return [
            'tour_id' => 'required|exists:tours,id',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                new WithinTourDateRange($tourId, true), // true indicates start date validation
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                new WithinTourDateRange($tourId, false), // false indicates end date validation
            ],
        ];
    }
}
