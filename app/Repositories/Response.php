<?php


namespace App\Repositories;


trait Response
{
    public function successResponse($data = []){
        return ["status" => true, "data" => $data];
    }

    public function errorResponse($data=[]){
        return ["status" => false, "data" => $data];
    }
}
