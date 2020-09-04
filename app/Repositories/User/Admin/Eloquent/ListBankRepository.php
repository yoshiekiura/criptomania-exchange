<?php

namespace App\Repositories\User\Admin\Eloquent;

use App\Models\Backend\ListBank;
use App\Repositories\User\Admin\Interfaces\ListBankInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;


class ListBankRepository extends BaseRepository implements ListBankInterface
{
	protected $model;

	public function __construct(ListBank $model){
		$this->model = $model;
	}

	public function getAllListBank(){
		$data = $this->model->all();
        return Datatables::of($data)->addIndexColumn()->addColumn('action',function($row){
                
                $btn = ' <div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">';

                                            if(has_permission('admin.list-bank.edit')){
                                             $btn .= '<li>
                                                    <a href="'.route('admin.list-bank.edit', $row->id).'"><i
                                                                class="fa fa-pencil"></i>Edit</a>
                                                </li>';
                                            }

                                            if(has_permission('admin.list-bank.destroy')){
                                             $btn .=  '<li>
                                                    <a data-form-id="delete-'.$row->id.'" data-form-method="DELETE"
                                                       href="'.route('admin.list-bank.destroy', $row->id).'" class="confirmation"
                                                       data-alert="Do you want to delete this Bank?"><i
                                                                class="fa fa-trash-o"></i> Delete</a>
                                                </li>';
                                            }
                                       
                                        $btn .= '</ul></div>';
                return $btn;
        })->rawColumns(['action'])->make(true);
	}

    public function allListBank()
    {
        return $this->model->all();
    }

	public function getListBankCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function updateListBankRows(array $attributes, array $conditions = null)
    {
        $model = is_null($conditions) ? $this->model : $this->model->where($conditions);

        return $model->update($attributes);
    }

    public function getListBankById($id)
    {
        return $this->model->where('id', $id)
            ->select([
            	'bank_name',
            	'account_number',
            ]);
    }

}
