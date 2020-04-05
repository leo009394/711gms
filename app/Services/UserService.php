<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(array $params)
    {
        if(empty($params['user_uuid'])) {
            return new LengthAwarePaginator([], 0, 1);
        }
        $user = $this->getByUuid($params['user_uuid']);
        $user->is_admin = 1;
        if(empty($params['user_uuid'])) {
            return new LengthAwarePaginator([], 0, 1);
        }
        $storeIds =  $user->stores()->pluck('id');
        if(!$user->is_admin && $storeIds->isEmpty()) {
            return new LengthAwarePaginator([], 0, 1);
        }

        /** @var LengthAwarePaginator $users */
        return $this->userRepository->getList($params, $storeIds->toArray(), $user->is_admin);
    }

    /**
     * @param string $uuid
     * @return User
     */
    public function getByUuid(string $uuid)
    {
        return $this->userRepository->getByUuid($uuid);
    }


    /**
     * @param array $params
     * @return User|mixed
     * @throws \Exception
     */
    public function create(array $params)
    {
        return $this->userRepository->create($params);
    }

    /**
     * @param User $user
     * @param array $params
     * @return bool
     */
    public function update(User $user, array $params)
    {
        return $this->userRepository->update($user, $params);
    }
}
