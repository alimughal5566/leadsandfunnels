<?php
include_once('thedb.php');
//check key in array
function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false)
            return $what;
    }
    return false;
}
//Created Date:14-2-2020 Created By: Muhammad Zulfiqar
//add vertical name for folder in leadpops_client_folders table if exist otherwise get the folder id against vertical name
function assign_folder_to_funnel($client_id,$folder_name){
    $s = Getfolder($folder_name,$client_id);
    if($s->num_rows == 0) {
        if(strtolower($folder_name) == 'website funnels'){
            $website = 1;
        }else{
            $website = 0;
        }
        $folder = array(
            'client_id' => $client_id,
            'folder_name' => $folder_name,
            'is_default' => 1,
            'is_website' => $website
        );
        $id = insert('leadpops_client_folders', $folder);
        return $id;
    }else{
        $rec =  $s->fetch_assoc();
        $s->free();
        return $rec['id'];
    }
}
//add sub vertical name or group name for tag in leadpops_tags table f exist otherwise get the tag id against sub vertical name or group name
function assign_tag_to_funnel($client_id,$leadpop_id,$client_leadpop_id,$tag_name){
    $rs = Gettag($tag_name, $client_id);
    $arr = array();
    if($rs->num_rows == 0) {
        $tag = array(
            'client_id' => $client_id,
            'tag_name' => $tag_name,
            'is_default' => 1
        );
        $tag_id = insert('leadpops_tags', $tag);
    }else{
        $rec =  $rs->fetch_assoc();
        $tag_id = $rec['id'];
        $rs->free();
    }
    $chk_tag = Checktagmaping($client_id,$client_leadpop_id,$tag_id,$leadpop_id,$tag_name);
    $arr = array('num_rows' => $chk_tag->num_rows ,'tag_id' => $tag_id,'tag_name' => $tag_name,'client_leadpops_id' => $client_leadpop_id);
    if($chk_tag->num_rows == 0) {
        $data = array(
            'client_id' => $client_id,
            'leadpop_id' => $leadpop_id,
            'client_leadpop_id' => $client_leadpop_id,
            'leadpop_tag_id' => $tag_id,
            'client_tag_name' => $tag_name,
            'active' => 1
        );
        insert('leadpops_client_tags', $data);
    }else{
        $tag_rec =  $chk_tag->fetch_assoc();
        $data = array(
            'client_id' => $client_id,
            'leadpop_id' => $leadpop_id,
            'client_leadpop_id' => $client_leadpop_id,
            'leadpop_tag_id' => $tag_id,
            'client_tag_name' => $tag_name,
            'active' => 1
        );
        $where = "id = '".$tag_rec['id']."'";
        update('leadpops_client_tags', $data,$where);
    }
    $chk_tag->free();
    return $arr;
}
//get folder by name  and client_id
function Getfolder($folder_name,$client_id){
    global $db1;
    $sql = "SELECT
            *
        FROM
            leadpops_client_folders
        WHERE
            folder_name = '".$folder_name."'
            AND client_id  = '".$client_id."'";
    console_comment('Query leadpops_client_folders =>' .$sql);
    return $db1->query($sql);
}
//get tag by name and client_id
function Gettag($t,$client_id){
    global $db1;
    $sql = "SELECT
            *
        FROM
            leadpops_tags
        WHERE
            tag_name = '".$t."'
            AND client_id  = '".$client_id."'";
    //Pause Logic to verify SQL
    console_comment('Query leadpops_tags =>' .$sql);
    return $db1->query($sql);
}
//get tag mapping list against client_id , client_leadpop_id and tag_id
function Checktagmaping($client_id,$client_leadpop_id,$tag_id,$leadpop_id,$client_tag_name){
    global $db1;
    $sql = "SELECT
            *
        FROM
            leadpops_client_tags
        WHERE
            (client_leadpop_id = '".$client_leadpop_id."'
            AND  leadpop_tag_id  = '".$tag_id."'
            )
            AND client_id  = '".$client_id."'";
    //Pause Logic to verify SQL
    console_comment('Check leadpops_client_tags table exist entry =>' .$sql);
    $rec = $db1->query($sql);
    return $rec;
}

//insert record
function insert($table, array $data){
    global $db1;

    $q = "INSERT into  `" . $table . "` ";
    $k = '';
    $v = '';

    foreach($data as $key => $val){
        $k .= "`$key`,";
        $v .= "'".$val."',";
    }

    $q .= "(" . rtrim($k, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
    $db1->query($q);
    echo "\n\n insert query\n\n";
    console_info($q);
    return $db1->insert_id;
}
//update record
function update($table, array $data,$where){
    global $db1;

    $q = "UPDATE `" . $table . "` SET";
    foreach($data as $key => $val){
        $q .= "`$key`='" . $val . "', ";
    }

    $q = rtrim($q, ', ') . ' WHERE ' . $where . ';';

    echo "\n\n update query\n\n";
    console_info($q);
    $db1->query($q);
}
