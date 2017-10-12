<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
class  App{

    public static $db;
    public static $config;

	public function __construct($config){
	    self::$config = $config;
		self::$db = new db_new($config["db"][$config["db"]["type"]]);
	}

	public static function getConfigParams($param){
	    return (isset(self::$config[$param])) ? self::$config[$param] : '';
    }

	public function start(){
		
            $default = BASE_CONTROLLER;

		if(isset($_GET["c"])){
			$controller = $_GET["c"]."Controller";
		}else{
			$controller = $default;
		}

		if(isset($_GET["a"])){
			$action = $_GET["a"];
		}else{
			$action = "index";
		}

		$c = new $controller;
		//echo get_class($c), " - ", $action, method_exists($c,$action);
		if(method_exists($c,$action)){
			$c->$action();
		}else{

		    if(get_class($c) == 'ApiController'){
		        //$c->send404Response('request not found');
                header('HTTP/1.0 404 Not Found');
                echo 'request not found';
                exit();
            }else {
                echo "ERROR: $action not found.";
            }
		}
	}

}