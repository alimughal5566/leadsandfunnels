<?php
require_once("/var/www/vhosts/itclix.com/lpIframeCrossDomain.php");
/*header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");*/

error_reporting(0);

@date_default_timezone_set('America/Los_Angeles');
require($_SERVER['DOCUMENT_ROOT'] . '/db.php');
global $zdb;
global $db;

if (isset($_POST['lps']) && $_POST['lps'] != "") {
    if (isset($_POST['lptype']) && $_POST['lptype'] == "site"){
        $remote_session = $_POST['lps'];
        session_id($remote_session);
        session_start();
        $s = "select * from remote_funnel_session where session_id = '".$_POST['lps']."' limit 1 ";
        $remoteData =  $zdb->fetchall($s);
        $_SESSION["client"] = unserialize($remoteData[0]["session_data"]);
        if (isset($_SESSION['client']->subdomain_name)) {
            $_SERVER['HTTP_HOST'] = $_SESSION["client"]->subdomain_name . "." . $_SESSION["client"]->top_level_domain;
        } else if(isset($_SESSION['client']->domain_name)){
            $_SERVER['HTTP_HOST'] = $_SESSION["client"]->domain_name;
        }
        unset($_POST["lps"]);
    }else{
        session_id($_POST['lps']);
        session_start();
        unset($_POST["lps"]);
    }
}
else {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/identify.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/steps.php');
$oStep = new steps($db);

$cookieName = str_replace(".","_",$_SERVER['HTTP_HOST']);

//echo $_SESSION['client']->include_path ;
if ($_GET["muhammad"] == "test") {
    echo "<pre>".print_r($_SESSION,1)."</pre>";
    echo "<pre>".print_r($_SERVER,1)."</pre>";
    exit;
}

if($_SESSION["client"]->include_path == '' ) {

    $tHost = explode(".",$_SERVER['HTTP_HOST']);
    $tcnt = count($tHost);
    if($tcnt > 2 && $tHost[0] != 'www')  {
        $clientTopDomain = $tHost[1].".".$tHost[2];
    }
    else if($tcnt > 2 && $tHost[0] == 'www') {
        $clientTopDomain = $tHost[1].".".$tHost[2];
    }
    else if($tcnt == 2) {
        $clientTopDomain = $tHost[0] . "." . $tHost[1];
    }

    setcookie($cookieName, "" , (time() - 3600), "/", $clientTopDomain );

    echo 'expired';
    exit;
}


if(@$_COOKIE["dev"]=="m") {
    // Lead Tracker
    $saving_type = "Before Saving";
    $s = " insert into leadpops_lead_track (id,";
    $s .= " client_id,url,saving_type,post_data,unique_key) values (null," . $_SESSION['client']->client_id;
    $s .= "," . strtolower($_SERVER['SERVER_NAME']) . "," . $saving_type . "," . json_encode($_POST) . ",'".$_SESSION['client']->unique_key."')" ;
    $db->query($s);
}

//$step = $oStep->getStep($_COOKIE[$cookieName]);
$step = $oStep->getStep($_SESSION['client']->unique_key);
$s = " delete from leadpops_leads_qa ";
$s .= " where  leadpop_lead_id  = " . $_SESSION['client']->leadpop_lead_id;
$s .= " and unique_key = '".$_SESSION['client']->unique_key."'  ";
$s .= " and step = " . $step;

$db->query($s); // delete data for this step, then insert all new data

$i = 0;
$break = 1;
$last_step = 0;
$post = $_POST;
if(@$post['test']==1){
    $post['Zip_Code'] = "98001".$post['Zip_Code'];
    $post['First_Name'] = "LP".$post['First_Name'];
    $post['Last_Name'] = "Test".$post['Last_Name'];
    $post['Primary_Email'] = "test@leadpops.com".$post['Primary_Email'];
    $post['Primary_Phone'] = "1111111111".$post['Primary_Phone'];
    unset($post['test']);
}


foreach ($post as $k => $v) {

    if($k == "undefined") {
        $k = "Loan_Program";
    }

    $v = str_replace('#1#','>',$v);
    $v = str_replace('#2#','<',$v);

    $aV = explode("~~~",$v);
    $insertV = $aV[0];
    $fieldName = $aV[1];
    $fieldStep = $aV[2];

    if($last_step!=$fieldStep){
        $last_step = $fieldStep;
        $seq = 1;
    }else{
        $seq++;
    }
    $keyres = explode("_",$k);
    if (@is_numeric($keyres[2])) {
        $k = str_replace('_'.$keyres[2]," ",$k);
    }
    if($fieldName != "xxTrustedFormCertUrl" && $fieldName != "costconum" ) {
        $i += 1;
        $s = " insert into leadpops_leads_qa (id,";
        $s .= " leadpop_lead_id,step,seq,question,answer,field,unique_key) values (null," . $_SESSION['client']->leadpop_lead_id;
        $s .= "," . $fieldStep . "," . $seq . ",'".addslashes(str_replace("_"," ",$k))."','".addslashes($insertV)."','".$fieldName."','".$_SESSION['client']->unique_key."')" ;
        $db->query($s);
    }
    else if ($fieldName == "xxTrustedFormCertUrl" && $_SESSION['client']->trusted == 1) {
        $i += 1;
        $s = " insert into leadpops_leads_qa (id,";
        $s .= " leadpop_lead_id,step,seq,question,answer,field,unique_key) values (null," . $_SESSION['client']->leadpop_lead_id;
        $s .= "," . $fieldStep . "," . $seq . ",'".addslashes(str_replace("_"," ",$k))."','".addslashes($insertV)."','".$fieldName."','".$_SESSION['client']->unique_key."')" ;
        $db->query($s);
        $_SESSION['client']->trusted += 1;
    }
    else if ($fieldName == "costconum" && $_SESSION['client']->costco == 1) {
        $i += 1;
        $s = " insert into leadpops_leads_qa (id,";
        $s .= " leadpop_lead_id,step,seq,question,answer,field,unique_key) values (null," . $_SESSION['client']->leadpop_lead_id;
        $s .= "," . $fieldStep . "," . $seq . ",'".addslashes(str_replace("_"," ",$k))."','".addslashes($insertV)."','".$fieldName."','".$_SESSION['client']->unique_key."')" ;
        $db->query($s);
        $_SESSION['client']->costco += 1;
    }
}

?>
