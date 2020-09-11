<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 7/7/18
 * Time: 1:25 PM
 */

namespace App\Repositories\User\Eloquent;

use App\Models\User\UserInfo;
use App\Repositories\BaseRepository;
use App\Repositories\User\Interfaces\UserInfoInterface;
use Carbon\Carbon;
use DataTables;

class UserInfoRepository extends BaseRepository implements UserInfoInterface
{
    /**
     * @var UserInfo
     */
    protected $model;

    public function __construct(UserInfo $model)
    {
        $this->model = $model;
    }

    public function idManagementJson()
    {
    	$data = $this->model->join('users', 'users.id', '=', 'user_infos.user_id')
    						->where('is_id_verified', '!=', ID_STATUS_UNVERIFIED)
    						->select(['users.id as id', 'email', 'id_type', 'is_id_verified'])
    						->get();
    	return Datatables::of($data)
    					  ->addIndexColumn()
    					  ->editColumn('email', function($user){
    					  	 if(has_permission('users.show')){
                                $show = '<a href='.route('users.show', $user->id).'>'.$user->email.'</a>';
                             }
                             else{
                                $show = $user->email;
                             }

                             return $show;
    					  })
    					  ->editColumn('id-type', function($user){
    					  	 $show = $user->id_type ? id_type($user->id_type) : '-';

    					  	 return $show;
    					  })
    					  ->editColumn('status', function($user){
    					  	$span = '<span class="label label-'.config('commonconfig.id_status.' . $user->is_id_verified . '.color_class') 		.'">'.id_status($user->is_id_verified).'</span>';
    					  	return $span;
    					  })
    					  ->addColumn('action',function($user){
    					  	$btn = '<div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                       <ul class="dropdown-menu pull-right dropdown-menu-stock-pair">';
                            if(has_permission('admin.id-management.show')){
                            	$btn .= '<li><a href='.route('admin.id-management.show',$user->id).'><i class="fa fa-eye"></i>'.__('Show'		).'</a></li>';
                            }

                            $btn .=     '</ul></div>';

                            return $btn;
    					  })->rawColumns(['action','id-type','status','email'])->make(true);

    }
}