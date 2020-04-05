<?php


namespace App\Http\Controllers;


use App\Http\Requests\User\GetList;
use App\Http\Requests\User\PutUpdate;
use App\Http\Requests\User\Register;
use App\Http\Resources\Response;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController
{
    /** @var UserService */
    protected $service;

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param GetList $request
     * @return Response
     */
    public function index(GetList $request)
    {
        $params = $request->validated();
        $params['user_uuid'] = $request->user()->uuid;
        $entities = $this->service->getList($params);

        return new Response($entities);
    }

    /**
     * @param string $uuid
     * @return \App\Http\Resources\Response
     */
    public function show(string $uuid)
    {
        $entity = $this->service->getByUuid($uuid);
        if (!$entity instanceof User) {
            throw new NotFoundHttpException('user.not_found');
        }

        return new Response($entity);
    }

    /**
     * @param string $uuid
     * @param PutUpdate $request
     * @return \App\Http\Resources\Response
     * @throws \Exception
     */
    public function update(string $uuid, PutUpdate $request)
    {
        $entity = $this->service->getByUuid($uuid);
        $this->service->update($entity, $request->validated());

        return new Response($entity);
    }

    /**
     * @param Register $request
     * @return \App\Http\Resources\Response
     * @throws \Exception
     */
    public function register(Register $request)
    {
        $entity = $this->service->create($request->validated());
        return new Response($entity);
    }
}
