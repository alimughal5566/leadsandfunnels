<?php

namespace App\Helpers;

use App\Services\gm_process\MyLeadsEvents;

class Query {

    protected static $db;
    protected static $isInitialized;
    protected static $currentLpKey;
    protected static $gearmanEnabled;
    protected static $myleadsEvents;

    /**
     * Initializes local proties according to environment and based on current
     * request
     *
     * @return void
     */
    protected static function init(){
        // If it is initialized before, return early
        if(self::$isInitialized) return;

        // Get current request
        $request = request();
        // If current_hash is sent in request, we convert it to lp key
        $currentHash = $request->input('current_hash');
        if($currentHash){
            self::$currentLpKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        }

        // Check if gearman is enabled
        self::$gearmanEnabled = env('GEARMAN_ENABLE') == '1';
        // Get db service instance
        self::$db = app('\App\Services\DbService');
        // Get gearman instance
        self::$myleadsEvents = MyLeadsEvents::getInstance();
        // Setting it to true to skip initialization on further calls
        self::$isInitialized = true;
    }

    /**
     * It executes query synchronously if given funnelKey is of current funnel,
     * else if gearman is enabled it would send query to gearman,
     * else if none of above condition are met, it would run query synchronously
     *
     * @param string $query
     * @param string $funnelKey lpKey (optional)
     * @return void
     */
    public static function execute(string $query, string $funnelKey = ''){
        // We initialize if not already
        self::init();

        // If funnel key is given and it is of current funnel
        // then we run query synchronously 
        if($funnelKey && $funnelKey == self::$currentLpKey){
            return self::$db->query($query);
        } else if(self::$gearmanEnabled){
            // Other wise, if gearman is enabled, we send query to gearman
            return self::$myleadsEvents->runMyLeadsClient([$query]);
        } else {
            // If gearman is not enabled, then we run query synchronously
            return self::$db->query($query);
        }
    }
}