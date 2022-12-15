<?php
namespace App\Http\Controllers;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
//use App\Constants\Layout_Partials;
//use App\Constants\LP_Constants;
//use LP_Helper2;

use App\Services\DataRegistry;
use App\Services\DbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use LP_Helper;
use Session;

class ModelController extends BaseController {
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(LpAdminRepository $lpAdmin){
        $this->middleware(function($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            return $next($request);
        });
    }
    public function getVehicleModels(){
        $data = [];
        $s = "SELECT model FROM models order by model asc";
        $models = $this->db->fetchAll($s);
        foreach ($models AS $md){
            array_push($data,$md["model"]);
        }
        return response()->json($data);
    }

}
