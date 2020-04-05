<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Response extends JsonResource
{
    /** @var string */
    protected $presenter;

    /**
     * @param $presenter
     * @return $this
     */
    public function setPresenter($presenter)
    {
        $this->presenter = $presenter;
        return $this;
    }

    /**
     * @return string
     */
    protected function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $presenter = $this->getPresenter();
        if ($this->resource instanceof AbstractPaginator) {
            $collection = $this->resource->getCollection();
            $data = [
                'items' => $presenter ? $collection->mapInto($presenter) : $collection,
                'pagination' => $this->getPaginationData()
            ];
        } elseif ($this->resource instanceof Collection) {
            $data['items'] = $presenter ? $this->resource->mapInto($presenter) : $this->resource;
        } elseif ($this->resource instanceof Model) {
            $data['item'] = $presenter ? new $presenter($this->resource) : $this->resource;
        } else {
            $data = $this->resource;
        }

        return $result = [
            'status' => true,
            'data' => $data ?? []
        ];
    }

    /**
     * @return array
     */
    private function getPaginationData()
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            $result = [
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage()
            ];
        }

        return $result ?? [];
    }

    /**
     * @param $key
     * @param $value
     * @return $this
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
