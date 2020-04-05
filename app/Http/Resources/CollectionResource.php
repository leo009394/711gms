<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);

        $data = [];
        if ($this->resource instanceof Paginator && isset($response['data'])) {
            $data['items'] = $response['data'];
            $data['pagination'] = $this->getPaginationData($response);
        } elseif ($this->resource instanceof Collection) {
            $data['items'] = $response;
        } elseif ($this->resource instanceof Model) {
            $data['item'] = $response;
        } else {
            $data = $response;
        }

        $result = [
            'status' => 'true',
            'data' => $data
        ];

        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    private function getPaginationData(array $data)
    {
        return [
            'total' => $data['total'] ?? 0,
            'per_page' => $data['per_page'],
            'current_page' => $data['current_page'],
            'total_pages' => $data['last_page'] ?? 0,
        ];
    }

    /**
     * @param $key
     * @param $value
     * @return CollectionResource
     */
    public function withData($key, $value)
    {
        return $this->additional([
            'data' => [
                $key => $value
            ]
        ]);
    }
}
