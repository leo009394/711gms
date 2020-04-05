<?php


namespace App\Http\Controllers;

use App\Http\Requests\Store\GetList;
use App\Http\Requests\Store\PutUpdate;
use App\Http\Requests\Store\PostCreate;
use App\Http\Resources\Response;
use App\Models\Store;
use App\Services\StoreService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoreController
{
    /** @var StoreService */
    protected $service;

    /**
     * StoreController constructor.
     * @param StoreService $service
     */
    public function __construct(StoreService $service)
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
        if (!$entity instanceof Store) {
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
     * @param PostCreate $request
     * @return \App\Http\Resources\Response
     * @throws \Exception
     */
    public function register(PostCreate $request)
    {
        $entity = $this->service->create($request->validated());
        return new Response($entity);
    }
}
