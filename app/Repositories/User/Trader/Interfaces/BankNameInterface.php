<?php 
namespace App\Repositories\User\Trader\Interfaces;

interface BankNameInterface
{
    public function getAllBankName();

    public function getBankNameCountByConditions(array $conditions);

    public function getBankNameById($userId);
    
}