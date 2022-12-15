<?php
//Created Date:08-05-2020 Created By: Muhammad Zulfiqar
//update wrong folder against website funnel
include_once('thedb.php');
date_default_timezone_set('America/Los_Angeles');
ini_set('memory_limit', '2024M');
ini_set('max_execution_time', 300);
set_time_limit(0);
require_once('console.php');
require_once('tag-function.php');
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
            $sql = "SELECT
                        c_lp.id as client_leadpop_id,c_lp.client_id
                    FROM
                        clients_leadpops c_lp
                    join leadpops_client_folders lcf on
                        lcf.id = c_lp.leadpop_folder_id
                    WHERE
                        lcf.folder_name != 'Website Funnels'
                        and c_lp.funnel_market = 'w' ";
            if($client_id != 'all') {
                $sql .=" AND c_lp.client_id IN (" . $client_id . ")";
            }
            $sql .=' order by
                        c_lp.client_id';

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
                            $rs = Getfolder('Website Funnels',$r['client_id']);
                            if($rs) {
                                $rec = $rs->fetch_assoc();
                                $folder_id = $rec['id'];
                                echo "\n\n";
                                console_info('Website folder ID ' . $folder_id);
                                echo "\n\n";
                                $arr[$r['client_id']][$r['client_leadpop_id']][] = $folder_id;
                                echo "\n\n";
                                $s = "UPDATE clients_leadpops SET leadpop_folder_id = " . $folder_id . "";
                                $s .= " where id = " . $r["client_leadpop_id"];
                                $db->query($s);
                                echo "\n\n";
                                console_comment($s);
                                echo "\n\n";
                                echo console_info('Number Of  rows updated ' . $i);
                                echo "\n\n";
                                $i++;
                                console_info("Client # ".$client_id." migrated...");
                            }else{
                                console_comment('Website folder is not exist in this client - '.$r['client_id']);
                            }
                }
                $q->free();
                echo "\n\n";
                $fp = fopen("website_folder_assign_list.txt", "wb");
                fwrite($fp, print_r($arr, true));
                fclose($fp);
            }else{
                echo console_info('Number Of  rows updated ' . $i);
            }
    }
