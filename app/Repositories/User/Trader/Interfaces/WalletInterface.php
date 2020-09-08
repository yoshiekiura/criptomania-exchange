<?php

namespace App\Repositories\User\Trader\Interfaces;

interface WalletInterface
{
	public function all();
    public function findStockItem(int $id);

    public function insert(array $parameters);

    public function updateWalletBalance($conditions, $amount);

    public function getWalletJson($userId);
    public function getWalletJsonTrader($userId);

}