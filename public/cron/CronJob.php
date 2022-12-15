<?php

/**
 * @author mzac90
 * Class CronJob
 * Created Date: 22/07/2020
 * Time: 10:00 PM
 */
class CronJob
{
    private $gmc;
    # production gearman server host added by mzac90
    const GM_SERVER_HOST = "10.183.250.92";
    # staging gearman server host added by mzac90
    const GM_STAGING_SERVER_HOST = "127.0.0.1";
    const GM_SERVER_PORT = 4730;
    const EVENT_ACCOUNT_CANCELLATION = "account_cancellation";
    # Database connection parameters
    const DB_HOST="7f71f9ac2c1c498183bbbc75b049a1ef.publb.rackspaceclouddb.com";
    const DB_NAME="devleadpops";
    const DB_USER="leadpops_leadpop";
    const DB_PASSWORD="DorisElaine1925";
    //development server db
    //const DB_HOST="127.0.0.1";
    //const DB_NAME="leadpops21";
    //const DB_USER="leadpops";
    //const DB_PASSWORD="leadpops@@1";
      const cancellation_days = 90;
    /**
     * @return CronJob
     */
    public static function getInstance(){
        static $instance = null;
        if ($instance === null) {
            $instance = new CronJob();
        }
        return $instance;
    }
    public function __construct(){
            $this->gmc = new \GearmanClient();
            $this->gmc->addServer(self::GM_STAGING_SERVER_HOST, self::GM_SERVER_PORT);
    }

    /**
     *client account cancellation event process
     * @author mzac90
     */
    function clientAccountCancellation(){
        $db = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
        $sql = "select client_id,rackspace_container,DATEDIFF(now(),cancellation_date) as inactive_date_diff
            from clients
              WHERE cancellation_status = 0  HAVING inactive_date_diff > ".self::cancellation_days."";
        $q = $db->query($sql);
        $rec = $q->fetch_all(MYSQLI_ASSOC);
        $arr = array();
        if($rec) {
            foreach ($rec as $r) {
                $arr[] = $r;
                $this->gmc->doBackground(self::EVENT_ACCOUNT_CANCELLATION, serialize($r));
            }
            $fp = fopen("cancellation_account_client_".date('Ymd').".log", "wb");
            fwrite($fp, print_r($arr,true));
            fclose($fp);
        }else{
            $fp = fopen("cancellation_account_".date('Ymd').".log", "wb");
            fwrite($fp, count($rec));
            fclose($fp);
        }
        $q->free();
        $db->close();
    }
}
