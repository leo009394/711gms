<?php

namespace App\Http\Requests\User;

use App\Http\Requests\WithoutAuthorizeRequest;
use Illuminate\Foundation\Http\FormRequest;

class PutUpdate extends FormRequest
{
    use WithoutAuthorizeRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email',
            'password' => 'string|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'roles' => 'array',
            'phone' => 'string|nullable',
            'is_admin' => 'boolean',
            'active' => 'boolean',
            'first_name'=> 'string',
            'local_first_name'=> 'string',
            'last_name'=> 'string',
            'local_last_name'=> 'string',
            'employee_number'=> 'string|nullable',
            'rank'=> 'string|nullable',
            'birthdate' => 'date',
            'zip_code' => 'string|nullable',
            'state' => 'string|nullable',
            'city' => 'string|nullable',
            'street' => 'string|nullable',
            'building'=> 'string|nullable',
            'stores' => 'array',
        ];
    }
}
