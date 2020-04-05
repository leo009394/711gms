<?php

namespace App\Http\Requests\User;

use App\Http\Requests\WithoutAuthorizeRequest;
use Illuminate\Foundation\Http\FormRequest;

class GetList extends FormRequest
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
            'limit' => 'integer|min:0|max:500',
            'page' => 'integer',
            'sort_field' => 'string',
            'sort_type' => 'in:asc,desc',
            'name' => 'string',
            'email' => 'string',
            'active' => 'integer',
            'employee_number' => 'string',
            'rank' => 'string',
        ];
    }
}
