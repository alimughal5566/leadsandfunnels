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


class TestController extends BaseController {

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

    public function test(Request $request){
        $action = $request->get('test');
        if(method_exists($this, $action)){
            $this->{$action}();
        }
        else{
            dd($action. " NOT FOUND");
        }
    }

    public function test1(){
        $v = \Stats_Helper::getInstance()->getDefaults("test-key");
        #$reg = $this->getRegistry();
        $reg = DataRegistry::getInstance();
        $reg->leadpops->var5 = "AA-A-".rand(1,9);
        $reg->leadpops->var6 = "AA-AE-".rand(1,9);
        $reg->leadpops->var3 = "AA-VC-".rand(1,9);
        $reg->leadpops->var4 = "AA-AD-".rand(1,9);
        #$this->updateRegistry($reg);
        lp_debug($reg, "###", false);
        $reg->updateRegistry();
    }

    public function all_session(){
        lp_debug(\Session::all(), "test function", false);

        $reg = DataRegistry::getInstance();
        lp_debug($reg->leadpops,"",0);
        dd(Session::all());
    }


    function hashing(){
        $str_to_hash = 'pete!@#';
        $invalid_str_to_test = 'pete@#';

        # For Plain PHP
        #require the illuminate/hashing in your composer.json to pull in https://packagist.org/packages/illuminate/hashing.

        echo "<h3>By Requiring \Illuminate\Hashing\BcryptHasher</h3>";
        $hasher = new \Illuminate\Hashing\BcryptHasher();
        $hash = $hasher->make($str_to_hash);
        echo "Hash String: ".$hash."<br />";
        echo "Hash Check with Valid value: ".(\Hash::check($str_to_hash, $hash))."<br />";
        echo "Hash Check with Invalid value: ".(\Hash::check($invalid_str_to_test, $hash))."<br />";

        if (Auth::attempt(['contact_email' => 'pete@move.com', 'password' => $str_to_hash])) echo "<strong>LOGIN IS VALID</strong><br />";
        else echo "<strong>LOGIN IN-VALID</strong><br />";

        echo "<br />";

        # For Plain PHP Second Approch
        echo "<h3>By using password_hash</h3>";
        $hashAlt = password_hash($str_to_hash, PASSWORD_BCRYPT, ['cost' => 10]);
        echo "Hash String: ".$hashAlt."<br />";
        echo "Hash Check with Valid value: ".(\Hash::check($str_to_hash, $hashAlt))."<br />";
        echo "Hash Check with Invalid value: ".(\Hash::check($invalid_str_to_test, $hashAlt))."<br />";

        if (Auth::attempt(['contact_email' => 'pete@move.com', 'password' => $str_to_hash])) echo "<strong>LOGIN IS VALID</strong><br />";
        else echo "<strong>LOGIN IN-VALID</strong><br />";

        echo "<br />";

        # For Laravel Hash
        echo "<h3>Laravel Hash</h3>";
        $lr_hash = \Hash::make($str_to_hash);
        echo "Hash String: ".$lr_hash."<br />";
        echo "Hash Check with Valid value: ".(\Hash::check($str_to_hash, $lr_hash))."<br />";
        echo "Hash Check with Invalid value: ".(\Hash::check($invalid_str_to_test, $lr_hash))."<br />";

        $res = Auth::attempt(['contact_email' => 'pete@move.com', 'password' => $str_to_hash]);
        if ($res) echo "<strong>LOGIN IS VALID</strong><br />";
        else echo "<strong>LOGIN IN-VALID</strong><br />";

        dd("END");
    }

    function rackspace(){
        $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = 'clients'");
        $containerInfo = objectToArray($res[0]);
        $parsedUrl = parse_url($containerInfo['image_path']);
        substr($parsedUrl['path'],1);


        $ss = "images1/3/3111/logos/3111_160_1_3_74_80_80_1_favicon-circle.png";
        $needle = "3111/";
        $aa = $str = substr($ss, strpos($ss, $needle) + strlen($needle));
        dd($aa);


        $rackspace = \App::make('App\Services\RackspaceUploader');

        $handle = fopen("/var/www/leadpops/admin_2.1_laravel/public/jaz.txt", 'r');
        $aa = $rackspace->uploadTo('robert', $handle, 'jaz/t1.txt');
        dd($aa);
    }

    function rs_image(){
        $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = 'clients'");
        $containerInfo = objectToArray($res[0]);
        #dd($containerInfo);

        /** @var \App\Services\RackspaceUploader $rackspace */
        $rackspace = \App::make('App\Services\RackspaceUploader');
        #dd($rackspace->exist("images1/3/3111/logos/3111_160_1_3_74_80_80_10_spartan.png", "clients"));
        dd($rackspace->getFile("3/3111/logos/3111_160_1_3_74_80_80_10_spartan.png", "clients"));
    }

    function img(){
        $file = "/tmp/test-sp.png";
        $im = imagecreatefrompng("/var/www/leadpops/admin_2.1_laravel/public/tmp/im-spartan.png");
        imagepng($im, $file);
        imagedestroy($im);

        #ob_start();
        #imagepng($im);
        #$imagedata = ob_get_clean();
        #$imgstr = base64_encode($imagedata);
        #print '<p><img src="'.$imgstr.'" alt="image 1" width="96" height="48"/></p>'; exit;

        $rackspace = \App::make('App\Services\RackspaceUploader');
        $handle = fopen($file, 'r');
        $aa = $rackspace->uploadTo('robert', $handle, 'img3.png');

        unlink($file);
        dd($aa);
    }

    function img2(){
        $file = "/tmp/a1~a2~test-sp.png";
        $im = imagecreatefrompng("/var/www/leadpops/admin_2.1_laravel/public/tmp/im-spartan.png");
        imagepng($im, $file);
        imagedestroy($im);

        dd(move_file_to_rackspace($file, "a1/a2/", "robert"));
    }

    function img3(){
        list($width, $height) = getimagesize("http://images-devclixonit.scdn3.secure.raxcdn.com/images1/3/3111/logos/3111_160_1_3_74_80_80_10_movementlogosquarefinal.jpg");
        dd($width, $height);
    }

    function cp(){
        /** @var \App\Services\RackspaceUploader $rackspace */
        #$rackspace = \App::make('App\Services\RackspaceUploader');
        #dd($rackspace->copyFile("https://images-devclixonit.scdn3.secure.raxcdn.com/images1/3/3111/logos/3111_global_pulse.png", "images1/3/3111/logos/cpp2.png", "clients"));

        dd(rackspace_copy_file_as("https://images.lp-images1.com/images1/3/3111/logos/3111_global_pulse.png", "3/3111/logos/3111_jaz_test.png", "clients"));
    }
}
