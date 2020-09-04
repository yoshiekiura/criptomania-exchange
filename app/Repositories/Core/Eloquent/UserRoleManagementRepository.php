<?php
/**
 * Created by PhpStorm.
 * User: rabbi
 * Date: 7/24/18
 * Time: 4:34 PM
 */

namespace App\Repositories\Core\Eloquent;


use App\Models\Core\UserRoleManagement;
use App\Repositories\BaseRepository;
use App\Repositories\Core\Interfaces\UserRoleManagementInterface;
use DataTables;
use Carbon\Carbon;


class UserRoleManagementRepository extends BaseRepository implements UserRoleManagementInterface
{
    /**
     * @var UserRoleManagement
     */
    protected $model;

    public function __construct(UserRoleManagement $model)
    {
        $this->model = $model;
    }

    public function getAllRoles()
    {
      $data = $this->model->all();

      return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action',function($row){
                          $defaultRoles = config('commonconfig.fixed_roles');

                          $btn = '<div class="btn-group pull-right">
                              <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-gear"></i>
                              </button>
                              <ul class="dropdown-menu pull-right">';


                            if(has_permission('user-role-managements.edit')){
                                      $btn .= '<li>
                                                    <a href="'.route('user-role-managements.edit', $row->id).'"><i
                                                                class="fa fa-eye"></i>Edit</a>
                                                </li>';
                            }


                              if(!in_array($row->id, $defaultRoles)){
                                      $btn .=    '<li>
                                                  <a class="confirmation" data-alert="Do you want to delete this role?" data-form-id="ur-'.$row->id.'"
                                                  data-form-method="delete" href="'.route('user-role-managements.destroy',$row->id).'">
                                                  <i class="fa fa-trash-o"></i>Delete</a>
                                              </li>';

                                        if(has_permission('user-role-managements.status') && $row->is_active == ACTIVE_STATUS_ACTIVE){
                                            $btn .=  '<li>
                                                          <a data-form-id="ur-'.$row->id.'" data-form-method="PUT"
                                                          href='.route('user-role-managements.status',$row->id).'
                                                          class="confirmation" data-alert="Do you want to disable this role?">
                                                          <i class="fa  fa-times-circle-o"></i>Disable</a>
                                                      </li>';
                                                    }
                              }


                              if($row->is_active == ACTIVE_STATUS_INACTIVE){
                                      $btn .=  '<li>
                                          <a data-form-id="ur-'.$row->id.'" data-form-method="PUT"
                                          href='.route('user-role-managements.status',$row->id).'
                                          class="confirmation" data-alert="Do you want to active this role?">
                                          <i class="fa fa-check-square-o"></i>Active</a>
                                            </li>';
                                }

                      return $btn;
                    })->editColumn('is_active', function($active){
                          return $active->is_active == ACTIVE_STATUS_ACTIVE ? '<i class="fa fa-check text-green"></i>' : '<i class="fa fa-close text-red"></i>';
                    })->editColumn('created_at', function ($date) {
                        return $date->created_at ? with(new Carbon($date->created_at))->format('m/d/Y') : '';
                    })->rawColumns(['action','is_active'])->make(true);
    }
    public function getUserRoles()
    {
        return $this->model->where('is_active', ACTIVE_STATUS_ACTIVE)->pluck('role_name', 'id');
    }

    public function getDefaultRole()
    {
        return $this->model->where('id', admin_settings('default_role_to_register'))->firstOrFail();
    }

    public function create(array $parameters)
    {
        if ($userRole = $this->model->create($parameters)) {
            cache()->forever("userRoleManagement{$userRole->id}", $userRole->route_group);
            return $userRole;
        }

        return false;
    }

    public function update(array $parameters, int $id, string $attribute = 'id')
    {

        $userRole = $this->getFirstByConditions([$attribute => $id]);

        if ($userRole->update($parameters)) {
            cache()->forget("userRoleManagement{$userRole->id}");
            cache()->forever("userRoleManagement{$userRole->id}", $userRole->route_group);
            return true;
        }

        return false;
    }

    public function deleteById(int $id)
    {
        $userRoleManagement = $this->getFirstById($id);

        if ($this->isNonDeletableRole($id)) {
            return false;
        }
        $userCount = $userRoleManagement->users->count();

        if ($userCount <= 0) {
            return $userRoleManagement->delete();
        }

        return false;
    }

    public function isNonDeletableRole(int $id)
    {
        $rolesFromAdminSetting =admin_settings(['default_role_to_register','signupable_user_roles']);
        $defaultRoles = config('commonconfig.fixed_roles');
        if ($rolesFromAdminSetting['default_role_to_register']==$id || in_array($id, $defaultRoles) || in_array($id, $rolesFromAdminSetting['signupable_user_roles'])) {
            return true;
        }

        return false;
    }

    public function toggleStatusById(int $id, string $attribute ='is_active')
    {
        $userRoleManagement = $this->getFirstById($id);

        if ($this->isNonDeletableRole($id)) {
            return false;
        }

        $status = $userRoleManagement->is_active == ACTIVE_STATUS_ACTIVE ? ACTIVE_STATUS_INACTIVE : ACTIVE_STATUS_ACTIVE;
        $userRoleManagement->is_active = $status;

        if ($userRoleManagement->update()) {
            return $status == ACTIVE_STATUS_ACTIVE ? 'activated' : 'deactivated';
        }

        return false;
    }
}
