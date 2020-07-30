<?php

namespace App\Repositories\User\Trader\Interfaces;

interface WithdrawalInterface
{
     public function getLast24hrWithrawalAmount(array $conditions);
     public function withdrawAll();


}