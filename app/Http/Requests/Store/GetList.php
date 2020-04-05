<?php

namespace App\Http\Requests\Store;

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
            'ignore_limit' => 'integer',
            'limit' => 'integer|min:0|max:500',
            'page' => 'integer',
            'sort_field' => 'string',
            'sort_type' => 'in:asc,desc',
            'active' => 'integer',
            'name' => 'string',
            'phone' => 'string',
            'address' => 'string',
            'owner_name' => 'string',
            'owner_mail' => 'string',
            'manager_name' => 'string',
            'manager_mail' => 'string',
            'in_charger_name' => 'string',
            'in_charger_mail' => 'string'
        ];
    }
}
