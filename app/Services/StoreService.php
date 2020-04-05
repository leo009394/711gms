<?php


namespace App\Services;

use App\Models\Store;
use App\Repositories\StoreRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreService
{
    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * StoreService constructor.
     * @param UserService $userService
     * @param StoreRepository $storeRepository
     */
    public function __construct(
        UserService $userService,
        StoreRepository $storeRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->userService = $userService;
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $params)
    {
        if(empty($params['user_uuid'])) {
            return new LengthAwarePaginator([], 0, 1);
        }
        $user = $this->userService->getByUuid($params['user_uuid']);
        if(empty($params['user_uuid'])) {
            return new LengthAwarePaginator([], 0, 1);
        }
        $storeIds =  $user->stores()->pluck('id');
        if(!$user->is_admin && $storeIds->isEmpty()) {
            return new LengthAwarePaginator([], 0, 1);
        }

        return $this->storeRepository->getList($params, $storeIds->toArray(), $user->is_admin);
    }

    /**
     * @param string $uuid
     * @return Store
     */
    public function getByUuid(string $uuid)
    {
        return $this->storeRepository->getByUuid($uuid);
    }


    /**
     * @param array $params
     * @return Store|mixed
     * @throws \Exception
     */
    public function create(array $params)
    {
        return $this->storeRepository->create($params);
    }

    /**
     * @param Store $store
     * @param array $params
     * @return bool
     */
    public function update(Store $store, array $params)
    {
        return $this->storeRepository->update($store, $params);
    }
}
