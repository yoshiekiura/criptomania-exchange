<?php

namespace App\Repositories\User\Trader\Eloquent;

use App\Models\User\BankName;
use App\Repositories\User\Trader\Interfaces\BankNameInterface;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;



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

    public function getAllListBankJson($userId)
    {
        $data = $this->model->where('users_id',$userId)->get();
        return Datatables::of($data)->addIndexColumn()->addColumn('action',function($row){
                
                $btn = ' <div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">';

                                            if(has_permission('trader.trader-bank.edit')){
                                             $btn .= '<li>
                                                    <a href="'.route('trader.trader-bank.edit', $row->id).'"><i
                                                                class="fa fa-pencil"></i>Edit</a>
                                                </li>';
                                            }

                                            if(has_permission('trader.trader-bank.destroy')){
                                             $btn .=  '<li>
                                                    <a data-form-id="delete-'.$row->id.'" data-form-method="DELETE"
                                                       href="'.route('trader.trader-bank.destroy', $row->id).'" class="confirmation"
                                                       data-alert="Do you want to delete this Bank?"><i
                                                                class="fa fa-trash-o"></i> Delete</a>
                                                </li>';
                                            }
                                       
                                        $btn .= '</ul></div>';
                return $btn;
        })->rawColumns(['action'])->make(true);
    }

}
