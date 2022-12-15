<?php
//Created Date:06-05-2020 Created By: Muhammad Zulfiqar
//All existing client, having website funnels, "Website" tag should be assigned to website funnels.
include_once('thedb.php');
date_default_timezone_set('America/Los_Angeles');
ini_set('memory_limit', '2024M');
ini_set('max_execution_time', 300);
set_time_limit(0);
require_once('console.php');
require_once('tag-function.php');
$argv = array('tag','client_id=8395,8396,8397,8398,8399,8400,8401,8402,8403,8404,8405,8406,8407,8408,8409');
$cond = false;
$client_id_input = "";
if (count($argv) < 2) {
    console_info("");
    console_comment("Help");
    console_info("  Script will migrate clients to new tag and folder based Structure.");
    console_comment("Usage:");
    console_log("  php " . $_SERVER['SCRIPT_NAME'] . "  [options]");
    console_comment("Options:");
    console_info("\t client_id=3111,2300 or client_id=all\t\t\t\t\t Required");
    console_info("");
    exit;
} else {
    $cond = true;
    foreach ($argv as $i => $arg) {
        if ($i == 0) continue;
        list($col, $val) = explode("=", $arg);
        if ($col === "" || trim($val) === "") {
            console_error("Invalid Parameters");
            exit;
        }

        if ($col == "client_id") {
            $client_id_input = $val;
            continue;
        }
    }
    if ($client_id_input == "") {
        console_error("Client ID is missing.");
        exit;
    }
}

// Starts execution
if ($cond) {
            $client_id = $client_id_input;
            $sql = "select c_lp.id as client_leadpop_id,c_lp.leadpop_id,c_lp.client_id
            from clients_leadpops c_lp
           WHERE  c_lp.funnel_market = 'w' ";
            if($client_id != 'all') {
                $sql .=" AND c_lp.client_id IN (" . $client_id . ")";
            }

            $q = $db1->query($sql);
            $rec = $q->fetch_all(MYSQLI_ASSOC);

            console_comment($sql);
            console_comment(count($rec) . " Funnels found...");
            for ($s = 5; $s >= 1; $s--) {
                console_log("Process starting in $s Seconds.");
                sleep(1);
            }
            $i = 0;
            $arr = array();
            if($rec){
                foreach ($rec as $r) {
                           //insert website name in tag table
                           $group_id = assign_tag_to_funnel($r['client_id'],$r['leadpop_id'],$r['client_leadpop_id'],'Website');
                            echo "\n\n";
                           console_info('Website name added in tag table => Tag ID '.$group_id['tag_id']);
                            echo "\n\n";
                           $arr[$r['client_leadpop_id']][]  = $group_id;
                            echo "\n\n";
                    $fl_list[$r['client_id']][$r['client_leadpop_id']] = $arr[$r['client_leadpop_id']];

                    echo "\n\n";
                    echo console_info('Number Of  rows added '.$i);
                    echo "\n\n";
                    $i++;
                }
                $q->free();
                echo "\n\n";
                console_info("Client # ".$client_id." migrated...");
                $fp = fopen("website_tag_assign_list.txt", "wb");
                fwrite($fp, print_r($fl_list, true));
                fclose($fp);

                $log_file = "website_tag_assign_".date('Ymd').".log";
                if(!file_exists($log_file)){
                    shell_exec("touch ".$log_file);
                }
                shell_exec('echo "['.date('Y-m-d H:i:s').'] Client # '.$client_id.'" >> '.$log_file);
            }
    }
