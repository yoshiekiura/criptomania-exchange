<?php

namespace App\Repositories\User\Admin\Eloquent;
use App\Repositories\BaseRepository;
use App\Models\Backend\ApiService;
use App\Repositories\User\Admin\Interfaces\ApiServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;


class ApiServiceRepository extends BaseRepository implements ApiServiceInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(ApiService $model)
    {
      $this->model = $model;
    }

    public function getAllApiService()
    {
    	$data = $this->model->all();
        return Datatables::of($data)->addIndexColumn()
                                    ->editColumn('created', function($row){
                                        return $row->created_at->toDateTimeString();
                                    })
                                    ->rawColumns(['created'])->make(true);
    }

    public function getApiServiceCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function updateApiServiceRows(array $attributes, array $conditions = null)
    {
        $model = is_null($conditions) ? $this->model : $this->model->where($conditions);

        return $model->update($attributes);
    }

}