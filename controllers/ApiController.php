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
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $autoModel = AutoModels::model()->findAll();

        $this->sendResponse(["success" => 1, "data" => $autoModel]);
        exit();
    }

    public function search(){
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
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
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $auto = Auto::model()->findAll();
        $this->sendResponse(["success" => 1, "data" => $auto]);
    }

    public function getAutoById(){

        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }

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

    public function auth(){
        if($this->getRequestType() !== "POST") {
            $this->requestError(405);
        }
        $request = $this->getRequestParams();
        $requiredParams = ["login", "password"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }
        $this->sendResponse(["success" => 1, "data" => []]);
    }

}