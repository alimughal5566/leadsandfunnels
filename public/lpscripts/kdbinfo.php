<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$content = array_filter(explode("\n", file_get_contents("../../.env")));
if($content){
    foreach ($content as $var){
        if(strpos($var, "#") === false){
            list($k, $v) = explode("=", $var);
            $v = str_replace('"', '', $v);
            putenv($k."=".$v);

        }
    }
}
$host = getenv('REDIS_HOST');
echo "Redis Host: ".$host."<br />";
$port = getenv('REDIS_PORT');
$timeout = "";
$redis_enable = 1;

echo "<br />";
if($redis_enable){
    $redis = new \Redis();
    $con = $redis->connect($host, $port);
    echo "Connection Active: "; var_dump($con); echo "<br />";
    echo "Server is running: ".$redis->ping()."<br />";

    if(@$_GET['key'] != ""){
        echo "<h2>Key: ".$_GET['key']."</h2>";
        echo "<strong>Key Value: </strong><br />";

        $str = $redis->get($_GET['key']);
	echo "Raw Data: <pre>".print_r($str, 1)."</pre>";
        $data = @unserialize($str);
        if ($data !== false) {
            if(array_key_exists('defaults', $data)){
                $keys = ['mobile_visits', 'mobile_visits_weekly', 'mobile_visits_monthly', 'desktop_visits', 'desktop_visits_weekly', 'desktop_visits_monthly', 'mobile_leads', 'mobile_leads_weekly', 'mobile_leads_monthly', 'desktop_leads', 'desktop_leads_weekly', 'desktop_leads_monthly'];
                echo "<pre>".print_r($keys, 1)."</pre>";
            }
            echo "<pre>".print_r($data, 1)."</pre>";
        } else {
            $is_valid_json =  is_string($str) && is_array(json_decode($str, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
            if($is_valid_json){
                echo "<pre>".print_r(json_decode($str, 1), 1)."</pre>";
            }
            else{
                echo "<pre>".print_r($data, 1)."</pre>";
            }
        }

        if($redis->hGetAll($_GET['key'])){
            echo "<br />";
            echo "<strong>Key Value: </strong><br /><pre>".print_r($redis->hGetAll($_GET['key']), 1)."</pre>";
        }
    }
    else {
        echo "<h3>Memory ".$redis->dbSize()." keys</h3>";
        echo "<pre>" . print_r($redis->keys('*'), 1) . "</pre>";   // all keys will match this.
    }
}
