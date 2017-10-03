<?php
/**
 * Created by PhpStorm.
 * User: Samsung
 * Date: 03.10.2017
 * Time: 15:39
 */

class ApiController extends BaseController
{
    public function getAllModels(){
        $autoModel = AutoModels::model()->findAll();

        $this->sendResponse(["success" => 1, "data" => $autoModel]);
        exit();
    }

    public function search(){
        $request = $this->getRequestParams();
        $requiredParams = ["year"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }

        $auto = Auto::model()->findAll($request);

        $this->sendResponse(["success" => 1, "data" => $auto], 'txt');
    }

    public function getAuto(){
        $auto = Auto::model()->getList();
        $this->sendResponse(["success" => 1, "data" => $auto]);
    }

    public function getAutoById(){
        $request = $this->getRequestParams();
        $requiredParams = ["id"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }

        $auto = Auto::model()->find($request["id"]);

        $this->sendResponse(["success" => 1, "data" => $auto]);
    }
}