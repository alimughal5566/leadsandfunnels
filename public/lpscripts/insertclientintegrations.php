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

require_once("thedb.php");

$integration_type = "";
$client_id = "";
$post_url = "";
$post_info = "";
$notify_email = "";

/*
    This variable checks for the type of integration and
    adds the integration name in "name" table column accordingly
    possible values for this variable are:
    1) "velocify" 2) "motivator" 3) "cimmaron" 4) "leadmailbox" 5) "liondesk"
    6) "bntouch" 7) "zapier" 7) "insellerate"  8) "marksman" 9) "whiteboard"
*/

//Motivator = https://2603814-www.tapapp.me/LeadImport/LeadPopsMaster.aspx
//Cimmaron = https://2953654-www.tapapp.me/LeadImport/LeadPopsFunnel.aspx

if(isset($_POST["integration_type"]) && $_POST["integration_type"] != ''){
    $integration_type = $_POST["integration_type"];
} else {
    print "integration_type is empty";
    exit;
}

if(isset($_POST["client_id"]) && $_POST["client_id"] != ''){
    $client_id = $_POST["client_id"];
} else {
    print "client_id is empty";
    exit;
}

if(isset($_POST["post_url"]) && $_POST["post_url"] != ''){
    $post_url = $_POST["post_url"];
} else {
    print "post_url is empty";
    exit;
}

if (($_POST["integration_type"] == "velocify" || $_POST["integration_type"] == "leadmailbox" || $_POST["integration_type"] == "marksman") && $_POST["post_info"] == '') {
    print "post_info is empty";
    exit;
} else {
    $post_info = $_POST["post_info"];
}


if ($_POST["integration_type"] == "motivator" && $_POST["notify_email"] == '') {
    print "notify_email is empty";
    exit;
} else {
    $notify_email = $_POST["notify_email"];
}


// please leave it empty if no email is mentioned to be added, otherwise add email, email should also be added for motivator and cimmaron
$lplist = array();
$integration_name = "";
$lpkey_funnels = getClientdomainslist($client_id,$db);
$lplist = explode(",", $lpkey_funnels);
$purchase_template_id = array(89,83,80,92,95,86);
$refi_template_id = array(90,84,93,81,96,87);
$refipurchase_template_id = array(91,94,97,88,85,82,99);
$reverse_template_id = array(98);
$harp_template_id = array(99);
//for Real Estate Funnels Integrations
$homesearch_template_id = array(100,103,102,101,110);
$homefinder_template_id = array(104,107,106,105);
$homevalues_template_id = array(108,109);
$shortsale_template_id = array(111);



foreach ($lplist as $index => $lp) {
    $lpconstt = explode("~", $lp);
    $leadpop_vertical_id = $lpconstt[0];
    $leadpop_vertical_sub_id = $lpconstt[1];
    $leadpop_id = $lpconstt[2];
    $leadpop_version_seq = $lpconstt[3];
    $s = "select * from leadpops where id = " . $leadpop_id;
    $lpres = $db->fetchRow($s);

    $leadpop_type_id  = $lpres['leadpop_type_id'];
    $leadpop_template_id = $lpres['leadpop_template_id'];
    $leadpop_version_id = $lpres['leadpop_version_id'];

    $integration_name = "";
    if($integration_type == "motivator" || $integration_type == "cimmaron"){

        if (in_array($leadpop_template_id, $purchase_template_id)) {
            $integration_name = 'loantekpurchase';
        } else if (in_array($leadpop_template_id, $refi_template_id)) {
            $integration_name = 'loantekrefi';
        } else if (in_array($leadpop_template_id, $refipurchase_template_id)){
            $integration_name = 'loantekrefipurchase';
        } else if (in_array($leadpop_template_id, $reverse_template_id)){
            $integration_name = 'loantekreverse';
        } else if (in_array($leadpop_template_id, $harp_template_id)){
            $integration_name = 'loantekharp';
        } else if (in_array($leadpop_template_id, $homesearch_template_id) ||
            in_array($leadpop_template_id, $homefinder_template_id)) {
            $integration_name = 'loantekhomesearch';
        } else if (in_array($leadpop_template_id, $homevalues_template_id)) {
            $integration_name = 'loantekhomevalues';
        } else if (in_array($leadpop_template_id, $shortsale_template_id)){
            $integration_name = 'loantekshortsale';
        }
    }
    elseif ($integration_type == "velocify"){

        if (in_array($leadpop_template_id, $purchase_template_id)) {
            $integration_name = 'classicpurchase';
        } else if (in_array($leadpop_template_id, $refi_template_id)) {
            $integration_name = 'classicrefinance';
        } else if ( in_array($leadpop_template_id, $refipurchase_template_id) ||
            in_array($leadpop_template_id, $harp_template_id)){
            $integration_name = 'classicrefipurchase';
        } else if (in_array($leadpop_template_id, $reverse_template_id)){
            $integration_name = 'classicreverse';
        } else if (in_array($leadpop_template_id, $homevalues_template_id )){
            $integration_name = 'classicrealestatevalue';
        } else if ( in_array($leadpop_template_id, $homesearch_template_id) ||
            in_array($leadpop_template_id, $homefinder_template_id) ||
            in_array($leadpop_template_id, $shortsale_template_id)){
            $integration_name = 'classicrealestate';
        }

    }
    elseif ($integration_type == "bntouch"){

        if (in_array($leadpop_template_id, $purchase_template_id)) {
            $integration_name = 'bntpurchase';
        } else if (in_array($leadpop_template_id, $refi_template_id)) {
            $integration_name = 'bntrefinance';
        } else {
            $integration_name = 'bntrefipurchase';
        }
    }
    elseif ($integration_type == "leadmailbox"){

        if (in_array($leadpop_template_id, $purchase_template_id)) {
            $integration_name = 'leadmailboxpurchase';
        } else if (in_array($leadpop_template_id, $refi_template_id)) {
            $integration_name = 'leadmailboxrefinance';
        } else if ( in_array($leadpop_template_id, $refipurchase_template_id) ||
            in_array($leadpop_template_id, $harp_template_id) || in_array($leadpop_template_id, $reverse_template_id)){
            $integration_name = 'leadmailboxrefipurchase';
        }
    } elseif ($integration_type == "liondesk"){
        $integration_name = "liondesk";
    } elseif ($integration_type == "zapier"){
        $integration_name = "zapier";
    } elseif ($integration_type == "insellerate"){
        $integration_name = "insellerate";
    } elseif ($integration_type == "whiteboard"){
        $integration_name = "whiteboard";
    } elseif ($integration_type == "marksman"){
        $integration_name = "marksman";
    } else{
        echo "Please enter correct value for '\$integration_type' variable and then re run this script. Dont worry, nothing has been updated yet\n";
        exit;
    }

    //echo " Template_id ->".$leadpop_template_id." and integration name ". $integration_name."</br>";

    $s = "SELECT concat(subdomain_name,'.',top_level_domain) as domain  FROM clients_subdomains ";
    $s .= " where client_id = " . $client_id;
    $s .= " and leadpop_id = " . $leadpop_id;
    $s .= " and leadpop_type_id = " . $leadpop_type_id;
    $s .= " and leadpop_vertical_id = " .$leadpop_vertical_id;
    $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
    $s .= " and leadpop_template_id = " . $leadpop_template_id;
    $s .= " and leadpop_version_id = " . $leadpop_version_id;
    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
    $domain = $db->fetchOne($s);
    if (!$domain) {
        $s = "SELECT domain_name as domain FROM clients_domains ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " .$leadpop_vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $domain = $db->fetchOne($s);
    }


    if($domain) {

        $s = "SELECT * FROM client_integrations ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and name = " . "'".$integration_name."'";
        $s .= " and post_url = " . "'".$post_url."'";
        $s .= " and post_info = " . "'".$post_info."'";
        $s .= " and url = " . "'".$domain."'";
        $domainexist = $db->fetchOne($s);

        if (!$domainexist) {
            $s = "insert into client_integrations (id,client_id,name,post_url,post_info,url,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,notify_email)";
            $s .= " values (null,";
            $s .= $client_id . ",'" . $integration_name . "',";
            $s .= "'" .$post_url . "',";
            $s .= "'". $post_info . "','" . strtolower($domain) . "',";
            $s .= $leadpop_vertical_id . ",";
            $s .= $leadpop_vertical_sub_id . ",";
            $s .= $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $leadpop_version_seq . ",";
            $s .= "'". $notify_email . "')";
            // echo $s;
            $db->query($s);
        }
    }
}

echo "Response: Success";
echo print_r(json_encode($_POST), 1);
exit;


function getClientdomainslist ($client_id,$db){
    $s = "select id, display_label from leadpops_verticals_sub";
    $_sub_verticals = $db->fetchAll($s);
    $sub_verticals = array();
    foreach ($_sub_verticals as $index => $sub) {
        $sub_verticals[$sub['id']] = $sub['display_label'];
    }
    $s = "select DISTINCT cs.* from `clients_subdomains` cs
        LEFT JOIN `clients_leadpops` cl ON cs.client_id = cl.client_id AND cs.leadpop_id = cl.leadpop_id
        LEFT JOIN `leadpops` lp ON lp.id = cl.leadpop_id where cs.client_id = ".$client_id." AND cl.`leadpop_active` != 3";
    $domainslist = $db->fetchAll($s);


    $s = "select DISTINCT cd.* from `clients_domains` cd
        LEFT JOIN `clients_leadpops` cl ON cd.client_id = cl.client_id AND cd.leadpop_id = cl.leadpop_id
        LEFT JOIN `leadpops` lp ON lp.id = cl.leadpop_id where cd.client_id = ".$client_id." AND cl.`leadpop_active` != 3";
    $topdomainslist = $db->fetchAll($s);

    if($topdomainslist){
        $domainslist = array_merge($domainslist,$topdomainslist);
    }

    foreach ($domainslist as $key=>$item) {
        $clientdomainslist[$sub_verticals[$item['leadpop_vertical_sub_id']]][] = $item;
    }
    $total_keys = array();
    foreach ($clientdomainslist as $sub_display_label => $lp_items) {
        foreach ($lp_items as $index => $lp) {
            $domain_name = $lp['subdomain_name'].".".$lp['top_level_domain'];
            $fkey =  $lp['leadpop_vertical_id']."~".$lp['leadpop_vertical_sub_id']."~".$lp['leadpop_id']."~".$lp['leadpop_version_seq'];
            array_push($total_keys,$fkey);
        }
    }
    $total_keys = implode(",", $total_keys);
    return $total_keys;
}

