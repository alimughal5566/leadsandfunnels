<?php

use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Support\Str;

if (!function_exists('textCleaner')) {
    function textCleaner($str){
        $str = str_replace("â€™", "'", $str);
        return $str;
    }
}

if (!function_exists('objectToArray')) {
    function objectToArray(&$object){
        return @json_decode(json_encode($object), true);
    }
}

if (!function_exists('getToken')) {
    function getToken($length){
        $token = "";
        $string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string .= "abcdefghijklmnopqrstuvwxyz";
        $string .= "0123456789";
        $max = strlen($string); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[random_int(0, $max - 1)];
        }

        return $token;
    }
}

if (!function_exists('is_valid_email')) {
	function is_valid_email( $email ) {
		return ( ! preg_match( "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email ) ) ? false : true;
	}
}

/**
 * Encrypts the plain text to encrypted string
 * @param $plain_string
 * @param string $key
 * @return string
 */
if (!function_exists('lp_encrypt')) {

	function lp_encrypt( $plain_string = '' ) {
		if ( $plain_string == "" ) {
			return $plain_string;
		}

		$encrypt_method = "AES-256-CBC";
		$key            = hash( 'sha256', config('leadpops.myleads.secret_key') );
		$iv             = substr( hash( 'sha256', config('leadpops.myleads.secret_iv') ), 0, 16 );

		$encrypted = openssl_encrypt( $plain_string, $encrypt_method, $key, 0, $iv );

		return $encrypted;
	}
}


/**
 * Encrypts the plain text to encrypted string remove spaces
 * @param $plain_string
 * @param string $key
 * @return string
 */
if (!function_exists('lp_space_encrypt')) {

    function lp_space_encrypt( $plain_string = '' ) {
        if ( $plain_string == "" ) {
            return $plain_string;
        }
        $string = urlencode($plain_string);
        $string = str_replace("+", "%2B",$string);
        $string = urldecode($string);
        $encrypt_method = "AES-256-CBC";
        $key            = hash( 'sha256', config('leadpops.myleads.secret_key') );
        $iv             = substr( hash( 'sha256', config('leadpops.myleads.secret_iv') ), 0, 16 );

        $encrypted = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );

        return $encrypted;
    }
}
/**
 * decrypts the string back to plain text
 * @param $encrypted_string
 * @param string $key
 * @return bool|string
 */
if (!function_exists('lp_decrypt')) {
	function lp_decrypt( $encrypted ) {
		if ( $encrypted == "" ) {
			return $encrypted;
		}

		$encrypt_method = "AES-256-CBC";
		$key            = hash( 'sha256', config('leadpops.myleads.secret_key') );
		$iv             = substr( hash( 'sha256', config('leadpops.myleads.secret_iv') ), 0, 16 );

		$plain_string = openssl_decrypt( $encrypted, $encrypt_method, $key, 0, $iv );

		return $plain_string;
	}
}
/**
 * Encrypts the my leads password
 * @param $plain_string
 * @param string $key
 * @return string
 */
if (!function_exists('myleads_encrypt')) {

    function myleads_encrypt($string)
    {
        $key = "petebird";
        $string = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $string;
    }
}
/**
 * decrypts the my leads password
 * @param $encrypted_string
 * @param string $key
 * @return bool|string
 */
if (!function_exists('myleads_decrypt')) {

    function myleads_decrypt($string)
    {
        $key = "petebird";
        $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $string;
    }
}

if(!function_exists('format_number')){
    function format_number($number, $precision=0){
        $num = number_format($number, $precision);
        return $num;
    }
}

/**
 * Uploads Files to Rackspace directly from input stream
 *
 * @param string $file file path in string format from file upload input
 * @param string $local_path local path - Split it from clients and convert local path into a string to map directories on CDN   e.g /var/www/leadpops/admin_2.1_laravel/public/images/clients/3/3111/logos/3111_160_1_3_74_80_80_10_dot_img.png
 * @param string $container optional - if not provided then it detects container auto from clientInfo in registry
 * @return array
 * @throws Exception
 */
if(!function_exists('move_uploaded_file_to_rackspace')) {
    function move_uploaded_file_to_rackspace($file, $local_path, $container = '')
    {
        $registry = \App\Services\DataRegistry::getInstance();
        $rackspace_client_baseurl = rackspace_client_baseurl();
        $dirs = explode("clients/", $local_path);
        if (count($dirs) > 1) {
            $tmp_file_name = str_replace("/", "~", end($dirs));      # E.g :: 3/3111/logos/3111_160_1_3_74_80_80_10_dot_img.png => 3~3111~logos~3111_160_1_3_74_80_80_10_dot_img.png
        } else {
            $tmp_file_name = str_replace("/", "~", $dirs[0]);
        }

        $rackspace_path = str_replace("~", "/", $tmp_file_name);    # E.g :: 3~3111~logos~3111_160_1_3_74_80_80_10_dot_img.png => 3/3111/logos/3111_160_1_3_74_80_80_10_dot_img.png

        if ($container == "") {
            //Get container for a specific funnel
            $container = $registry->leadpops->clientInfo['rackspace_container'];
        }

        // FOR Local Development
        if (env('APP_ENV') == config('app.env_local')) {
//        if (false) {
            if(!file_exists(str_replace(basename($rackspace_path), "", $container . "/" . $rackspace_path))) mkdir(str_replace(basename($rackspace_path), "", $container . "/" . $rackspace_path), 0777, true);

            move_uploaded_file($file, $container . "/" . $rackspace_path);
            return array("rs_cdn" => $container . "/" . $rackspace_path, "client_cdn" => env("APP_URL"). "/" .$container. "/" .$rackspace_path, 'image_url'=>env("APP_URL"). "/" .$container. "/" .$rackspace_path);
        }

        /** @var $rackspace \App\Services\RackspaceUploader */
        $rackspace = \App::make('App\Services\RackspaceUploader');
        if ($container) {
            $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '" . $container . "'");
            $containerInfo = objectToArray($res[0]);
            $parsedUrl = parse_url($containerInfo['image_path']);
            if (substr($parsedUrl['path'], 1) != "") {
                $rackspace_path = substr($parsedUrl['path'], 1) . $rackspace_path;
            }

            $imageCompresser = \App\Helpers\ImageCompression_Helper::getInstance();
            $compressedFilePath = $imageCompresser->compress($file, $tmp_file_name);
            $data = fopen($compressedFilePath, 'r');
            $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
            @unlink($compressedFilePath);

            $needle = $registry->leadpops->clientInfo['client_id'] . "/";
            $dir_path = substr($cdn['path'], strpos($cdn['path'], $needle) + strlen($needle));
            if(substr($dir_path, -1) !== "/") $dir_path = "/".$dir_path;

            return array("rs_cdn" => $cdn['rs_cdn'], "client_cdn" => $rackspace_client_baseurl . $dir_path, 'image_url'=>$cdn['image_url']);
        } else {
            throw new \Exception("Unable to determine Rackpsace Container to perform upload process.", 500);
        }

    }
}

/**
 * Uploads Files from tmp directory to rackspace
 *
 * @param string $file file path to move on rackspace from public directory
 * @param string $container optional - if not provided then it detects container auto from clientInfo in registry
 * @return array
 * @throws Exception
 */
if(!function_exists('move_file_to_rackspace')) {
    function move_file_to_rackspace($file, $container = ''){
        $registry = \App\Services\DataRegistry::getInstance();
        $rackspace_client_baseurl = rackspace_client_baseurl();
        //Get container for a specific funnel
        if ($container == "") {
            $container = $registry->leadpops->clientInfo['rackspace_container'];
        }
        /** @var $rackspace \App\Services\RackspaceUploader */
        $rackspace = \App::make('App\Services\RackspaceUploader');
        if ($container) {
            $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '" . $container . "'");
            $containerInfo = objectToArray($res[0]);
            $parsedUrl = parse_url($containerInfo['image_path']);
            if (substr($parsedUrl['path'], 1) != "") {
                $rackspace_path = substr($parsedUrl['path'], 1);
            }

            $rackspace_path = $rackspace_path . str_replace("rs_tmp/","", str_replace("~","/", $file));

            // FOR Local Development
            if (env('APP_ENV') == config('app.env_local')) {
//            if (false) {
                $rackspace_path = str_replace("images1/", "", $rackspace_path);
                if(!file_exists(str_replace(basename($rackspace_path), "", $container . "/" . $rackspace_path))) mkdir(str_replace(basename($rackspace_path), "", $container . "/" . $rackspace_path), 0777, true);

                if(strpos($file, "rs_tmp") !== false){
                    $file = LP_BASE_DIR . "public/".$file;
                }
                copy($file, $container . "/" . $rackspace_path);
                return array("rs_cdn" => $container . "/" . $rackspace_path, "client_cdn" => env("APP_URL"). "/" .$container. "/" .$rackspace_path, 'image_url'=>env("APP_URL"). "/" .$container. "/" .$rackspace_path);
            }

            $data = fopen($file, 'r');
            $cdn = $rackspace->uploadTo($container, $data, $rackspace_path);
            if(is_resource($data)) {
                fclose($data);
            }
            unlink($file);

            $needle = $registry->leadpops->clientInfo['client_id'] . "/";
            $dir_path = substr($cdn['path'], strpos($cdn['path'], $needle) + strlen($needle));
            if(substr($dir_path, -1) !== "/") $dir_path = "/".$dir_path;

            return array("rs_cdn" => $cdn['rs_cdn'], "client_cdn" => $rackspace_client_baseurl . $dir_path);
        }
        else {
            throw new \Exception("Unable to determine Rackpsace Container to perform upload process.", 500);
        }

    }
}

function rackspace_copy_file_as($file, $new_name, $container=''){
    /** @var $rackspace \App\Services\RackspaceUploader */
    $rackspace = \App::make('App\Services\RackspaceUploader');
    if($container == ""){
        $registry = \App\Services\DataRegistry::getInstance();
        $container = $registry->leadpops->clientInfo['rackspace_container'];
    }

//    if(false) {
    if(getenv('APP_ENV') == "local") {
        if(strpos($file, env("APP_URL")) !== false){
            $fileArr = explode($container, $file);
            $file = substr($fileArr[1], 1);
        }

        if(strpos($file, $container) === false) $src_file = $container . "/" . $file;
        else $src_file = $file;

        copy($src_file, $container . "/" . $new_name);
        return array("rs_cdn" => $container . "/" . $new_name, "client_cdn" => env("APP_URL"). "/" .$container. "/" .$new_name, 'image_url'=>env("APP_URL"). "/" .$container. "/" .$new_name);
    } else {
        return $rackspace->copyFile($file, $new_name, $container);
    }
}

function rackspace_copy_file_as_with_gearman($file, $new_name, $container='', $client_id='', $tracking_keys=''){
    if($container == ""){
        $registry = \App\Services\DataRegistry::getInstance();
        $container = $registry->leadpops->clientInfo['rackspace_container'];
    }

//    if(false) {
    if(getenv('APP_ENV') == "local") {
        if(strpos($file, env("APP_URL")) !== false){
            $fileArr = explode($container, $file);
            $file = substr($fileArr[1], 1);
        }

        if(strpos($file, $container) === false) $src_file = $container . "/" . $file;
        else $src_file = $file;

        copy($src_file, $container . "/" . $new_name);
        return array("rs_cdn" => $container . "/" . $new_name, "client_cdn" => env("APP_URL"). "/" .$container. "/" .$new_name, 'image_url'=>env("APP_URL"). "/" .$container. "/" .$new_name);
    }
    else {
        $job = array( 'container' => $container, 'sourceFilePath' => $file, 'newFilePath' => $new_name, 'clientId' => $client_id, 'trackingKeys' => $tracking_keys);
        MyLeadsEvents::getInstance()->executeRackspaceToRackspaceCopyCdnClient($job);
        return array("rs_cdn" => $new_name, "client_cdn" => $new_name, 'image_url'=>$new_name);
    }
}

function rackspace_file_exists($file, $container=''){
    /** @var $rackspace \App\Services\RackspaceUploader */
    $rackspace = \App::make('App\Services\RackspaceUploader');

    if($container == ""){
        $registry = \App\Services\DataRegistry::getInstance();
        $container = $registry->leadpops->clientInfo['rackspace_container'];
    }

    return $rackspace->exist($file, $container);
}

function rackspace_client_baseurl(){
    $registry = \App\Services\DataRegistry::getInstance();
    $rackspace_client_baseurl = $registry->leadpops->clientInfo['rackspace_image_base'];
    return $rackspace_client_baseurl;
}

function rackspace_stock_assets(){
    $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
    $res = \DB::select($s);
    $defaultCdn = objectToArray($res[0]);

    return $defaultCdn['image_path'];
}

function rackspace_container_info($containerType, $infoRequired){
    $s = "SELECT * FROM current_container_image_path WHERE cdn_type = '".$containerType."'";
    $res = \DB::select($s);
    $defaultCdn = objectToArray($res[0]);

    return $defaultCdn[$infoRequired];
}

if(!function_exists('getCdnLink')) {
    function getCdnLink(){
        $registry = \App\Services\DataRegistry::getInstance();
        if (env('APP_ENV') == config('app.env_local')) {
            $client_id = $registry->leadpops->clientInfo['client_id'];
            $section = substr($client_id, 0, 1);
            $container = $registry->leadpops->clientInfo['rackspace_container'];
            $client_base_url = env("APP_URL"). "/" .$container. "/".$section . '/' . $client_id;
        }
        else {
            $client_base_url = $registry->leadpops->clientInfo['rackspace_image_base'];
            if (substr("testers", -1) === "/") $client_base_url = substr($client_base_url, 0, -1);
        }
        return $client_base_url;
    }
}

if(!function_exists('dir_to_str')) {
    function dir_to_str($file_with_dir, $tmp_dir_path=false, $reverseOrder=false){
        $file_with_dir = trim($file_with_dir);
        if($reverseOrder){
            $rsp = str_replace("~", "/", $file_with_dir);
        } else {
            $rsp = str_replace("/", "~", $file_with_dir);
        }

        if($tmp_dir_path){
            $path = public_path().'/'.env('RACKSPACE_TMP_DIR', '');
            \File::isDirectory($path) or \File::makeDirectory($path, 0777, true, true);

            $rsp = env('RACKSPACE_TMP_DIR', '') ."/". $rsp;
        }

        return $rsp;
    }
}


/* Saif */
/* For update last updated time */

function update_clients_leadpops_last_eidt($leadpop_id = ""){
    $db = App::make('App\Services\DbService');
    if($leadpop_id == ""){
        $funnel_data = LP_Helper::getInstance()->getFunnelData();
        $id = $funnel_data['client_leadpop_id'];
    }else{
        $id = $leadpop_id;
    }
    $data = array(
        'last_edit' => date("Y-m-d H:i:s")
    );
    $where = ' id = '.$id." ";
    $db->update('clients_leadpops',$data,$where);
    //::update('',$data, $where);
}
function UR_exists($url){
    if($url) {
        $headers = @get_headers($url);
        return stripos($headers[0], "200 OK") ? true : false;
    }
}
//created by MZAC90
//client base folder list
function folder_list(){
    $registry = \App\Services\DataRegistry::getInstance();
    $rec = array();
    $query = "SELECT *,(
            select
                count(*)
            from
                leadpops_client_folders
            where
                `order` = 0 and client_id = '".$registry->leadpops->clientInfo['client_id']."') as unsort_len
        FROM
            leadpops_client_folders lcf
        WHERE
            lcf.client_id  = '".$registry->leadpops->clientInfo['client_id']."'
            ORDER BY lcf.`order`
            ";
    $res = \DB::select($query);
    if($res) {
        if ($res[0]->unsort_len >= 2) {
            $rec = dashboardFolderListSort($res);
        } else {
            $rec = $res;
        }
    }
    return $rec;
}
//client base tag list
function tag_list(){
    $registry = \App\Services\DataRegistry::getInstance();
    $res = \DB::select("SELECT *
        FROM
            leadpops_tags
        WHERE
            client_id  = '".$registry->leadpops->clientInfo['client_id']."'
            ORDER BY tag_name
            ");
    return $res;
}

//get funnel base tag list by client_id and client_leadpop_id
function funnel_tag_list($client_leadpop_id){
    $registry = \App\Services\DataRegistry::getInstance();
    $res = \DB::select("SELECT *
        FROM
            leadpops_client_tags
        WHERE
            client_id  = '".$registry->leadpops->clientInfo['client_id']."'
             AND client_leadpop_id =".$client_leadpop_id);
    return $res;
}
//check default tag name in array
function strpos_arr($haystack) {
    $needle = array('Purchase', 'Refinance', 'Hybrid');
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false)
            return $what;
    }
    return false;
}
//get all tag list
function Gettag($t){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $query = "SELECT
            *
        FROM
            leadpops_tags
        WHERE
            tag_name = '".$t."'
            AND client_id  = '".$registry->leadpops->clientInfo['client_id']."'";
    $res = $db->fetchRow($query);
    return $res;
}
//get all folder list
function Getfolder($folder_name){
    $registry = \App\Services\DataRegistry::getInstance();
    $sql = \DB::select("SELECT
            *
        FROM
            leadpops_client_folders
        WHERE
            folder_name = '".$folder_name."'
            AND client_id  = '".$registry->leadpops->clientInfo['client_id']."'");
    return $sql;
}

//get tag mapping list against client_id , client_leadpop_id and tag_id
function Checktagmaping($client_leadpop_id,$leadpop_id,$tag_name){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $query = "SELECT
            *
        FROM
            leadpops_client_tags
        WHERE
            id = '".$client_leadpop_id."'
            AND leadpop_id = '".$leadpop_id."'
            AND  client_tag_name  = '".$tag_name."'
            AND client_id  = '".$registry->leadpops->clientInfo['client_id']."'";
    $sql = $db->fetchRow($query);
    //Pause Logic to verify SQL
    return $sql;
}

/**
 * To get funnel selected tags
 * @param $client_id
 * @param $client_leadpop_id
 * @return mixed
 */
function getFunnelSelectedTags($client_id, $client_leadpop_id){
    $db = App::make('App\Services\DbService');
    $query = "SELECT id, leadpop_tag_id
        FROM
            leadpops_client_tags
        WHERE
            client_leadpop_id = " .$client_leadpop_id. " AND client_id  = " . $client_id;
    return $db->fetchAll($query);
}

//add vertical name for folder in leadpops_client_folders table if exist otherwise get the folder id against vertical name
function assign_folder_to_funnel($folder_name){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $s = Getfolder($folder_name);
    if(empty($s)) {
        if(strtolower($folder_name) == 'website funnels'){
            $website = 1;
        }else{
            $website = 0;
        }
        $folder = array(
            'client_id' => $registry->leadpops->clientInfo['client_id'],
            'folder_name' => $folder_name,
            'is_default' => 1,
            'is_website' => $website
        );
        $id = $db->insert('leadpops_client_folders', $folder);
        return $id;
    }else{
        $rec = objectToArray($s[0]);
        return $rec['id'];
    }
}
//add sub vertical name or group name for tag in leadpops_tags table f exist otherwise get the tag id against sub vertical name or group name
function assign_tag_to_funnel($client_leadpop_id,$leadpop_id,$tag_name){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $rs = Gettag($tag_name);
    if(empty($rs)) {
        $tag = array(
            'client_id' => $registry->leadpops->clientInfo['client_id'],
            'tag_name' => $tag_name,
            'is_default' => 1
        );
        $tag_id = $db->insert('leadpops_tags', $tag);
    }else{
        $tag_id = $rs['id'];
    }
    $chk_tag = Checktagmaping($client_leadpop_id,$leadpop_id,$tag_name);
    if(empty($chk_tag)) {
        $data = array(
            'client_id' => $registry->leadpops->clientInfo['client_id'],
            'client_leadpop_id' => $client_leadpop_id,
            'leadpop_id' => $leadpop_id,
            'leadpop_tag_id' => $tag_id,
            'client_tag_name' => $tag_name,
            'active' => 1
        );
        $db->insert('leadpops_client_tags', $data);
    }else{
            $data = array(
                'client_id' => $registry->leadpops->clientInfo['client_id'],
                'client_leadpop_id' => $client_leadpop_id,
                'leadpop_id' =>$leadpop_id,
                'leadpop_tag_id' =>$tag_id,
                'client_tag_name' => $tag_name,
                'active' => 1
            );
            $db->update('leadpops_client_tags', $data,'id='.$chk_tag['id']);
    }
}


function getPartition($client_id, $table, $format='table'){
    ///dev
    if(getenv('APP_ENV') == "local") {
        return $table;
    }

    $partitionsPrefix = ['lead_stats'=>'c', 'leadpop_background_swatches'=>'s', 'clients_leadpops'=>'clp', 'lead_content'=>'lcp'];
    $num = intdiv($client_id, 1000) + 1;

    if($format == 'table'){
        return $table." Partition (".$partitionsPrefix[$table].$num.")";
    }
    else if($format == 'name'){
        return $partitionsPrefix[$table].$num;
    }
    else {  // blank
        return $table;
    }
}

/**
 *if does not have any record of folder so, folder name will not show in dashboard folder list
 * @param $folder_id
 */
function dashboardEmptyFolderSkip($folder_id){
    $ids = array();
    $arr =  LP_Helper::getInstance()->getAllFunnel();
    if($arr) {
        foreach ($arr as $val) {
            if ((int)$folder_id and $folder_id == $val['leadpop_folder_id']) {
                $ids[] = $val['leadpop_folder_id'];
            }
            else if ($folder_id === $val['funnel_market']) {
                $ids[] = $val['leadpop_folder_id'];
            }
            else{
                $ids = $ids;
            }
        }
    }
  return $ids;

}

/**
 * if dashboard folder list is not sort then we are doing sort manually
 * @param array $res
 */
function dashboardFolderListSort(array $res){
    $new_list = array();
    $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
    $funnel = array_search($funnelTypes['f'],array_column($res, 'folder_name'));
    if($res) {
        if (isset($res[$funnel]) and !empty($res[$funnel])) {
            $new_list[] = $res[$funnel];
            unset($res[$funnel]);
        }
        usort($res, 'multiDimensionalSorting');
         foreach($res as $k => $v){
             $new_list[] = $v;
         }
    }
    return $new_list;
}

/**
 * using for multidimensional sorting
 * @param $a
 * @param $b
 * @return int|lt
 */
function multiDimensionalSorting($a,$b){
    return strcmp($a->folder_name,$b->folder_name);
}

/**
 * check client funnel name is exist OR not
 * @param $funnel_name
 * @return mixed
 */
function checkFunnelName($currentLeadpopId, $funnel_name){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');

    $query = "SELECT
            *
        FROM
            clients_leadpops
        WHERE
            LOWER(funnel_name) = '".strtolower($funnel_name)."'
            AND client_id  = '".$registry->leadpops->clientInfo['client_id']."' AND id  != " . $currentLeadpopId;

    $res = $db->fetchRow($query);
    if($res) {
        return $res;
    }else{
        return '';
    }
}

/**
 * get tag and folder video link for dashboard
 * @param $view
 */
 function getTagFolderVideo($view)
{
    $header_html = "";
    $header_html .= "<div class=\"watch-video\">";
    if (isset($view->data->wistia_id) && !empty($view->data->wistia_id)) {
        if (isset($view->data->videotitle) && !empty($view->data->videotitle)) {
            $wistitle = $view->data->videotitle;
        }else{
            $wistitle = 'Name & Tags';
        }
        $wisid = $view->data->wistia_id;
        $header_html .= "<a data-lp-wistia-title=\"$wistitle\" data-lp-wistia-key=\"$wisid\" class=\"btn-video lp-wistia-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
    } elseif ((isset($view->data->videolink) && $view->data->videolink)) {
        $header_html .= "<a class=\"btn-video\" href=\"#\" data-toggle=\"modal\" data-target=\"#lp-video-modal\"><i class=\"lp-icon-strip camera-icon\"></i> &nbsp;<span class=\"action-title\">Watch how to video</span></a>";
    }
    $header_html .='</div>';
    return $header_html;
}

/**
 * function use for dashboard filter special character replace
 * @param $str
 */
function filterStrReplace($str,$revse = false)
{
    $find = array('mzac_lp_and', 'mzac_lp_comma', 'mzac_lp_less', 'mzac_lp_greater');
    $replace = array('&', ',', '<', '>');
    if ($revse) {
        return str_replace($replace,$find,$str);
    }else{
        return str_replace($find,$replace,$str);
    }
}
/**
 * drop down list array selected value
 * @param $v
 * @param array $arr
 * @return string
 */
 function getSelectedArr($v,array $arr){
     if($arr){
         foreach($arr as $val){
             if($v === htmlentities(filterStrReplace($val),ENT_QUOTES)){
                 return 'selected';
             }
         }
     }
}

/**
 * drop down list single selected value
 * @param drop down $value
 * @param $selected $value
 * @return string
 */
function getSelected($dropdown, $select){

    return ($dropdown == $select)?'selected':'';
}

/**
 *update funnel lead
 * @param $hash_data
 * @param $delete_ids
 */
function updateLeadContentInKeyDB($hash_data, $delete_ids){
     $arr = [
        'client_id'=>$hash_data['funnel']['client_id'],
        'client_leadpop_id'=>$hash_data['funnel']['client_leadpop_id'],
        'domain_id'=>$hash_data['funnel']['domain_id'],
        'leadpop_id'=>$hash_data['funnel']['leadpop_id'],
        'leadpop_version_seq'=>$hash_data['funnel']['leadpop_version_seq']
     ];
     $ids = explode("~",$delete_ids);
     if($ids){
         foreach($ids as $lead_content_id){
             $new_leads =  getUnReadLead($hash_data);
             $total_leads =  getTotalLeads($hash_data);
             MyLeads_Helper::getInstance()->updateDashboardLead($arr, $new_leads);
             if($total_leads <= 10){
                 MyLeads_Helper::getInstance()->rewriteLeadContent($arr, getLeads($hash_data));
             } else {
                 MyLeads_Helper::getInstance()->updateDeleteLeadContent($arr, $lead_content_id);
             }
         }
     }
}

/**
 * get the un read leads from lead_content
 * @param $hash_data
 * @return bool
 */
function getUnReadLead($hash_data){
    $db = App::make('App\Services\DbService');
    $sql = "SELECT COUNT(id) as new_leads FROM `lead_content` lc WHERE
				lc.client_id = ".$hash_data['funnel']['client_id']."
				AND lc.leadpop_version_id = ".$hash_data['funnel']['leadpop_version_id']."
				AND lc.leadpop_version_seq = ".$hash_data['funnel']['leadpop_version_seq']."
				AND lc.opened = 0
				AND lc.deleted = 0";
    $res = $db->fetchRow($sql);
    if($res) {
        return $res['new_leads'];
    }else{
        return 0;
    }
}

/**
 * get the total Leads (excluding deleted leads)
 * @param $hash_data
 * @return bool
 */
function getTotalLeads($hash_data){
    $db = App::make('App\Services\DbService');
    $sql = "SELECT COUNT(id) as total_leads FROM `lead_content` lc WHERE
				lc.client_id = ".$hash_data['funnel']['client_id']."
				AND lc.leadpop_version_id = ".$hash_data['funnel']['leadpop_version_id']."
				AND lc.leadpop_version_seq = ".$hash_data['funnel']['leadpop_version_seq']."
				AND lc.deleted = 0";
    $res = $db->fetchRow($sql);
    if($res) {
        return $res['total_leads'];
    }else{
        return 0;
    }
}

/**
 * get the total Leads (excluding deleted leads)
 * @param $hash_data
 * @return bool
 */
function getLeads($hash_data){
    $db = App::make('App\Services\DbService');
    $sql = "SELECT id, firstname, lastname, email, date_completed, opened, unique_key, phone, lead_questions, lead_answers FROM `lead_content` WHERE
				client_id = ".$hash_data['funnel']['client_id']."
				AND leadpop_version_id = ".$hash_data['funnel']['leadpop_version_id']."
				AND leadpop_version_seq = ".$hash_data['funnel']['leadpop_version_seq']."
				AND deleted = 0 ORDER BY date_completed ASC";
    $res = $db->fetchAll($sql);
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

                        $zrow = $db->fetchRow($ss);
                        if ($zrow) {
                            $statecode = $zrow['state'];
                            $city = $zrow['city'];
                            $address = $city . "-" . $statecode . "-" . $zipcode_city;
                        } else {
                            if(strpos($zipcode_city, ",") !== false){
                                $expr = explode(",", $zipcode_city);
                                $address = rtrim(trim($expr[1])) . "-" . rtrim(trim($expr[2])) . "-" . rtrim(trim($expr[0]));
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
    return $leads;
}

/**
 * update new lead counter on dashboard after read the lead in myleads page
 * @param $hash_data
 */
   function updateFunnelNewLeadDashboard($hash_data){
        $arr = array('client_id'=>$hash_data['funnel']['client_id'],
            'client_leadpop_id'=>$hash_data['funnel']['client_leadpop_id'],
            'domain_id'=>$hash_data['funnel']['domain_id']);
             $leadcount =  getUnReadLead($hash_data);
             MyLeads_Helper::getInstance()->updateDashboardLead($arr,$leadcount);
    }

if (!function_exists('colorizeBasedOnAplhaChannnel')) {
    function colorizeBasedOnAplhaChannnel($file, $targetR, $targetG, $targetB, $targetName)
    {

        if (file_exists($targetName)) {
            unlink($targetName);
        }

        $im_src = imagecreatefrompng($file);
        $width = imagesx($im_src);
        $height = imagesy($im_src);

        $im_dst = imagecreatefrompng($file);

        imagealphablending($im_dst, false);
        imagesavealpha($im_dst, true);
        imagealphablending($im_src, false);
        imagesavealpha($im_src, true);
        imagefilledrectangle($im_dst, 0, 0, $width, $height, '0xFFFFFF');

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
        imagepng($im_dst, $targetName);
        imagedestroy($im_dst);
    }

    if (!function_exists('fromRGB')) {
        function fromRGB($R, $G, $B)
        {

            $R = dechex($R);
            If (strlen($R) < 2)
                $R = '0' . $R;

            $G = dechex($G);
            If (strlen($G) < 2)
                $G = '0' . $G;

            $B = dechex($B);
            If (strlen($B) < 2)
                $B = '0' . $B;

            return '#' . $R . $G . $B;


        }
    }
    if (!function_exists('getClientDefaultsTableByClientObject')) {
        function getClientDefaultsTableByClientObject($client)
        {
            if ($client->is_fairway == 1)
                $trial_launch_defaults = "trial_launch_defaults_fairway";
            else if ($client->is_mm == 1)
                $trial_launch_defaults = "trial_launch_defaults_mm";
            else
                $trial_launch_defaults = "trial_launch_defaults";

            return $trial_launch_defaults;
        }
    }

    //set plan price on confirmation box when we are clicking on clone button
    if(!function_exists('setPlanPrice')){
        function setPlanPrice(){
            $registry = \App\Services\DataRegistry::getInstance();

            if($registry->leadpops->clientInfo['is_mm'] == 1){
                $planPirce = config('lp.pro_package_price.movement_pro');
            }
            else if($registry->leadpops->clientInfo['is_fairway'] == 1
                and $registry->leadpops->clientInfo['is_lite'] == 1){
                $planPirce = config('lp.pro_package_price.fairway_lite_pro');
            }
            else if($registry->leadpops->clientInfo['is_fairway'] == 1){
                $planPirce = config('lp.pro_package_price.fairway_pro');
            }
            else if($registry->leadpops->clientInfo['is_aime'] == 1){
                $planPirce = config('lp.pro_package_price.aime_pro');
            }
            else if($registry->leadpops->clientInfo['is_thrive'] == 1){
                $planPirce = config('lp.pro_package_price.thrive_pro');
            }
            else if($registry->leadpops->clientInfo['is_c2'] == 1){
                $planPirce = config('lp.pro_package_price.c2_pro');
            }
            else{
                $planPirce = config('lp.pro_package_price.mortgage_pro');
            }
            return '$'.$planPirce;
        }
    }
}

/**
 * this function use for inner sub menu active module Breadcrum admin3.0
 * @menu
 */
if(!function_exists('activeModule')) {
    function activeModule($menu)
    {
        switch($menu){
            case \App\Constants\LP_Constants::FOOTER:
            case \App\Constants\LP_Constants::CALL_TO_ACTION:
            case \App\Constants\LP_Constants::CONTACT_INFO:
            case \App\Constants\LP_Constants::THANK_YOU:
            case \App\Constants\LP_Constants::AUTO_RESPONDER:
            case \App\Constants\LP_Constants::ADVANCE_FOOTER:
                return 'content:';
                break;
            case \App\Constants\LP_Constants::LOGO:
            case \App\Constants\LP_Constants::BACKGROUND:
            case \App\Constants\LP_Constants::FEATURED_MEDIA:
                return 'design:';
                break;
            case \App\Constants\LP_Constants::ALERTS:
            case \App\Constants\LP_Constants::PIXEL:
            case \App\Constants\LP_Constants::INTEGRATION:
            case \App\Constants\LP_Constants::ADA_ACCESSIBILITY:
            case \App\Constants\LP_Constants::AUTO_RESPONDER:
                return 'settings:';
                break;
            case \App\Constants\LP_Constants::TAG:
            case \App\Constants\LP_Constants::DOMAIN:
            case \App\Constants\LP_Constants::SEO:
                return 'basic info:';
                break;
            case \App\Constants\LP_Constants::SHARE_FUNNEL:
                return 'promote:';
                break;
            default:
                return 'funnels:';
                break;
        }

    }
}

/**
 * get chargebee customer by email @mzac90
 * @param $email
 * @return mixed
 */
//if(!function_exists('getChargebeeCustomer')) {
//    function getChargebeeCustomer($email)
//    {
//        $endpointUrl = getenv('LP_API_ENDPOINT_BASE_URL');
//        $authKey = getenv('LP_API_ENDPOINT_AUTH_KEY');
//        $endpoint = $endpointUrl?$endpointUrl:config('lp.chargebee.lp_api_endpoint_base_url');
//        $auth_key = $authKey?$authKey:config('lp.chargebee.lp_api_endpoint_auth_key');
//        $handle = curl_init();
//        $url = $endpoint . '/api/chargebee/customer/get-customers';
//        $postField = json_encode(array('email[is]' => $email));
//        $headers = array(
//            'Authorization:' . $auth_key,
//            "Content-Type:application/json",
//            'Content-Length:' . strlen($postField)
//        );
//        curl_setopt_array($handle,
//            array(
//                CURLOPT_URL => $url,
//                CURLOPT_POST => true,
//                CURLINFO_HEADER_OUT => true,
//                CURLOPT_POSTFIELDS => $postField,
//                CURLOPT_HTTPHEADER => $headers,
//                CURLOPT_RETURNTRANSFER => true
//            )
//        );
//
//        $data = curl_exec($handle);
//        curl_close($handle);
//        return json_decode($data, true);
//    }
//}


function customTagSave($v){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $rs = Gettag($v);
    if(empty($rs)) {
        $tag = array(
            'client_id' =>  $registry->leadpops->clientInfo['client_id'],
            'tag_name' => $v,
            'is_default' => 0
        );
        $tag_id = $db->insert('leadpops_tags', $tag);
    }
    else{
        $tag_id = $rs['id'];
    }
    return $tag_id;
}


/**
 * Converts cents to dollars string with maximum of two decimals (if needed)
 * and adds comma to it
 *
 * @param number|string $cents a string or number representing cents
 * @return string converted dollar string
 */
function convertCentsToDollarsString($cents) : string {
    return preg_replace('/\.[0]*$/', '', number_format($cents / 100, 2, '.', ','));
}

/**
 * we can use this function for get the current funnel key
 * return @including key mention the below
 * leadpop_vertical_id
 * leadpop_vertical_sub_id
 * leadpop_id
 * leadpop_version_seq
 * @param $funnel
 * @return string
 */
function getCurrentFunnelKey($funnel){
    return $funnel["leadpop_vertical_id"] . "~" . $funnel["leadpop_vertical_sub_id"] . "~" . $funnel["leadpop_id"] . "~" . $funnel["leadpop_version_seq"];
}

/**
 * Query format where clause
 * update set key/values
 * @param array $data
 * @param string $implode
 * @return string
 */
function queryFormat(array $data,string $implode){
    array_walk($data, function(&$value, $key) {
        $value = "{$key} = '{$value}'";
    });

    return implode($implode,$data);

}

/**
 * How much has funnel cloned
 * @return mixed
 */
function getFunnelCloneNumber(){
    $registry = \App\Services\DataRegistry::getInstance();
    $db = App::make('App\Services\DbService');
    $query = "SELECT count(*) FROM clients_leadpops cl , clients_leadpops_attributes cla
            where cl.client_id = " . $registry->leadpops->clientInfo['client_id'] . "
            and cl.leadpop_active <> 3
            and cla.clients_leadpop_id  = cl.id
            and cla.client_id  =  cl.client_id
            and cla.is_clone = 1";
     return $db->fetchOne($query);
}

/**
 * check domain name by funnel name
 * @param $funnelName
 */
function checkDomainName($funnelName, $top_level_domain='secure-clix.com'){
    $domaineExists = \DB::table("clients_funnels_domains")
        ->where('subdomain_name', $funnelName)
        ->where("top_level_domain", $top_level_domain)
        ->get()->count();
    return $domaineExists;
}

/**
 * @param $funnel_data
 * get all thank you content from current hash data
 */
function renderThankYouContentCustomArray($thankyouPageList,$hash){
    $registry = \App\Services\DataRegistry::getInstance();
    $protocol = "http://";
    if($registry->leadpops->clientInfo['is_secured']){
        $protocol = "https://";
    }

    $submission = [];
    if($thankyouPageList) {
        foreach($thankyouPageList as $key => $val){
            $data['insertId'] = $val->id;
            $data['hash'] =  $hash['current_hash'];
            $data['funnel_url'] = $protocol.$hash["funnel"]["domain_name"];
            if($val->thirdparty_active == 'y'){
                $data['typ_type'] = 'external';
                $data['type'] = '3rd Party URL';
                $data['set_class'] = 'outside-link';
            }
            else{
                $data['typ_type'] = 'internal';
                $data['type'] = 'Thank You';
                $data['set_class'] = '';
            }
            $data['thank_you_title'] = $val->thankyou_title;
            $data['thankyou_slug'] = ($val->thankyou_slug) ? $val->thankyou_slug : Str::slug($val->thankyou_title);
            $data['thankyou'] = $val->thankyou;
            $data['thirdparty_active'] = $val->thirdparty_active;
            $data['https_flag'] = $val->https_flag;
            $data['thankyou_url'] = $val->thirdparty;
            $data['thankyou_logo'] = $val->thankyou_logo;

            /* Requirement is to change the Lock Icon without going into updating all rows in database records. (A30-2351) */
            $replace_icon_old = 'src="https://images.lp-images1.com/default/images/lock-icon.png"';
            $replace_icon_new = 'src="https://images.lp-images1.com/default/images/email-privacy-icon.png"';
            $data['thankyou'] = str_replace($replace_icon_old,$replace_icon_new, $data['thankyou']);
            $re = '/email-privacy-icon\.png".*?style="(.*?)"/m';
            preg_match_all($re, $data['thankyou'], $matches, PREG_SET_ORDER, 0);
            if(count($matches) > 0 && count($matches[0]) > 1) {
                $data['thankyou'] = str_replace($matches[0][1], "", $data['thankyou']);
            }

            $submission[$val->id] = $data;
        }
    }
    return $submission;
}

/**
 * checkbox checked if value and match value is equal
 * @param $val
 * @param $match
 * @return string
 */

if(!function_exists('getChceked')){
    function getChecked($val,$match){
        if($val === $match){
            return "checked";
        }
    }
}
/**
 * @param $file
 * @param $width
 * @param $height
 * @param $resizeWidth
 * @param $resizeHeight
 * @param $type
 * @param $fileName
 */

function imageResize($tempName, $width, $height, $resizeWidth, $resizeHeight, $type, $fileName){
        $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
        switch ($type) {
            case IMAGETYPE_JPEG:
                $resourceType = imagecreatefromjpeg($tempName);
                break;
            case IMAGETYPE_GIF:
                $resourceType = imagecreatefromgif($tempName);
                break;
            case IMAGETYPE_PNG:
                $resourceType = imagecreatefrompng($tempName);
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($imageLayer, 0, 0, 0);
                // removing the black from the placeholder
                imagecolortransparent($imageLayer, $background);

                // turning off alpha blending (to ensure alpha channel information
                // is preserved, rather than removed (blending with the rest of the
                // image in the form of black))
                imagealphablending($imageLayer, false);

                // turning on alpha channel information saving (to ensure the full range
                // of transparency is preserved)
                imagesavealpha($imageLayer, true);

                break;
        }
            imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $width,$height);
            imagepng($imageLayer, $fileName);
            unset($imageLayer);
}


function getImageDimensions ($w,$h, $newWidth, $newHeight) {
    $ratio = ($w / $h);
    do  {
        $w -= $ratio;
        $h -= 1;
    } while ($w > $newWidth || $h > $newHeight);
    return $w . "~" . $h;
}
