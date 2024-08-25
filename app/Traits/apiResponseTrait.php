<?php
namespace App\Traits;

trait apiResponseTrait{
    public function responseApi($data,$message,$status){
        $array=[
            $data,
            $message,
        ];
        return response()->json($array,$status);

    }
    public function apiResponse($message,$status){
       
        return response()->json($message,$status);
    }
}