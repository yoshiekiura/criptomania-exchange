<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 9/30/18
 * Time: 11:31 AM
 */

namespace App\Repositories\Core\Interfaces;

interface RpcInterface
{
    public function getAllRpcPort();

    public function getRpcCountByConditions(array $conditions);

    public function updateRpcRows(array $attributes, array $conditions = null);

    public function getRpcPort($conditions);

    public function listRpcJson();



}
