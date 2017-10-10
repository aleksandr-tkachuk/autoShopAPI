<?php

abstract class BaseController
{
    protected function render($view, $params = array())
    {

        $keys = array_keys($params);

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        $controller = strtolower(str_replace("Controller", "", get_class($this)));
        if (file_exists(BASE_PASS . "/views/$controller/" . $view . ".php")) {
            include(BASE_PASS . "/views/$controller/" . $view . ".php");
        } else {
            echo "view " . $view . ".php not found";
            exit();
        }
    }

    protected function getRequestParams()
    {
        $params = $_REQUEST;
        unset($params["c"]);
        unset($params["a"]);
        unset($params["rtype"]);
        return $params;
    }

    protected function sendResponse($data = [], $type = 'json')
    {
        if (isset($_REQUEST["rtype"])) {
            $type = $_REQUEST["rtype"];
        }
        switch ($type) {
            case 'json';
                header('Content-type: application/json');
                echo json_encode($data);
                break;
            case 'xml';
                header('Content-type: application/xml');
                $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
                $xml = $this->buildXml($data, $xml);
                echo $xml->asXML();
                break;
            case 'txt';
                header('Content-type: text/plain');
                print_r($data);
                break;
            case 'html';
                header('Content-type: text/html');
                $this->buildHTML($data);
                break;
            default:
                $this->requestError(500, ", Bad Request");
                break;
        }
        exit();
    }

    private function buildHTML($data)
    {
        echo "<!DOCTYPE html>
                <html>
                    <head>
                        <meta charset='UTF-8'>
                        <title>HTML</title>
                    </head>
                    <body>
                        <h1>Output via HTML:</h1>
                        <pre>";
        foreach ($data as $key => $value) {
            print_r($value);
        }
        echo "</pre></body></html>";

    }

    private function buildXML($data, $xml)
    {
        foreach ($data as $k => $v) {
            if (is_numeric($k)) {
                $k = "item_" . $k;
            }

            if (is_array($v) || is_object($v)) {
                $sub = $xml->addChild($k);
                $this->buildXML($v, $sub);
            } else {
                $xml->addChild($k, htmlspecialchars($v));
            }
        }
        return $xml;
    }

    protected function send404Response($message = "")
    {
        header('HTTP/1.0 404 Not Found');
        echo $message;
        exit();
    }

    protected function requestError($code, $message = "")
    {
        $errors = [
            200 => "Ok",
            400 => "Bad Request",
            401 => "Unauthorized",
            404 => "Not Found",
            405 => "Method not Allowed",
            500 => "Internal Server Error"
        ];
        header('HTTP/1.0 ' . $code . ' ' . $errors[$code]);
        echo $errors[$code] . " " . $message;
        exit();
    }

    protected function getRequestType()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}