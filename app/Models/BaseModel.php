<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{

    /**
     * Convert array to object string
     *
     * @param string $value
     * @param bool $asObject
     *
     * @return mixed
     */
    public function fromJson($value, $asObject = false)
    {
        return json_decode($value, $asObject);
    }

    /**
     * Convert Unicode
     *
     * @param mixed $value
     *
     * @return false|string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
