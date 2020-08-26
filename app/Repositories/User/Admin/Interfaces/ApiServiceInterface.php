<?php

namespace App\Repositories\User\Admin\Interfaces;

interface ApiServiceInterface
{

    public function getAllApiService();

    public function getApiServiceCountByConditions(array $conditions);

    public function updateApiServiceRows(array $attributes, array $conditions = null);
    

}