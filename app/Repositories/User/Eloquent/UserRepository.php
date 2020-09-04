<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 7/7/18
 * Time: 1:25 PM
 */

namespace App\Repositories\User\Eloquent;

use App\Models\User\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\Interfaces\UserInterface;
use DataTables;


class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * @var User
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function getByUserIds(array $ids, array $conditions = [])
    {
        $model = $this->model->whereIn('id', $ids);

        if (!empty($conditions)) {
            $model = $model->where($conditions);
        }

        return $model->get();
    }

    public function getUserInfo()
    {
      $data = $this->model
      ->join('user_role_managements', 'user_role_managements.id', '=', 'users.user_role_management_id')
      ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
      ->select([
        'users.*',
        'role_name',
        'first_name',
        'last_name',
      ]);

      return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action',function($row){
                          $btn = '<div class="btn-group pull-right">
                              <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-gear"></i>
                              </button>
                              <ul class="dropdown-menu pull-right">';


                            if(has_permission('users.edit')){
                                      $btn .= '<li><a href="'.route('users.show',$row->id).'"><i class="fa fa-eye"></i>Show</a></li>
                                               <li><a href="'.route('users.edit',$row->id).'">
                                                    <i class="fa fa-pencil-square-o fa-lg text-info"></i>Edit Info</a>
                                               </li>
                                               <li><a href="'.route('users.edit.status',$row->id).'">
                                                    <i class="fa fa-pencil-square fa-lg text-info"></i>Edit Status</a>
                                               </li>';
                            }


                              if(has_permission('admin.users.wallets')){
                                      $btn .=    '<li><a href="'.route('admin.users.wallets',$row->id).'">
                                                    <i class="fa fa-list fa-lg text-info"></i>View Wallets</a>
                                                  </li>';
                              }


                              if(has_permission('reports.admin.open-orders')){
                                      $btn .=  '<li><a href="'.route('reports.admin.open-orders', $row->id).'">
                                                  <i class="fa fa-list fa-lg text-info"></i>View Open Orders</a>
                                                </li>';
                                }

                              if(has_permission('reports.admin.trades')){
                                  $btn .=  '<li><a href="'.route('reports.admin.trades', $row->id).'">
                                                <i class="fa fa-list fa-lg text-info"></i>View trade history</a>
                                            </li>';
                                }

                                if(has_permission('admin.stock-pairs.destroy') && $row->is_default != ACTIVE_STATUS_ACTIVE){
                                    $btn .=  '<li>
                                        <a data-form-id="delete-'.$row->id.'" data-form-method="DELETE"
                                           href='.route('admin.stock-pairs.destroy', $row->id).' class="confirmation"
                                           data-alert="Do you want to delete this stock pair?"><i
                                                    class="fa fa-trash-o"></i>Delete</a>
                                    </li>
                                    </ul>
                                  </div>';
                                }

                      return $btn;
                    })->editColumn('is_active', function($active){
                        return $active->is_active ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
                    })->editColumn('email',function($user){
                        if(has_permission('users.show'))
                        {
                          $email = '<a href="'.route('users.show', $user->id).'">'.$user->email.'</a>';
                        }
                        else{
                          $email = $user->email;
                        }
                        return $email;
                    })->rawColumns(['action','is_active','email'])->make(true);
    }
}
