<?php

namespace App\Repositories\User\Admin\Eloquent;

use App\Models\Backend\ListBank;
use App\Repositories\User\Admin\Interfaces\ListBankInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ListBankRepository extends BaseRepository implements ListBankInterface
{
	protected $model;

	public function __construct(ListBank $model){
		$this->model = $model;
	}

	public function getAllListBank(){
		$this->model->all();
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
