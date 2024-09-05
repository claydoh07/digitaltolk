<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class AtLeastOneFieldRequired implements Rule
{
    private $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function passes($attribute, $value)
    {
        foreach ($this->fields as $field) {
            if (Request::input($field) !== null && Request::input($field) !== '') {
                return true;
            }
        }
        return false;
    }

    public function message()
    {
        $response['status'] = 'fail';
        $response['message'] = "Du måste göra ett val här";
        $response['field_name'] = "customer_phone_type";
        return $response;
    }
}

?>