<?php
/**
 * Created by PhpStorm.
 * User: MZAC
 * Date: 22/11/2019
 * Time: 10:34 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  ExportRepository --> Source: Default_Model_Export
 */

namespace App\Repositories;
use App\Services\DataRegistry;
use LP_Helper;
class ExportRepository
{
    private $db;
    protected  $rackspace;
    public $date_format = 'F j, Y';
    public $time_format = 'g:i a T';

    public function __construct(\App\Services\DbService $service){
        $this->db = $service;
        $this->registry = DataRegistry::getInstance();
        $this->rackspace = \App::make('App\Services\RackspaceUploader');
    }

    function parseTextForExport($text){
        $Text_to_Add = htmlentities($text);
        $Test_to_Add_XML_Cleaned = $this->xmlEntities($Text_to_Add);
        return $Test_to_Add_XML_Cleaned;
    }

    function xmlEntities($str){

        $xml = array('&#34;','&#38;','&#38;','&#60;','&#62;','&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;');
        $html = array('&quot;','&amp;','&amp;','&lt;','&gt;','&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&Aacute;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&Eacute;','&Ecirc;','&Euml;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&Oacute;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&Uacute;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;');
        $str = str_replace($html,$xml,$str);
        $str = str_ireplace($html,$xml,$str);
        return $str;
    }

    function getFileNameForExport($client_id){
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        return preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".pdf";
    }

    function getClientInfo($client_id) {
        $m = "select first_name,last_name,contact_email,company_name,phone_number  from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        return $fn;
    }
    function getLeadContentByFunnel($uiqurekey){
        $return_data=array();
        $ts = "SELECT * from lead_content ";
        $ts .= " WHERE id  IN (" . $uiqurekey .")";
        //echo $ts;
        $lead = $this->db->fetchAll($ts);
        return $lead;
        $return_data['lead']=$lead;

        /*$u = "SELECT * from  lead_headings  ";
        $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
        $u .= " order by display_sequence, display_order ";
        $z = $this->db->fetchAll($u);
        $return_data['z']=$z;*/
        return $return_data;
    }

    function getLeadContentByFunnelOrignal($uiqurekey){
        $return_data=array();
        $ts = "SELECT * from lead_content";
        $ts .= " WHERE id  = '" . $uiqurekey ."' ";
        $lead = $this->db->fetchRow($ts);
        $return_data['lead']=$lead;

        $u = "SELECT * from  lead_headings  ";
        $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
        $u .= " order by display_sequence, display_order ";
        $z = $this->db->fetchAll($u);
        $return_data['z']=$z;
        return $return_data;
    }


    function getleadname ($client_id,$unique_key)  {

        $s = " SELECT firstname,lastname,email,phone,date_completed    ";
        $s .= " from lead_content  " ;
        $s .= " WHERE client_id = " . $client_id;
        $s .= " and id = '".$unique_key."' limit 1 ";

        $r = $this->db->fetchRow($s);
        $dtime = strtotime($r['date_completed']);
        $dt = date('d/m/Y g:i a',$dtime);

        $phone = preg_replace("[^0-9]", "", $r['phone'] );
        $phone = $this->formatPhone($phone);
        $s = ucfirst($r['firstname'])." ".ucfirst($r['lastname'])." | ". $phone . " | ". $r['email'] . " |  Completed " . $dt;
        return  ($s);
    }
    function formatPhone($phone) {
        if (empty($phone)) return "";
        $phone = preg_replace("/[^0-9]/", "", $phone);
        if (strlen($phone) == 7)
            sscanf($phone, "%3s%4s", $prefix, $exchange);
        else if (strlen($phone) == 10)
            sscanf($phone, "%3s%3s%4s", $area, $prefix, $exchange);
        else if (strlen($phone) > 10)
            if(substr($phone,0,1)=='1') {
                sscanf($phone, "%1s%3s%3s%4s", $country, $area, $prefix, $exchange);
            }
            else{
                sscanf($phone, "%3s%3s%4s%s", $area, $prefix, $exchange, $extension);
            }
        else
            return "unknown phone format: $phone";

        $out = "";
        $out .= isset($country) ? $country.' ' : '';
        $out .= isset($area) ? '(' . $area . ') ' : '';
        $out .= $prefix . '-' . $exchange;
        $out .= isset($extension) ? ' x' . $extension : '';
        return $out;
    }

    function exportMyLeadsEmailData(){

        $_lead_ids = $_POST['lead_ids'];
        $client_ids = $_POST['client_id'];
        $email = $_POST['email'];
        $export_type = $_POST['export_type'];
        switch ($export_type) {
            case 'expswdlnk':
                $fileName = LP_BASE_DIR.'/commands/exportsWordCmd.php';
                break;
            case 'expsexelnk':
                $fileName = LP_BASE_DIR.'/commands/exportsExcelCmd.php';
                break;
            case 'expspdflnk':
                $fileName = LP_BASE_DIR.'/commands/exportsPdfCmd.php';
                break;
        }
        $command = "/usr/bin/php -f {$fileName} {$client_ids} {$_lead_ids} {$email} > ".LP_BASE_DIR."/export_data/expemail_log01.txt 2>&1 &";
        exec ($command);
        return;
    }

    function getMyLeadsPrintV1(){
        //set_time_limit(0);
        ini_set('memory_limit', -1);
        $sunique = $_POST['u'];
        $aunique = explode("~",$sunique);
        $client_id = $_POST['client_id'];

        $funnelURL = $funnelName = null;
        $this->setFunnelURL($funnelURL);
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnelName = $hash_data['funnel']['funnel_name'];
        }


        $section = substr($client_id, 0, 1);
        $clientInfo = $this->getClientInfo($client_id) ;
        $s ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        $s .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $s .= '<head>';
        $s .= '<title>Leadpops, LLC</title>';
        $s .= '</head>';
        $s .= '<body>';
        $s .= "<table border='0'  width='100%' cellpadding='0' cellspacing='0'>";
        $s .= "<tr><td  width='70%'><b>".ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])."</b><br><b>";
        $s .= $clientInfo['company_name']."</b><br><b>";
        $s .= $this->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']."</b></td>";
        $s .= "<td align='left' style='font-family: arial, helvetica, verdana, sans-serif; font-style: italic'>Powered by:  leadPops, LLC<br /> http://www.leadpops.com</td></tr></table>";

        $filename = "";
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $filename = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".php";

        $lead_ids=implode(",", $aunique);
        $return_data=$this->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        foreach ($return_data as $lead) {

            //$unique_arr = explode("-", $lead["unique_key"]);
            //$common_str = substr($unique_arr[1], 0, 10);
            //$ipaddress = str_replace($common_str, "", $unique_arr[0]);

            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            if($heading) {
                $s .= "<p style='margin-bottom: 4px; margin-top: 4px;  text-align: center; font-family: arial, helvetica, sans-serif; font-size: 14px; font-weight: bold'>".$linfo."</p>";
                $s .= "<table border='0' cellspacing='0'>";
                $s .= "<tr style='background: #f4f4f4'><td align='center' colspan='3'><b>".$heading."</b></td></tr>";
            }
            for($i=1; $i<= 50; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];

                    $this->replaceQuestionIfMatchesAny($question);
                    $this->replaceAnswerIfMatchesAny($answer);
                    $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>".$question.":</b></td>";
                    $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$answer."</td></tr>";

                }
            }

            if($funnelName) {
                $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Funnel Name:</b></td>";
                $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$funnelName."</td></tr>";
            }
            if($funnelURL) {
                $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Funnel URL:</b></td>";
                $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$funnelURL."</td></tr>";
            }

            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Date:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->date_format, strtotime($lead["date_completed"]))."</td></tr>";

            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Time:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->time_format, strtotime($lead["date_completed"]))."</td></tr>";

            /**
             * ip address remove export word from @mzac90
             */
//            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>IP Address:</b> </td>";
//            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$ipaddress."</td></tr>";
            $s .= "</table>'";
            $s .= "<hr />";

        }
        $s .= '         <script type="text/javascript">';
        $s .= '             window.print();';
        $s .= '            </script>';
        $s .= ' </body>';
        $s .= '</html>';

        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
        $rep = fopen($report, 'wb');
        fwrite($rep,$s);
        fclose($rep);
        return  LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
//        $container = $this->registry->leadpops->clientInfo['rackspace_container'];
//        $rackspace_path = 'images1/'. $section . '/' . $client_id . '/files/' . $filename;
//        $data = fopen($report, 'r+');
//        $cdn = $this->rackspace->uploadTo($container, $data, $rackspace_path);
//        unlink($report);
//        return $cdn['image_url'];
    }


    function getMyLeadsPrint(){
       /* if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->getMyLeadsPrintV1();
        }*/

        //set_time_limit(0);
        ini_set('memory_limit', -1);
        $sunique = $_POST['u'];
        $aunique = explode("~",$sunique);
        $client_id = $_POST['client_id'];

        $funnelURL = null;
        $this->setFunnelURL($funnelURL);

        $section = substr($client_id, 0, 1);
        $clientInfo = $this->getClientInfo($client_id) ;
        $s ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        $s .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $s .= '<head>';
        $s .= '<title>Leadpops, LLC</title>';
        $s .= '</head>';
        $s .= '<body>';
        $s .= "<table border='0'  width='100%' cellpadding='0' cellspacing='0'>";
        $s .= "<tr><td  width='70%'><b>".ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])."</b><br><b>";
        $s .= $clientInfo['company_name']."</b><br><b>";
        $s .= $this->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']."</b></td>";
        $s .= "<td align='left' style='font-family: arial, helvetica, verdana, sans-serif; font-style: italic'>Powered by:  leadPops, LLC<br /> http://www.leadpops.com</td></tr></table>";

        $filename = "";
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $filename = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".php";

        $lead_ids=implode(",", $aunique);
        $return_data=$this->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        foreach ($return_data as $lead) {

            $leadQuestions = json_decode($lead['lead_questions'], 1);
            $leadAnswers = json_decode($lead['lead_answers'], 1);

            //$unique_arr = explode("-", $lead["unique_key"]);
            //$common_str = substr($unique_arr[1], 0, 10);
            //$ipaddress = str_replace($common_str, "", $unique_arr[0]);

            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            if($heading) {
                $s .= "<p style='margin-bottom: 4px; margin-top: 4px;  text-align: center; font-family: arial, helvetica, sans-serif; font-size: 14px; font-weight: bold'>".$linfo."</p>";
                $s .= "<table border='0' cellspacing='0'>";
                $s .= "<tr style='background: #f4f4f4'><td align='center' colspan='3'><b>".$heading."</b></td></tr>";
            }

            foreach($leadQuestions as $qk => $oneQuestion) {

                if( $leadQuestions[$qk]!=""){

                    $answer = $leadAnswers[$qk];
                    if(is_array($oneQuestion)) {
                        $question = $oneQuestion['question'];
                    } else {
                        $question = $leadQuestions[$qk];
                    }

                    $this->replaceQuestionIfMatchesAny($question);
                    $this->replaceAnswerIfMatchesAny($answer);
                    $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>".$question.":</b></td>";
                    $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$answer."</td></tr>";

                }
            }
         /*   for($i=1; $i<= 50; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];

                    $this->replaceQuestionIfMatchesAny($question);
                    $this->replaceAnswerIfMatchesAny($answer);
                    $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>".$question.":</b></td>";
                    $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$answer."</td></tr>";

                }
            }*/

            if($funnelURL) {
                $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Funnel URL:</b></td>";
                $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$funnelURL."</td></tr>";
            }

            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Date:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->date_format, strtotime($lead["date_completed"]))."</td></tr>";

            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Time:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->time_format, strtotime($lead["date_completed"]))."</td></tr>";

            /**
             * ip address remove export word from @mzac90
             */
//            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>IP Address:</b> </td>";
//            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$ipaddress."</td></tr>";
            $s .= "</table>'";
            $s .= "<hr />";

        }
        $s .= '         <script type="text/javascript">';
        $s .= '             window.print();';
        $s .= '            </script>';
        $s .= ' </body>';
        $s .= '</html>';

        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
        $rep = fopen($report, 'wb');
        fwrite($rep,$s);
        fclose($rep);
        return  LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
//        $container = $this->registry->leadpops->clientInfo['rackspace_container'];
//        $rackspace_path = 'images1/'. $section . '/' . $client_id . '/files/' . $filename;
//        $data = fopen($report, 'r+');
//        $cdn = $this->rackspace->uploadTo($container, $data, $rackspace_path);
//        unlink($report);
//        return $cdn['image_url'];
    }


    function getMyLeadPopPrint(){
        $sunique = $_POST['u'];
        $client_id = $_POST['client_id'];
        $clientInfo = $this->getClientInfo($client_id) ;
        $funnelURL = $funnelName = null;
        $this->setFunnelURL($funnelURL);
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnelName = $hash_data['funnel']['funnel_name'];
        }
        $s ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        $s .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $s .= '<head>';
        $s .= '<title>Leadpops, LLC</title>';
        $s .= '</head>';
        $s .= '<body>';
        $s .= "<table border='0'  width='100%' cellpadding='0' cellspacing='0'>";
        $s .= "<tr><td  width='70%'><b>".ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])."</b><br><b>";
        $s .= $clientInfo['company_name']."</b><br><b>";
        $s .= $this->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']."</b></td>";
        $s .= "<td align='left' style='font-family: arial, helvetica, verdana, sans-serif; font-style: italic'>Powered by:  leadPops, LLC<br /> http://www.leadpops.com</td></tr></table>";

        $filename = "";
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $filename = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".php";

        $s1 = "SELECT a.* from lead_content a  ";
        $s1 .= " WHERE a.id  = '" . $sunique."' limit 1 ";
        $lead = $this->db->fetchRow($s1);

        $u = "SELECT * from  lead_headings  ";
        $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
        $u .= " order by display_sequence, display_order ";
        $z = $this->db->fetchAll($u);
        //print($s1);
        //print($u);
        //var_dump($z);
        //exit;
        $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:"Lead Information";
        if($heading) {
            $s .= "<p style='margin-bottom: 4px; margin-top: 4px;  text-align: center; font-family: arial, helvetica, sans-serif; font-size: 14px; font-weight: bold'>".$this->getleadname($client_id,$sunique)."</p>";
            $s .= "<table border='0' cellspacing='0'>";
            $s .= "<tr style='background: #f4f4f4'><td align='center' colspan='3'><b>".$heading."</b></td></tr>";
        }
        $leadQuestions = json_decode($lead['lead_questions'], 1);
        $leadAnswers = json_decode($lead['lead_answers'], 1);
        foreach($leadQuestions as $qk => $oneQuestion) {
            if( $leadQuestions[$qk]!=""){
                if(is_array($oneQuestion)) {
                    $question = $oneQuestion['question'];
                } else {
                    $question = $leadQuestions[$qk];
                }
                $answer = $leadAnswers[$qk];

                $this->replaceQuestionIfMatchesAny($question);
                $this->replaceAnswerIfMatchesAny($answer);
                $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>".$question."</b></td>";
                $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$answer."</td></tr>";
            }
        }
        if($funnelName) {
            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Funnel Name:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$funnelName."</td></tr>";
        }
        if($funnelURL) {
            $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Funnel URL:</b></td>";
            $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$funnelURL."</td></tr>";
        }

        $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Date:</b></td>";
        $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->date_format, strtotime($lead["date_completed"]))."</td></tr>";

        $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>Time:</b></td>";
        $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".date($this->time_format, strtotime($lead["date_completed"]))."</td></tr>";

        $s .= "</table>'";
        $s .= "<hr />";

        $s .= '<script type="text/javascript">';
        $s .= 'window.print();';
        $s .= '</script>';
        $s .= ' </body>';
        $s .= '</html>';
        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
        $rep = fopen($report, 'wb');
        fwrite($rep,$s);
        fclose($rep);
        return  LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$filename;
    }

    /**
     * Change question text and any condition matched
     * @param $question
     */
    public function replaceQuestionIfMatchesAny(&$question) {
        if(strpos(strtolower($question),'email') !== false){
            $question = 'Email Address';
        } else if(strpos(strtolower($question),'phone') !== false){
            $question = 'Phone Number';
        }
    }

    /**
     * Replace answer if matched in any condition
     * @param $answer
     */
    public function replaceAnswerIfMatchesAny(&$answer) {
        if(strtolower($answer) === "computer"){
            $answer="Desktop";
        }
        else if(strtolower($answer) ==="phone" ){
            $answer="Tablet/Smartphone";
        }
        $answer = stripslashes($answer);
    }

    public function setFunnelURL(&$funnelURL){
        if(isset($_POST['funnel_url']) && !empty($_POST['funnel_url'])) {
            $funnelURL =  $_POST['funnel_url'];
        } elseif(isset($_GET['funnel_url']) && !empty($_GET['funnel_url'])) {
            $funnelURL =  $_GET['funnel_url'];
        }

    }
}

