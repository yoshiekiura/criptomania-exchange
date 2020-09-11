<?php

/**
 * Created by PhpStorm.
 * User: rana
 * Date: 7/7/18
 * Time: 1:25 PM
 */

namespace App\Repositories\User\Eloquent;


use App\Models\User\Notification;
use App\Models\User\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\Interfaces\NotificationInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DataTables;

class NotificationRepository extends BaseRepository implements NotificationInterface
{
    /**
     * @var Notification
     */
    protected $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function getLastFive($userId)
    {
        return $this->model->where('user_id', $userId)->whereNull('read_at')->orderBy('id', 'desc')->take(5)->get();
    }

    public function countUnread($userId)
    {
        return $this->model->where('user_id', $userId)->whereNull('read_at')->count();
    }

    public function read($id)
    {
        $notice = $this->model->where('id', $id)->firstOrFail();
        if (empty($notice->read_at)) {
            $notice->read_at = Carbon::now();
            return $notice->update();
        }
        return false;
    }

    public function notificationJson()
    {
      $userId = User::where('id',Auth::id())->first()->id;
      $query = $this->model->where('user_id',$userId)->orderBy('id', 'desc')->get();

      return DataTables::of($query)
                        ->addIndexColumn()
                        ->addColumn('action',function($row){
                          $btn = '<div class="btn-group pull-right">
                                      <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                          <i class="fa fa-gear"></i>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-stock-pair pull-right">
                                        <li>';

                                     if($row->read_at){
                          $btn.=     '<a href="'.route('notices.mark-as-unread',$row->id).'"><i
                                              class="fa fa-dot-circle-o text-red"></i>
                                          '.__('Mark as unread').'</a>';
                                      }
                                      else{
                          $btn.=     ' <a href="'.route('notices.mark-as-read',$row->id).'"><i
                                              class="fa fa-dot-circle-o text-green"></i>
                                          '.__('Mark as read').'</a>';
                                      }

                          $btn .=       '</li>
                                      </ul>
                                    </div>';

                          return $btn;
                        })->editColumn('data', function($data){
                              // $td = "<td ".$data->read_at ? '' : 'class=text-bold'.">".$data->data."</td>";
                              //
                              // return $td;

                              if($data->read_at == NULL){
                                $td = "<span class='text-bold'>".$data->data."</span>";
                                return $td;
                              }else{
                                $td = $data->data;
                                return $td;
                              }
                        })->editColumn('date',function($date){

                              if($date->read_at == NULL){
                                $td = '<span class="text-bold">'.$date->created_at.'</span>';
                                return $td;
                              }else{
                                $td = $date->created_at;
                                return $td;
                              }
                              // $td = "<td ".$date->read_at ? '' : 'class=text-bold'.">".$date->created_at."</td>";

                              // return $td;
                        })->editColumn('status', function($status){
                              if($status->read_at == NULL){
                                $td = "<span class='text-bold'>Unread</span>";
                                return $td;
                              }else{
                                $td = "Read";
                                return $td;
                              }
                              // $td = "<td ".$status->read_at ? '' : 'class=text-bold'.">"
                              // .$status->read_at ? __('Read') : __('Unread')."</td>";

                              return $td;
                        })->editColumn('id',function ($id){
                          $td = "<td style='display:none'>".$id->id."</td>";
                          return $td;
                        })->rawColumns(['action','data','date','status'])->make(true);
    }

    public function readAll()
    {
        $id = User::where('id', Auth::id())->first()->id;
        $this->model->where('user_id', $id)->update(['read_at' => Carbon::now()]);
        return true;
    }

    public function unread($id)
    {
        $notice = $this->model->where('id', $id)->firstOrFail();
        if (!empty($notice->read_at)) {
            $notice->read_at = null;
            return $notice->update();
        }
        return false;
    }
}