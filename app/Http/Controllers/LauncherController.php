<?php

namespace App\Http\Controllers;

use App\Helpers\CustomErrorMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LauncherRequest;
use App\Repositories\ClientRepository;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Repositories\ProcessRepository;
use App\Services\gm_process\InfusionsoftGearmanClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Support\Facades\Validator;
use App\Constants\FunnelVariables;
use mysql_xdevapi\Exception;

class LauncherController extends BaseController
{

    protected $loginRepo;
    protected $lpAdmin;
    private $clientFunnels;
    private $clientObj;

    public function __construct(LpAdminRepository $lpAdmin,
                                ClientRepository $client,
                                CustomizeRepository $customtizeRepo
    )
    {
        $this->init($lpAdmin);
        $this->loginRepo = $client;
        $this->lpAdmin = $lpAdmin;
        $this->Default_Model_Customize = $customtizeRepo;
    }

    /**
     *
     */

    public function index(Request $request)
    {
        $hash = $request->query('hash') ?? null;
        $this->setSession($hash);
        $clientDataExtractedFromHash = Session::get('clientDataExtractedFromHash');
        $client = DB::table('clients')
            ->where('client_id', $clientDataExtractedFromHash->id)
            ->first();

        if ($client == null) {
            Session::flash('error', 'Activation link is invalid!');
            return $this->_redirect(LP_PATH . '/login?ok=no');

        } elseif ($client->launch_status == config('lp.launch_status.not_password_nor_launchscreen')) {
            Session::put('launch_status', config('lp.launch_status.not_password_nor_launchscreen'));
            $this->db->query("UPDATE free_trial_builder SET status='on-activation-link' WHERE emailaddress = '".$client->contact_email."'");
            return $this->_redirect(LP_PATH . '/activate/' . $hash);

        } elseif ($client->launch_status == config('lp.launch_status.password_only')) {
            Session::put('launch_status', config('lp.launch_status.password_only'));
            Session::flash('success', 'Your password has been updated.');
            $this->db->query("UPDATE free_trial_builder SET status='on-activation-link' WHERE emailaddress = '".$client->contact_email."'");
            return $this->_redirect(route('launchFunnelShow', ['hash' => $hash]));

        } elseif ($client->launch_status == config('lp.launch_status.both_password_and_launchscreen')) {
            //   Session::flash('success', 'Your password has been updated.');
            Session::put('launch_status', config('lp.launch_status.both_password_and_launchscreen'));
            return $this->_redirect(route('login'));
        }
        // Flow => password is setup but launch screen is not
        // User go to login what happened
        // in this function hash is required to send user to launch screen
        return false;
    }

    public function launchFunnelShow(Request $request)
    {

        $hash = $request->query('hash') ?? null;
        if (Session::get('clientDataExtractedFromHash') == null) {
            return $this->_redirect(route('launcher', ['hash' => $hash]));
        } else {
            $isSetPassword = Session::get('launch_status');
            if ($isSetPassword != 1)
                return $this->_redirect(route('launcher', ['hash' => $hash]));
        }
        $clientDataExtractedFromHash = Session::get('clientDataExtractedFromHash');
        $clientId = $clientDataExtractedFromHash->id;
        $clientObj = $this->getClient($clientId);
        $clientLogo = null;
        $defaultSwatches = DB::table("default_swatches")
            ->select("swatch")
            ->where("active", "y")
            ->orderBy("id", "asc")
            ->get();

        $swatches = [];
        if (count($defaultSwatches)) {
            foreach ($defaultSwatches as $swatch) {
                $swatches[] = $swatch->swatch;
            }
        }
        $logo = '';
        if ($clientObj->is_fairway == 1) {
            $logo = '/lp_assets/adminimages/fairway_logo.png';
            //if (empty($clientObj->company_name)) {
                $clientObj->company_name = 'Fairway Independent Mortgage Corporation';
            //}
        }
        if ($clientObj->is_mm == 1) {
            $logo = '/lp_assets/adminimages/movement-logo.png';
            //if (empty($clientObj->company_name)) {
                $clientObj->company_name = 'Movement Mortgage';
            //}
        }
        if ($clientObj->is_thrive == 1) {
            $logo = '/lp_assets/adminimages/logo-thrive.png';
            //if (empty($clientObj->company_name)) {
                $clientObj->company_name = 'Thrive Mortgage';
            //}
        }
        $data = array(
            "funnelData" => $clientObj,
            "swatches" => $swatches,
            'logo' => $logo,
            'hash' => $hash
        );
        //dd($data);

        return view('launcher.index')->with("data", $data);
    }


    public function getInitialSwatches(Request $request)
    {
        $defaultSwatches = DB::table("default_swatches")
            ->select("swatch")
            ->where("active", "y")
            ->orderBy("id", "asc")
            ->get();
//        dd($defaultSwatches);

        $swatches = '';
        if (count($defaultSwatches)) {
            foreach ($defaultSwatches as $swatch) {
                $swatches .= ' <li class="list-swatches__li">
                  <label class="custom-radio">
                      <input type="radio" data-color="' . $swatch->swatch . '" name="swatcher">
                         <span class="fake-radio">
                         <span class="fake-radio__bg" style="background: ' . $swatch->swatch . '></span>
                         </span>
                   </label>
                    </li>';
            }
        }

        echo $swatches;
    }

    public function launchFunnel(Request $request)
    {
        //dd($request->all());
        $clientDataExtractedFromHash = Session::get('clientDataExtractedFromHash');
        if (!$clientDataExtractedFromHash || $clientDataExtractedFromHash == null) {
            Session::flash('error', 'Activation link is invalid!');
            return $this->_redirect(LP_PATH . '/login?ok=no');
        }

        $ImageName = $DestImageName = null;

        if (isset($_FILES) && $request->hasFile('imageInput')) {

            $DestinationDirectory = public_path('rs_tmp/');
            $Quality = 90;

            // check $_FILES['ImageFile'] not empty
            if (!isset($_FILES['imageInput']) || !is_uploaded_file($_FILES['imageInput']['tmp_name'])) {
                print('upload general error!'); // output error when above checks fail.
                exit;
            }

            $client = new \App\Services\Client();
            $ImageName = \App\Helpers\LauncherHelper::generateRandomString();
            $saveImageName = $ImageName;
            $ImageSize = $_FILES['imageInput']['size']; // get original image size
            $TempSrc = $_FILES['imageInput']['tmp_name']; // Temp name of image file stored in PHP tmp folder
            $ImageType = $_FILES['imageInput']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.
            //Let's check allowed $ImageType, we use PHP SWITCH statement here
            switch (strtolower($ImageType)) {
                case 'image/png':
                    //Create a new image from file
                    $CreatedImage = imagecreatefrompng($_FILES['imageInput']['tmp_name']);
                    $ImageName = $ImageName . ".png";
                    $image = $client->loadPng($_FILES['imageInput']['tmp_name']);
                    $logo_color = $image->extract();
                    break;
                case 'image/gif':
                    $CreatedImage = imagecreatefromgif($_FILES['imageInput']['tmp_name']);
                    $ImageName = $ImageName . ".png";
                    $image = $client->loadGif($_FILES['imageInput']['tmp_name']);
                    $logo_color = $image->extract();
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    $CreatedImage = imagecreatefromjpeg($_FILES['imageInput']['tmp_name']);
                    $ImageName = $ImageName . ".png";
                    $image = $client->loadJpeg($_FILES['imageInput']['tmp_name']);
                    $logo_color = $image->extract();
                    break;
                default:
                    die('Unsupported File!'); //output error and exit
            }
            if (is_array($logo_color)) {
                $logo_color = $logo_color[0];
            }
            list($CurWidth, $CurHeight) = getimagesize($TempSrc);

            $resize = true;
            if ($CurWidth <= 350 && $CurHeight <= 130) { // best fit for logo image is no larger than this
                $resize = false;
            }
            $DestImageName = $DestinationDirectory . $ImageName; // Image with destination directory
            $DestImageNameOrignal = $DestinationDirectory . "source_" . $ImageName; // Image with destination directory

            $mobileDestination = $DestinationDirectory . "mobile_" . $ImageName;

            $okupload = \App\Helpers\LauncherHelper::resizeImage($CurWidth, $CurHeight, $DestImageName, $CreatedImage, $Quality, $ImageType, $resize, $TempSrc, $mobileDestination, $DestImageNameOrignal);
        }

        $this->clientObj = $this->getClient($clientDataExtractedFromHash->id);
        $this->getClientFunnels();

        //update client info eg: phone,cell number and company
        $this->updateClientsTable($request);

        $post = $request->except(['imageInput']);
        $post['color'] = false;
        // if user upload/default logo and swatches

        if ($request->has('swatcher') && $request->swatcher != null) {
            preg_match('#\((.*?)\)#', $request->swatcher, $match);
            $logoRgbstr = $match[1];
            $arr = explode(',', $logoRgbstr);
            $hexColor = fromRGB($arr[0], $arr[1], $arr[2]);
            $post['swatcher'] = $hexColor;
            $post['color'] = true;
            $this->updateClientBackgroundSwatches($request->swatches);
            $this->updateLogoInCreatedFunnels($DestImageName, $ImageName, $hexColor, $request->swatches);
            $this->updateClientBackgroundColors($request->base_color,$request->swatcher);
        }

            // update client launcher info through gearman
        if (env('APP_ENV') != config('app.env_local')){
            $postArray = array('clientInfo' => $this->clientObj, 'post' => $post);
            MyLeadsEvents::getInstance()->updateClientLauncherInfo($postArray);
        }

        if (env('APP_ENV') == config('app.env_production') && strpos($clientDataExtractedFromHash->email, "@test-leadpops.com") === false) {
            $this->hubSpotUpdate($clientDataExtractedFromHash->email);
        }

        $this->doLogin();

        DB::table('free_trial_builder')->where("emailaddress", $clientDataExtractedFromHash->email)->delete();


        Session::forget('clientDataExtractedFromHash');
        Session::forget('launch_status');

        return $this->_redirect(LP_PATH . '/index');
    }

    private function hubSpotUpdate($email)
    {
        $s = "select * from free_trial_builder where emailaddress = '" . $email . "' ORDER BY id desc LIMIT 1";
        $trial_data = $this->db->fetchRow($s);

        $hubspot_data = array();
        $hubspot_data['leadpops_client_id'] = $this->clientObj->client_id;
        $hubspot_data['funnel_launch_status'] = 'Yes';
        if (@$_COOKIE['trial_data'] == 1) {
            echo $trial_data['package'];
            die;
        }
        /*
        if (@$trial_data['package'] == "pro" || @$trial_data['package'] == "marketer") {
            $hubspot_data['free_trial_status'] = '30-days';
        } else {
            $hubspot_data['free_trial_status'] = 'Client';
        }
        */

        // Requirement for free_trial_status: free_trial_status should only update if request for account launch is from free-trial only
        // If free trial type is missing then don't add because its not from free-trial request
        $hs_contact_info = $this->_getHubSpotContact( $email );
        if ( !empty($hs_contact_info) && array_key_exists('free_trial_type', $hs_contact_info) && $hs_contact_info['free_trial_type']!="" ) {
            $hubspot_data['free_trial_status'] = 'Client';
        }


        $s = "select * from clients where contact_email = '" . $email . "' ORDER BY client_id desc LIMIT 1";
        $client = $this->db->fetchRow($s);

        if ($client['is_fairway'] == 1) {
            $hubspot_data['company'] = 'Fairway Independent Mortgage Corporation';
        }
        else if ($client['is_mm'] == 1) {
            $hubspot_data['company'] = 'Movement Mortgage';
        }
        else if ($client['is_thrive'] == 1) {
            $hubspot_data['company'] = 'Thrive Mortgage';
        }
        else{
            $hubspot_data['company'] = $client['company_name'];
        }

        if($client['phone_number'] != ""){
            $hubspot_data['phone'] = $client['phone_number'];
        }

        InfusionsoftGearmanClient::getInstance()->updateContact($hubspot_data, $email);
    }

    private function updateTrialFinalData($clientId, $session_id, $request, $imgeName)
    {
        return DB::table('trial_final_data')
            ->where('client_id', $clientId)
//            ->where('session_id', $session_id)
            ->update([
                'defaultlogo' => $imgeName,
                'company_name' => $request->company,
                'phone_number' => $request->phone,
            ]);
    }

    private function getClient($client_id)
    {
        return DB::table('clients')->where('client_id', $client_id)->first();

    }

    /**
     * get client default and website funnels
     * @return array
     */
    private function getClientFunnels()
    {
        $defaultfunnel = "select
            `cs`.*
        from
            clients_funnels_domains cs
            inner join clients_leadpops cl on
            cs.client_id = cl.client_id
            and cs.leadpop_id  = cl.leadpop_id
            and cs.leadpop_version_id  = cl.leadpop_version_id
            and cs.leadpop_version_seq  = cl.leadpop_version_seq
            and cs.leadpop_type_id  = " . config('leadpops.leadpopSubDomainTypeId') . "
            and cl.funnel_market = 'f'
        where
            cs.client_id = " . $this->clientObj->client_id . "
            and cs.leadpop_vertical_id =  " . $this->clientObj->client_type . "";
        $res = $this->db->fetchAll($defaultfunnel);

        $websitefunnel = "select
            `cs`.*
        from
            clients_funnels_domains cs
            inner join clients_leadpops cl on
            cs.client_id = cl.client_id
            and cs.leadpop_id  = cl.leadpop_id
            and cs.leadpop_version_id  = cl.leadpop_version_id
            and cs.leadpop_version_seq  = cl.leadpop_version_seq
            and cs.leadpop_type_id  = " . config('leadpops.leadpopSubDomainTypeId') . "
            and cl.funnel_market = 'w'
        where
            cs.client_id = " . $this->clientObj->client_id . "";
        $rec = $this->db->fetchAll($websitefunnel);
        $allFunnel = array_merge($res, $rec);
        return $this->clientFunnels = $allFunnel;
    }

    private function updateClientsTable($request)
    {

        DB::table("clients")
            ->where("client_id", $this->clientObj->client_id)
            ->update(array(
                "launch_status" => config('lp.launch_status.both_password_and_launchscreen'),
                "company_name" => $request->company,
                "phone_number" => $request->phone,
                "cell_number" => $request->phone
            ));
        Session::put('launch_status', config('lp.launch_status.both_password_and_launchscreen'));
    }

    /**
     * update selected logo color swatches
     * @param $swatches
     * @param $selected_swatch
     */
    private function updateClientBackgroundSwatches($swatches)
    {
        if (getenv("WRITE_LOG") == 1) {
            $this->db->query("INSERT INTO `launcher_log` (`message`, `type`) VALUES ('update background swatches => " . date('dmY h:i:s') . "', 'Client => " . $this->clientObj->client_id . "');");
        }
        $swatches = explode('#', $swatches);
        $vertical_ids = array();
        foreach ($this->clientFunnels as $funnel) {
            array_push($vertical_ids, $funnel['leadpop_vertical_id']);
        }

        if(!empty($vertical_ids)){
            $delete_swatches = "DELETE from leadpop_background_swatches WHERE client_id = " . $this->clientObj->client_id . " AND leadpop_vertical_id IN (" . implode(",", array_unique($vertical_ids)) . ")";
            if (getenv("APP_ENV") == "local") lp_debug($delete_swatches, "updateClientBackgroundSwatches", false);
            $this->db->query($delete_swatches);
        }

        $inserts = array();
        foreach ($this->clientFunnels as $funnel) {
            foreach ($swatches as $key => $value) {
                list($red, $green, $blue) = explode("-", $value);
                if ($key < 1) {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                } else {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                }
                $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                $new_swatches = array($str0, $str1, $str2, $str3);
                $is_primary = 'n';
                if ($key == 0) {
                    $is_primary = 'y';
                }
                for ($i = 0; $i < 4; $i++) {
                    $arr = array(
                        "client_id" => $this->clientObj->client_id,
                        "leadpop_id" => $funnel['leadpop_id'],
                        "leadpop_type_id" => $funnel['leadpop_type_id'],
                        "leadpop_vertical_id" => $funnel['leadpop_vertical_id'],
                        "leadpop_vertical_sub_id" => $funnel['leadpop_vertical_sub_id'],
                        "leadpop_template_id" => $funnel['leadpop_template_id'],
                        "leadpop_version_id" => $funnel['leadpop_version_id'],
                        "leadpop_version_seq" => $funnel['leadpop_version_seq'],
                        'swatch' => addslashes($new_swatches[$i]),
                        'is_primary' => $is_primary,
                        'active' => 'y'
                    );
                    $inserts[] = $arr;
                }
            }
        }

        $inserts = collect($inserts);
        $chunks = $inserts->chunk(1000);
        foreach ($chunks as $c=>$chunk){
            if (getenv("APP_ENV") == "local") lp_debug("INSERT INTO leadpop_background_swatches", "leadpop_background_swatches", false);
            DB::table('leadpop_background_swatches')->insert($chunk->toArray());
        }
    }

    /*
     * Update default logos
     * */
    private function updateLogoInCreatedFunnels($imageSource, $imageName, $hexColor, $swatches)
    {
        if (getenv("WRITE_LOG") == 1) {
            $this->db->query("INSERT INTO `launcher_log` (`message`, `type`) VALUES ('update logos => " . date('dmY h:i:s') . "', 'Client => " . $this->clientObj->client_id . "');");
        }
        $design_variables = array();
        // dd($client_id, $imageSource, $imageName);
        $container = $this->clientObj->rackspace_container;
        $rackspace_stock_assets = rackspace_stock_assets();

        $global_logo = array();
        foreach ($this->clientFunnels as $cli) {
            $leadpop_id = $cli['leadpop_id'];
            $leadpop_type_id = $cli['leadpop_type_id'];
            $leadpop_vertical_id = $cli['leadpop_vertical_id'];
            $leadpop_vertical_sub_id = $cli['leadpop_vertical_sub_id'];
            $leadpop_template_id = $cli['leadpop_template_id'];
            $leadpop_version_id = $cli['leadpop_version_id'];
            $leadpop_version_seq = $cli['leadpop_version_seq'];
            $filename = strtolower(
                $this->clientObj->client_id . "_" .
                $leadpop_id . "_" .
                $leadpop_type_id . "_" .
                $leadpop_vertical_id . "_" .
                $leadpop_vertical_sub_id . "_" .
                $leadpop_template_id . "_" .
                $leadpop_version_id . "_" .
                $leadpop_version_seq . "_");

            $section = substr($this->clientObj->client_id, 0, 1);
            $logo_path = $section . '/' . $this->clientObj->client_id . '/logos/';
            $logoname = strtolower($filename . $imageName);
            $icon_arr = array(
                $logoname,
                $filename . 'favicon-circle.png',
                $filename . 'dot_img.png',
                $filename . 'ring.png',
                $filename . 'mvp-check.png'
            );
            //we launch the client with uploaded logo
            if ($imageName) {
                $newlogopath = $logo_path . $icon_arr[0];
                $newlogoname = $icon_arr[0];
                $server_file = $imageSource;
            }
            //we launch the client with default logo
            else {
                if ($this->clientObj->is_fairway == 1) {
                    $server_file = 'https://images.lp-images1.com/default/logo/fairway-logo.png';
                    $logoname = 'fairway-logo.png';
                }
                if ($this->clientObj->is_mm == 1) {
                    $server_file = 'https://images.lp-images1.com/default/images/movement-logo.png';
                    $logoname = 'movement-logo.png';
                }
                if ($this->clientObj->is_thrive == 1) {
                    $server_file = 'https://images.lp-images1.com/default/images/logo-thrive.png';
                    $logoname = 'logo-thrive.png';
                }
                $newlogopath = $logo_path . $icon_arr[0] . $logoname;
                $newlogoname = $icon_arr[0] . $logoname;
            }

            ## MOVING THESE 2 SQL to Gearman
            /*
            DB::table('leadpop_logos')
                ->where("client_id", $this->clientObj->client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $leadpop_vertical_id)
                ->where("leadpop_vertical_sub_id", $leadpop_vertical_sub_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $leadpop_version_seq)
                ->update(array(
                    'logo_src' => $newlogoname,
                    'use_default' => 'n',
                    'use_me' => 'y',
                    'logo_color' => $hexColor,
                    'ini_logo_color' => $hexColor,
                    'swatches' => $swatches
                ));

            DB::table('current_logo')
                ->where("client_id", $this->clientObj->client_id)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_type_id", $leadpop_type_id)
                ->where("leadpop_vertical_id", $leadpop_vertical_id)
                ->where("leadpop_vertical_sub_id", $leadpop_vertical_sub_id)
                ->where("leadpop_template_id", $leadpop_template_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where("leadpop_version_seq", $leadpop_version_seq)
                ->update(array(
                    'logo_src' => $newlogoname
                ));
            */
            $sql_leadpop_logos = 'update `leadpop_logos` set `logo_src` = "'.$newlogoname.'", `use_default` = "n", `use_me` = "y", `logo_color` = "'.$hexColor.'", `ini_logo_color` = "'.$hexColor.'", `swatches` = "'.$swatches.'" where ';
            $sql_leadpop_logos .= ' `client_id` = '.$this->clientObj->client_id.' and `leadpop_id` = '.$leadpop_id.' and `leadpop_type_id` = '.$leadpop_type_id.' and `leadpop_vertical_id` = '.$leadpop_vertical_id;
            $sql_leadpop_logos .= ' and `leadpop_vertical_sub_id` = '.$leadpop_vertical_sub_id.' and `leadpop_template_id` = '.$leadpop_template_id.' and `leadpop_version_id` = '.$leadpop_version_id.' and `leadpop_version_seq` = '.$leadpop_version_seq;
            if (env('APP_ENV') != config('app.env_local')) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$sql_leadpop_logos]);
            }

            $sql_current_logo = 'update `current_logo` set `logo_src` = "'.$newlogoname.'" where ';
            $sql_current_logo .= ' `client_id` = '.$this->clientObj->client_id.' and `leadpop_id` = '.$leadpop_id.' and `leadpop_type_id` = '.$leadpop_type_id.' and `leadpop_vertical_id` = '.$leadpop_vertical_id;
            $sql_current_logo .= ' and `leadpop_vertical_sub_id` = '.$leadpop_vertical_sub_id.' and `leadpop_template_id` = '.$leadpop_template_id.' and `leadpop_version_id` = '.$leadpop_version_id.' and `leadpop_version_seq` = '.$leadpop_version_seq;
            if (env('APP_ENV') != config('app.env_local')) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$sql_current_logo]);
            }

            $global_logo[] = array('server_file' => $server_file,
                'container' => $container,
                'rackspace_path' => 'images1/' . $newlogopath
            );
            $logosrc = $this->clientObj->rackspace_image_base . '/logos/' . $newlogoname;

            ////////////////////////////////////////////////////////////////

            $design_variables[FunnelVariables::LOGO_SRC] = $logosrc;
            $favicon_location = $rackspace_stock_assets . "images/favicon-circle.png";
            $image_location = $rackspace_stock_assets . "images/dot-img.png";
            $mvp_dot_location = $rackspace_stock_assets . "images/ring.png";
            $mvp_check_location = $rackspace_stock_assets . "images/mvp-check.png";

            $favicon_dst_src = public_path('rs_tmp/') . $icon_arr[1];
            $colored_dot_src = public_path('rs_tmp/') . $icon_arr[2];
            $ring_src = public_path('rs_tmp/') . $icon_arr[3];
            $mvp_check_src = public_path('rs_tmp/') . $icon_arr[4];

            $backgroundColor = '/*###>*/background-color: ' . $hexColor . ';/*@@@*/
        background-image: url(data:image/svg xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIHZpZXdCb3g9IjAgMCAxIDEiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxsaW5lYXJHcmFkaWVudCBpZD0idnNnZyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSJ1bmRlZmluZWQiIHkxPSJ1bmRlZmluZWQiIHgyPSJ1bmRlZmluZWQiIHkyPSJ1bmRlZmluZWQiPjxzdG9wIHN0b3AtY29sb3I9IiNlNGVjZjgiIHN0b3Atb3BhY2l0eT0iMSIgb2Zmc2V0PSIwIi8 PHN0b3Agc3RvcC1jb2xvcj0iI2U0ZWNmOCIgc3RvcC1vcGFjaXR5PSIxIiBvZmZzZXQ9IjEiLz48L2xpbmVhckdyYWRpZW50PjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InVybCgjdnNnZykiIC8 PC9zdmc ); /* IE9, iOS 3.2  */
        background-image: -webkit-gradient(linear, ,color-stop(0, rgb(228, 236, 248)),color-stop(1, rgb(228, 236, 248))); /*Old Webkit*/
        background-image: -webkit-linear-gradient(undefined,rgb(228, 236, 248) 0%,rgb(228, 236, 248) 100%); /* Android 2.3 */
        background-image: -ms-linear-gradient(undefined,rgb(228, 236, 248) 0%,rgb(228, 236, 248) 100%); /* IE10  */
        background-image: linear-gradient(to right bottom,rgb(228, 236, 248) 0%,rgb(228, 236, 248) 100%); /* W3C */

        /* IE8- CSS hack */
        @media screen,screen9 {
            .gradient {
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ffe4ecf8",endColorstr="#ffe4ecf8",GradientType=1);
            }
        }';

            $c_rbg = $this->getClientSelectedColor($backgroundColor);
            list ($logo_color, $rbg_str) = explode("###", $c_rbg);
            list ($clr_red, $clr_green, $clr_blue) = explode("~", $rbg_str);


            $this->colorizeBasedOnAplhaChannnel($image_location, $clr_red, $clr_green, $clr_blue, $colored_dot_src);
            $this->colorizeBasedOnAplhaChannnel($favicon_location, $clr_red, $clr_green, $clr_blue, $favicon_dst_src);
            $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $clr_red, $clr_green, $clr_blue, $ring_src);
            $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $clr_red, $clr_green, $clr_blue, $mvp_check_src);

            $global_logo[] = array(
                'server_file' => $favicon_dst_src,
                'container' => $container,
                'rackspace_path' => 'images1/' . $logo_path . $icon_arr[1]
            );
            $global_logo[] = array(
                'server_file' => $colored_dot_src,
                'container' => $container,
                'rackspace_path' => 'images1/' . $logo_path . $icon_arr[2]
            );
            $global_logo[] = array(
                'server_file' => $ring_src,
                'container' => $container,
                'rackspace_path' => 'images1/' . $logo_path . $icon_arr[3]
            );
            $global_logo[] = array(
                'server_file' => $mvp_check_src,
                'container' => $container,
                'rackspace_path' => 'images1/' . $logo_path . $icon_arr[4]
            );


            $colored_dot = $this->clientObj->rackspace_image_base . '/logos/' . $filename . 'dot_img.png';
            $favicon_dst = $this->clientObj->rackspace_image_base . '/logos/' . $filename . 'favicon-circle.png';
            $mvp_dot = $this->clientObj->rackspace_image_base . '/logos/' . $filename . 'ring.png';
            $mvp_check = $this->clientObj->rackspace_image_base . '/logos/' . $filename . 'mvp-check.png';

            $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
            $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
            $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
            $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
            $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
            $this->Default_Model_Customize->updateFunnelVariables($design_variables, $this->clientObj->client_id, $leadpop_id, $leadpop_version_seq);
        }

        if (env('APP_ENV') != config('app.env_local')) {
            if ($global_logo) {
                MyLeadsEvents::getInstance()->executeRackspaceCDNClient($global_logo);
            }
        }
    }

    /**
     * update background color
     * @param $logo_color
     */
    private function updateClientBackgroundColors($bg,$logo_color)
    {
        if (getenv("WRITE_LOG") == 1) {
            $this->db->query("INSERT INTO `launcher_log` (`message`, `type`) VALUES ('update background color => " . date('dmY h:i:s') . "', 'Client => " . $this->clientObj->client_id . "');");
        }
        $logo_color = str_replace(array('rgba(', ')'), '', $logo_color);
        $logo_color = "rgba(" . $logo_color . ",1)";
        $backgroundColor = '/*###>*/background-color: ' . $logo_color .
            ';/*@@@*/ background-image: '.$bg.'; /* W3C */';

        foreach ($this->clientFunnels as $i => $cli) {

            # MOVED THIS TO GEARMAN to cover up N+1
            /*
            DB::table('leadpop_background_color')
                ->where("client_id", $this->clientObj->client_id)
                ->where("leadpop_id", $cli['leadpop_id'])
                ->where("leadpop_type_id", $cli['leadpop_type_id'])
                ->where("leadpop_vertical_id", $cli['leadpop_vertical_id'])
                ->where("leadpop_vertical_sub_id", $cli['leadpop_vertical_sub_id'])
                ->where("leadpop_template_id", $cli['leadpop_template_id'])
                ->where("leadpop_version_id", $cli['leadpop_version_id'])
                ->where("leadpop_version_seq", $cli['leadpop_version_seq'])
                ->update(array(
                    'default_changed' => 'y',
                    'background_color' => $backgroundColor,
                ));
            */

            $sql_leadpop_background_color = 'update `leadpop_background_color` set `default_changed` = "y", `background_color` = "'.$backgroundColor.'" where ';
            $sql_leadpop_background_color .= '`client_id` = '.$this->clientObj->client_id.' and `leadpop_id` = '.$cli['leadpop_id'].' and ';
            $sql_leadpop_background_color .= '`leadpop_version_id` = '.$cli['leadpop_version_id'].' and `leadpop_version_seq` = '.$cli['leadpop_version_seq'];
            if (env('APP_ENV') != config('app.env_local')) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$sql_leadpop_background_color]);
            }
        }
    }


    private function doLogin()
    {
        Auth::loginUsingId($this->clientObj->client_id);
        $registry = \App\Services\DataRegistry::getInstance();
        $registry->leadpops->client_id = $this->clientObj->client_id;
        $registry->leadpops->clientInfo = (array)$this->clientObj;
        $registry->leadpops->tag_filter = array();
        $registry->leadpops->loggedIn = 1;
        $registry->leadpops->skip_survey = 0;
        $registry->leadpops->show_overlay = $this->clientObj->overlay_flag;
        $registry->leadpops->skeletonLogin = 0;
        if ($this->clientObj->dashboard_menu_filter) {
            $arr = json_decode($this->clientObj->dashboard_menu_filter, true);
            if ($arr) {
                $registry->leadpops->tag_filter = $arr;
            }
        }
        $registry->updateRegistry();
    }

    private function colorizeBasedOnAplhaChannnel($file, $targetR, $targetG, $targetB, $targetName)
    {


        if (file_exists($targetName)) {
            unlink($targetName);
        }

        $im_src = imagecreatefrompng($file);
        $width = imagesx($im_src);
        $height = imagesy($im_src);

        $im_dst = imagecreatefrompng($file);

//        dd($file, $targetR, $targetG, $targetB, $targetName);
        // dd($im_src, $width, $height, $im_dst);

        imagealphablending($im_dst, false);
        imagesavealpha($im_dst, true);
        imagealphablending($im_src, false);
        imagesavealpha($im_src, true);
        @imagefilledrectangle($im_dst, 0, 0, (int)$width, (int)$height, '0xFFFFFF');

//die('helo');

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {

                $alpha = (imagecolorat($im_src, $x, $y) >> 24 & 0xFF);
                $col = imagecolorallocatealpha($im_dst,
                    $targetR - (int)(1.0 / 255.0 * $alpha * (double)$targetR),
                    $targetG - (int)(1.0 / 255.0 * $alpha * (double)$targetG),
                    $targetB - (int)(1.0 / 255.0 * $alpha * (double)$targetB),
                    $alpha
                );
                if (false === $col) {
                    die('sorry, out of colors...');
                }
                imagesetpixel($im_dst, $x, $y, $col);
            }

        }
        return imagepng($im_dst, $targetName);
    }

    /**
     * get rgb logo color
     * @param $background_color
     * @return string
     */
    function getClientSelectedColor($background_color)
    {
        if (strpos($background_color, "background-color: #")) {
            $sindex = strpos($background_color, '/*###>*/background-color: #') + 26;
            $eindex = strpos($background_color, ';/*@@@*/');
            $length = $eindex - $sindex;
            $logo_color = substr($background_color, $sindex, $length);
            $_rgb = $this->hex2rgb($logo_color);
        } else {
            $sindex = strpos($background_color, '/*###>*/background-color: rgba(') + 31;
            $eindex = strpos($background_color, ');/*@@@*/');
            $length = $eindex - $sindex;
            $rbgcolor = substr($background_color, $sindex, $length);
            list($clr_red, $clr_green, $clr_blue) = explode(",", $rbgcolor);
            $_rgb = array($clr_red, $clr_green, $clr_blue);
            $logo_color = $this->rgb2html($clr_red, $clr_green, $clr_blue);
            if (is_array($logo_color)) {
                $logo_color = $logo_color[0];
            }
        }
        return $logo_color . "###" . implode("~", $_rgb);
    }

    /**
     * hex color convert into rgb
     * @param $hex
     * @return array
     */
    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    //client infor set in session for launch the account
    private function setSession($hash)
    {
        $activationJson = \LP_Helper::decrypt($hash);
//        if(strtolower(getenv('APP_ENV')) == 'local') {
//            $activationJson = json_encode(array('id' => 3111));
//        }
//        else {
        if (!$hash || !$activationJson) {
            Session::flash('error', 'Activation link is invalid!');
            return $this->_redirect(LP_PATH . '/login?ok=no');
        }
        //}
        $clientDataExtractedFromHash = json_decode($activationJson);
        Session::forget('clientDataExtractedFromHash');
        Session::put('clientDataExtractedFromHash', $clientDataExtractedFromHash);
    }


    public function getLaunchStatus(){
        return json_encode(array('status' => Session::get('launch_status')));
    }


    function getLogoPrimaryColor(Request $request){

        $rules = [
            'logo' => "mimes:jpeg,jpg,png|file|max:" . config('validation.logo_image_size')
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            $failed = $validator->failed();
            $key = array_key_first($failed);
            if(isset($failed[$key]["Mimes"])){
                return json_encode(array('error' => 'Only png, jpg and jpeg files are allowed.'));
            }
            return json_encode(array('error' => 'File size should be less than 1MB.'));
        }else {

            $client = new \App\Services\Client();
            $ImageType = $_FILES['logo']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.
            //Let's check allowed $ImageType, we use PHP SWITCH statement here
            try {
                switch (strtolower($ImageType)) {
                    case 'image/png':
                        $image = $client->loadPng($_FILES['logo']['tmp_name']);
                        $logo_color = $image->extract();
                        break;
                    case 'image/gif':
                        $image = $client->loadGif($_FILES['logo']['tmp_name']);
                        $logo_color = $image->extract();
                        break;
                    case 'image/jpeg':
                    case 'image/pjpeg':
                    case 'image/jpg':
                        $image = $client->loadJpeg($_FILES['logo']['tmp_name']);
                        $logo_color = $image->extract();
                        break;
                    default:
                        die('Unsupported File!'); //output error and exit
                }
            }
            catch (Exception $e){
                dd($e);
            }
            if (is_array($logo_color)) {
                return json_encode(array('color' => $logo_color[0]));
            }
        }
    }

    private function _getHubSpotContact($email="april4homes@outlook.com"){
        $endpointUrl = config('lp.chargebee.lp_api_endpoint_base_url');
        $authKey = config('lp.chargebee.lp_api_endpoint_auth_key');

        $hubspot_internal_api = $endpointUrl . "/hubspot/contact/get-by-email";
        $postData = json_encode(['email' => $email]);

        $curl = curl_init();
        $headers = [
            'Authorization: '.$authKey,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData)
        ];
        curl_setopt_array($curl, [
            CURLOPT_URL => $hubspot_internal_api,
            CURLOPT_POST => true,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $hubspot = array();
        $info = json_decode($response, 1);
        if($info['status']){
            $data = $info['result']['data'];
            foreach($data as $key=>$val){
                if($key != "properties" && is_array($val)) continue;

                if($key == "properties" && is_array($val)){
                    foreach($val as $name=>$property){
                        $hubspot[$name] = $property['value'];
                    }
                }
                else{
                    $hubspot[$key] = $val;
                }
            }
        }

        return $hubspot;
    }
}
