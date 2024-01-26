<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Contracts\MasterData\PlantCategoryContract;
use App\Models\MasterData\PlantCategory;

class PlantCategoryRepository extends BaseRepository implements PlantCategoryContract
{
    protected $plantCategory;

    public function __construct(PlantCategory $plantCategory)
    {
        parent::__construct($plantCategory);
        $this->plantCategory = $plantCategory;
    }

    public function indexSearch(array $request)
    {
        $per_page = $request['per_page'] ?? config('default.pagination.per_page');
        $sort_by = $request['sort_by'] ?? config('default.sort.by');
        $sort_direction = $request['sort_direction'] ?? config('default.sort.direction');
        $search = $request['search'] ?? null;

        $query = $this->plantCategory
            ->orderBy($sort_by, $sort_direction);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($per_page);
    }
}
