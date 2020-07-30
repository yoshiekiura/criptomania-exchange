<?php

namespace App\Repositories\User\Trader\Eloquent;

use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Models\User\DepositBankTransfer;
use App\Repositories\BaseRepository;

class DepositBankRepository extends BaseRepository implements DepositBankInterface
{
    /**
     * @var Deposit
     */
    protected $model;

    public function __construct(DepositBankTransfer $deposit)
    {
        $this->model = $deposit;
    }

    public function updateOrCreate(array $attributes, array $conditions)
    {
        return $this->model->updateOrCreate($conditions, $attributes);
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function firstOrFail(array $conditions, $relations = null)
    {
        return $this->model->where($conditions)->with($this->extractToArray($relations))->firstOrFail();
    }

     public function getByIdDepo(array $ids, array $conditions = [])
    {
        $model = $this->model->whereIn('id', $ids);

        if (!empty($conditions)) {
            $model = $model->where($conditions);
        }

        return $model->get();
    }

    public function getDepositBankByCondition($conditions)
    {
        $depoBank = $this->getDeposit($conditions)->first();

        return $depoBank;
    }



    public function getDeposit($conditions)
    {
        return $this->model->where($conditions)
            ->join('users', 'users.id', '=', 'deposit_bank_transfer.users_id')
            ->join('wallets', 'wallets.id', '=', 'deposit_bank_transfer.wallet_id')
            ->join('stock_items', 'stock_items.id', '=', 'deposit_bank_transfer.stock_item_id')
            ->join('list_bank as list_bank', 'list_bank.id', '=', 'deposit_bank_transfer.admin_bank_id')
            ->select([

                'deposit_bank_transfer.*',
                'users.email',
                'wallets.id',
                'deposit_bank_transfer.id',
                'stock_items.item_name',
                'list_bank.bank_name',
                'list_bank.account_number',
            ]);
    }
}