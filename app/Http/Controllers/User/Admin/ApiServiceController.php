<?php

namespace App\Http\Controllers\User\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\Admin\Interfaces\ApiServiceInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\Admin\ApiServiceRequest;
/*
    Developer   : Muhammad Rizky Firdaus
    Date        : 26-08-2020
    Description : Controller for Api Service CRUD

*/
class ApiServiceController extends Controller
{
	public $apiservice;
    
    public function __construct(ApiServiceInterface $apiservice)
    {
    	$this->apiservice = $apiservice;
    }

    public function index()
    {
    	$searchFields = [
            ['api_name', __('Api Name')],
            ['api_value', __('Api Core Name')],
        ];

        $orderFields = [
            ['api_name', __('Api Name')],
            ['api_value', __('Api Core Name')],
            ['api_stock_item.created_at', __('Created Date')],
        ];


        $query = $this->apiservice->paginateWithFilters($searchFields, $orderFields);

        $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        $data['title'] = __('Api Service List');

        return view('backend.apiService.index', $data);
    }

     public function create()
    {
        $data['title'] = __('Create New Api Service');

        return view('backend.apiService.create', $data);
    }

       public function store(ApiServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $attributes = $request->only('api_value','api_name');

            $this->apiservice->create($attributes);

            DB::commit();

            return redirect()->route('admin.api-service-name')->with(SERVICE_RESPONSE_SUCCESS, __('The Api Service has been created successfully.'));
        }
        catch (\Exception $exception) {
            DB::rollBack();
            if($exception->getCode() == 23000) {
                return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('The Api Service already exists.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create Api Service.'));
        }
    }



}
