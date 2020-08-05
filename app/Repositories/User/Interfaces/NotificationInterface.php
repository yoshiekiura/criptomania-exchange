<?php

/**
 * Created by PhpStorm.
 * User: rana
 * Date: 10/1/18
 * Time: 11:19 AM
 */

namespace App\Repositories\User\Interfaces;


interface NotificationInterface
{
    public function read($id);

<<<<<<< HEAD
=======

>>>>>>> 81fb0a94a09ce55ba0e67b2b308309b3e13aee50

    public function unread($id);
    public function readAll();

    public function countUnread($userId);

    public function getLastFive($userId);
}
