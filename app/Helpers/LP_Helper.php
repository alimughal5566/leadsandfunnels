<?php

use App\Models\Clients;
use App\Models\LynxlyLinks;
use App\Constants\LP_Constants;
use Illuminate\Support\Facades\Session;
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 05/11/2019
 * Time: 6:33 PM
 */
class LP_Helper
{
    private $db;
#   private $registry;
    private $session;
    private $verticals;
    private $sub_verticals;
    private $groups;
    private $funnels;
    private $website_funnels_list;
    private $secret_key;
    private $secret_iv;
    private $current_url;
    private $current_hash;
    private $funnel_data;
    private $client_products;
    private $clone_flag;
    private $packages_permissions;
    private $client_type;
    private $website_funnel;
    private $website_url;
    private $has_website;

    // overlay properties
    private $path;
    private $url;
    private $data;
    private $client_id;
    private $overlay_flag;
    private $overlay_flag_val;
    private $vertical_id;
    private $service_base_url, $overlay_data, $overlay_setting;
    const MODE = "dev";
    public $total_leads;
    public $datasrc;
    private $all_funnels = array();
    private $all_funnels_sticky_bar_data = array();
    private $shortLinks = null;

    const INSURANCE_CLIENT = 5;
    const IS_FAIRWAY = 1;
    const IS_MM = 1;

    public $to, $from_email, $from_name, $subject, $body = '';

    private $stats = '';
    public $client_info;
    /**
     * LP_Helper constructor.
     */
    private function __construct()
    {
        $this->db = App::make('App\Services\DbService');
        $this->stats = App::make('App\Repositories\StatsRepository');
        $this->secret_key = getenv('ENCRYPTION_IV');
        $this->secret_iv = getenv('ENCRYPTION_IV');
        $this->current_hash = false;

        $this->session = json_decode(json_encode(@Session::all()['leadpops']));
        $this->overlay_flag = false;
        if (isset($this->session->client_id) && $this->session->client_id != "") {
            /*
            $s = "SELECT overlay_flag FROM clients WHERE client_id=" . $this->session->client_id;
            $this->overlay_flag_val = $this->db->fetchOne($s);


            $s = "SELECT website_url, has_website FROM clients WHERE client_id=" . $this->session->client_id;
            $website = $this->db->fetchAll($s);
            if(sizeof($website)>0){
                $website = $website[0];
                $this->website_url = $website['website_url'];
                $this->has_website = $website['has_website'];
            }
            */

            $this->client_info = $this->get_loggedin_client_info();
            $this->overlay_flag_val = $this->client_info['overlay_flag'];
            $this->website_url = $this->client_info['website_url'];
            $this->has_website = $this->client_info['has_website'];
        }

        $this->client_type = "";
        if (isset($this->session->clientInfo->client_type) && $this->session->clientInfo->client_type) {
            $s = "SELECT vertical_label FROM leadpops_verticals WHERE id=" . $this->session->clientInfo->client_type;
            $this->client_type = $this->db->fetchOne($s);
        }

        $this->website_funnel = false;
        $this->vertical_id = 13; // Todo: Mortgage

        $this->funnelTypes = $this->verticals = $this->sub_verticals = $this->groups = $this->funnels = [];

        $this->overlay_data = [];
        $this->overlay_setting = [];

        if (@$this->session->client_id && $this->session->show_overlay == 1) {
            if (\Route::getFacadeRoot()->current()->getName() == "dashboard") {
                //$this->session->show_overlay
                $this->overlay_flag = 0; //currently, we don't need to use session value for this use the hard-code value 0
            }
        }

    }

    public static function getInstance()
    {
        static $self = null;
        if ($self === null) {
            $self = new LP_Helper();
        }
        return $self;
    }


    public function get_loggedin_client_info(){
        $q = "SELECT * ";
        $q .= " FROM clients WHERE client_id = '" . @$this->session->client_id . "'";
        return $this->db->fetchrow($q);
    }

    public function get_overlay_detail()
    {
        $return_arr = [];
        $vertical = [];
        $overlay_data = [];

        $query = "";
        $query = "SELECT hvi.title AS ititle,hvi.wistia_id AS iwistia_id,hv.id AS vertical_id,hvc.id AS vertical_cta_id,
                  hvi.id AS vertical_item_id,hvi.vertical_id AS itemver,hv.cta_url AS consultlnk,
                  hv.* ,hvi.* ,hvc.*
                  FROM helper_vertical as hv
                  join helper_vertical_items as hvi on hv.id=hvi.vertical_id
                  join helper_vertical_cta as hvc on hv.id=hvc.vertical_id";
        if ($this->client_type) {
            $query .= " WHERE hv.vertical_name='" . $this->client_type . "'";
        }
        $overlay = $this->db->fetchAll($query);

        if (isset($overlay) && !empty($overlay)) {
            $return_arr["status"] = "success";
            foreach ($overlay as $od) {
                if (!isset($vertical[$od['vertical_id']])) {
                    $vertical[$od['vertical_id']] = $od['vertical_id'];
                }
            }
            foreach ($vertical as $vertical_id => $vid) {
                foreach ($overlay as $od) {
                    if ($vertical_id == $od['vertical_id']) {
                        if (!isset($overlay_data[$od['vertical_id']]["vertical"])) {
                            $overlay_data[$od['vertical_id']]["vertical"] = array("id" => $od['vertical_id'], "version_id" => $od['version_id'], "vertical_name" => $od['vertical_name'], "summary_title" => $od['summary_title'], "summary" => $od['summary'], "phone" => $od['phone'], "cta_title" => $od['cta_title'], "cta_url" => $od['consultlnk'], "active" => $od['active'], "updated_at" => $od['updated_at'], "created_at" => $od['created_at']);
                        }
                        if (!isset($overlay_data[$od['vertical_id']]["vertical_cta"][$od['vertical_cta_id']])) {
                            $overlay_data[$od['vertical_id']]["vertical_cta"][$od['vertical_cta_id']] = ["id" => $od['vertical_cta_id'], "vertical_id" => $od['vertical_id'], "cta_name" => $od['cta_name'], "cta_url" => $od['cta_url'], "cta_target" => $od['cta_target'], "cta_link_desc" => htmlentities($od['cta_link_desc']), "active" => $od['active'], "updated_at" => $od['updated_at'], "created_at" => $od['created_at']];

                        }
                        if (!isset($overlay_data[$od['vertical_id']]["vertical_item"][$od['vertical_item_id']])) {
                            $overlay_data[$od['vertical_id']]["vertical_item"][$od['vertical_item_id']] = ["id" => $od['vertical_item_id'], "vertical_id" => $od['vertical_id'], "item_name" => $od['item_name'], "short_description" => htmlentities($od['short_description']), "video_type" => $od['video_type'], "video" => $od['video'], "description" => htmlentities($od['description']), "active" => $od['active'], "updated_at" => $od['updated_at'], "created_at" => $od['created_at'], "icon" => $od['icon'], "icon_name" => $od['icon_name'], "order" => $od['order'], 'title' => $od["ititle"], 'wistia_id' => $od["iwistia_id"]];

                        }
                    }
                }

            }

            $json = json_encode($overlay_data, JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);
            $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
            $json = str_replace("\\r", '', $json);
            $json = str_replace("\\n", '', $json);
            $json = str_replace("\\t", '', $json);
            $this->overlay_data = $json;
            //debug overlay data
            if (isset($_COOKIE['overlay_debug']) and $_COOKIE['overlay_debug'] == 1) {
                echo $query;
                echo '<pre>';
                print_r($json);
                die;
            }

            return $json;
        }

    }

    public function setOverlaySetting()
    {
        $overlay_setting_data = [];
        $query = "SELECT *
        FROM client_training_setting
        WHERE client_id=" . $this->session->client_id;
        $setting_data = $this->db->fetchAll($query);
        if (isset($setting_data) && !empty($setting_data)) {
            foreach ($setting_data as $d) {
                if (!isset($overlay_setting_data["overlay_setting"][$d["vertical_id"]])) {
                    $overlay_setting_data["overlay_setting"][$d["vertical_id"]] = json_decode($d["params"], true);
                }
            }
            $this->overlay_setting = $overlay_setting_data;
        }
    }

    /**
     * @return mixed
     */
    public function getOverlayData()
    {
        return $this->overlay_data;
    }

    public function getOverlaySetting()
    {
        return $this->overlay_setting;
    }

    public function getOverlayFlag()
    {
        return $this->overlay_flag;
    }

    public function getOverlayFlagVal()
    {
        return $this->overlay_flag_val;
    }

    public function escapeJsonString($value)
    { # list FROM www.json.org: (\b backspace, \f formfeed)
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }

    public function getDesignjpgurl()
    {
        $url = url()->current();
        if ($url == '/lp') {
            $file = "home-design.jpg";
        } else if ($url == '/lp/index') {
            $file = "home-design.jpg";
        } else if ($url == '/lp/support') {
            $file = "support-page.jpg";
        } else if ($url == '/lp/global') {
            $file = "global-settings.jpg";
        } else {
            $str = explode("/", $url);
            $file = $str[2] . "-" . $str[3] . ".jpg";
        }
        return $file;
    }

    public function getCurrentHashData($hash = NULL)
    {
        if (NULL != $hash) {
            $this->current_hash = $hash;
        } else {
            $this->current_url = url()->current();
            $arr_data = explode("/", $this->current_url);
            $this->current_hash = end($arr_data);
        }

        $this->funnel_data = $this->funnel_hash($this->current_hash);

        $this->funnel_data['leadpop_vertical_name'] = $this->getVerticalName(@$this->funnel_data["leadpop_vertical_id"]);
        $this->funnel_data['leadpop_vertical_sub_name'] = $this->getSubVerticalName(@$this->funnel_data["leadpop_vertical_sub_id"]);
        $this->funnel_data['group_name'] = $this->getGroupName(@$this->funnel_data["group_id"]);
        $funnel_info = $this->getFunnelName();
        if($funnel_info){
            $this->funnel_data['funnel'] = $funnel_info;
        } else {
            $this->_fetch_all_funnels($this->funnel_data);
            $this->funnel_data['funnel'] = $this->getFunnelName();
        }
        $this->funnel_data['tag_funnel'] = $this->getCurrentFunnel();
        $this->funnel_data['current_hash'] = $this->current_hash;

        $old_key = [];
        $old_key[] = $this->funnel_data['leadpop_vertical_name'];
        $old_key[] = $this->funnel_data['leadpop_vertical_sub_name'];
        $old_key[] = $this->funnel_data['leadpop_id'];
        $old_key[] = $this->funnel_data['leadpop_version_seq'];
        $old_key[] = $this->funnel_data['client_id'];
        $this->funnel_data['_key'] = implode('~', $old_key);

        if (!$this->funnel_data['funnel']) {
            // TODO: 404
            die('Funnel not found.');
        }
        return $this->current_hash;
    }

    /**
     * This function triggers a function from LP_Helper which gets all funnels from database for client based on ENV
     * return void
     */
    public function _fetch_all_funnels($current_funnel=array()){
        if(getenv('APP_ENV') == 'local' or @$_COOKIE['load_stats'] == "db"){
            $load_keydb_stats = false;  // load from db
        } else {
            $load_keydb_stats = true;  // load from keydb
        }

        if($load_keydb_stats)
            LP_Helper::getInstance()->get_client_funnels($current_funnel);
        else
            LP_Helper::getInstance()->get_client_funnels_db($current_funnel);
    }

    public function funnel_hash($args)
    {
        $sep = "~";
        $funnel_keys = [];
        $keysToHash = ["client_leadpop_id", "client_id", "leadpop_id", "leadpop_vertical_id", "group_id", "leadpop_vertical_sub_id", "leadpop_template_id", "leadpop_version_id", "leadpop_version_seq", "leadpop_type_id"];

        if (is_array($args)) {
            foreach ($keysToHash as $_key) {
                $funnel_keys[$_key] = ((isset($args[$_key]) && $args[$_key] != "") ? $args[$_key] : 0);
            }

            $response = $this->encrypt(implode($sep, $funnel_keys));
        } else {
            $arr = explode($sep, $this->decrypt($args));

            if (is_array($arr) && count($arr) > 2) {
                foreach ($keysToHash as $i => $_key) {
                    $funnel_keys[$_key] = $arr[$i];
                }

                $response = $funnel_keys;
            } else {
                $response = array();
            }
        }

        return $response;
    }

    /**
     * Encrypts the plain text to encrypted string. Usage is to generate funnel hashes
     * @param $plain_string
     * @param string $key
     * @return string
     */
    public static function encrypt($plain_string = '')
    {
        if ($plain_string == "")
            return $plain_string;

        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', ENCRYPTION_SECRET);
        $iv = substr(hash('sha256', ENCRYPTION_IV), 0, 16);

        $encrypted = openssl_encrypt($plain_string, $encrypt_method, $key, 0, $iv);

        $encrypted = str_replace(array("/", "+", "&", "=", "?"), array("hsAls", "sUlP", "dnAsrePma", "laUqe", "kraMnOitSeuq"), $encrypted);
        return $encrypted;
    }

    /**
     * Decrypts the string back to plain text. Usage is to generate keys from funnel hashes
     * @param $encrypted_string
     * @param string $key
     * @return bool|string
     */
    public static function decrypt($encrypted)
    {
        if ($encrypted == "")
            return $encrypted;

        $encrypted = str_replace(array("hsAls", "sUlP", "dnAsrePma", "laUqe", "kraMnOitSeuq"), array("/", "+", "&", "=", "?"), $encrypted);
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', ENCRYPTION_SECRET);
        $iv = substr(hash('sha256', ENCRYPTION_IV), 0, 16);

        $plain_string = openssl_decrypt($encrypted, $encrypt_method, $key, 0, $iv);
        return $plain_string;
    }


    public function getFunnelKeyStringFromHash($hash){
        if(empty($hash)){
            return '';
        }

        $funnelInfo = $this->funnel_hash($hash);

        return implode('~', [
            $funnelInfo['leadpop_vertical_id'],
            $funnelInfo['leadpop_vertical_sub_id'],
            $funnelInfo['leadpop_id'],
            $funnelInfo['leadpop_version_seq']
        ]);
    }

    public function get_homepage()
    {
        $return = [];
        $s = "SELECT * FROM homepage WHERE client_id = " . $this->session->client_id;
        return $this->db->fetchAll($s);
    }

    public function get_homepage_count()
    {
        return count($this->get_homepage());
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }


    /**
     * @return array
     */
    public function getVerticals()
    {
        return $this->verticals;
    }

    /**
     * @return array
     */
    public function setAllFunnel($funnels)
    {
        return $this->all_funnels = $funnels;
    }

    /**
     * @return array
     */
    public function getAllFunnel()
    {
        return $this->all_funnels;
    }

    public function getFunnelTypes($type)
    {
        ## $funnelTypesData['all']="All";
        $funnelTypesData['f'] = $type . " Funnels";
        ## if( $this->website_funnel==true && !empty($this->website_funnels_list) )
        //{
        $funnelTypesData['w'] = "Website Funnels";
        //}
        return $this->funnelTypes = $funnelTypesData;
    }

    /**
     * @param array $verticals
     */
    public function setVerticals($verticals)
    {
        $this->verticals = $verticals;
    }

    /**
     * @return mixed
     */
    public function getSubVerticals()
    {
        return $this->sub_verticals;
    }

    /**
     * @param mixed $sub_verticals
     */
    public function setSubVerticals($sub_verticals)
    {
        $this->sub_verticals = $sub_verticals;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return mixed
     */
    public function getFunnels()
    {
        return $this->funnels;
    }

    public function checkHaveWebsiteFunnels()
    {
        return $this->website_funnel;
    }

    public function websiteFunnelsList()
    {
        return $this->website_funnels_list;
    }

    /**
     * @param mixed $funnels
     */
    public function setFunnels($funnels)
    {
        $this->funnels = $funnels;
    }

    public function getFunnelName()
    {

        $data = @$this->funnels[$this->funnel_data['leadpop_vertical_id']][$this->funnel_data['group_id']][$this->funnel_data['leadpop_vertical_sub_id']][$this->funnel_data['client_leadpop_id']];
        return $data;
    }

    public function getCurrentFunnel()
    {
        if (is_array($this->all_funnels) && !empty($this->all_funnels)) {
            $key = array_search($this->current_hash, array_column($this->all_funnels, 'hash'));
            return $this->all_funnels[$key];
        } else {
            return null;
        }
    }


    public function getGroupName($group_id)
    {
        return (key_exists($group_id, $this->groups)) ? $this->groups[$group_id]['name'] : "";
    }

    public function getGroupCount($group_id)
    {
        return (key_exists($group_id, $this->groups)) ? $this->groups[$group_id]['count'] : "";
    }

    public function getGroupSlug($group_id)
    {
        return str_replace(' ', '-', strtolower($group_id . "_" . $this->getGroupName($group_id)));
    }

    public function getSubVerticalName($sub_vertical_id)
    {
        return (key_exists($sub_vertical_id, $this->sub_verticals)) ? $this->sub_verticals[$sub_vertical_id] : "";
    }

    public function getVerticalName($vertical_id)
    {
        return (key_exists($vertical_id, $this->verticals)) ? $this->verticals[$vertical_id] : "";
    }

    public function getSubVerticalSlug($sub_vertical_id)
    {
        ## return str_replace(' ','-',strtolower($sub_vertical_id."-".$this->getSubVerticalName($sub_vertical_id)));
        return str_replace(' ', '-', strtolower($this->getSubVerticalName($sub_vertical_id)));
    }

/*    public function getAllShortLinksForClient(){
        if($this->shortLinks === null){
            $this->shortLinks = LynxlyLinks::where('client_id', $this->session->client_id)
                ->where('lynxly_hash', '!=', "")
            ->groupBy('id')
            ->get()
            ->keyBy('id')
            ->toArray();
        }

        return $this->shortLinks;
    }*/


    public function getAllShortLinksForClient(){
        if($this->shortLinks === null){
            $this->shortLinks = LynxlyLinks::where('client_id', $this->session->client_id)
                ->groupBy('id')
                ->get()
                ->keyBy('clients_leadpops_id')
                ->toArray();
        }

       // print_r($this->shortLinks );

        return $this->shortLinks;
    }

    public function getThridPartyWebsiteData($sticky_id)
    {
        $results = 'select * from client_funnel_sticky_3rd_party_website where client_funnel_sticky_id =' . $sticky_id . ' and active_flag = 1  ORDER BY created_date DESC';
        $results = $this->db->fetchall($results);
        $thrid_party_website_array = [];

        foreach ($results as $result) {
            $thrid_party_website_array[$result['client_funnel_sticky_id']][] = [
                'id' => $result['id'],
                'client_id' => $result['client_id'],
                'clients_leadpops_id' => $result['clients_leadpops_id'],
                'clicks' => $result['clicks'],
                'hash' => $result['hash'],
                'sticky_url' => $result['sticky_url'],
                'sticky_bar_style' => $result['sticky_bar_style'],
                'third_party_url' => $result['third_party_url'],
                'third_party_url_tooltip' => $result['third_party_url_tooltip'],
                'created_date' => strtotime($result['created_date']),
                'created_date_format' => date('m/d/y', strtotime($result['created_date']))
            ];
        }
        if (empty($thrid_party_website_array)) {
            return $thrid_party_website_array = '';
        } else return $thrid_party_website_array;
    }

    public function getFunnelsByVertical($vertical_id)
    {
        return (key_exists($vertical_id, $this->funnels)) ? $this->funnels[$vertical_id] : [];
    }

    /**
     * @return mixed
     */
    public function getCurrentUrl()
    {
        return $this->current_url;
    }

    /**
     * @param mixed $current_url
     */
    public function setCurrentUrl($current_url)
    {
        $this->current_url = $current_url;
    }

    /**
     * @return mixed
     */
    public function getCurrentHash()
    {
        return $this->current_hash;
    }

    /**
     * @param mixed $current_hash
     */
    public function setCurrentHash($current_hash)
    {
        $this->current_hash = $current_hash;
    }

    /**
     * @return mixed
     */
    public function getFunnelData()
    {
        /**
         * Note By Jaz: 2109/12/12
         * In some forms we are passing complete funnel_data as hidden value and since we added json based question thsoe form not working
         * due to huge data in hidden field so removing funnel Questions + Sequence for funnel data array
         *
         * If you need question
         */

        $remvoe_indexes = array("question_sequence", "funnel_questions");
        $remove_from = array("funnel", "tag_funnel");

        if ($this->funnel_data) {
            foreach ($remove_from as $key) {
                if (array_key_exists($key, $this->funnel_data)) {
                    foreach ($remvoe_indexes as $index) {
                        unset($this->funnel_data[$key][$index]);
                    }
                }
            }
        }

        return $this->funnel_data;
    }

    /**
     * @param mixed $funnel_data
     */
    public function setFunnelData($funnel_data)
    {
        $this->funnel_data = $funnel_data;
    }

    public static function getFontFamilies($json=false,$route = '')
    {

        $fontJson = json_decode(file_get_contents(env("constants.LP_BASE_DIR") . "/public" . config('view.theme_assets') . "/js/funnel/json/fonts.json"), true);
        $currentRoute = Request::route()->getName();
        if($route){
            $currentRoute = $route;
        }
//         if($currentRoute === 'funnel-builder' || $currentRoute === 'createTcpaFromPage' || $currentRoute === 'EditTcpaFromPage'){
//             $_font = $fontJson['funnel-builder'];
//         }
//        else
        if($currentRoute === 'calltoaction'){
            $_font = $fontJson['cta-fonts'];
            sort($_font);
        }
         else{
             $_font = $fontJson['froala-editor'];
         }
        return $json ? json_encode($_font) : $_font;
    }

    public static function getFontFamilesClass($fontfamiles)
    {
        $ffclass = "";
        foreach ($fontfamiles as $font):
            $cfont = str_replace(" ", "_", strtolower($font));
            $ffclass .= "." . $cfont . "{";
            $ffclass .= "font-family: '" . $font . "'";
            $ffclass .= "}";
        endforeach;
        return $ffclass;
    }

    public static function getFontFamilyFiles($font_familes)
    {
        $font_familes_file_link = [];
        $prefix = "https://fonts.googleapis.com/css?family=";
        foreach ($font_familes as $fs) {
            $filename = str_replace(" ", "+", $fs);
            $statusCode = get_headers($prefix . $filename);
            if(stripos($statusCode[0],"200 OK")){
            array_push($font_familes_file_link, $prefix . $filename);
             }
        }
        return $font_familes_file_link;
    }


//    HTML functions

    public function getFunnelHeader($view)
    {
        /**
         * @var Zend_View_Helper_Action $view
         */
        $funnel_name = ($this->session->clientInfo->dashboard_v2 == 1) ? $this->funnel_data['tag_funnel']['funnel_name'] : strtolower($this->funnel_data['funnel']['domain_name']);
        $header_html = "<div class=\"title-wrapper\">
                <div class=\"row\">
                    <div class=\"col-sm-9 lp-main-title\">
                        <span>" . LP_Constants::getBreadcrumText($view->data->active_menu) . ": </span><span class=\"lp-url-color selectedFunnel\">" . $funnel_name . "</span>
                    </div>";
        $header_html .= "<div class=\"col-sm-3 text-right\">";
        $header_html .= "<div class=\"watch-video\">";
        /*if(isset($view->data->wistia_id) && $view->data->wistia_id){
            $header_html .="<a popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true class=\"btn-video\" href=\"#wistia_".$view->data->wistia_id."?autoPlay=false\" ><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
         }else{*/
        if ((isset($view->data->wistia_id) && $view->data->wistia_id)) {
            if (isset($view->data->videotitle) && $view->data->videotitle) {
                $wistitle = $view->data->videotitle;
            }
            $wisid = $view->data->wistia_id;
            $header_html .= "<a data-lp-wistia-title=\"$wistitle\" data-lp-wistia-key=\"$wisid\" class=\"btn-video lp-wistia-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
        } elseif ((isset($view->data->videolink) && $view->data->videolink)) {
            $header_html .= "<a class=\"btn-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
        }
        //}
        $header_html .= "</div>";
        $header_html .= "</div>";
        $header_html .= "</div>
            </div>";
        //debug($header_html);
        echo $header_html;
    }


    public function getFunnelHeaderAdminTheme3($view, $backUrl = null, $ifSuperFooter = false, $ifFooter= false, $backLink = [])
    {

        $funnel_data = $this->funnel_data['funnel'];
        $funnel_name = $funnel_data['funnel_name'];
        $menu = LP_Constants::getBreadcrumText($view->data->active_menu, $view->data);
        $currentRoute = Request::route()->getName();

        $selectedFunnelCount = $this->getGlobalSettingHtml();

        if ((isset($view->data->wistia_id) && $view->data->wistia_id)) {
            if (isset($view->data->videotitle) && $view->data->videotitle) {
                $wistitle = $view->data->videotitle;
            }
            $wisid = $view->data->wistia_id;
        } elseif ((isset($view->data->videolink) && $view->data->videolink)) {
            $wistitle = $view->data->videotitle;
            $wisid = $view->data->videolink;
            //Setting video title to show video
            //we don't need. i have fixed above on two lines. @mzac90
//           if (isset($view->data->videotitle) && $view->data->videotitle) {
//                $wistitle = $view->data->videotitle;
//            }
//            $wisid = "";
        }

        $actions_having_tabs = config('lp.actions_having_tabs');
        $head_tab_class = in_array(Route::getCurrentRoute()->getActionName(), $actions_having_tabs)?'main-content__head_tabs':'';
        if(!$ifFooter) {
            // show funnel tile and menu in case if not footer main page
            $funnelHeader = <<<funnel

                     <div class="main-content__head $head_tab_class">
                            <div class="col-left">
                                <h1 class="title">
                                    <span class="page-name">$menu:</span>
                                    <div class="funnel-name-wrap">
                                        <span class="funnel-name el-tooltip" title="$funnel_name" data-old-name="$funnel_name" contenteditable="false" onfocus="document.execCommand('selectAll',false,null)">$funnel_name</span>
funnel;
                                        if($currentRoute === 'funnel-builder'){
                                         $funnelHeader .= <<<funnel
                                        <span class="funnel-edit-check"><i class="ico-check"></i></span>
                                        <span class="funnel-edit-close"><i class="ico-cross"></i></span>
                                        <span class="funnel-edit"><i class="ico-edit"></i></span>
funnel;
                                        }
            $funnelHeader .= <<<funnel
                                    </div>
                                </h1>
                                $selectedFunnelCount
                            </div>
funnel;
        } else {
            // show footer checkbox in case of footer
            $funnelHeader = <<<funnel

                     <div class="main-content__head main-content__head_tabs">
                        <div class="col-left">
                             <h1 class="title">
                                    <span class="page-name">$menu:</span>
                                    <div class="funnel-name-wrap">
                                        <span class="funnel-name el-tooltip" title="$funnel_name">$funnel_name</span>
                                      </div>
                                </h1>
                                 $selectedFunnelCount
                                <div class="disabled-wrapper el-tooltip" title="This feature is coming soon!">
                                <input checked id="footer-page" name="footer-page" data-toggle="toggle"
                                        data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
                                </div>
                        </div>
funnel;

        }

        if (isset($wistitle)) {
            $funnelHeader .= <<<funnelVideo
             <div class="col-right">
funnelVideo;
                              if($currentRoute == 'integration'){
                              $funnelHeader .= <<<funnelVideo
                                <a class="api-key-opener" data-toggle="modal" href="#api-key-popup"><i class="ico-key"></i>API Authorization Key</a>
funnelVideo;
                                }
            if($currentRoute === 'funnel-builder'){
                $funnelHeader .= <<<funnelVideo
                    <span class="take-tour-btn funnel">take a tour</span>
funnelVideo;
            }
            $funnelHeader .= <<<funnelVideo
                                <a data-lp-wistia-title="$wistitle"  data-lp-wistia-key="$wisid"
                                   class="video-link lp-wistia-video" href="#" data-toggle="modal"
                                   data-target="#lp-video-modal">
                                    <span class="icon ico-video"></span>
                                    WATCH HOW-TO VIDEO
                                </a>


funnelVideo;

            $pageTabs = "";
            if ($ifSuperFooter && is_array($ifSuperFooter)) {
                foreach ($ifSuperFooter as $tab) {
                     $tabClass = "";
                     $tabTooltip = "";
                     $tabLinkClass = "";

                     if(isset($tab["active"]) && $tab["active"]) {
                         $tabLinkClass = "active";
                     } else if(isset($tab["disabled"]) && $tab["disabled"]) {
                         $tabClass .= "disabled el-tooltip";
                         $tabTooltip = "title='This feature is coming soon!'";
                     }
                    $pageTabs .= <<<tabs
                                <li class="nav-item $tabClass" {$tabTooltip}>
                                    <a class="nav-link {$tabLinkClass}" data-toggle="pill" href="{$tab["href"]}">{$tab["tab"]}</a>
                                </li>
tabs;
                }

                $funnelHeader .= <<<footer
                        <div class="tab__wrapper">
                                <ul class="nav nav__tab" role="tablist">
                                    $pageTabs
                                </ul>
                            </div>
footer;

            }

            $funnelHeader .= "</div>";

        }

        if ($backUrl) {
        $funnelHeader .= <<<funnelVideo

             <div class="col-right">
                        <a href="$backUrl" class="back-link">
                            <span class="icon icon-back ico-caret-up"></span>
                            Back to Footer Options
                        </a>
             </div>

funnelVideo;

    }


        if ($backLink) {
            $link = $backLink['link'];
            $text = $backLink['text'];
            $funnelHeader .= <<<backLink

             <div class="col-right">
                        <a href="$link" class="back-link">
                            <span class="icon icon-back ico-caret-up"></span>
                            $text
                        </a>
             </div>

backLink;

        }
        $funnelHeader .= "</div>";


        echo $funnelHeader;


    }


    public function getFunnelHeaderAdminThreeThankYouPage($view, $hash)
    {

        $funnel_name = $this->funnel_data['tag_funnel']['funnel_name'];
        $menu = LP_Constants::getBreadcrumText($view->data->active_menu);

        $selectedFunnelCount = $this->getGlobalSettingHtml();
        $wistitle = $wisid = '';

        if ((isset($view->data->wistia_id) && $view->data->wistia_id)) {
            if (isset($view->data->videotitle) && $view->data->videotitle) {
                $wistitle = $view->data->videotitle;
            }
            $wisid = $view->data->wistia_id;
            //  $header_html .= "<a data-lp-wistia-title=\"$wistitle\" data-lp-wistia-key=\"$wisid\" class=\"btn-video lp-wistia-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
        } elseif ((isset($view->data->videolink) && $view->data->videolink)) {
            $wistitle = $view->data->videotitle;
            $wisid = $view->data->videolink;
//          $header_html .= "<a class=\"btn-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
        }

        $route = $view->route;

        echo <<<thankyouFunnel

          <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                           <span class="page-name">$menu:</span> <span class="funnel-name">$funnel_name</span>
                        </h1>
                         $selectedFunnelCount
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a data-lp-wistia-title="$wistitle" data-lp-wistia-key="$wisid"
                                       class="video-link lp-wistia-video" href="#" data-toggle="modal"
                                       data-target="#lp-video-modal">
                                        <span class="icon ico-video"></span> WATCH HOW-TO VIDEO</a>
                                </li>
                                <li class="action__item">
                                    <a href="$route" class="back-link"><span
                                                class="icon icon-back ico-caret-up"></span>  $view->title </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

thankyouFunnel;

    }

    public function getGlobalSettingHtml(){
        $currentRoute = Request::route()->getName();
        $blueBarRoutes = config('routes.blueBarRoutes');
        $plusIcon = 'd-none';
        $selectedFunnelCount = "";
        if(!in_array($currentRoute, $blueBarRoutes)){
            $selectedFunnelCount = '<span class="funnel-plus-icon '.$plusIcon.'">+</span> <div class="funnel-info-tag">
                                <a class="global-setting-link selectedFunnelCount" data-toggle="modal" href="#global-setting-funnel-list-pop" title="Global Settings" onclick="globalModalObj.initFunnelList()"></a>
                                  </div>';
        }
        return $selectedFunnelCount;
    }

    public function getClientVerticals()
    {
        $s = "SELECT DISTINCT leadpop_vertical_id, lead_pop_vertical FROM homepage WHERE client_id = " . $this->session->client_id;
        $leadpopList = $this->db->fetchAll($s);

        $result = array();
        $result['excludedVerticals'] = array(7);;
        $result['hasfunnels'] = "0";
        $result['hasenterprise'] = "0";
        foreach ($leadpopList as $leadpop_vertical_id) {
            if (in_array($leadpop_vertical_id['leadpop_vertical_id'], $result['excludedVerticals'])) {
                $result['hasenterprise'] = "1";
            }
            if (!in_array($leadpop_vertical_id['leadpop_vertical_id'], $result['excludedVerticals'])) {
                $result['hasfunnels'] = "1";
            }
        }

        $verticals = array();
        if ($result['hasfunnels'] == "1") {
            for ($i = 0; $i < count($leadpopList); $i++) {
                if (in_array($leadpopList[$i]['leadpop_vertical_id'], $result['excludedVerticals'])) {
                    continue;
                }

                $vertical = array();
                $vertical['leadpop_vertical_id'] = $leadpopList[$i]['leadpop_vertical_id'];
                $vertical['leadpop_vertical_name'] = $leadpopList[$i]['lead_pop_vertical'];
                if ($this->session->clientInfo->client_type == $leadpopList[$i]['leadpop_vertical_id'])
                    $vertical['selected'] = 1;
                else
                    $vertical['selected'] = 0;

                $verticals[$leadpopList[$i]['leadpop_vertical_id']] = $vertical;
            }
        } else if ($result['hasenterprise'] == "1") {
            for ($i = 0; $i < count($leadpopList); $i++) {
                if (!in_array($leadpopList[$i]['leadpop_vertical_id'], $result['excludedVerticals'])) {
                    continue;
                }

                $vertical = array();
                $vertical['leadpop_vertical_id'] = $leadpopList[$i]['leadpop_vertical_id'];
                $vertical['leadpop_vertical_name'] = $leadpopList[$i]['lead_pop_vertical'];
                $verticals[$leadpopList[$i]['leadpop_vertical_id']] = $vertical;
            }
        }

        $result['verticals'] = $verticals;
        return $result;
    }

    public function get_client_products()
    {
        if (@!$this->client_products) {

            $s = "SELECT clone FROM client_vertical_packages_permissions WHERE client_id = " . $this->session->client_id . " LIMIT 1 ";
            $this->packages_permissions = $this->db->fetchOne($s);
            $this->clone_flag = $this->packages_permissions;
            //if default clone feature disable then clone feature will be enable for new requirement
            //set the 2 limit for cloning, client cannot clone the funnel greater than set the limit
            if($this->clone_flag === 'n'){
               $this->checkFunnelCloneLimit();
            }
            $this->client_products = [
                LP_Constants::PRODUCT_FUNNEL => 0,
                LP_Constants::PRODUCT_LANDING => 0,
                LP_Constants::PRODUCT_EMAILFIRE => 0
            ];
            /**
             * Check EMMA Status
             */
            $s = "SELECT status FROM client_emma_account WHERE client_id = " . $this->session->client_id . " LIMIT 1 ";
            $res = $this->db->fetchAll($s);
            if (@$res[0]['status']) {
                $this->client_products[LP_Constants::PRODUCT_EMAILFIRE] = 1;
            }

            /**
             * Check Page Lading Status
             */
            $verticals = $this->getVerticals();
            $vertical_ids = array_keys($verticals);

            /*if(in_array(3,$vertical_ids)){
              $this->client_type ="Mortgage";
            }*/

            /*
             * Enterprice ID = 7
             */
            if (in_array(7, $vertical_ids)) {
                // Enterprice
                $this->client_products[LP_Constants::PRODUCT_LANDING] = 1;
            }
            //if(!in_array(7,$vertical_ids)){
            if (in_array(1, $vertical_ids) || in_array(3, $vertical_ids) || in_array(5, $vertical_ids)) {
                // Check Funnel Status
                $this->client_products[LP_Constants::PRODUCT_FUNNEL] = 1;
            }
        }
    }

    public function get_hasenterpris()
    {

        $s = "SELECT DISTINCT leadpop_vertical_id, lead_pop_vertical FROM homepage WHERE client_id = " . $this->session->client_id;
        $leadpopList = $this->db->fetchAll($s);
        $enterprise = array(7);
        $enterprisenames = array(7 => "Mortgage");
        $cnt = count($leadpopList);
        $hasenterprise = "0";
        $ecnt = 0;
        for ($z = 0; $z < count($leadpopList); $z++) {
            if (in_array($leadpopList[$z]['leadpop_vertical_id'], $enterprise)) {

                $enterpriseindex[$ecnt] = [$leadpopList[$z]['leadpop_vertical_id']];
                $enterpriselabel[$ecnt] = [$enterprisenames[$leadpopList[$z]['leadpop_vertical_id']]];

                $ecnt += 1;
                $hasenterprise = "1";

            }

        }
        LP_Constants::PRODUCT_LANDING == $hasenterprise;

    }

    public function clientTypeOrLandingPages()
    {
        $clientVerticals = $this->getVerticals();
        if (!array_key_exists($this->session->clientInfo->client_type, $clientVerticals) && count($clientVerticals) == 1 && in_array(7, array_keys($clientVerticals))) {
            $vclient_type = 7;  // if client has landing pages only
        } else {
            $vclient_type = $this->session->clientInfo->client_type;
        }
        return $vclient_type;
    }

    public function getFunnelUrl($url)
    {
        $s = "SELECT is_secured FROM clients WHERE client_id = " . $this->session->client_id;
        $info = $this->db->fetchAll($s);
        if ($info) {
            $is_secured = $info[0]['is_secured'];
        } else {
            $is_secured = 0;
        }

        return (@$is_secured == 1 ? "https://" : "http://") . $url;
    }

    public function getFunnelUrlTag()
    {
        $s = "SELECT is_secured FROM clients WHERE client_id = " . $this->session->client_id;
        $info = $this->db->fetchAll($s);
        if ($info) {
            $is_secured = $info[0]['is_secured'];
        } else {
            $is_secured = 0;
        }

        return (@$is_secured == 1 ? "https://" : "http://");
    }

    public function getDirectClientInfo()
    {
        $s = "SELECT * FROM clients WHERE client_id = " . $this->session->client_id;
        $info = $this->db->fetchAll($s);
        if ($info) {
            $client = $info[0];
        } else {
            $client = array();
        }
        return $client;
    }

    public function getTotalExpertInfo()
    {
        $s = "SELECT client_id,active FROM totalexpert WHERE client_id = " . $this->session->client_id . " LIMIT 1 ";
        $te = $this->db->fetchAll($s);
        return $te;
    }

    public function getHomebotInfo()
    {
        $s = "SELECT client_id,active FROM homebot WHERE client_id = " . $this->session->client_id . " limit 1 ";
        $hb = $this->db->fetchAll($s);
        return $hb;
    }

    /**
     * @return array
     */
    public function getClientProducts()
    {
        return $this->client_products;
    }

    /**
     * @param array $client_products
     */
    public function setClientProducts($client_products)
    {
        $this->client_products = $client_products;
    }

    /**
     * @param bool $include_free_clone Is cloning allowed (y) consider free funnels in allowed case
     * @return string
     */
    public function getCloneFlag($include_free_clone=true)
    {
        return $include_free_clone ? $this->clone_flag : $this->packages_permissions;
    }

    /**
     * @return mixed
     */
    public function getClientType()
    {

        return $this->client_type;
    }

    /**
     * @return $website
     */
    public function getClientWebsiteInfo()
    {
        return [
            'website_url' =>$this->website_url,
            'has_website' =>$this->has_website
        ];
    }


    /**
     * @param mixed $clone_flag
     */
    public function setCloneFlag($clone_flag)
    {
        $this->clone_flag = $clone_flag;
    }

    public function getClientFunnelUrl()
    {
        $s = "SELECT sticky_url , sticky_funnel_url FROM client_funnel_sticky WHERE client_id = " . $this->session->client_id;
        $te = $this->db->fetchAll($s);
        return $te;
    }

    public function getTopLevelDomain()
    {

        $s = "SELECT * FROM top_level_domains ORDER BY primary_domain = 'y' DESC";
        $te = $this->db->fetchAll($s);
        return $te;

    }

    public function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

    }

    public function generateSubdDomain($subdomain)
    {
        if (strpos($subdomain, '-') !== false) {
            $str = explode('-', $subdomain);
            $last_str = end($str);
            if (strlen($last_str) == 8 and preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $last_str, $match)) {
                $n = substr($subdomain, 0, strlen($subdomain) - 8) . $this->generateRandomString(8);
            } else {
                $n = $subdomain . '-' . $this->generateRandomString(8);
            }
        } else {
            $n = $subdomain . '-' . $this->generateRandomString(8);
        }
        return $n;
    }

    public function FunnelQuestionJson()
    {
        $leadpop_vertical_id = $this->getFunnelData()['funnel']['leadpop_vertical_id'];
        $leadpop_vertical_sub_id = $this->getFunnelData()['funnel']['leadpop_vertical_sub_id'];
        $leadpop_version_id = $this->getFunnelData()['funnel']['leadpop_version_id'];
        $leadpop_template_id = $this->getFunnelData()['funnel']['leadpop_template_id'];

        $s = "SELECT fb_questions_json FROM leadpops_template_info WHERE leadpop_vertical_id = '" . $leadpop_vertical_id . "' AND leadpop_vertical_sub_id = '" . $leadpop_vertical_sub_id . "'";
        $s .= " AND leadpop_version_id = '" . $leadpop_version_id . "' AND leadpop_template_id = '" . $leadpop_template_id . "'";

        $fb_questions_json = $this->db->fetchOne($s);

        if ($fb_questions_json == "" || $fb_questions_json == "null") {
            $te = array();
        } else {
            $te = json_decode($fb_questions_json);
        }
        return $te;

    }

    public function CurrencyFormat($v)
    {
        $r = $this->AplhaReplaceEmptyStr($v);
        if ($r == "" or $r == 0) {
            return 0;
        } else {
            return $r;
        }
    }

    public function AplhaReplaceEmptyStr($v)
    {
        return preg_replace("/[^\d,\.]/", "", $v);
    }

    public function GetClientTag()
    {
        $s = "SELECT DISTINCT client_tag_name FROM leadpops_client_tags WHERE
        client_id = '" . $this->session->client_id . "' ORDER BY client_tag_name ASC";
        $te = $this->db->fetchAll($s);
        return $te;

    }

    public function funnel_type_list()
    {
        $arr = array();
        $arr_of_veriticals_have_SF = array();
        $clientVerticals = $this->getVerticals();
        $rec = $this->getFunnelTypes($this->getClientType());
        $arr_of_veriticals_have_SF[$this->session->clientInfo->client_type] = $rec['f'];
        unset($arr_of_veriticals_have_SF['f']);
        $array_key = array_keys($clientVerticals);
        /*
         * Note: if a vertical don't have stock funnels, it will be hide form dropdown
         * */
        foreach ($this->all_funnels as $k => $v) {
            if ($v['funnel_type'] == 'f' && in_array($v['leadpop_vertical_id'], $array_key) && !array_key_exists($v['leadpop_vertical_id'], $arr_of_veriticals_have_SF)) {
                $arr[$v['leadpop_vertical_id']] = $clientVerticals[$v['leadpop_vertical_id']] . ' Funnels';
            }
        }
        asort($arr);
        $arr_of_veriticals_have_SF = $arr_of_veriticals_have_SF + $arr;
        $arr_of_veriticals_have_SF['w'] = $rec['w'];
        return $arr_of_veriticals_have_SF;
    }

    public function getGroupCountLitePackage($vertical_id, $group_id)
    {
        /* if  User Have Lite Package*/
        $str_lite_funnels = $this->session->clientInfo->lite_funnels;
        $lite_funnels = explode(",", $str_lite_funnels);
        /* End if  User Have Lite Package*/
        $AllVerticalFunnels = $this->getFunnelsByVertical($vertical_id);
        $total_group_active_funnel_lite_package = 0;
        foreach ($AllVerticalFunnels[$group_id] as $group_item) {
            foreach ($group_item as $vertical_group_funnel) {
                if (in_array($vertical_group_funnel['leadpop_vertical_sub_id'], $lite_funnels)) {
                    $total_group_active_funnel_lite_package += 1;
                }
            }
        }
        return $total_group_active_funnel_lite_package;
    }

    public function send_mail()
    {

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . $this->from_name . ' <' . $this->from_email . '>' . "\r\n";
        foreach ($this->to as $v) {
            $ret = mail($v, $this->subject, $this->body, $headers);
        }
        return $ret;
    }

    public function addScheme($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }


    public function default_background_color()
    {
        $default = array();
//        $default["leadpop_vertical_id"] = $vertical_id;
//        $default["leadpop_vertical_sub_id"] = $subvertical_id;
//        $default["leadpop_type_id"] = $leadpop_type_id;
//        $default["leadpop_template_id"] = $leadpop_template_id;
//        $default["leadpop_id"] = $leadpop_id;
//        $default["leadpop_version_id"] = $leadpop_version_id;
//        $default["leadpop_version_seq"] = $version_seq;
        $default["background_overlay"] = "";
        $default["bgimage_properties"] = "";
        $default["bgimage_url"] = "";
        $default["bgimage_style"] = "";
        $default["background_overlay"] = "";
        $default["active_backgroundimage"] = "n";
        $default["active_overlay"] = "n";
        $default["background_type"] = "1";
        $default["background_overlay_opacity"] = "0";
        $default["background_custom_color"] = "null";
        $default["background_color"] = "/*###>*/background-color: rgba(171, 179, 182, 1);/*@@@*/\t\t\t\tbackground-image: linear-gradient(to right bottom,rgba(171, 179, 182, 1) 0%,rgba(171, 179, 182, 1) 100%); /* W3C */";
        $default["active"] = "y";
        $default["default_changed"] = "y";

        return $default;
    }

    /**
     * @deprecated
     *
     * This functions gets all funnels with minimum information to load on dashboard v2
     * with Optimizing Big SQL for Dashboard v2
     * @since 2.1.0 - Query Optimized during migration to laravel
     */
    public function get_client_leadpops_optimized()
    {
        $graphDays = ' -8';
        if (count($this->getAllFunnel()) < 1) {
            $select = array();
            $joins = array();

            $select["verticals"] = " lead_pop_vertical, vertical_label";
            $joins["verticals"] = " INNER JOIN leadpops_verticals verticals ON (verticals.id = lp.leadpop_vertical_id)";

            $select["subverticals"] = " display_label, group_id, lead_pop_vertical_sub, v_sticky_button, v_sticky_cta, subverticals.ordering AS subvertorder, subverticals.fs_display_label";
            $joins["subverticals"] = " INNER JOIN leadpops_verticals_sub subverticals ON (subverticals.id = lp.leadpop_vertical_sub_id AND subverticals.active = 'y')";

            $select["groups"] = " group_name";
            $joins["groups"] = " INNER JOIN leadpops_vertical_groups groups ON (groups.id = subverticals.group_id)";

            /*
            TODO: Work on this optimization logic after cutover if required else remove this commented code (Jaz) - Logic here is to store one time data for some table in session and remove those from joins
            if(Session::has("verticals")){
                $verticals = session('verticals');
            } else {
                $verticals = $this->db->fetchAll("SELECT id, lead_pop_vertical, vertical_label FROM leadpops_verticals");
                $verticals = array_column($verticals, null, 'id');
                session(['verticals' => $verticals]);
            }

            if(Session::has("subverticals")){
                $subverticals = session('subverticals');
            } else {
                $subverticals = $this->db->fetchAll("SELECT id, display_label, group_id, lead_pop_vertical_sub, v_sticky_button, v_sticky_cta, ordering AS subvertorder, fs_display_label FROM leadpops_verticals_sub");
                $subverticals = array_column($subverticals, null, 'id');
                session(['subverticals' => $subverticals]);
            }

            if(Session::has("groups")){
                $groups = session('groups');
            } else {
                $groups = $this->db->fetchAll("SELECT id, group_name FROM leadpops_vertical_groups");
                $groups = array_column($groups, null, 'id');
                session(['groups' => $groups]);
            }
            */

            $select["sticky"] = " sticky.id as sticky_id, sticky.sticky_name, sticky.sticky_cta, sticky.sticky_button, sticky.sticky_url, sticky.sticky_url_pathname, sticky.sticky_funnel_url, sticky.sticky_js_file, sticky.sticky_website_flag, sticky.sticky_status, sticky.pending_flag, sticky.sticky_updated, sticky.sticky_location, sticky.show_cta, sticky.sticky_size, sticky.zindex, sticky.zindex_type, sticky.hide_animation, sticky.stickybar_number, sticky.stickybar_number_flag, sticky.sticky_data, sticky.third_party_website_flag, sticky.script_type as sticky_script_type";
            $joins["sticky"] = " LEFT JOIN client_funnel_sticky sticky ON (sticky.client_id = client_lp.client_id AND sticky.clients_leadpops_id = client_lp.id)";
            $select["lynxly_links"] = "lynxly_links.id, lynxly_links.slug_name, lynxly_links.target_url, lynxly_links.clients_leadpops_id, lynxly_links.client_id";
            $joins["lynxly_links"] = " LEFT JOIN lynxly_links ON (lynxly_links.client_id = client_lp.client_id AND lynxly_links.clients_leadpops_id = client_lp.id )";

            $sql = "SELECT domains.domain_name as domain_name, NULL as subdomain_name, NULL as top_level_domain, domains.id AS domain_id,
                      client_lp.id as client_leadpop_id, client_lp.client_id, client_lp.container, client_lp.date_added, client_lp.date_updated, client_lp.funnel_market, client_lp.funnel_market AS funnel_type, client_lp.funnel_name,
                      client_lp.last_edit, client_lp.last_submission, client_lp.leadpop_active, client_lp.leadpop_folder_id, client_lp.leadpop_version_id, client_lp.leadpop_version_seq, client_lp.question_sequence,client_lp.lynxly_hash,
                      lp.id as leadpop_id, lp.leadpop_vertical_id as leadpop_vertical_id, lp.leadpop_vertical_sub_id as leadpop_vertical_sub_id, lp.leadpop_template_id as leadpop_template_id, lp.leadpop_type_id, lp.leadpop_version_id,
                      " . implode(", ", array_filter($select)) . "
                      FROM clients_domains domains
                      INNER JOIN leadpops lp ON (
                          domains.leadpop_vertical_id = lp.leadpop_vertical_id AND
                          domains.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id
                      )
                      INNER JOIN clients_leadpops client_lp ON (
                          client_lp.leadpop_id = lp.id AND
                          domains.client_id = client_lp.client_id AND
                          domains.leadpop_id = client_lp.leadpop_id AND
                          domains.leadpop_version_id = client_lp.leadpop_version_id AND
                          domains.leadpop_version_seq = client_lp.leadpop_version_seq
                      )
                      " . implode("", $joins) . "
                      WHERE domains.domain_name NOT LIKE '%temporary%' AND client_lp.leadpop_active <> 3 AND client_lp.client_id = " . $this->session->client_id . " AND groups.id IS NOT NULL
                      GROUP BY domain_name
                      UNION
                      SELECT CONCAT(subdomains.subdomain_name,'.',subdomains.top_level_domain) as domain_name, subdomains.subdomain_name, subdomains.top_level_domain, subdomains.id AS domain_id,
                      client_lp.id as client_leadpop_id, client_lp.client_id, client_lp.container, client_lp.date_added, client_lp.date_updated, client_lp.funnel_market, client_lp.funnel_market AS funnel_type, client_lp.funnel_name,
                      client_lp.last_edit, client_lp.last_submission, client_lp.leadpop_active, client_lp.leadpop_folder_id, client_lp.leadpop_version_id, client_lp.leadpop_version_seq, client_lp.question_sequence,client_lp.lynxly_hash,
                      lp.id as leadpop_id, lp.leadpop_vertical_id as leadpop_vertical_id, lp.leadpop_vertical_sub_id as leadpop_vertical_sub_id, lp.leadpop_template_id as leadpop_template_id, lp.leadpop_type_id, lp.leadpop_version_id,
                      " . implode(", ", array_filter($select)) . "
                      FROM clients_subdomains subdomains
                      INNER JOIN leadpops lp ON (
                          subdomains.leadpop_vertical_id = lp.leadpop_vertical_id AND
                          subdomains.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id
                      )
                      INNER JOIN clients_leadpops client_lp ON (
                          client_lp.leadpop_id = lp.id AND
                          subdomains.client_id = client_lp.client_id AND
                          subdomains.leadpop_id = client_lp.leadpop_id AND
                          subdomains.leadpop_version_id = client_lp.leadpop_version_id AND
                          subdomains.leadpop_version_seq = client_lp.leadpop_version_seq
                      )
                      " . implode("", $joins) . "
                      WHERE subdomains.subdomain_name NOT LIKE '%temporary%' AND client_lp.client_id = " . $this->session->client_id . " AND client_lp.`leadpop_active` <> 3 AND groups.id IS NOT NULL
                      GROUP BY domain_name";

            //debug($sql, '', 1);
            if (isset($_COOKIE['dashboard_v2_sql']) and $_COOKIE['dashboard_v2_sql'] == 1) {
                debug($sql, '', 0);
            }
            $leadpops = $this->db->fetchAll($sql);
            if (isset($_COOKIE['dashboard_v2_sql']) and $_COOKIE['dashboard_v2_sql'] == 1) {
                debug($leadpops, 'Total Funnel' . count($leadpops));
            }
            $total_leads = 0;
            $startDate = date('Y-m-d',strtotime($graphDays.' days'));
            $endDate = date('Y-m-d');
            foreach ($leadpops as $k => $leadpop) {
                if ($this->website_funnel == false || $leadpop["funnel_type"] === "w") {
                    $this->website_funnel = true;
                }

                if ($leadpop["funnel_type"] === "w") {
                    $this->website_funnels_list[] = $leadpop;
                }

                if ($leadpop['leadpop_id'] == "") {
                    debug($leadpop, '', 0);
                }
                $this->verticals[$leadpop['leadpop_vertical_id']] = $leadpop['vertical_label'];
                $this->sub_verticals[$leadpop['leadpop_vertical_sub_id']] = $leadpop['fs_display_label'];

                /*
                * TODO: Work on this optimization logic after cutover if required else remove this commented code (Jaz) - Logic here is to store one time data for some table in session and remove those from joins
                */
                # $this->verticals[$leadpop['leadpop_vertical_id']] = $verticals[$leadpop['leadpop_vertical_id']]['vertical_label'];
                # $this->sub_verticals[$leadpop['leadpop_vertical_sub_id']] = $subverticals[$leadpop['leadpop_vertical_sub_id']]['fs_display_label'];

                $group_count = array_key_exists($leadpop['group_id'], $this->groups) ? $this->groups[$leadpop['group_id']]['count'] + 1 : 1;
                $this->groups[$leadpop['group_id']] = [
                    "name" => $leadpop['group_name'],
                    "count" => $group_count
                ];

                $leadpop['hash'] = $this->funnel_hash($leadpop);
                $leadpop['funnel_name'] = html_entity_decode ($leadpop['funnel_name'],ENT_QUOTES);
                $funnelName = trim(preg_replace('/[^a-zA-Z0-9]/', ' ', strtolower($leadpop['funnel_name'])));
                $subdomain = preg_replace('/\s*[\-\ ]\s*/', '-', $funnelName);
                $leadpop['subdomain_name'] = $this->generateSubdDomain($subdomain);
                $leadpop['top_level_domain'] = ($leadpop['top_level_domain']) ? $leadpop['top_level_domain'] : 'itclix.com';
                $leadpop['sticky_cta'] = str_replace('\\', '', $leadpop['sticky_cta']);
                $leadpop['sticky_button'] = str_replace('\\', '', $leadpop['sticky_button']);
                /*
                 * Note: unset the sticky data because we dont use this in funnel_json for dashborad.
                 * this is only use in sticky bar version 2
                 * */
//                $leadpop['sticky_data'] = addslashes($leadpop['sticky_data']);
                $this->client_funnel_sticky_data($leadpop);
                $leadpop['sticky_data'] = '';

                $leadpop['third_party_website_flag'] = json_decode(addslashes($leadpop['third_party_website_flag']));
                $leadpop['v_sticky_button'] = str_replace('###', '\'', $leadpop['v_sticky_button']);
                $leadpop['v_sticky_cta'] = str_replace('###', '\'', $leadpop['v_sticky_cta']);
                $leadpop['stats_redis_key'] = \Stats_Helper::getInstance()->getRedisKey($leadpop);

                if(@$_COOKIE['N1SQL'] == 1) {
                    $leadpop['client_tag_name'] = $this->getClientTagWithFunnel($leadpop);
                    $leadpop['client_tag_id'] = $this->getClientTagIdsWithFunnel($leadpop);
                }

                $funnelStats = \Stats_Helper::getInstance()->getDefaults($leadpop['stats_redis_key']);
                $leadpop['stats'] = implode("-", $funnelStats);
                $leadpop['new_leads'] = $funnelStats['newLeads'];
                $leadpop['visits_sunday'] = $funnelStats['sinceSunday'];
                $leadpop['visits_month'] = $funnelStats['thisMonth'];
                $leadpop['total_leads'] = $funnelStats['totalLeads'];
                $leadpop['total_visits'] = $funnelStats['totalVisitors'];
                $leadpop['conversion_rate'] = $funnelStats['conversionRate'];
                if($leadpop['last_submission'] == '0000-00-00 00:00:00' or $leadpop['last_submission'] == null){
                    $leadpop['last_submission'] = '1970-01-01 01:00:00';
                }

                $endDate = $this->getDateInClientsTimezone();
                $startDate = date('Y-m-d', strtotime($endDate . $graphDays.' days'));
                $funnelStats = \Stats_Helper::getInstance()->getWeeklyLeads($leadpop['stats_redis_key'],$startDate,$endDate);
                $leadpop['funnelGraphStats'] = $funnelStats;
                $this->all_funnels[] = $leadpop;
                $total_leads += $leadpop['total_leads'];

                $this->funnels[$leadpop['leadpop_vertical_id']][$leadpop['group_id']][$leadpop['leadpop_vertical_sub_id']][$leadpop['client_leadpop_id']] = $leadpop;
            }

                $funnel_tags = $this->getAllFunnelTags();
                foreach ($this->all_funnels as $k => $info) {
                    $client_tag_name = $client_tag_id = '';
                    if (array_key_exists($info['client_leadpop_id'], $funnel_tags)) {
                        $client_tag_name = $funnel_tags[$info['client_leadpop_id']]['tags'];
                        $client_tag_id = $funnel_tags[$info['client_leadpop_id']]['tag_ids'];
                    }

                    $this->all_funnels[$k]['client_tag_name'] = $client_tag_name;
                    $this->all_funnels[$k]['client_tag_id'] = $client_tag_id;

                    $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_name'] = $client_tag_name;
                    $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_id'] = $client_tag_id;
                }

            $this->total_leads = $total_leads;
            $this->datasrc = "memory";
            if(@$_COOKIE['debug-data'] == 1){
                debug($this->funnels, "All Funnels");
            }
            $this->setAllFunnel($this->getAllFunnel());
        }
    }

    /*
     * Note: collect data for sticky bar version 2 from table client_funnel_sticky => col sticky_data
     * */
    private function client_funnel_sticky_data($current_funnel_data)
    {

        /*
        * if sticky_data is empty.
        * sticky_data is empty for all new and existing clients.
        * once we submit sticky bar data for version 2 this will be go to else.
        * */
        if (empty($current_funnel_data["sticky_data"])) {
            $funnel_Data = array(
                'client_id' => $current_funnel_data["client_id"],
                'clients_leadpops_id' => (int)$current_funnel_data["client_leadpop_id"],
                'domain_name' => $current_funnel_data["domain_name"],
                'sticky_id' => $current_funnel_data["sticky_id"],
                'sticky_name' => $current_funnel_data["sticky_name"],
                'sticky_cta' => $current_funnel_data["sticky_cta"],
                'sticky_button' => $current_funnel_data["sticky_button"],
                'sticky_url' => $current_funnel_data["sticky_url"],
                'sticky_url_pathname' => $current_funnel_data["sticky_url_pathname"],
                'sticky_funnel_url' => $current_funnel_data["domain_name"],
                'sticky_website_flag' => $current_funnel_data["sticky_website_flag"],
                'sticky_status' => $current_funnel_data["sticky_status"],
                'pending_flag' => $current_funnel_data["pending_flag"],
                'sticky_updated' => $current_funnel_data["sticky_updated"],
                'sticky_location' => $current_funnel_data["sticky_location"],
                'show_cta' => $current_funnel_data["show_cta"],
                'sticky_size' => $current_funnel_data["sticky_size"],
                'zindex' => $current_funnel_data["zindex"],
                'sticky_js_file' => $current_funnel_data["sticky_js_file"],
                'third_party_website_flag' => "0",
                'cta_color' => 'ffffff',
                'url_flag' => "",
                'cta_background_color' => '000000',
                'cta_btn_color' => 'ffffff',
                'cta_btn_background_color' => 'FF9900',
                'cta_btn_vertical_padding' => "20px",
                'cta_btn_horizontal_padding' => "53px",
                'hide_animation' => $current_funnel_data['hide_animation'],
                'when_to_display' => 'Immediately',
                'when_to_hide' => 'Immediately',
                'cta_btn_animation' => 'Wobble',
                'full_page_sticky_bar_flag' => 'off', 'cta_box_shadow' => '10',
                'cta_text_html' => '<p style="font-size: 30px; color: #ffffff;" >I am your sticky bar and i am being awesome!</p>',
                'cta_btn_text_html' => '<p style="font-size: 26px; color: #ffffff;" >Lets do it!</p>',
                'advance_sticky_location' => 'stick-at-top',
                'third_party_website' => [
                ],
                'zindex_type' => $current_funnel_data["zindex_type"],
                'background_image_path' => "",
                'edit_url_hash' => "",
                'third_party_url_edit_flag' => '0',
                'third_party_url_edit' => "",
                'cta_btn_text_font_family' => "",
                'cta_text_font_family' => "",
                'logo_image_path' => "",
                'logo_image_height' => "",
                'logo_image_width' => "",
                'last_selection_of_website' => 'null',
                'another_cta_url' => "",
                'background_image_base_code' => "",
                'logo_image_path_base_code' => "",
                'background_image_color_overlay' => "00aef0",
                'logo_image_replacement' => "left",
                'background_image_opacity' => "0.60",
                'background_image_size' => "100",
                'logo_image_size' => "100",
                'stickybar_number' => $current_funnel_data["stickybar_number"],
                'stickybar_number_flag' => $current_funnel_data["stickybar_number_flag"],
                'stickybar_btn_flag' => "f",
                'stickybar_cta_btn_other_url' => "",
                'sticky_bar_pixel' => "",
                'sticky_bar_v2' => false,
                'logo_spacing' => "32",
                'script_type' => $current_funnel_data["sticky_script_type"],
                'cta_text_html' => $current_funnel_data["sticky_cta"],
                'cta_btn_text_html' => $current_funnel_data["sticky_button"],
                'hash' => $current_funnel_data["hash"]
            );

            /*
             * Note: this is use to updated the json with existing CTA text and CTA btn text according to sticky_size.
             * */

            if ($current_funnel_data["sticky_size"] == "f") {
                $text_exist = false;
                if (empty($current_funnel_data["sticky_cta"])) {
                    $text_exist = true;
                    $text_setting = array('cta_btn_vertical_padding' => '8px',
                        'cta_box_shadow' => '',
                        'cta_btn_horizontal_padding' => '20px',
                        'parent_data' => 'fill'
                    );

                }
                $text_setting = array(
                    'cta_text_html' => "<p style='font-size: 30px; line-height: 30px; color: #ffffff;'>" . $current_funnel_data["sticky_cta"] . "</p>",
                    'cta_btn_text_html' => "<p style='font-size: 26px; line-height: 26px; color: #ffffff;'>" . $current_funnel_data["sticky_button"] . "</p>",
                    'new_client' => $text_exist,
                    'sticky_size' => '138'
                );
            } else if ($current_funnel_data["sticky_size"] == "m") {
                $text_exist = false;
                if (empty($current_funnel_data["sticky_cta"])) {
                    $text_exist = true;
                    $text_setting = array(
                        'cta_btn_vertical_padding' => '6px',
                        'cta_btn_horizontal_padding' => '15px',
                        'cta_box_shadow' => '',
                        'parent_data' => 'fill'
                    );
                }
                $text_setting = array(
                    'cta_text_html' => "<p style='font-size: 23px; line-height: 23px; color: #ffffff;'>" . $current_funnel_data["sticky_cta"] . "</p>",
                    'cta_btn_text_html' => "<p style='font-size: 20px; line-height: 20px; color: #ffffff;'>" . $current_funnel_data["sticky_button"] . "</p>",
                    'new_client' => $text_exist,
                    'sticky_size' => '80'
                );

            } else if ($current_funnel_data["sticky_size"] == "s") {
                $text_exist = false;
                if (empty($current_funnel_data["sticky_cta"])) {
                    $text_exist = true;
                    $text_setting = array(
                        'cta_box_shadow' => '',
                        'cta_btn_vertical_padding' => '4px',
                        'cta_btn_horizontal_padding' => '10px',
                        'parent_data' => 'fill'
                    );
                }
                $text_setting = array(
                    'cta_text_html' => "<p style='font-size: 15px; line-height: 17px; color: #ffffff;'>" . $current_funnel_data["sticky_cta"] . "</p>",
                    'cta_btn_text_html' => "<p style='font-size: 13px; line-height: 13px; color: #ffffff;'>" . $current_funnel_data["sticky_button"] . "</p>",
                    'new_client' => $text_exist,
                    'sticky_size' => '53'
                );
            } else {
                $text_setting = array(
                    'cta_btn_vertical_padding' => "20px",
                    'cta_btn_horizontal_padding' => "53px",
                    'cta_box_shadow' => '10',
                    'parent_data' => 'empty',
                    'cta_text_html' => '<p style="font-size: 30px; color: #ffffff;" >I am your sticky bar and i am being awesome!</p>',
                    'cta_btn_text_html' => '<p style="font-size: 26px; color: #ffffff;" >Lets do it!</p>',
                    'hide_animation' => '0',
                    'new_client' => true
                );
            }
            $funnel_Data = array_merge($funnel_Data, $text_setting);
            $this->all_funnels_sticky_bar_data[] = $funnel_Data;
        } else {
            $thrid_party_website_data = '';
            $sticky_id = $current_funnel_data['sticky_id'];
            $funnel_sticky_data = json_decode($current_funnel_data["sticky_data"], true);
            $funnel_sticky_data['sticky_id'] = $sticky_id;
            $funnel_sticky_data['sticky_funnel_url'] = $current_funnel_data["sticky_funnel_url"];
            $funnel_sticky_data['third_party_website_flag'] = $current_funnel_data["third_party_website_flag"];
            $funnel_sticky_data['sticky_url'] = $current_funnel_data["sticky_url"];
            $funnel_sticky_data['sticky_bar_v2'] = 'true';
            $thrid_party_website_data = $this->getThridPartyWebsiteData($sticky_id);
            $funnel_sticky_data['third_party_website'] = $thrid_party_website_data;
            $this->all_funnels_sticky_bar_data[] = $funnel_sticky_data;
        }
    }

    /*
     * Note: to get data of col sticky_data for client_funnel_sticky table
     * */

    public function getStickyBarData()
    {
        return $this->all_funnels_sticky_bar_data;
    }

    /**
     * This function is the replacement function of getClientTagWithFunnel() + getClientTagIdsWithFunnel() to remove N+1 SQLs
     *
     */
    public function getAllFunnelTags(){
        $sql = "SELECT tag_name as tags, leadpop_tag_id, client_leadpop_id FROM leadpops_client_tags funnel_tags INNER JOIN leadpops_tags tags ON funnel_tags.leadpop_tag_id = tags.id";
        $sql .= " WHERE funnel_tags.client_id = ".$this->session->client_id." GROUP BY funnel_tags.client_leadpop_id, funnel_tags.leadpop_tag_id ORDER BY client_leadpop_id ASC";
        $tags_list = $this->db->fetchAll($sql);
        $funnels_tags = array();

        if($tags_list){
            $tags = array();
            $tag_ids = array();
            $last_leadpop_id = 0;
            foreach($tags_list as $v){
                if($v['client_leadpop_id'] != $last_leadpop_id && $last_leadpop_id > 0){
                    $funnels_tags[$last_leadpop_id]['tags'] = implode(',',$tags);
                    $funnels_tags[$last_leadpop_id]['tag_ids'] = json_encode($tag_ids);
                    $tags = array();
                    $tag_ids = array();
                }
                $tag_ids[] = $v['leadpop_tag_id'];
                $tags[] = filterStrReplace($v['tags'], true);
                $last_leadpop_id = $v['client_leadpop_id'];
            }

            if(!empty($tags)){
                $funnels_tags[$last_leadpop_id]['tags'] = implode(',',$tags);
                $funnels_tags[$last_leadpop_id]['tag_ids'] = json_encode($tag_ids);
            }
        }
        return $funnels_tags;
    }

    /**
     * funnel tag render for dashboard
     * @param $leadpop
     * @return string
     */
    public function getClientTagWithFunnel($leadpop)
    {
        $arr = array();
        //this is for tag and folder
        if (isset($this->session->clientInfo->tag_folder)
            and ($this->session->clientInfo->tag_folder == 1 OR @$_COOKIE['tag'] == 1)) {
            $sql = "select lp_tag.tag_name as tags from
                         leadpops_client_tags lp_ct ,leadpops_tags lp_tag
                        where lp_ct.client_id = " . $leadpop['client_id'] . "
                        AND lp_ct.client_leadpop_id = " . $leadpop['client_leadpop_id'] . "
                        AND lp_tag.id = lp_ct.leadpop_tag_id
                        GROUP BY lp_ct.client_leadpop_id, lp_ct.leadpop_tag_id
                         ";
        } else {
            // this is old tag functionality
            if ($leadpop['funnel_market'] == 'w') {
                $sql = "SELECT lc_tg.client_tag_name as tags
     						FROM leadpops_client_tags lc_tg
     						WHERE lc_tg.client_id =  " . $leadpop['client_id'] . "
     						AND lc_tg.leadpop_id = " . $leadpop['leadpop_id'] . "
     						AND lc_tg.active = '1'
     						GROUP BY lc_tg.leadpop_id,lc_tg.client_tag_name";
            } else {
                $sql = "SELECT lc_tg.client_tag_name as tags
     						FROM leadpops_client_tags lc_tg
     						WHERE lc_tg.client_id =  " . $leadpop['client_id'] . "
     						AND lc_tg.leadpop_id = " . $leadpop['leadpop_id'] . "
     						AND lc_tg.active = '1'
     						AND LOWER(lc_tg.client_tag_name) != 'website'
     						GROUP BY lc_tg.leadpop_id,lc_tg.client_tag_name";
            }

        }
        $leadpops = $this->db->fetchAll($sql);
        if ($leadpops) {
            foreach ($leadpops as $v) {
                $arr[] = filterStrReplace($v['tags'], true);
            }
            $ret = implode(',', $arr );
        } else {
            $ret = '';
        }
        return $ret;
    }


    /**
     * @param $leadpop
     * @return string
     */
    public function getClientTagIdsWithFunnel($leadpop)
    {
        $arr = array();
        //this is for tag ids
            $sql = "select lp_ct.leadpop_tag_id from
                         leadpops_client_tags lp_ct
                        where lp_ct.client_id = " . $leadpop['client_id'] . "
                        AND lp_ct.client_leadpop_id = " . $leadpop['client_leadpop_id'] . "
                        GROUP BY lp_ct.client_leadpop_id, lp_ct.leadpop_tag_id
                         ";
        $leadpops = $this->db->fetchAll($sql);
        if ($leadpops) {
            foreach ($leadpops as $v) {
                $arr[] = $v['leadpop_tag_id'];
            }
            $ret = json_encode($arr);
        } else {
            $ret = '';
        }
        return $ret;
    }


    /**
     * Code to remove sticky banner
     * @var array
     */
    private $removeStickyBannerForClients = [6198];

    public function isDisabledStickyBannerForClient($client_id)
    {
        return in_array($client_id, $this->removeStickyBannerForClients);
    }

    public function getVariationConfig($routeName){
        $variations = config("routes.headerOptions");
        foreach ($variations as $vKey => $variation_route) {
            if(in_array($routeName, $variation_route)) {
                return ["variation"=> $vKey, "options"=> config("routes.top_nav_view")[$vKey]];
            }
        }

        //Default variation
        return ["variation"=>"variation2", "options"=> config("routes.top_nav_view")["variation2"]];
    }

    /**
     * Show active Parent nav link active/inactive
     * @param $menu
     * @param $routeName
     * @return bool
     */
    public function isActiveSidebarParentNav($menu, $routeName){
        $sidebarConfig = config("routes.sidebar_config");
        $menuItems = $sidebarConfig[$menu];

        if(in_array($routeName, $menuItems) || isset($menuItems[$routeName])) {
            return true;
        }

        foreach ($menuItems as $key=>$routes) {
            if(is_array($routes) && in_array($routeName, $routes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Used for page they have inner pages, Show active menu item
     * When any current route is active page OR any of inner pages
     * @param $menu
     * @param $routeName
     * @param $innerPageOption
     * @return bool
     */
    public function isActiveSidebarMenuLink($menu, $routeName, $parentOption){
        $sidebarConfig = config("routes.sidebar_config");
        $menuItems = $sidebarConfig[$menu];


        if(isset($menuItems[$parentOption]) && is_array($menuItems[$parentOption])) {
            return in_array($routeName, $menuItems[$parentOption]) || $routeName == $parentOption;
        }

        return false;
    }

    public function getClientAccountType(){
        $ctype = "";
        switch ($this->session->clientInfo->client_type){
            case 1:
                $ctype = "Insurance";
                break;

            case 3:
                if($this->session->clientInfo->is_mm){
                    $ctype = "Movement";
                }
                elseif($this->session->clientInfo->is_fairway){
                    $ctype = "Fairway";
                }
                elseif($this->session->clientInfo->is_aime){
                    $ctype = "BAB";
                }
                elseif($this->session->clientInfo->is_thrive){
                    $ctype = "Thrive";
                }
                elseif($this->session->clientInfo->is_c2){
                    $ctype = "C2";
                }
                else{
                    $ctype = "Standard";
                }
                break;
            case 5:
                $ctype = "Real Estate";
                break;

            default:
                $ctype = "Standard";
                break;
        }
        return $ctype;
    }

    /**
     * @param bool $include_free_clone Is cloning allowed (y) consider free funnels in allowed case
     * @return string
     */
    public function getClientFunnelType($include_free_clone=true){
        return $this->getCloneFlag($include_free_clone) == 'y' ? 'Marketer Pro' : 'Marketer';
    }

    public function getClientIndustry(){
        if($this->session->clientInfo->client_type == 1) {
            return "Insurance";
        } else if($this->session->clientInfo->client_type == 5) {
            return "Real Estate";
        }
        return "Mortgage";
    }

    /**
     * will return date in clients timezone if value is correct in cookie variable
     * otherwise will return date in system timezone
     * @return false|string
     */
    public function getDateInClientsTimezone(){
        if(isset($_COOKIE['tzo'])) {
            $timeZone = $_COOKIE['tzo'];
            try {
                $date = new DateTime('now', new DateTimeZone($timeZone));
                // return date in client timezone
                return $date->format("Y-m-d");
            } catch (Exception $e) {
                // return date in system timezone
                return date('Y-m-d');
            }
        }
        // return date in system timezone
        return date('Y-m-d');
    }

    /**
     * function will return the clone enable n/y
     * @return string
     */
    function checkFunnelCloneLimit(){
        $cloneNum = getFunnelCloneNumber();
        if($cloneNum < config('lp.funnel_clone_limit')){
            $clone  = 'y';
        }
        else{
            $clone = 'n';
        }
        $this->clone_flag = $clone;
    }

    /**
     * As clients_domains, Clients_subdomains tables merged, So moved domain_name logic here
     * @param $funnel
     */
    public function updateFunnelDomainProperties(&$funnel){
        if($funnel['leadpop_type_id'] == config('leadpops.leadpopSubDomainTypeId')) {
            $funnel['domain_name'] = $funnel['subdomain_name'].".".$funnel['top_level_domain'];
        } elseif ($funnel['leadpop_type_id'] == config('leadpops.leadpopDomainTypeId')) {
            $funnel['subdomain_name'] = null;
            $funnel['top_level_domain'] = null;
        }

        if(is_null($funnel['funnel_name'])){
            $funnel['funnel_name'] = "";
        }
    }

    /**
     * return max version sequence from Clients_subdomains table
     * @param $leadpopId
     * @return mixed
     */
    public function getMaxVersionSequence(){
        return \DB::table("clients_funnels_domains As cs")
            ->where("cs.client_id", $this->session->client_id)->max("cs.leadpop_version_seq");
    }

    /**
     * return record from Clients_subdomains by ID
     * @param $domainId
     * @return mixed
     */
    public function getDomainDataById($domainId){
        return \DB::table("clients_funnels_domains")
            ->select("*")
            ->where("client_id", $this->session->client_id)
            ->where("id", $domainId)
            ->first();
    }

    /**
     * return domain OR subdomain entry by clients_domain_id and type
     * @param $clientsDomainId
     * @param $leadpopTypeId
     * @return mixed
     */
    public function getDomainDataByIdAndType($clientsDomainId, $leadpopTypeId){
        return \DB::table("clients_funnels_domains")
            ->select("*")
            ->where("client_id", $this->session->client_id)
            ->where("clients_domain_id", $clientsDomainId)
            ->where("leadpop_type_id", $leadpopTypeId)
            ->first();
    }

    /**
     * return domain OR sub domain name on the base of leadpop_type_id
     * @param $domainData
     * @return string
     */
    public function getDomainName($domainData) {
        return ($domainData->leadpop_type_id  == config('leadpops.leadpopSubDomainTypeId') ? ($domainData->subdomain_name . "." . $domainData->top_level_domain) : $domainData->domain_name);
    }

    private function _sql_client_funnels($current_funnel=array()){
        if(getenv('APP_ENV') == 'local') {
            $sql = "SELECT c_sd.domain_name, c_sd.clients_domain_id as domain_id
                          ,c_sd.subdomain_name, c_sd.top_level_domain, c_lp.id as client_leadpop_id,
                           c_lp.*, lp.*, lp_v.*, lp_vs.*, lp_vg.*,
                          lynxly_links.id, lynxly_links.slug_name, lynxly_links.target_url,
                          ls.total_visits,
                          ls.total_leads,
                          ls.conversion_rate,
                          ls_week.weekly_visits as 'visits_sunday',
                          ls_month.monthly_visits as 'visits_month',
                          count(lc.id) as new_leads,
                          lp.id as leadpop_id,
                          lp.leadpop_vertical_id as leadpop_vertical_id,
                          lp.leadpop_vertical_sub_id as leadpop_vertical_sub_id,
                          lp.leadpop_template_id as leadpop_template_id,
                          c_lp.funnel_market AS funnel_type,
                          lp_vs.ordering AS subvertorder,
                          lp_vs.fs_display_label,
                          cfs.id as sticky_id,
                          cfs.sticky_name,
                          cfs.sticky_cta,
                          cfs.sticky_button,
                          cfs.sticky_url,
                          cfs.sticky_url_pathname,
                          cfs.sticky_funnel_url,
                          cfs.sticky_js_file,
                          cfs.sticky_website_flag,
                          cfs.sticky_status,
                          cfs.pending_flag,
                          cfs.sticky_updated,
                          cfs.sticky_location,
                          cfs.show_cta,
                          cfs.sticky_size,
                          cfs.zindex,
                          cfs.zindex_type, cfs.hide_animation,
                          cfs.stickybar_number,
                          cfs.stickybar_number_flag,
                          cfs.sticky_data,
                          cfs.third_party_website_flag,
                          cfs.script_type as sticky_script_type
                          FROM leadpops lp
                          INNER JOIN `clients_leadpops` c_lp ON lp.id = c_lp.leadpop_id
                          LEFT JOIN `leadpops_verticals` lp_v ON lp_v.id = lp.`leadpop_vertical_id`
                          LEFT JOIN `leadpops_verticals_sub` lp_vs ON lp_vs.id = lp.`leadpop_vertical_sub_id`
                          LEFT JOIN `leadpops_vertical_groups` lp_vg ON lp_vg.id = lp_vs.group_id
                          INNER JOIN `clients_funnels_domains` c_sd ON (
                            c_sd.leadpop_vertical_id = lp.leadpop_vertical_id AND
                            c_sd.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id AND
                            c_sd.client_id = c_lp.client_id AND
                            c_sd.leadpop_id = c_lp.leadpop_id AND
                            c_sd.leadpop_version_id = c_lp.leadpop_version_id AND
                            c_sd.leadpop_version_seq = c_lp.leadpop_version_seq AND
                            ((c_sd.leadpop_type_id = " . config('leadpops.leadpopSubDomainTypeId') . " AND c_sd.subdomain_name NOT LIKE '%temporary%') OR
                            (c_sd.leadpop_type_id = " . config('leadpops.leadpopDomainTypeId') . " AND c_sd.domain_name NOT LIKE '%temporary%'))
                          )
                          LEFT JOIN (
                                (SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id,
                                 leadpop_version_seq, leadpop_template_id, (SUM(mobile_visits) + SUM(desktop_visits)) AS 'total_visits',
                                 (SUM(mobile_leads) + SUM(desktop_leads)) AS 'total_leads',
                                    ROUND(((SUM(mobile_leads) + SUM(desktop_leads)) / (SUM(mobile_visits) + SUM(desktop_visits))) * 100,2) AS 'conversion_rate'
                                    FROM lead_stats WHERE client_id = " . $this->session->client_id . "
                                    GROUP BY client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,
                                     leadpop_version_id, leadpop_version_seq
                                ) ls) ON (
                                    ls.client_id = c_lp.client_id AND
                                    ls.leadpop_vertical_id = lp.leadpop_vertical_id AND
                                    ls.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id AND
                                    ls.leadpop_version_id = c_lp.leadpop_version_id AND
                                    ls.leadpop_version_seq = c_lp.leadpop_version_seq AND
                                    ls.leadpop_template_id = lp.leadpop_template_id
                            )
                            LEFT JOIN (
                                (SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id,
                                 leadpop_version_seq, leadpop_template_id,
                                (SUM(mobile_visits) + SUM(desktop_visits)) AS 'weekly_visits' FROM lead_stats
                                WHERE WEEK(`date`) = WEEK(NOW()) AND client_id = " . $this->session->client_id . "
                                GROUP BY WEEK(`date`), client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,
                                 leadpop_version_id, leadpop_version_seq) ls_week) ON (
                                    ls_week.client_id = c_lp.client_id AND
                                    ls_week.leadpop_vertical_id = lp.leadpop_vertical_id AND
                                    ls_week.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id AND
                                    ls_week.leadpop_version_id = c_lp.leadpop_version_id AND
                                    ls_week.leadpop_version_seq = c_lp.leadpop_version_seq AND
                                    ls_week.leadpop_template_id = lp.leadpop_template_id
                            )
                            LEFT JOIN (
                                (SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id,
                                leadpop_version_seq, leadpop_template_id,
                                (SUM(mobile_visits) + SUM(desktop_visits)) AS 'monthly_visits' FROM lead_stats
                                WHERE MONTH(`date`) = MONTH(NOW()) AND client_id = " . $this->session->client_id . "
                                GROUP BY MONTH(`date`), client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,
                                 leadpop_version_id, leadpop_version_seq) ls_month) ON (
                                    ls_month.client_id = c_lp.client_id AND
                                    ls_month.leadpop_vertical_id = lp.leadpop_vertical_id AND
                                    ls_month.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id AND
                                    ls_month.leadpop_version_id = c_lp.leadpop_version_id AND
                                    ls_month.leadpop_version_seq = c_lp.leadpop_version_seq AND
                                    ls_month.leadpop_template_id = lp.leadpop_template_id
                            )
                          LEFT JOIN `lead_content` lc ON (
                              lc.client_id = c_lp.client_id AND
                              lc.leadpop_vertical_id = lp.leadpop_vertical_id AND
                              lc.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id AND
                              lc.leadpop_version_id = c_lp.leadpop_version_id AND
                              lc.leadpop_version_seq = c_lp.leadpop_version_seq AND
                              lc.leadpop_template_id = lp.leadpop_template_id AND
                              lc.opened = '0' AND deleted = 0
                          )
                           LEFT JOIN `lynxly_links` ON (
                              lynxly_links.client_id = c_lp.client_id AND
                              lynxly_links.clients_leadpops_id = c_lp.id
                          )

                          LEFT JOIN `client_funnel_sticky` cfs ON (
                            cfs.client_id = c_lp.client_id AND cfs.clients_leadpops_id = c_lp.id
                          )
                          WHERE c_lp.client_id = " . $this->session->client_id . " AND c_lp.`leadpop_active` <> 3 AND lp_vg.id IS NOT NULL ";
            if(!empty($current_funnel)){
                $sql .= " AND c_lp.id = ".$current_funnel['client_leadpop_id'];
                $sql .= " AND c_sd.leadpop_version_id = ".$current_funnel['leadpop_version_id'];
                $sql .= " AND c_sd.leadpop_version_seq = ".$current_funnel['leadpop_version_seq'];
            }
            $sql .= " GROUP BY c_sd.domain_name, CONCAT(c_sd.subdomain_name,'.',c_sd.top_level_domain)";

        }
        else{
            $select = array();
            $joins = array();

            $select["verticals"] = " lead_pop_vertical, vertical_label";
            $joins["verticals"] = " INNER JOIN leadpops_verticals verticals ON (verticals.id = lp.leadpop_vertical_id)";

            $select["subverticals"] = " display_label, group_id, lead_pop_vertical_sub, v_sticky_button, v_sticky_cta, subverticals.ordering AS subvertorder, subverticals.fs_display_label";
            $joins["subverticals"] = " INNER JOIN leadpops_verticals_sub subverticals ON (subverticals.id = lp.leadpop_vertical_sub_id AND subverticals.active = 'y')";

            $select["groups"] = " group_name";
            $joins["groups"] = " INNER JOIN leadpops_vertical_groups groups ON (groups.id = subverticals.group_id)";

            /*
            TODO: Work on this optimization logic after cutover if required else remove this commented code (Jaz) - Logic here is to store one time data for some table in session and remove those from joins
            if(Session::has("verticals")){
                $verticals = session('verticals');
            } else {
                $verticals = $this->db->fetchAll("SELECT id, lead_pop_vertical, vertical_label FROM leadpops_verticals");
                $verticals = array_column($verticals, null, 'id');
                session(['verticals' => $verticals]);
            }

            if(Session::has("subverticals")){
                $subverticals = session('subverticals');
            } else {
                $subverticals = $this->db->fetchAll("SELECT id, display_label, group_id, lead_pop_vertical_sub, v_sticky_button, v_sticky_cta, ordering AS subvertorder, fs_display_label FROM leadpops_verticals_sub");
                $subverticals = array_column($subverticals, null, 'id');
                session(['subverticals' => $subverticals]);
            }

            if(Session::has("groups")){
                $groups = session('groups');
            } else {
                $groups = $this->db->fetchAll("SELECT id, group_name FROM leadpops_vertical_groups");
                $groups = array_column($groups, null, 'id');
                session(['groups' => $groups]);
            }
            */

            $select["sticky"] = " sticky.id as sticky_id, sticky.sticky_name, sticky.sticky_cta, sticky.sticky_button, sticky.sticky_url, sticky.sticky_url_pathname, sticky.sticky_funnel_url, sticky.sticky_js_file, sticky.sticky_website_flag, sticky.sticky_status, sticky.pending_flag, sticky.sticky_updated, sticky.sticky_location, sticky.show_cta, sticky.sticky_size, sticky.zindex, sticky.zindex_type, sticky.hide_animation, sticky.stickybar_number, sticky.stickybar_number_flag, sticky.sticky_data, sticky.third_party_website_flag, sticky.script_type as sticky_script_type";
            $joins["sticky"] = " LEFT JOIN client_funnel_sticky sticky ON (sticky.client_id = client_lp.client_id AND sticky.clients_leadpops_id = client_lp.id)";
            $select["lynxly_links"] = "lynxly_links.id, lynxly_links.slug_name, lynxly_links.target_url";
            $joins["lynxly_links"] = " LEFT JOIN lynxly_links ON (lynxly_links.client_id = client_lp.client_id AND lynxly_links.clients_leadpops_id = client_lp.id )";



            $sql = "SELECT subdomains.domain_name, subdomains.subdomain_name, subdomains.top_level_domain, subdomains.clients_domain_id AS domain_id,
                  client_lp.id as client_leadpop_id, client_lp.client_id, client_lp.container, client_lp.date_added, client_lp.date_updated, client_lp.funnel_market, client_lp.funnel_market AS funnel_type, client_lp.funnel_name,
                  client_lp.last_edit, client_lp.last_submission, client_lp.leadpop_active, client_lp.leadpop_folder_id, client_lp.leadpop_version_id, client_lp.leadpop_version_seq, client_lp.question_sequence,
                  lp.id as leadpop_id, lp.leadpop_vertical_id as leadpop_vertical_id, lp.leadpop_vertical_sub_id as leadpop_vertical_sub_id, lp.leadpop_template_id as leadpop_template_id, lp.leadpop_type_id, lp.leadpop_version_id,
                  " . implode(", ", array_filter($select)) . "
                  FROM clients_funnels_domains subdomains
                  INNER JOIN leadpops lp ON (
                      subdomains.leadpop_vertical_id = lp.leadpop_vertical_id AND
                      subdomains.leadpop_vertical_sub_id = lp.leadpop_vertical_sub_id
                  )
                  INNER JOIN clients_leadpops client_lp ON (
                      client_lp.leadpop_id = lp.id AND
                      subdomains.client_id = client_lp.client_id AND
                      subdomains.leadpop_id = client_lp.leadpop_id AND
                      subdomains.leadpop_version_id = client_lp.leadpop_version_id AND
                      subdomains.leadpop_version_seq = client_lp.leadpop_version_seq
                  )
                  " . implode("", $joins) . "
                  WHERE client_lp.client_id = " . $this->session->client_id . " AND client_lp.`leadpop_active` <> 3 AND groups.id IS NOT NULL
                  AND ( (subdomains.leadpop_type_id = " . config('leadpops.leadpopSubDomainTypeId') . " AND subdomains.subdomain_name NOT LIKE '%temporary%')
                    OR (subdomains.leadpop_type_id = " . config('leadpops.leadpopDomainTypeId') . " AND subdomains.domain_name NOT LIKE '%temporary%')) ";
            if(!empty($current_funnel)){
                $sql .= " AND client_lp.id = ".$current_funnel['client_leadpop_id'];
                $sql .= " AND subdomains.leadpop_version_id = ".$current_funnel['leadpop_version_id'];
                $sql .= " AND subdomains.leadpop_version_seq = ".$current_funnel['leadpop_version_seq'];
            }
            $sql .= " GROUP BY subdomains.domain_name, CONCAT(subdomains.subdomain_name,'.',subdomains.top_level_domain)";
        }
        return $sql;
    }

    /**
     * @deprecated
     * THIS IS FOR LOCAL DEVELOPMENT
     */
    public function get_client_funnels_db($current_funnel=array()){
        $graphDays7DaysGraph =' -8';
        $graphDays30DaysGraph =' -32';
        if (count($this->getAllFunnel()) < 1) {
            $sql = $this->_sql_client_funnels($current_funnel);
            $leadpops = $this->db->fetchAll($sql);
            if (isset($_COOKIE['dashboard_sql']) and $_COOKIE['dashboard_sql'] == 1) {
                echo 'Total Funnel' . count($leadpops);
                debug($sql, '', 0);
                debug($leadpops);
            }
            $total_leads = 0;
            $domain_keys = array();
            $endDate = $this->getDateInClientsTimezone();
            $startDate7DaysGraph = date('Y-m-d', strtotime($endDate . $graphDays7DaysGraph.' days'));
            $startDate30DaysGraph = date('Y-m-d', strtotime($endDate . $graphDays30DaysGraph.' days'));
            $isActiveClientFunnelBuilder = $this->isActiveClientFunnelBuilder();
            foreach ($leadpops as $k => $leadpop) {
                $this->updateFunnelDomainProperties($leadpop);
                $this->updateActiveFunnelBuilderProperties($isActiveClientFunnelBuilder, $leadpop);
                if ($this->website_funnel == false || $leadpop["funnel_type"] === "w") {
                    $this->website_funnel = true;
                }

                if ($leadpop["funnel_type"] === "w") {
                    $this->website_funnels_list[] = $leadpop;
                }

                if ($leadpop['leadpop_id'] == "") {
                    debug($leadpop, '', 0);
                }
                $this->verticals[$leadpop['leadpop_vertical_id']] = $leadpop['vertical_label'];
                $this->sub_verticals[$leadpop['leadpop_vertical_sub_id']] = $leadpop['fs_display_label'];
                $group_count = array_key_exists($leadpop['group_id'], $this->groups) ? $this->groups[$leadpop['group_id']]['count'] + 1 : 1;
                $this->groups[$leadpop['group_id']] = [
                    "name" => $leadpop['group_name'],
                    "count" => $group_count
                ];

                $leadpop['hash'] = $this->funnel_hash($leadpop);
                $subdomain = strtolower(preg_replace('/\s*[\-\ ]\s*/', '-', ($leadpop['funnel_name']) ? $leadpop['funnel_name'] : $leadpop['subdomain_name']));
                $leadpop['subdomain_name'] = $this->generateSubdDomain($subdomain);
                //if funnel type own domain then it will work in clone process
                if ($leadpop['leadpop_type_id'] == 2) {
                    $top_domain = 'secure-clix.com';
                } else {
                    $top_domain = 'itclix.com';
                }
                $leadpop['top_level_domain'] = ($leadpop['top_level_domain']) ? $leadpop['top_level_domain'] : $top_domain;
                $leadpop['sticky_cta'] = str_replace('\\', '', $leadpop['sticky_cta']);
                $leadpop['sticky_button'] = str_replace('\\', '', $leadpop['sticky_button']);
                $this->client_funnel_sticky_data($leadpop);
                $leadpop['sticky_data'] = '';

                $leadpop['third_party_website_flag'] = json_decode(addslashes($leadpop['third_party_website_flag']));
                $leadpop['v_sticky_button'] = str_replace('###', '\'', $leadpop['v_sticky_button']);
                $leadpop['lead_line'] = json_decode($leadpop['lead_line']);
                $leadpop['second_line_more'] = json_decode($leadpop['second_line_more']);
                $leadpop['v_sticky_cta'] = str_replace('###', '\'', $leadpop['v_sticky_cta']);
                $leadpop['total_leads'] = ($leadpop['total_leads']) ? $leadpop['total_leads'] : 0;
                $leadpop['total_visits'] = ($leadpop['total_visits']) ? $leadpop['total_visits'] : 0;
                $leadpop['conversion_rate'] = ($leadpop['conversion_rate']) ? $leadpop['conversion_rate'] : 0;
                $leadpop['funnel_variables'] = json_decode(addslashes($leadpop['funnel_variables']), true);
                if($leadpop['last_submission'] == '0000-00-00 00:00:00' or $leadpop['last_submission'] == null){
                    $leadpop['last_submission'] = '1970-01-01 01:00:00';
                }

                unset($leadpop['funnel_questions']);
                unset($leadpop['funnel_hidden_field']);

                // need conditional_logic in Questions Menu creation, therefore setting a property
                if($leadpop['conditional_logic'] && $leadpop['conditional_logic'] != '' && $leadpop['conditional_logic'] != 'null'){
                    $leadpop['has_conditional_logic'] = true;
                } else {
                    $leadpop['has_conditional_logic'] = false;
                }

                unset($leadpop['conditional_logic']);
                $this->all_funnels[] = $leadpop;
                $total_leads += $leadpop['total_leads'];
                $this->funnels[$leadpop['leadpop_vertical_id']][$leadpop['group_id']][$leadpop['leadpop_vertical_sub_id']][$leadpop['client_leadpop_id']] = $leadpop;
                array_push($domain_keys, $leadpop['domain_id']);
            }

            $funnel_tags = $this->getAllFunnelTags();

            // Logic to get tags
            if(!empty($domain_keys)) {
                $funnelStats7DaysGraph = $this->stats->getWeeklyLeadsByDomains($this->session->client_id, $startDate7DaysGraph, $endDate, $domain_keys);
                $funnelStats30DaysGraph = $this->stats->getWeeklyLeadsByDomains($this->session->client_id, $startDate30DaysGraph, $endDate, $domain_keys);

                foreach ($this->all_funnels as $k => $info) {
                    $client_tag_name = "";
                    $client_tag_id = "";

                    if (array_key_exists($info['client_leadpop_id'], $funnel_tags)) {
                        $client_tag_name = $funnel_tags[$info['client_leadpop_id']]['tags'];
                        $client_tag_id = $funnel_tags[$info['client_leadpop_id']]['tag_ids'];
                    }

                    $this->all_funnels[$k]['client_tag_name'] = $client_tag_name;
                    $this->all_funnels[$k]['client_tag_id'] = $client_tag_id;

                    $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_name'] = $client_tag_name;
                    $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_id'] = $client_tag_id;

                    // Update Graph Statistics 7DaysGraph
                    if (array_key_exists($info['domain_id'], $funnelStats7DaysGraph)) {
                        $this->all_funnels[$k]['funnelStats7DaysGraph'] = $funnelStats7DaysGraph[$info['domain_id']];
                        $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['funnelStats7DaysGraph'] = $funnelStats7DaysGraph[$info['domain_id']];
                    }

                    // Update Graph Statistics 30DaysGraph
                    if (array_key_exists($info['domain_id'], $funnelStats30DaysGraph)) {
                        $this->all_funnels[$k]['funnelStats30DaysGraph'] = $funnelStats30DaysGraph[$info['domain_id']];
                        $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['funnelStats30DaysGraph'] = $funnelStats30DaysGraph[$info['domain_id']];
                    }
                }
            }

            $this->total_leads = $total_leads;
            $this->datasrc = "data";
            $this->setAllFunnel($this->getAllFunnel());
            if(@$_COOKIE['debug-data'] == 1){
                debug($this->funnels, "All Funnels");
            }
            array_push($domain_keys, $leadpop['domain_id']);
        }
    }

    /**
     * This functions gets all data for client with BIG SQL
     */
    public function get_client_funnels($current_funnel=array())
    {
        $graphDays7DaysGraph =' -8';
        $graphDays30DaysGraph =' -32';
        if (count($this->getAllFunnel()) < 1) {
            $sql = $this->_sql_client_funnels($current_funnel);

            //debug($sql, '', 1);
            if (isset($_COOKIE['dashboard_sql']) and $_COOKIE['dashboard_sql'] == 1) {
                debug($sql, '', 0);
            }
            $leadpops = $this->db->fetchAll($sql);
            if (isset($_COOKIE['dashboard_sql']) and $_COOKIE['dashboard_sql'] == 1) {
                debug($leadpops, 'Total Funnel' . count($leadpops));
            }
            $total_leads = 0;
            $isActiveClientFunnelBuilder = $this->isActiveClientFunnelBuilder();
            foreach ($leadpops as $k => $leadpop) {
                $this->updateFunnelDomainProperties($leadpop);
                $this->updateActiveFunnelBuilderProperties($isActiveClientFunnelBuilder, $leadpop);

                if ($this->website_funnel == false || $leadpop["funnel_type"] === "w") {
                    $this->website_funnel = true;
                }

                if ($leadpop["funnel_type"] === "w") {
                    $this->website_funnels_list[] = $leadpop;
                }

                if ($leadpop['leadpop_id'] == "") {
                    debug($leadpop, '', 0);
                }
                $this->verticals[$leadpop['leadpop_vertical_id']] = $leadpop['vertical_label'];
                $this->sub_verticals[$leadpop['leadpop_vertical_sub_id']] = $leadpop['fs_display_label'];

                /*
                * TODO: Work on this optimization logic after cutover if required else remove this commented code (Jaz) - Logic here is to store one time data for some table in session and remove those from joins
                */
                # $this->verticals[$leadpop['leadpop_vertical_id']] = $verticals[$leadpop['leadpop_vertical_id']]['vertical_label'];
                # $this->sub_verticals[$leadpop['leadpop_vertical_sub_id']] = $subverticals[$leadpop['leadpop_vertical_sub_id']]['fs_display_label'];

                $group_count = array_key_exists($leadpop['group_id'], $this->groups) ? $this->groups[$leadpop['group_id']]['count'] + 1 : 1;
                $this->groups[$leadpop['group_id']] = [
                    "name" => $leadpop['group_name'],
                    "count" => $group_count
                ];

                $leadpop['hash'] = $this->funnel_hash($leadpop);
                $subdomain = strtolower(str_replace(' ', '-', ($leadpop['subdomain_name']) ? $leadpop['subdomain_name'] : $leadpop['funnel_name']));
                $leadpop['subdomain_name'] = $this->generateSubdDomain($subdomain);
                $leadpop['top_level_domain'] = ($leadpop['top_level_domain']) ? $leadpop['top_level_domain'] : 'itclix.com';
                $leadpop['sticky_cta'] = str_replace('\\', '', $leadpop['sticky_cta']);
                $leadpop['sticky_button'] = str_replace('\\', '', $leadpop['sticky_button']);
                /*
                 * Note: unset the sticky data because we dont use this in funnel_json for dashborad.
                 * this is only use in sticky bar version 2
                 * */
//                $leadpop['sticky_data'] = addslashes($leadpop['sticky_data']);
                $this->client_funnel_sticky_data($leadpop);
                $leadpop['sticky_data'] = '';

                $leadpop['third_party_website_flag'] = json_decode(addslashes($leadpop['third_party_website_flag']));
                $leadpop['v_sticky_button'] = str_replace('###', '\'', $leadpop['v_sticky_button']);
                $leadpop['v_sticky_cta'] = str_replace('###', '\'', $leadpop['v_sticky_cta']);
                $leadpop['stats_redis_key'] = \Stats_Helper::getInstance()->getRedisKey($leadpop);

                $funnelStats = \Stats_Helper::getInstance()->getDefaults($leadpop['stats_redis_key']);
                $leadpop['stats'] = implode("-", $funnelStats);
                $leadpop['new_leads'] = $funnelStats['newLeads'];
                $leadpop['visits_sunday'] = $funnelStats['sinceSunday'];
                $leadpop['visits_month'] = $funnelStats['thisMonth'];
                $leadpop['total_leads'] = $funnelStats['totalLeads'];
                $leadpop['total_visits'] = $funnelStats['totalVisitors'];
                $leadpop['conversion_rate'] = $funnelStats['conversionRate'];
                if($leadpop['last_submission'] == '0000-00-00 00:00:00' or $leadpop['last_submission'] == null){
                    $leadpop['last_submission'] = '1970-01-01 01:00:00';
                }

                $endDate = $this->getDateInClientsTimezone();
                $startDate7DaysGraph = date('Y-m-d', strtotime($endDate . $graphDays7DaysGraph.' days'));
                $startDate30DaysGraph = date('Y-m-d', strtotime($endDate . $graphDays30DaysGraph.' days'));
                // getStatsAccordingToDays
                $funnelStats7DaysGraph = \Stats_Helper::getInstance()->getWeeklyLeads($leadpop['stats_redis_key'],$startDate7DaysGraph,$endDate);
                $funnelStats30DaysGraph = \Stats_Helper::getInstance()->getWeeklyLeads($leadpop['stats_redis_key'],$startDate30DaysGraph,$endDate);
//                $leadpop['funnelGraphStats'] = $funnelStats;
                $leadpop['funnelStats7DaysGraph'] = $funnelStats7DaysGraph;
                $leadpop['funnelStats30DaysGraph'] = $funnelStats30DaysGraph;
                $this->all_funnels[] = $leadpop;
                $total_leads += $leadpop['total_leads'];

                $this->funnels[$leadpop['leadpop_vertical_id']][$leadpop['group_id']][$leadpop['leadpop_vertical_sub_id']][$leadpop['client_leadpop_id']] = $leadpop;
            }

            // Logic to get all tags without n+1
            $funnel_tags = $this->getAllFunnelTags();
            foreach ($this->all_funnels as $k => $info) {
                $client_tag_name = "";
                $client_tag_id = "";

                if (array_key_exists($info['client_leadpop_id'], $funnel_tags)) {
                    $client_tag_name = $funnel_tags[$info['client_leadpop_id']]['tags'];
                    $client_tag_id = $funnel_tags[$info['client_leadpop_id']]['tag_ids'];
                }

                $this->all_funnels[$k]['client_tag_name'] = $client_tag_name;
                $this->all_funnels[$k]['client_tag_id'] = $client_tag_id;

                $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_name'] = $client_tag_name;
                $this->funnels[$info['leadpop_vertical_id']][$info['group_id']][$info['leadpop_vertical_sub_id']][$info['client_leadpop_id']]['client_tag_id'] = $client_tag_id;
            }

            $this->total_leads = $total_leads;
            $this->datasrc = "memory";
            if(@$_COOKIE['debug-data'] == 1){
                debug($this->funnels, "All Funnels");
            }
            $this->setAllFunnel($this->getAllFunnel());
        }
    }

    /**
     * Function For Development Server Only
     * @param $redisKey`
     */
    function getLeadsFromDB($redisKey){
        $arr = explode("-", $redisKey);
        $sql = "SELECT id, firstname, lastname, email, date_completed, opened, unique_key, phone, lead_questions, lead_answers FROM lead_content where client_id = ".$arr[2]." AND leadpop_id = ".$arr[3]." AND leadpop_version_seq = ".$arr[4];
        $res = $this->db->fetchAll($sql);

        $leads = array();
        if($res) {
            foreach ($res as $k=>$row){
                $address = "";

                $questions = json_decode($row['lead_questions'], 1);
                $answers = json_decode($row['lead_answers'], 1);
                foreach ($questions as $i => $question) {
                    if ($question != "") {
                        if(is_array($question)){
                            $question = $question['label'];
                        }

                        $statecode = "";
                        $city = "";
                        if (stristr($question, 'zip')) {
                            $zipcode_city = $answers[$i];

                            if (!preg_match('/^[0-9]+$/', trim($zipcode_city))) {
                                $ss = "select state,city from zipcodes where city = '" . trim($zipcode_city) . "' limit 1 ";
                            } else {
                                $ss = "select state,city from zipcodes where zipcode = '" . trim($zipcode_city) . "' limit 1 ";
                            }

                            $zrow = $this->db->fetchRow($ss);
                            if ($zrow) {
                                $statecode = $zrow['state'];
                                $city = $zrow['city'];
                                $address = $city . "-" . $statecode . "-" . $zipcode_city;
                            } else {
                                if(strpos($zipcode_city, ",") !== false){
                                    $expr = explode(",", $zipcode_city);
                                    if(isset($expr[2])){
                                        $address = rtrim(trim($expr[1])) . "-" . rtrim(trim($expr[2])) . "-" . rtrim(trim($expr[0]));
                                    }else if(isset($expr[1])){
                                        $address = rtrim(trim($expr[1])) . "-" . rtrim(trim($expr[0]));

                                    }
                                }
                            }
                            break;
                        }
                    }
                }

                $row_str = $row["id"] . "~" . $row["firstname"] . "~";
                $row_str .= $row["lastname"] . "~" . $row["email"] . "~";
                $row_str .= $row["date_completed"] . "~" . $row["opened"] . "~";
                $row_str .= $row["unique_key"] . "~" . $row["phone"] . "~" . $address;
                $leads[] = $row_str;
            }
        }
        return serialize($leads);
    }

    /**
     * To get default swatches
     * @param $client_id
     * @param false $use_default
     * @return mixed
     */
    public function getDefaultSwatches($client_id)
    {
        $client = Clients::select("is_fairway", 'is_mm', "is_thrive")
            ->where('client_id', $client_id)->first();
        // set default logo swatches color
 /*       if ($client->is_fairway == 1) {
            $swatch = '[
                {"swatch":"linear-gradient(to bottom, rgba(27,84,60,1.0) 0%,rgba(27,84,60,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(27,84,60,1.0) 0%,rgba(27,84,60,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(27,84,60,1.0) 0%,rgba(27,84,60,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(27,84,60,1.0) 0%,rgba(27,84,60,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(148,212,11,1.0) 0%,rgba(148,212,11,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(148,212,11,1.0) 0%,rgba(148,212,11,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(148,212,11,1.0) 0%,rgba(148,212,11,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(148,212,11,1.0) 0%,rgba(148,212,11,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(24,84,60,1.0) 0%,rgba(24,84,60,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(24,84,60,1.0) 0%,rgba(24,84,60,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(24,84,60,1.0) 0%,rgba(24,84,60,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(24,84,60,1.0) 0%,rgba(24,84,60,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(56,108,84,1.0) 0%,rgba(56,108,84,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(56,108,84,1.0) 0%,rgba(56,108,84,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(56,108,84,1.0) 0%,rgba(56,108,84,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(56,108,84,1.0) 0%,rgba(56,108,84,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(52,100,84,1.0) 0%,rgba(52,100,84,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(52,100,84,1.0) 0%,rgba(52,100,84,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(52,100,84,1.0) 0%,rgba(52,100,84,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(52,100,84,1.0) 0%,rgba(52,100,84,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(12,76,52,1.0) 0%,rgba(12,76,52,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(12,76,52,1.0) 0%,rgba(12,76,52,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(12,76,52,1.0) 0%,rgba(12,76,52,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(12,76,52,1.0) 0%,rgba(12,76,52,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(148,220,20,1.0) 0%,rgba(148,220,20,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(148,220,20,1.0) 0%,rgba(148,220,20,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(148,220,20,1.0) 0%,rgba(148,220,20,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(148,220,20,1.0) 0%,rgba(148,220,20,1.0) 100%)"}
                ]';
            return json_decode($swatch, true);
        } else if ($client->is_mm == 1) {
            $swatch = '[
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(168,0,13,1.0) 0%,rgba(168,0,13,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(168,0,13,1.0) 0%,rgba(168,0,13,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(204,35,51,1.0) 0%,rgba(204,35,51,.7) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(204,35,51,1.0) 0%,rgba(204,35,51,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(204,35,51,1.0) 0%,rgba(204,35,51,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(44,44,44,1.0) 0%,rgba(44,44,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(44,44,44,1.0) 0%,rgba(44,44,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(44,44,44,1.0) 0%,rgba(44,44,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(36,44,36,1.0) 0%,rgba(36,44,36,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(36,44,36,1.0) 0%,rgba(36,44,36,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(36,44,36,1.0) 0%,rgba(36,44,36,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(36,36,36,1.0) 0%,rgba(36,36,36,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(36,36,36,1.0) 0%,rgba(36,36,36,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(208,36,44,1.0) 0%,rgba(208,36,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(208,36,44,1.0) 0%,rgba(208,36,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(208,36,44,1.0) 0%,rgba(208,36,44,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(208,36,44,1.0) 0%,rgba(208,36,44,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"},
                {"swatch":"linear-gradient(to top, rgba(36,44,48,1.0) 0%,rgba(36,44,48,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom right, rgba(36,44,48,1.0) 0%,rgba(36,44,48,.7) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(168,0,13,1.0) 0%,rgba(168,0,13,1.0) 100%)"}
                ]';
            return json_decode($swatch, true);
        } else if ($client->is_thrive == 1) {
            $swatch = '[
                {"swatch":" linear-gradient(to bottom, rgba(196,12,4,1.0) 0%,rgba(196,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(197,12,4,1.0) 0%,rgba(197,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(198,12,4,1.0) 0%,rgba(198,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(198,12,4,1.0) 0%,rgba(198,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(199,12,4,1.0) 0%,rgba(199,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(200,12,4,1.0) 0%,rgba(200,12,4,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(178,10,3,1.0) 0%,rgba(178,10,3,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(156,7,2,1.0) 0%,rgba(156,7,2,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(133,5,2,1.0) 0%,rgba(133,5,2,1.0) 100%)"},
                {"swatch":" linear-gradient(to bottom, rgba(111,2,1,1.0) 0%,rgba(111,2,1,1.0) 100%)"},
                {"swatch":"linear-gradient(to bottom, rgba(255, 255, 255, 0.99) 0%, rgba(255, 255, 255, 0.99) 100%)"}
                ]';
            return json_decode($swatch, true);
        }
   */
        $s = "select * from default_swatches where active = 'y' order by id ";
        return $this->db->fetchAll($s);
    }

    /**
     * check funnel builder is enabled for client OR not
     */
    private function isActiveClientFunnelBuilder(){
//        $funnelBuilderEnabled = config('routes.funnel_builder.enable') ;
//        if($funnelBuilderEnabled) {
//            return $funnelBuilderEnabled;
//        }
//
//        if(isset($this->session->client_id)) {
//            $funnelBuilderClients = config('routes.funnel_builder.fb_enabled_clients') ;
//            $clients = explode(',' , $funnelBuilderClients);
//            return (is_array($clients) && in_array($this->session->client_id, $clients));
//        }
        return true;
    }

    /**
     * To check funnel builder is enabled on funnel OR not
     * @param $isActiveClientFunnelBuilder
     * @param $funnelData
     * @return bool
     */
    private function updateActiveFunnelBuilderProperties($isActiveClientFunnelBuilder, &$funnel){
        if($isActiveClientFunnelBuilder) {
            //if(!array_key_exists('conditional_logic', $funnel) || $funnel['conditional_logic'] == '' || $funnel['conditional_logic'] == 'null' || $funnel['conditional_logic'] == "{}"){
                if($this->hasClientIntegrations($funnel)) {
                    $funnel['is_active_funnel_builder'] = false;
                    $funnel['_fb_inactive'] = "has-integrations";
                } else {
                    $funnel['is_active_funnel_builder'] = true;
                }
            //} else {
            //    $funnel['is_active_funnel_builder'] = false;
            //    $funnel['_fb_inactive'] = "has-conditional-logic";
            //}
        } else {
            $funnel['is_active_funnel_builder'] = false;
            $funnel['_fb_inactive'] = "not-active-for-client";
        }
    }

    /**
     * Funnel builder to active/inactive questions menu
     * @param $funnel
     */
    public function hasClientIntegrations($funnel){
        return \DB::table("client_integrations")
            ->select("name", \DB::raw("count(*) as count"))
            ->where("client_id", $funnel["client_id"])
            ->where("leadpop_id", $funnel["leadpop_id"])
            ->where("leadpop_vertical_id", $funnel["leadpop_vertical_id"])
            ->where("leadpop_vertical_sub_id", $funnel["leadpop_vertical_sub_id"])
            ->where("leadpop_template_id", $funnel["leadpop_template_id"])
            ->where("leadpop_version_id", $funnel["leadpop_version_id"])
            ->where("leadpop_version_seq", $funnel["leadpop_version_seq"])
            ->where("active", "y")
            ->count();
    }

    /**
     * Transform json for bundle=>vehicle question to make it compatible with funnel builder
     *
     * @param $funnelQuestion
     * @param $key
     * @param $question_type
     * @return mixed
     */
    function transformBundleQuestion($funnelQuestion, $key, $question_type)
    {
        $fileJson = env("constants.LP_BASE_DIR") . "/public" . config('view.theme_assets') . "/js/funnel/json/" . $question_type . ".json";
        $json = file_get_contents($fileJson);
        $json = json_decode($json, true);
        $defaultJson = $json['options'];
        $out = array();
        $user_attr = $funnelQuestion[$key]['options'];

        foreach ($defaultJson as $name => $default) {
            if (is_array($default) && isset($user_attr[$name])) {
                foreach ($default as $i => $val) {
                    if (is_array($user_attr[$name])) {
                        $value = $user_attr[$name][$i];
                    } else {
                        if ($name == 'data-field') {
                            if ($i == 0) {
                                $value = $user_attr[$name];
                            } else {
                                $value = $defaultJson[$name][$i];
                            }
                        } else {
                            $value = $user_attr[$name];
                        }
                    }
                    $out[$name][$i] = $value;
                }
            } else {
                if (array_key_exists($name, $user_attr)) {
                    $out[$name] = isset($user_attr[$name]) ? $user_attr[$name] : $defaultJson[$name];
                } else {
                    if ($name === 'question-title' && array_key_exists('question', $user_attr)) {
                        $default = $user_attr['question'];
                    }
                    $out[$name] = $default;
                }
            }
        }

        $funnelQuestion[$key]['options'] = $out;
        $funnelQuestion[$key]['question-type'] = $question_type;

        return $funnelQuestion;
    }


/*
 * Combine user attributes with known attributes and fill in defaults when needed.
 */
    function combine_array_atts( $default_attr, $user_attr){
        $out = array();
        foreach ($default_attr as $name => $default) {
            if(is_array($default)){
                if($name === "fields" || $name === "field-order" && isset($user_attr[$name]) || ($name === "range" && count($user_attr[$name]))) {
                    $out[$name] = $user_attr[$name];
                } else {
                   if(empty($default)){
                       $out[$name] = $user_attr[$name];
                   }
                   else{
                       $out[$name] = $this->combine_array_atts($default, array_key_exists($name, $user_attr) ? $user_attr[$name] : [] );
                   }
                }
            }
            else{
                if (array_key_exists($name, $user_attr)) {
                    if($name === 'question' && isset($user_attr['question'])){
                        if($user_attr['question'] != '' && preg_match("/<[^<]+>/",htmlspecialchars_decode($user_attr['question']),$m) == 0){
                            $user_attr['question'] = '&lt;p&gt;'.$user_attr['question'].'&lt;&#x2F;p&gt;';
                        }
                    }
                    $out[$name] = isset($user_attr[$name])?$user_attr[$name]:$default_attr[$name];
                } else {
                    if($name === 'unique-variable-name' && array_key_exists('data-field', $user_attr)){
                        $default = $user_attr['data-field'];
                    }elseif($name === 'question-title' && isset($user_attr['question'])){
                        $default = strip_tags(htmlspecialchars_decode($user_attr['question']));
                    }
                    $out[$name] = $default;
                }
            }
        }
        return $out;
    }


    /**
     * @param $funnelQuestion
     * @param $leadpop_version_id
     * compare and combine DB questions and JSON file questions
     */
    function combine_json_attributes($funnelQuestion, $leadpop_version_id=0)
    {
        if ($funnelQuestion) {
            $lockIconActive = LP_Helper::getInstance()->getFunnelOptions('lock_icon_active');
            foreach ($funnelQuestion as $key => $funnelJson) {

                if (isset($funnelJson['question-type'])) {
                    // pre-made funnel bundle question transform json for funnel builder compatibility
                    if ($leadpop_version_id != config('funnelbuilder.funnel_builder_version_id') && $funnelJson['question-type'] == 'bundle') {
                        // vehicle question conversion
                        if ($funnelQuestion[$key]['options']['data-source'] == 'make-model') {
                            $funnelQuestion = LP_Helper::getInstance()->transformBundleQuestion($funnelQuestion, $key, 'vehicle');
                        }
                    } else {
                        if ($funnelJson['question-type'] == 'textarea') {
                            $funnelJson['question-type'] = 'text';
                        } elseif ($funnelJson['question-type'] == 'date') {
                            $funnelJson['question-type'] = 'birthday';
                        }
                        $fileJson = env("constants.LP_BASE_DIR") . "/public" . config('view.theme_assets') . "/js/funnel/json/" . $funnelJson['question-type'] . ".json";
                        if (file_exists($fileJson)) {
                            $json = file_get_contents($fileJson);
                            $defaultJson = json_decode($json, true);
                            if ($funnelJson['question-type'] == "contact") {

                                if (!array_key_exists('steps', $funnelJson['options']['all-step-types'][0])) {
                                    // for step 1 conversion of old contact.json fields have 'attributes' array instead of keys 'fullname' as per new contact.json
                                    if ($funnelQuestion[$key]['options']['all-step-types'][0]['fields'][0]['attributes']) {
                                        for ($i = 0; $i <= 5; $i++) {
                                            $tempArray = $funnelQuestion[$key]['options']['all-step-types'][0]['fields'][$i];
                                            unset($funnelQuestion[$key]['options']['all-step-types'][0]['fields'][$i]);
                                            $funnelQuestion[$key]['options']['all-step-types'][0]['steps'][0]['fields'][$i][$tempArray['question-type']] = $tempArray['attributes'];
                                        }
                                    }

                                    //backward compatibility
                                    foreach ($funnelQuestion[$key]['options']['all-step-types'] as $arr=>$steps_value) {
                                        foreach ($steps_value['steps'] as $step_index => $steps)
                                        {
                                            foreach ($steps as $field_index =>$fields)
                                            {
                                                if($field_index=='fields')
                                                {
                                                    foreach ($fields as $inner_index => $veriable) {

                                                        foreach ($veriable as $arr_name => $array)
                                                        {
                                                            if($arr_name == 'phone' && !array_key_exists('country-code',$array))
                                                            {
                                                                $funnelQuestion[$key]['options']['all-step-types'][$arr]['steps'][$step_index][$field_index][$inner_index][$arr_name]['country-code'] = 0;
                                                                $funnelQuestion[$key]['options']['all-step-types'][$arr]['steps'][$step_index][$field_index][$inner_index][$arr_name]['auto-format'] = 1;
                                                            }
                                                            if (!isset($var['unique-variable-name']))
                                                            {
                                                                $slide_step_now = $step_index+1;
                                                                $funnelQuestion[$key]['options']['all-step-types'][$arr]['steps'][$step_index][$field_index][$inner_index][$arr_name]['unique-variable-name'] = $arr_name."_contact_".$key;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $steps_options = $funnelQuestion[$key]['options']['all-step-types'][$arr]['steps'];
                                        $field_order = $defaultJson['options']['all-step-types'][$arr]['steps']['0']['field-order'];
                                        foreach ($field_order as $order)
                                        {
                                            foreach ($steps_options as $steps_array=>$each_array)
                                            {
                                                foreach ($each_array['fields'][$order] as $vl=>$value)
                                                {
                                                    if($steps_array==$order)
                                                    {
                                                        $funnelQuestion[$key]['options']['all-step-types'][$arr]['steps'][$steps_array]['fields'][$order][$vl]['value']=1;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $funnelQuestion[$key]['options']['all-step-types'][0] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][0], $funnelQuestion[$key]['options']['all-step-types'][0]);
                                    $funnelQuestion[$key]['options']['all-step-types'][1] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][1], $funnelQuestion[$key]['options']['all-step-types'][1]);
                                    $funnelQuestion[$key]['options']['all-step-types'][2] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][2], $funnelQuestion[$key]['options']['all-step-types'][2]);

                                    // we need this because in database record has conflict
                                    if ($funnelQuestion[$key]['options']['activesteptype'] == 3 )
                                    {
                                        $funnelQuestion[$key]['options']['all-step-types'][1]['steps'][1]['field-order'] = [4, 5];
                                    }
//                                    $funnelQuestion[$key]['options']['all-step-types'][0] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][0], $funnelJson['options']['all-step-types'][0]);
//                                    $funnelQuestion[$key]['options']['all-step-types'][1] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][1], $funnelJson['options']['all-step-types'][1]);
//                                    $funnelQuestion[$key]['options']['all-step-types'][2] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options']['all-step-types'][2], $funnelJson['options']['all-step-types'][2]);
                                } else {
                                    // new structure
                                    $funnelQuestion[$key]['options'] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options'], $funnelJson['options']);
                                }
                                // pre-made funnel enable security message for contact question
                                if ($leadpop_version_id != config('funnelbuilder.funnel_builder_version_id') && $lockIconActive == 1) {
                                    $funnelQuestion[$key]['options']['all-step-types'][0]['steps'][0]['enable-security-message'] = 1;
                                    $funnelQuestion[$key]['options']['all-step-types'][1]['steps'][0]['enable-security-message'] = 1;
                                    $funnelQuestion[$key]['options']['all-step-types'][1]['steps'][1]['enable-security-message'] = 1;
                                    $funnelQuestion[$key]['options']['all-step-types'][2]['steps'][0]['enable-security-message'] = 1;
                                    $funnelQuestion[$key]['options']['all-step-types'][2]['steps'][1]['enable-security-message'] = 1;
                                    $funnelQuestion[$key]['options']['all-step-types'][2]['steps'][2]['enable-security-message'] = 1;
                                }
                            } else {
                                if($leadpop_version_id != config('funnelbuilder.funnel_builder_version_id') && $funnelJson['question-type'] == 'slider') {
                                    $this->setCurrentSliderCustomLabels($funnelJson['options']);
                                }
                                $funnelQuestion[$key]['options'] = LP_Helper::getInstance()->combine_array_atts($defaultJson['options'], $funnelJson['options']);
                                // pre-made funnel update json logic
                                if ($leadpop_version_id != config('funnelbuilder.funnel_builder_version_id')) {
                                    $funnelQuestion = LP_Helper::getInstance()->premadeFunnelUpdateJson($funnelJson, $funnelQuestion, $key, $lockIconActive);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $funnelQuestion;
    }

    /**
     * set label for current slider
     * @param $defaultJson
     * @param $slider
     */
    function setCurrentSliderCustomLabels(&$slider){
        if($slider["slider-numeric"]["value"]){
            if($slider["slider-numeric"]["one-puck"]["value"]) {
                $this->setCustomNumericSliderLabels($slider["slider-numeric"]["one-puck"]);
            } else if($slider["slider-numeric"]["two-puck"]["value"]) {
                $this->setCustomNumericSliderLabels($slider["slider-numeric"]["two-puck"]);
            }
        } else if($slider["slider-non-numeric"]["value"]) {
            $this->setCustomNonNumericSliderLabels($slider["slider-non-numeric"]);
        }
    }

    /**
     * Non numeric custom slider labels fix for existing funnels
     * @param $slider
     */
    function setCustomNonNumericSliderLabels(&$slider){
        if($slider["customize-slider-labels"]["value"] && !isset($slider["customize-slider-labels"]["left_label"])) {
            $slider["customize-slider-labels"]["left_label"] = $slider["customize-slider-labels"]["left"] ?? "";
            $slider["customize-slider-labels"]["right_label"] = $slider["customize-slider-labels"]["right"] ?? "";

            if (isset($slider["range-pre-post-options"]) && $slider["range-pre-post-options"]["value"]) {
                $slider["customize-slider-labels"]["left"] = empty($slider["range-pre-post-options"]["starting-value"]) ? $slider["range"][0] : $slider["range-pre-post-options"]["starting-value"];
                $slider["customize-slider-labels"]["right"] = empty($slider["range-pre-post-options"]["ending-value"]) ? $slider["range"][count($slider["range"]) - 1] : $slider["range-pre-post-options"]["ending-value"];
            } else {
                $slider["customize-slider-labels"]["left"] = $slider["range"][0];
                $slider["customize-slider-labels"]["right"] = $slider["range"][count($slider["range"]) - 1];
            }
            array_splice($slider["range"], 0, 1);
            array_splice($slider["range"], count($slider["range"]) - 1, 1);
        }
    }

    /**
     * set label for existing records
     * @param $defaultJson
     * @param $slider
     */
    function setCustomNumericSliderLabels(&$slider){
        if($slider["customize-slider-labels"]["value"] && !isset($slider["customize-slider-labels"]["left_label"])) {
            if (isset($slider["range"][0]["start"])) {
                #Start::FA-571 replace any
                if(strtolower($slider["customize-slider-labels"]["left"]) == "any") {
                    $slider["customize-slider-labels"]["left"] = "";
                    $slider["customize-slider-labels"]["left_label"] = "";
                } else {
                    $slider["customize-slider-labels"]["left_label"] = $this->convert_number((empty($slider["customize-slider-labels"]["left"]) ? $slider["range"][0]["start"] : $slider["customize-slider-labels"]["left"]), $slider["unit"]);
                }
                #End::FA-571 replace any
                $slider["customize-slider-labels"]["right_label"] = $this->convert_number((empty($slider["customize-slider-labels"]["right"]) ? $slider["range"][count($slider["range"]) - 1]["end"] : $slider["customize-slider-labels"]["right"]), $slider["unit"]);
                if(isset($slider["range-pre-post-options"]) && $slider["range-pre-post-options"]["value"]) {
                    $slider["customize-slider-labels"]["left"] = empty($slider["range-pre-post-options"]["starting-value"]) ? $slider["customize-slider-labels"]["left"] : $slider["range-pre-post-options"]["starting-value"];
                    $slider["customize-slider-labels"]["right"] = empty($slider["range-pre-post-options"]["ending-value"]) ? $slider["customize-slider-labels"]["right"] : $slider["range-pre-post-options"]["ending-value"];
                }
            }
        }
    }


    public function convert_number($number, $unit='') {
        $number_str = $number;

        // If we set Both these variables TRUE it will be same output for label which we had in v1
        // Ideally both variable should FALSE
        $allow_roundup = false;
        $postpend_plus = false;

        // Got any other string then extract number out that string e.g. 50,000 Ore More OR 250,000
        $number = preg_replace('/[^\d]+/', '', $number);

        // reserve words - if any of these words are passed then we return as it is.
        if(in_array(strtolower($number_str), ["any"])){
            return $number_str;
        }

        // if $number is already set as customize-slider-labels like $5M+ then we need to return as it is.
        else if(
            (substr($number_str, 0, 1) == $unit && $number < 10)
            || (substr($number_str, 0, 1) == "<")
            || (substr($number_str, 0, 1) == ">")
        ){
            return $number_str;
        }

        if (!is_numeric($number)) {
            return $unit."0";
        }

        if ($number < 1000) {
            return $unit.$number;
        }

        $matrics = intval(log($number, 1000));
        $matricsArr = ['', 'K', 'M', 'B', 'T', 'Q'];

        if (array_key_exists($matrics, $matricsArr)) {
            $number = $number / pow(1000, $matrics);

            if($allow_roundup){
                $number = number_format($number, 0);
            }

            $number .= $matricsArr[$matrics];
            if(!$allow_roundup || $postpend_plus){
                if(strpos(strtolower($number_str), "or more") !== false || strpos(strtolower($number_str), "more than") !== false || strpos(strtolower($number_str), "over") !== false){
                    $number .= "+";
                }
            }
        }

        return $unit.$number;
    }

    /**
     * Pre-made funnel update json for backward compatibility
     *
     * @param $funnelJson
     * @param $funnelQuestion
     * @param $key
     * @param $lockIconActive
     * @return mixed
     */
    function premadeFunnelUpdateJson($funnelJson, $funnelQuestion, $key, $lockIconActive)
    {
        // city or zip code question related checks
        if ($funnelJson['question-type'] == "zipcode") {
            // set zip code button text to GO! if it is equal to 'Go!'
            if ($funnelQuestion[$key]['options']['button-text'] === 'Go!') {
                $funnelQuestion[$key]['options']['button-text'] = 'GO!';
                $funnelQuestion[$key]['options']['cta-button-settings']['font-size'] = 47;
            }

            // set default question text if it is equal to 'Zip Code'
            if (strip_tags(htmlspecialchars_decode($funnelQuestion[$key]['options']['question'])) == 'Zip Code') {
                $funnelQuestion[$key]['options']['question'] = '&lt;p&gt;Where are you located?&lt;&#x2F;p&gt;';
                $funnelQuestion[$key]['options']['question-title'] = 'Where are you located?';
            }

            // enable security message
            if ($lockIconActive == 1) {
                $funnelQuestion[$key]['options']['enable-security-message'] = 1;
            }

            // enable city zip code question
            if (isset($funnelJson['options']['zip-city']) && $funnelJson['options']['zip-city'] == 1) {
                $funnelQuestion[$key]['options']['zip-code-only'] = 0;
                $funnelQuestion[$key]['options']['city-or-zip-code'] = 1;
                unset($funnelQuestion[$key]['options']['zip-city']);
            }
        } elseif ($funnelJson['question-type'] == "dropdown") {
            if (trim($funnelJson['options']['rel']) != "<span class='off-text'>Question N/A</span>" && trim($funnelQuestion[$key]['options']['field-label']) == "select an option") {
                $funnelQuestion[$key]['options']['field-label'] = $funnelJson['options']['rel'];
            }
        }

        return $funnelQuestion;
    }


    /**
     * Get funnel options for current client
     *
     * @param $get
     * @return mixed
     */
    function getFunnelOptions($get)
    {
        $s = "select eho_active, lock_icon_active from client_funnel_options where client_id = " . $this->session->client_id;
        $client_options = $this->db->fetchRow($s);
        if(sizeof($client_options) == 0)
        {
            $client_options['eho_active'] = 'n';
            $client_options['lock_icon_active'] = '';
        }
        return $client_options[$get];
    }

    /**
     * @return mixed
     */
    function getStatesData(){
        $s = "select zipcode,StateFullName from zipcodes
        where StateFullName !='' group by StateFullName";
        return $this->db->fetchAll($s);
    }

    /**
     * @return mixed
     * get All models
     */
    public function getVehicleModels(){
        $s = "SELECT model FROM models order by model asc";
        return $this->db->fetchAll($s);
    }

    /**
     * @return mixed
     * get All Makes
     */
    public function getVehicleMakes(){
        $s = "SELECT make FROM makes order by make asc";
        return $this->db->fetchAll($s);

    }
}
