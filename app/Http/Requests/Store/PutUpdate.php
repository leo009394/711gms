<?php

namespace App\Http\Requests\Store;

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
            'name' => 'string',
            'phone' => 'string',
            'address'=> 'string',
            'closing_date'=> 'datetime',
            'owner_id' => 'int|nullable',
            'manager_id' => 'int|nullable',
            'in_charger_id' => 'int|nullable',
            'active' => 'int|nullable',
        ];
    }
}
