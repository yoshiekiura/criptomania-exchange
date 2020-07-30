<?php

namespace App\Repositories\User\Trader\Interfaces;

interface DepositBankInterface
{
     public function getByIdDepo(array $ids, array $conditions = []);

    public function getDeposit($conditions);

    public function getDepositBankByCondition($condition);


}