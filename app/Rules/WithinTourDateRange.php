<?php

namespace App\Rules;

use App\Models\Tour;
use Illuminate\Contracts\Validation\Rule;

class WithinTourDateRange implements Rule
{
    protected $tourId;
    protected $isStartDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tourId, $isStartDate)
    {
        $this->tourId = $tourId;
        $this->isStartDate = $isStartDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tour = Tour::find($this->tourId);

        if (!$tour || $value < $tour->start_date || $value > $tour->end_date) {
            return false;
        }

        return true;
    }

    public function message()
    {
        if ($this->isStartDate) {
            return "The selected start date is not within the tour's start and end dates.";
        } else {
            return "The selected end date is not within the tour's start and end dates.";
        }
    }
}
