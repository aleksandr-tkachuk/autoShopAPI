<?php
/**
 * Created by PhpStorm.
 * User: Samsung
 * Date: 03.10.2017
 * Time: 15:39
 */

class ApiController extends BaseController
{

    private function getRequestToken(){
        if(isset($_SERVER["HTTP_TOKEN"])){
            return $_SERVER["HTTP_TOKEN"];
        }else{
            $this->requestError(400, "need token");
        }
    }

    /*
    * get all models
    * request type GET
    * url - api/getAllModels
    * response type - json|xml|txt|html
    */
    public function getAllModels(){
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $autoModel = AutoModels::model()->findAll();

        $this->sendResponse(["success" => 1, "data" => $autoModel]);
        exit();
    }

    /*
    * search auto
    * request type GET
    * url - api/search.(response type)?year=(value)
    * year - require, year of issue
    * other parameters
    * response type - json|xml|txt|html
    */
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

    /*
    * get all auto
    * request type GET
    * url - api/auto.(response type)
    * response type - json|xml|txt|html
    */
    public function getAuto(){
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }
        $auto = Auto::model()->findAll();
        $this->sendResponse(["success" => 1, "data" => $auto]);
    }

    /*
    * get auto by brands
    * request type GET
    * url - api/auto/(auto id).(response type)
    * response type - json|xml|txt|html
    */
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

    /*
     * get auto by brands
     * request type GET
     * url - api/auto/(brand name).(response type)
     * response type - json|xml|txt|html
     */
    public function getBrand(){
        if($this->getRequestType() !== "GET") {
            $this->requestError(405);
        }

        $request = $this->getRequestParams();
        $requiredParams = ["brandName"];
        foreach($requiredParams as $param){
            if(!isset($request[$param]) || $request[$param] == '' ){
                $this->sendResponse(["success" => 0, "message" => $param." parameter is required"]);
            }
        }
        $brands = Auto::findBrand($request["brandName"]);
        if($brands == false){
            $this->requestError(404);
        }else {
            $this->sendResponse(["success" => 1, "data" => $brands]);
        }
    }

    /*
     * authorization
     * request type POST
     * url - api/auth
     * login - require, user login
     * password - require, user password
     * name - user name
     *
     * return user token
     */

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

        $user = User::model()->findByLogin($request["login"]);
        if($user == null){
            $newUser = new User();

            $token = $newUser->generateToken();

            $newUser->login = $request["login"];
            $newUser->password = md5($request["password"]);
            $newUser->name = $request["name"];
            $newUser->token = $token;
            $newUser->save();
        }else{
            if($user->password === md5($request["password"])){
                $token = $user->generateToken();
                $user->token = $token;
                $user->save();
            }else{
                $this->requestError(401);
            }
        }

        $this->sendResponse(["success" => 1, "data" => ["token" => $token]]);
    }

    /*
     * order
     * request type POST
     * url - api/order
     * token - require, http parameter token
     * auto - require, auto id
     *
     * return error or success
     */
    public function order()
    {
        if ($this->getRequestType() !== "POST") {
            $this->requestError(405);
        }

        $token = $this->getRequestToken();

        $request = $this->getRequestParams();
        $requiredParams = ["auto"];
        foreach ($requiredParams as $param) {
            if (!isset($request[$param]) || $request[$param] == '') {
                $this->sendResponse(["success" => 0, "message" => $param . " parameter is required"]);
            }
        }

        $user = User::model()->findByToken($token);
        if($user == null){
            $this->sendResponse(["success" => 0, "message" => "user not found"]);
        }else{
            $order = new Order();
            $order->user = $user->id;
            $order->auto = $request["auto"];
            $order->date = date("Y-m-d H:i:s", strtotime("now"));
            $order->save();
            $this->sendResponse(["success" => 1, "message" => "order has been created"]);
        }
    }

}