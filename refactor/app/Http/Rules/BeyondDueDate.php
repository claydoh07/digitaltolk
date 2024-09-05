<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class AtLeastOneFieldRequired implements Rule
{
    private $due_date;
    private $due_time;

    public function __construct($due_date, $due_time)
    {
        $this->due_date = $due_date;
        $this->due_time = $due_time;
    }

    public function passes($attribute, $value)
    {
        $due = $this->due_date . " " . $this->due_time;
        $due_carbon = Carbon::createFromFormat('m/d/Y H:i', $due);
        if ($due_carbon->isPast()) {
           return false;
        }
        return true;
    }

    public function message()
    {
        $response['status'] = 'fail';
        $response['message'] = "Can't create booking in past";
        $response['field_name'] = "due_date";
        return $response;
    }
}

?>