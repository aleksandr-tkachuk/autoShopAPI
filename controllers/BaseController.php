<?php
abstract class BaseController{

    
    protected  function render($view, $params = array()){
            
        $keys = array_keys($params);

            foreach($params as $key => $value){
               $$key = $value;
            }

            $controller = strtolower(str_replace("Controller", "", get_class($this)));
            if(file_exists(BASE_PASS."/views/$controller/".$view.".php")){
                    include(BASE_PASS."/views/$controller/".$view.".php");
            }else{
                    echo "view ". $view.".php not found";
                    exit();
            }
    }

    protected function getRequestParams(){
        $params = $_REQUEST;
        unset($params["c"]);
        unset($params["a"]);
        return $params;
    }

    protected function sendResponse($data = [],$type = 'json'){
        switch ($type){
            case 'json';
                header('Content-type: application/json');
                echo json_encode($data);
            break;
            case 'xml';
                header('Content-type: application/xml');
                break;
            case 'txt';
                header('Content-type: text/plain');
                print_r($data);
                break;
            case 'html';
                header('Content-type: text/html');
                break;
        }
        exit();
    }

    protected function send404Response($message = "") {
        header('HTTP/1.0 404 Not Found');
        echo $message;
        exit();
    }
}