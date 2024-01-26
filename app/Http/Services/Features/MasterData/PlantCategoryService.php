<?php

namespace App\Http\Services\Features\MasterData;

use App\Http\Repositories\Contracts\MasterData\PlantCategoryContract;
use App\Http\Resources\MasterData\PlantCategory\PlantCategoryResource;
use Exception;

class PlantCategoryService
{
    protected $repository;

    public function __construct(PlantCategoryContract $plantCategoryRepository)
    {
        $this->repository = $plantCategoryRepository;
    }

    protected function payload($request)
    {
        $payloads = [
            'name' => $request['name'],
        ];

        return $payloads;
    }

    public function indexService(array $request)
    {
        $plantCategories = $this->repository->indexSearch($request);

        return PlantCategoryResource::collection($plantCategories);
    }

    public function findService($id)
    {
        $plantCategory = $this->repository->find($id);

        return new PlantCategoryResource($plantCategory);
    }

    public function storeService(array $request)
    {
        $inputData = $this->payload($request);

        $plantCategory = $this->repository->store($inputData);

        return new PlantCategoryResource($plantCategory);
    }

    public function updateService(array $request, $id)
    {
        $inputData = $this->payload($request);

        $this->repository->update($inputData, $id);

        return $this->findService($id);
    }

    public function deleteService($id)
    {
        // $plants = $this->repository->find($id)->plants->count();

        // if ($plants != 0) {
        //     throw new Exception('Plant Category Already Used');
        // }

        $this->repository->delete($id);
    }
}
