<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Repositories\Core\Interfaces\AuditInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

class AuditsController extends Controller
{
    protected $audit;

    public function __construct(AuditInterface $audit)
    {
        $this->audit = $audit;
    }

    public function auditsJson()
    {
      $query = $this->audit->dataAudits();
        return $query;
    }
    public function index()
    {
        return view('backend.audits.index');
    }
}
