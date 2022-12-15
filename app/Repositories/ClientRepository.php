<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 06/11/2019
 * Time: 5:41 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  ClientRepository --> Source: Default_Model_Login
 */

namespace App\Repositories;
use App\Services\DataRegistry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
class ClientRepository
{
    private $db;

    public function __construct(\App\Services\DbService $service){
        $this->db = $service;
    }

    /*
    private function encrypt($string){
        $key = "petebird";
        $string = base64_encode(@mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $string;
    }

    public function decrypt($string){
        $key = "petebird";
        $string = rtrim(@mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $string;
    }
    */

    public function isandrew($aGet)
    {
        $res = "";
        $andrewlogin = $aGet[env('APP_SKELETON')];
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where  client_id = " . $andrewlogin . " limit 1 ";
            $res = $this->db->fetchRow($s);
        }

        if (!$res) {
            return 0;
        } else {
            if($res['active'] == 0) {
                return 'blocked';
            }
            else if($res['is_pause'] == 1) {
                return 'pause';
            }else{
                Auth::loginUsingId($res['client_id']);

                // put row into table for cron to check if client directories created
                $this->cron_create_client_directories($res['client_id']);
                $registry = DataRegistry::getInstance();
                $registry->leadpops->client_id = $res['client_id'];
                $registry->leadpops->clientInfo = $res;
                $registry->leadpops->tag_filter = array();
                $registry->leadpops->loggedIn = 1;
                $registry->leadpops->skip_survey = 0;
                $registry->leadpops->show_overlay = $res["overlay_flag"];
                $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
                $registry->leadpops->skeletonLogin = 1;
                if ($res['dashboard_menu_filter']) {
                    $arr = json_decode($res['dashboard_menu_filter'], true);
                    if ($arr) {
                        $registry->leadpops->tag_filter = $arr;
                    }
                }
                $registry->updateRegistry();

                $this->updateLastLogin('last_skeleton_login', $res['client_id']);
                return 'ok';
            }
        }
    }

    public function isOk($aData)
    {
        $res = Auth::attempt(['contact_email' => $aData['un'], 'password' => $aData['pw']]);
        if (!$res) {
            return 0;
        } else {
            $s = "SELECT * FROM clients WHERE contact_email = '" . $aData['un'] . "' AND active = '1'";
            $res = $this->db->fetchRow($s);

            if($res) {
                if ($res['is_pause'] == 1) {
                    return 'pause';
                } else {
                    Auth::loginUsingId($res['client_id']);

                    // put row into table for cron to check if client directories created
                    $this->cron_create_client_directories($res['client_id']);

                    $registry = DataRegistry::getInstance();
                    $registry->leadpops->client_id = $res['client_id'];
                    $registry->leadpops->clientInfo = $res;
                    $registry->leadpops->tag_filter = array();
                    $registry->leadpops->loggedIn = 1;
                    $registry->leadpops->skip_survey = 0;
                    $registry->leadpops->show_overlay = $res["overlay_flag"];
                    $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
                    $registry->leadpops->skeletonLogin = 0;
                    if ($res['dashboard_menu_filter']) {
                        $arr = json_decode($res['dashboard_menu_filter'], true);
                        if ($arr) {
                            $registry->leadpops->tag_filter = $arr;
                        }
                    }
                    $registry->updateRegistry();

                    $this->updateLastLogin('last_login', $res['client_id']);
                    return $res['client_id'];
                }
            }
            else{
                return 'blocked';
            }
        }
    }

    public function updateLastLogin($login_type, $client_id){
        $last_login = date('Y-m-d H:i:s');
        $this->db->query("UPDATE clients SET " . $login_type . " = '" . $last_login . "' WHERE client_id = " . $client_id);
        if ($login_type == "last_login") {
            // clients_logins is in use to make reporting in HubSpot/IFS for client login Over Last 30 Days/60 Days/90 Days/6 Month/12 Month
            $this->db->query("INSERT INTO clients_logins (client_id, login_time) VALUES (".$client_id.", '".$last_login."'); ");
        }
    }

    private function cron_create_client_directories($client_id){
        $s = "select count(*) as cnt from cron_create_client_directories where client_id =  " . $client_id;
        $cnt = $this->db->fetchOne($s);
        if ($cnt == 0) {
            $s = "insert into cron_create_client_directories (id,client_id,hasrun,daterun) values (null,";
            $s .= $client_id . ",'n','')";
            $this->db->query($s);
        }
    }

    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
                    CODE BELOW TO THIS SEPERATION NEEDS TO VERIFY
     ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */



    public function checkEmailClick($emailUsername, $emailPassword, $emailInvoice)
    {
        #$s = "select * from clients  where  ";
        #$s .= " contact_email = '" . urldecode($emailUsername) . "' and password = '" . $this->encrypt($emailPassword) . "'  ";
        #$res = $this->db->fetchRow($s);

        $res = Auth::attempt(['contact_email' => urldecode($emailUsername), 'password' => $emailPassword]);
        if (!$res) {
            return 'http://leadpops.com';
        } else {
            $res = $this->db->fetchRow("SELECT * FROM clients WHERE contact_email = '" . urldecode($emailUsername) . "'");
            $registry = DataRegistry::getInstance();
            $registry->leadpops->client_id = $res['client_id'];

            $this->cron_create_client_directories($res['client_id']);
            $registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']);
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            $registry->updateRegistry();
        }
    }

    public function checkIfSalesmanSale($client_id)
    {
        $registry = DataRegistry::getInstance();
        $salesman = 'n';

        $s = "select * from invoice where client_id = " . $client_id . " and invoice_status = 'x' and from_salesman = 'y' limit 1 ";
        //die($s);
        $inv = $this->db->fetchAll($s);
        if ($inv) {
            $s = "select count(*) as cnt from invoice_line where line_item_status = 'x' and invoice_number = '" . $inv[0]['invoice_number'] . "' ";
            $hasline = $this->db->fetchOne($s);
        }

        $now = time();
        $twodays = 172800;
        $y = "";

        if ($inv && $hasline) {
            for ($i = 0; $i < count($inv); $i++) {
                $test = strtotime($inv[$i]['invoice_date_due']);
                $cmp = ($now - $test);
                if ($cmp > $twodays) {
                    $s = "delete from invoice where invoice_number  = '" . $inv[$i]['invoice_number'] . "' ";
                    $this->db->query($s);
                    $s = "delete from invoice_line where invoice_number  = '" . $inv[$i]['invoice_number'] . "' ";
                    $this->db->query($s);
                } else if ($inv[$i]['from_salesman'] == 'y') {
                    $registry->leadpops->sales_id = $inv[$i]['salesman_id'];
                    $salesman = 'y';
                }
            }
        }

        if (!isset($registry->leadpops->sales_id) || $registry->leadpops->sales_id == "") {
            //$registry->leadpops->sales_id = $this->getSalesmanId($client_id) ;
        }

        return $salesman;
    }

    /**
     * @deprecated 2.1.0
     * @deprecated No longer used by internal code and not recommended salesmen and sales_clients table are not part of further builds (2019-10-08).
     */
    public function getSalesmanId($client_id)
    {
        $s = "SELECT a.sales_id  ";
        $s .= " from salesmen a, sales_clients b where b.sales_id = a.sales_id and b.client_id = " . $client_id . " limit 1 ";
        $res = $this->db->fetchAll($s);
        if ($res) {
            return $res[0]['sales_id'];
        } else {
            $s = "SELECT sales_id  ";
            $s .= " from salesmen where client_id = " . $client_id . " limit 1 ";
            $res2 = $this->db->fetchAll($s);
            return $res2[0]['sales_id'];
        }

    }

    private function unserialize_session_data($serialized_string)
    {
        $variables = array();
        $a = preg_split("/(\w+)\|/", $serialized_string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        for ($i = 0; $i < count($a); $i = $i + 2) {
            $variables[$a[$i]] = unserialize($a[$i + 1]);
        }
        return ($variables);
    }

    public function iscorp($client_id)
    {

        $s = "select * from clients  ";
        $s .= " where  client_id = " . $client_id;
        $res = $this->db->fetchRow($s);

        if (!$res) {
            return 0;
        } else {
            // put row into table for cron to check if client directories created
            $registry = DataRegistry::getInstance();
            //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
            //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
            $registry->leadpops->client_id = $res['client_id'];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            $registry->updateRegistry();
            return 1;
        }
    }

    public function isauto($aGet)
    {

        $andrewlogin = $aGet['autoxxxzzaqlk'];
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where  client_id = " . $andrewlogin;
            $res = $this->db->fetchRow($s);
        }

        if (!$res) {
            return 0;
        } else {
            $this->cron_create_client_directories($res['client_id']);
            $registry = DataRegistry::getInstance();
            //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
            //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
            $registry->leadpops->client_id = $res['client_id'];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            $registry->updateRegistry();
            return 1;
        }
    }



    public function ismovement($aGet)
    {

        $andrewlogin = $aGet['leadpopsaccess'];
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where contact_email = '" . $andrewlogin . "' and is_mm=1 limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        if (!$res) {
            return 0;
        } else {
            if($res['is_pause'] == 1) {
                return 'pause';
            }else {
                // put row into table for cron to check if client directories created
                $this->cron_create_client_directories($res['client_id']);
                $registry = DataRegistry::getInstance();
                //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
                //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
                $registry->leadpops->client_id = $res['client_id'];
                $registry->leadpops->clientInfo = $res;
                $registry->leadpops->tag_filter = array();
                $registry->leadpops->loggedIn = 1;
                $registry->leadpops->skip_survey = 0;
                $registry->leadpops->show_overlay = $res["overlay_flag"];
                $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
                $registry->leadpops->skeletonLogin = 1;
                if ($res['dashboard_menu_filter']) {
                    $arr = json_decode($res['dashboard_menu_filter'], true);
                    if ($arr) {
                        $registry->leadpops->tag_filter = $arr;
                    }
                }
                $registry->updateRegistry();
                return 'ok';
            }
        }
    }

    public function isfairwaymc($aGet)
    {
        $andrewlogin = $aGet['leadpopsfunnelsaccess'];
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where contact_email = '" . $andrewlogin . "' and is_fairway=1 limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        if (!$res) {
            return 0;
        } else {
            if($res['is_pause'] == 1) {
                return 'pause';
            }else {
                // put row into table for cron to check if client directories created
                $this->cron_create_client_directories($res['client_id']);
                $registry = DataRegistry::getInstance();
                //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
                //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
                $registry->leadpops->client_id = $res['client_id'];
                $registry->leadpops->clientInfo = $res;
                $registry->leadpops->tag_filter = array();
                $registry->leadpops->loggedIn = 1;
                $registry->leadpops->skip_survey = 0;
                $registry->leadpops->show_overlay = $res["overlay_flag"];
                $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
                $registry->leadpops->skeletonLogin = 1;
                if ($res['dashboard_menu_filter']) {
                    $arr = json_decode($res['dashboard_menu_filter'], true);
                    if ($arr) {
                        $registry->leadpops->tag_filter = $arr;
                    }
                }
                $registry->updateRegistry();
                return 'ok';
            }
        }
    }

    /* Notes: Did not find any usage for this function so just keeping in file for now */
    public function mmlink($aGet)
    {

        $andrewlogin = str_replace(" ", "+", $aGet['mmaccess']);
        $decrypted = $this->decrypt($andrewlogin);
        $unpw = explode("|", $decrypted);
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where contact_email = '" . $unpw[0] . "' and password = '" . $this->encrypt($unpw[1]) . "' limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        if (!$res) {
            return 0;
        } else {
            // put row into table for cron to check if client directories created
            $this->cron_create_client_directories($res['client_id']);
            $registry = DataRegistry::getInstance();
            //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
            //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
            $registry->leadpops->client_id = $res['client_id'];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            $registry->updateRegistry();
            return 'ok';
        }
    }

    /* Notes: Did not find any usage for this function so just keeping in file for now */
    public function fwlink($aGet)
    {

        $andrewlogin = str_replace(" ", "+", $aGet['fwaccess']);
        $decrypted = $this->decrypt($andrewlogin);
        $unpw = explode("|", $decrypted);
        if (isset($andrewlogin) && $andrewlogin != "") {
            $s = "select * from clients  ";
            $s .= " where contact_email = '" . $unpw[0] . "' and password = '" . $this->encrypt($unpw[1]) . "' limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        if (!$res) {
            return 0;
        } else {
            // put row into table for cron to check if client directories created
            $this->cron_create_client_directories($res['client_id']);
            $registry = DataRegistry::getInstance();
            //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
            //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
            $registry->leadpops->client_id = $res['client_id'];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            return 'ok';
        }
    }




    private function hasSale($client_id)
    {
        $s = "select hasorder from has_one_active_order   ";
        $s .= " where client_id =  " . $client_id . " limit 1 ";
        $has = $this->db->fetchRow($s);
        if (@$has['hasorder'] == 'y') {
            return 'y';
        } else {
            return 'n';
        }
    }

    /**
     * Check session during logic
     *
     * @deprecated since 2.1.0, using Laravel's auth().
     */
    public function checkSession($sessionId){
        /*
        $s = "select * from session_console where session_id  = '" . $sessionId . "'";
        $res = $this->sessionDb->fetchAll($s);
        if (!$res) {
            return 'http://leadpops.com';
        } else {
            $sessionObj = $this->unserialize_session_data($res[0]['session_data']);
            $client_id = $sessionObj['leadpops']['client_id'];
            $registry = DataRegistry::getInstance();
            $registry->leadpops->client_id = $client_id;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            return '/shoppops';
        }
        */
    }

    protected function _getDB()
    {
        $dbAdapters = Zend_Registry::get('dbAdapters');
        return $dbAdapters['client'];
    }

    public function cim($aGet)
    {
        $cim = $aGet['c'];
        if (isset($cim) && $cim != "") {
            $s = "select * from clients  ";
            $s .= " where  client_id = " . $cim . " limit 1 ";
            $res = $this->db->fetchRow($s);
        }
        if (!$res) {
            return 0;
        } else {
            $this->db->query("UPDATE clients set active = '1', payment_pending_flag = 0, payment_date = '" . date('Y-m-d H:i:s') . "' where client_id = " . $res['client_id']);
            // put row into table for cron to check if client directories created
            $registry = DataRegistry::getInstance();
            //$registry->leadpops->sales_id = $this->getSalesmanId($res['client_id']) ;
            //$registry->leadpops->salesmansale = $this->checkIfSalesmanSale($res['client_id']) ;
            $registry->leadpops->client_id = $res['client_id'];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = $this->hasSale($res['client_id']);
            $registry->updateRegistry();
            return 'ok';
        }
    }

}
