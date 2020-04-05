<?php

namespace App\Http\Requests\User;

use App\Http\Requests\WithoutAuthorizeRequest;
use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'string|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
            'roles' => 'array',
            'phone' => 'string',
            'is_admin' => 'boolean',
            'active' => 'boolean',
            'first_name'=> 'string',
            'local_first_name'=> 'string',
            'last_name'=> 'string',
            'local_last_name'=> 'string',
            'employee_number'=> 'string',
            'rank'=> 'string',
            'birthdate' => 'datetime',
            'zip_code' => 'string',
            'state' => 'string',
            'city' => 'string',
            'street' => 'string',
            'building'=> 'string',
            'stores' => 'array',
        ];
    }
}
