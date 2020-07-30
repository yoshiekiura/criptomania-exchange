<?php

namespace App\Repositories\User\Trader\Eloquent;

use App\Models\User\BankName;
use App\Repositories\User\Trader\Interfaces\BankNameInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BankNameRepository extends BaseRepository implements BankNameInterface
{
    protected $model;

    public function __construct(BankName $model){
        $this->model = $model;
    }

    public function getAllBankName()
    {
        $this->model->all();
    }

    public function getBankNameCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function updateBankNameRows(array $attributes, array $conditions = null)
    {
        $model = is_null($conditions) ? $this->model : $this->model->where($conditions);

        return $model->update($attributes);
    }

    public function getBankNameById($userId)
    {
        return $this->model->where('user', $userId)
            ->select([
                'bank_name',
                'account_number',
            ]);
    }

}
