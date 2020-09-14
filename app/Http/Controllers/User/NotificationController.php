<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Notification;
use App\Repositories\User\Interfaces\NotificationInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public $notification;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function notificationJson()
    {
      $data = $this->notification->notificationJson();

      return $data;
    }


    public function index()
    {

        $data['notif'] = Notification::where('user_id', Auth::id())->get();
        return view('backend.notices.index',$data);
    }

    public function markAsRead($id)
    {
        if ($this->notification->read($id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The notice has been marked as read.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to mark as read.'));
    }



    public function markAsUnread($id)
    {
        if ($this->notification->unread($id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The notice has been marked as unread.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to mark as unread.'));
    }

    public function markAllAsRead()
    {
        if ($this->notification->readAll()) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The notice has been marked all as read.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to mark as read.'));
    }
  

}
