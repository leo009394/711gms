<?php


namespace App\Repositories;

use \App\Models\Store;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class StoreRepository
{
    /** @var Store */
    protected $model;

    /**
     * StoreRepository constructor.
     * @param Store $model
     */
    public function __construct(
        Store $model
    ) {
        $this->model = $model;
    }

    /**
     * @param array $params
     * @param array $storeIds
     * @param bool $isAdmin
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $params, array $storeIds, bool $isAdmin)
    {
        /** @var Builder $query */
        $query = $this->model->newQuery();

        $query->orderBy($params['sort_field'] ?? 'id', $params['sort_type'] ?? 'asc');

        if (isset($params['active'])) {
            $query->where('active', $params['active']);
        } else {
            $query->where('active', 1);
        }

        if (isset($params['name'])) {
            $query->where('active', 'like', "%{$params['name']}%");
        }

        if (isset($params['phone'])) {
            $query->where('active', 'like', "%{$params['phone']}%");
        }

        if (isset($params['address'])) {
            $query->where('active', 'like', "%{$params['address']}%");
        }

        if(isset($params['manager_name']) || isset($params['manager_mail'])) {
            $query = $query->whereHas('managerUser',  function ($q) use ($params) {
                if (isset($params['manager_name'])) {
                    $q->where(function ($q1) use ($params) {
                        $q1->where('first_name', 'like', "%{$params['manager_name']}%")
                            ->orWhere('last_name', 'like', "%{$params['manager_name']}%");
                    });
                }

                if (isset($params['manager_mail'])) {
                    $q->where('email', 'like', "{$params['manager_mail']}%");
                }
            });
        }

        if (isset($params['owner_name']) || isset($params['owner_mail'])) {
            $query = $query->whereHas('ownerUser', function ($q) use ($params) {
                if (isset($params['owner_name'])) {
                    $q->where(function ($q1) use ($params) {
                        $q1->where('first_name', 'like', "%{$params['owner_name']}%")
                            ->orWhere('last_name', 'like', "%{$params['owner_name']}%");
                    });
                }

                if (isset($params['owner_mail'])) {
                    $q->where('email', 'like', "{$params['owner_mail']}%");
                }
            });
        }
        if (isset($params['in_charger_name']) || isset($params['in_charger_mail'])) {
            $query = $query->whereHas('inChargerUser', function ($q) use ($params) {
                if (isset($params['in_charger_name'])) {
                    $q->where(function ($q1) use ($params) {
                        $q1->where('first_name', 'like', "%{$params['in_charger_name']}%")
                            ->orWhere('last_name', 'like', "%{$params['in_charger_name']}%");
                    });
                }

                if (isset($params['in_charger_mail'])) {
                    $q->where('email', 'like', "{$params['in_charger_mail']}%");
                }
            });
        }
        $query = $query->with('users', 'managerUser', 'ownerUser', 'inChargerUser');

        if(!$isAdmin) {
            $query = $query->where('id', 'IN', $storeIds);
        }

        if (!empty($params['ignore_limit'])) {
            return $query->get();
        }

        return $query->paginate($params['limit'] ?? 10, ['Stores.*'], 'page', $params['page']);
    }

    /**
     * @param string $uuid
     * @return Store|null
     */
    public function getByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    /**
     * @param array $data
     * @return Store
     * @throws \Exception
     */
    public function create(array $data)
    {
        /** @var Store $entity */
        $entity = $this->model->make($data);
        $entity->uuid = Uuid::uuid4()->toString();
        $entity->save();
        return $entity;
    }

    /**
     * @param Store $entity
     * @param array $data
     * @return bool
     */
    public function update(Store $entity, array $data)
    {
        return $entity->update($data);
    }
}
