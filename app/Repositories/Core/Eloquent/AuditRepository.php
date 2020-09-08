<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 10/2/18
 * Time: 4:57 PM
 */

namespace App\Repositories\Core\Eloquent;


use App\Repositories\BaseRepository;
use App\Repositories\Core\Interfaces\AuditInterface;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;


class AuditRepository extends BaseRepository implements AuditInterface
{
    /**
     * @var Audit
     */
    protected $model;

    public function __construct(Audit $audit)
    {
        $this->model = $audit;
    }
    public function dataAudits()
    {
      $query = $this->model->join('users', 'users.id', '=', 'audits.user_id')
                           ->join('user_infos', 'user_infos.user_id', '=', 'users.id')
                           ->select([
                              'audits.*',
                              'email',
                              DB::raw("CONCAT(first_name,' ',last_name) as full_name"),
                           ])->get();
        return Datatables::of($query)
                          ->addIndexColumn()
                          ->editColumn('event',function($event){
                            return title_case($event->event);
                          })
                          ->editColumn('old_values',function($audit){
                            return json_encode($audit->old_values);
                          })
                          ->editColumn('new_values',function($values){
                            return json_encode($values->new_values);
                          })
                          ->rawColumns(['event','old_values','new_values'])
                          ->make(true);
    }
}
