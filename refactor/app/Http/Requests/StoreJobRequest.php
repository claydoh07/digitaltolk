<?php

namespace App\Http\Requests;

use App\Http\Rules\AtLeastOneFieldRequired;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {

        //Just a sample, it's hard to write each and every validation
        return [
            'from_language_id' => 'required',
            'due_date' => 'sometimes|not_in:""',
            'due_time' => 'sometimes|not_in:""',
            'fields_check' => [new AtLeastOneFieldRequired(['customer_phone_type', 'customer_physical_type'])],
            'duration' => 'sometimes|not_in:""',
            'check_if_beyond_due' => [new BeyondDueDate('due_date', 'due_time')],
        ];
    }

    public function messages(): array
    {
        return [
            'from_language_id.required' => ['status' => 'fail', 'message' => 'Du måste fylla in alla fält', 'field_name'=> 'from_language_id'],
            'due_date.not_in' => ['status' => 'fail', 'message' => 'Du måste fylla in alla fält', 'field_name'=> 'due_date'],
            'due_time.not_in' => ['status' => 'fail', 'message' => 'Du måste fylla in alla fält', 'field_name'=> 'due_time'],
            'duration.not_in' => ['status' => 'fail', 'message' => 'Du måste fylla in alla fält', 'field_name'=> 'duration'],
        ];
    }
}

?>