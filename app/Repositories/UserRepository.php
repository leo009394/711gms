<?php


namespace App\Repositories;
use \App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserRepository
{
    /** @var User */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(
        User $model
    ) {
        $this->model           = $model;
    }

    /**
     * @param array $params
     * @param array $storeIds
     * @param bool $isAdmin
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(array $params, array $storeIds, bool $isAdmin)
    {
        /** @var Builder $query */
        $query = $this->model->newQuery();

        $query->orderBy($params['sort_field'] ?? 'id', $params['sort_type'] ?? 'asc');

        if (isset($params['name'])) {
            $query->where(function ($q) use ($params) {
                $q->where('first_name', 'like', "%{$params['name']}%")
                    ->orWhere('last_name', 'like', "%{$params['name']}%");
            });
        }

        if (isset($params['email'])) {
            $query->where('email', 'like', "{$params['email']}%");
        }
        if (isset($params['active'])) {
            $query->where('active', $params['active']);
        } else {
            $query->where('active', 1);
        }

        if (isset($params['employee_number'])) {
            $query->where('employee_number', $params['employee_number']);
        }

        if (isset($params['rank'])) {
            $query->where('rank', $params['rank']);
        }

        if(!$isAdmin) {
            $query = $query->whereHas('stores', function ($q) use ($storeIds) {
                $q->where('id', 'IN', $storeIds);
            });
        }

        return $query->paginate($params['limit'] ?? 10, ['users.*'], 'page', $params['page']);
    }

    /**
     * @param string $uuid
     * @return User|null
     */
    public function getByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->with('stores')->first();
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function create(array $data)
    {
        /** @var User $entity */
        $entity = $this->model->make($data);
        $entity->uuid = Uuid::uuid4()->toString();
        if (isset($data['password'])) {
            $entity->password = Hash::make($data['password']);
        }
        $entity->save();

        if (isset($data['roles'])) {
            $roles = $entity->roles()->getRelated()
                ->whereIn('slug', $data['roles'])->pluck('id');
            $entity->roles()->sync($roles);
        }
        if (isset($data['stores'])) {
            $stores = $entity->stores()->getRelated()
                ->whereIn('uuid', $data['stores'])->pluck('id');
            $entity->stores()->sync($stores);
        }

        return $entity;
    }

    /**
     * @param User $entity
     * @param array $data
     * @return bool
     */
    public function update(User $entity, array $data)
    {
        if (isset($data['password'])) {
            $entity->password = Hash::make($data['password']);
        }
        if (isset($data['roles'])) {
            $roles = $entity->roles()->getRelated()
                ->whereIn('slug', $data['roles'])->pluck('id');
            $entity->roles()->sync($roles);
        }
        if (isset($data['stores'])) {
            $stores = $entity->stores()->getRelated()
                ->whereIn('uuid', $data['stores'])->pluck('id');
            $entity->stores()->sync($stores);
        }

        return $entity->update($data);
    }
}
