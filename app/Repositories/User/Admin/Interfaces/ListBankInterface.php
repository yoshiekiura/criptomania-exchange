<?php 
namespace App\Repositories\User\Admin\Interfaces;

interface ListBankInterface
{
	public function getAllListBank();

	public function getListBankCountByConditions(array $conditions);

    public function getListBankById($id);
}