<?php

namespace App\Http\Controllers;
use App\Repositories\LpAdminRepository;
//use App\Constants\Layout_Partials;
//use App\Constants\LP_Constants;
//use LP_Helper2;

use App\Services\DataRegistry;
use App\Services\DbService;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Session;


class TestAjaxController extends BaseController {

    public function __construct(LpAdminRepository $lpAdmin){
        $this->middleware(function($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            return $next($request);
        });
    }

    public function ajax(Request $request){
        return view('ajaxtest')->with('welcome', "Welcome Jaz!!");
    }

    public function getAjaxData(Request $request){
        $time = new \DateTime();
        $json = array();
        $json['Time'] = $time->format("H:i:s");
        $json['Token'] = $request->get('_token');
        $json['Controller'] = "TestAjaxController";
        $json['Function'] = "getAjaxData";
        $json['My Name Is'] = "Jaz!";

        return response()->json($json);
        #echo json_encode($json);
        #exit;
    }
}
