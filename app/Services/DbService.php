<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 05/11/2019
 * Time: 5:45 PM
 */

/**
 * Notes: This class defines all functions with similar name which we have in Zend_Db_Adapter Object
 */

namespace App\Services;
use \DB;
use Exception;

class DbService
{

    private $last_insert_id;

    public function __construct(){
        // nothing here
    }

    /**
     * Execute Query to database.
     *
     * @param $query string
     * @return int
     * @throws Exception
     */
    public function query($query){
        if(strpos(strtolower($query), "insert ") !== false){
            DB::insert($query);
            $this->last_insert_id = DB::getPdo()->lastInsertId();
            return $this->last_insert_id;
        }
        else if(strpos(strtolower($query), "update ") !== false){
            $resp = DB::update($query);
            return $resp;
        }
        else if(strpos(strtolower($query), "delete ") !== false){
            $resp = DB::delete($query);
            return $resp;
        }
        else{
            throw new Exception("[Unhandled Query] - ".$query);
        }
    }

    /**
     * Insert data to table and return last insert id

     * @param $table string
     * @param $data array
     * @return int
     */
    public function insert($table, $data){
        DB::table($table)->insert($data);
        $this->last_insert_id = DB::getPdo()->lastInsertId();
        return $this->last_insert_id;
    }


    /**
     * @param $table string
     * @param $data array
     * @param $condition string
     */
    public function update($table, $data, $condition){
        DB::table($table)->whereRaw($condition)->update($data);
    }


    /**
     * Return last insert id
     * @return int
     */
    public function lastInsertId(){
        return $this->last_insert_id;
    }

    /**
     * Get database result set for Query.
     *
     * @param $query string
     * @return array
     */
    public function fetchAll($query){
        $res = DB::select($query);
        if($res){
            $data = objectToArray($res);
            return $data;
        }
        else{
            return array();
        }
    }

    /**
     * Return single table row from database result set.
     *
     * @param $query string
     * @return bool|array
     */
    public function fetchRow($query){
        $res = DB::select($query);
        if($res){
            $data = objectToArray($res[0]);
            return $data;
        }
        else{
            return array();
        }
    }

    /**
     * Return value of a particular column
     *
     * @param $query string
     * @return bool|string|integer
     */
    public function fetchOne($query){
        $res = DB::select($query);
        if($res){
            $data = objectToArray($res[0]);
            return $data[key($data)];
        }
        else{
            return false;
        }
    }


    public function ping(){
        return "PING Successful.";
    }

}