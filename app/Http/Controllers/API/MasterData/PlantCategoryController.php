<?php

namespace App\Http\Controllers\API\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\PlantCategory\IndexPlantCategoryValidation;
use App\Http\Requests\API\MasterData\PlantCategory\StorePlantCategoryValidation;
use App\Http\Requests\API\MasterData\PlantCategory\UpdatePlantCategoryValidation;
use App\Http\Services\Features\MasterData\PlantCategoryService;
use App\Models\MasterData\PlantCategory;

class PlantCategoryController extends Controller
{
    protected $service;

    public function __construct(PlantCategoryService $service)
    {
        $this->service = $service;
    }

    public function index(IndexPlantCategoryValidation $request)
    {
        $params = $request->validated();

        try {
            $plantCategories = $this->service->indexService($params);

            return $this->paginatedApiResponse(
                'success',
                'Successfully Retrieved Plant Category Data',
                200,
                $plantCategories
            );
        } catch (\Throwable $th) {
            return $this->specificApiResponse('failed', $th->getMessage(), 400);
        }
    }

    public function show($id)
    {
        try {
            $plantCategory = $this->service->findService($id);

            return $this->specificApiResponse(
                'success',
                'Successfully Retrieved Specific Plant Category Data',
                200,
                $plantCategory
            );
        } catch (\Throwable $th) {
            return $this->specificApiResponse('failed', $th->getMessage(), 400);
        }
    }

    public function store(StorePlantCategoryValidation $request)
    {
        $inputData = $request->validated();

        try {
            $plantCategory = $this->service->storeService($inputData);

            return $this->specificApiResponse(
                'success',
                'Successfully Stored Plant Category Data',
                201,
                $plantCategory
            );
        } catch (\Throwable $th) {
            return $this->specificApiResponse('failed', $th->getMessage(), 400);
        }
    }

    public function update(UpdatePlantCategoryValidation $request, $id)
    {
        $inputData = $request->validated();

        try {
            $plantCategory = $this->service->updateService($inputData, $id);

            return $this->specificApiResponse(
                'success',
                'Successfully Updated Plant Category Data',
                200,
                $plantCategory
            );
        } catch (\Throwable $th) {
            return $this->specificApiResponse('failed', $th->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->deleteService($id);

            return $this->specificApiResponse('success', 'Plant Category Successfully Deleted', 200);
        } catch (\Throwable $th) {
            return $this->specificApiResponse('failed', $th->getMessage(), 400);
        }
    }
}
