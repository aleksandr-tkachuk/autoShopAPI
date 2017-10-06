<?php

class router
{
    protected $verb;
    public function __construct()
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
    }
    public function start()
    {
        if ($this->verb == 'GET') {
            if (isset($_GET['filename'])){
                $file_content = file_get_contents($_GET);
            }else{
                die('ERROR: REQUIRED PARAMETERS NOT GIVEN');
            }
        }elseif ($this->verb = 'POST'){
            //do some things
        }elseif ($this->verb = 'DELETE'){
            //delete some stuff
        }
    }


    public function getRout()
    {
        @list($objnm,$objid) = explode('/',$_GET['route']);
        if ($objnm == ''){
            echo 'ERROR: no object name';
        }

        $flnm = 'data.'.$objnm.'.json';
        $fldt = json_decode(@file_get_contents($flnm));

        if(($this->verb == 'POST') && ($this->verb =='')){
            $putdt = json_decode(file_get_contents('php://input'));
            if ($putdt == ''){
                echo 'ERROR: no data found';
                exit;
            }
            $putdt->id = uniqid();
            $fldt->{$objnm}[]=$putdt;
            file_put_contents($flnm,json_encode($fldt));
            exit;
        }

        if(!isset($fldt->$objnm)){
            if (($this->verb == 'GET') && ($objid =='')){
                echo '[]';
                exit;
            }
        }

        if(($this->verb == 'GET') && ($objid =='')){
            echo json_encode($fldt->$objnm);
            exit;
        }

        if($objid ==''){
            echo 'ERROR: no object id';
        }

        if($this->verb == 'GET'){
            foreach ($fldt->$objnm as $objval){
                if (isset($objval->id) && ($objval->id==$objid)){
                    echo json_encode($objval);
                    exit;
                }
            }
            echo 'ERROR: object not found';
            exit;
        }

        if($this->verb == 'PUT'){
            foreach ($fldt->$objnm as $objkey => $objval){
                if (isset($objval->id) && ($objval->id==$objid)){
                    $putdt = json_decode(file_get_contents('php://input'));
                    if ($putdt==''){
                        echo 'ERROR: no data found';
                        exit;
                    }
                    $fldt->{$objnm}[$objkey]=$putdt;
                    file_put_contents($flnm,json_encode($fldt));
                    exit;
                }
            }
            echo 'ERROR: object not found';exit;
        }

        if($this->verb == 'DELETE'){
            foreach ($fldt->$objnm as $objkey => $objval){
                if ($objval->id==$objid){
                    array_splice($fldt->$objnm,$objkey,1);
                    file_put_contents($flnm,json_encode($fldt));
                    exit;
                }
            }
            echo 'ERROR: object not found';
            exit;
        }

        echo 'ERROR: no method found';
        exit;
    }
}