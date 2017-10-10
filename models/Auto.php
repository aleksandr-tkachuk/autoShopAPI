<?php

class Auto extends Models{
    
    public $id = 0;
    public $model;
    public $year;
    public $engine;
    public $color;
    public $kpp;
    public $speed;
    public $price;
    public $brands;

    public function getTableName(){
        return "auto";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function findAll($params = [], $orders = [])
    {
        $listAuto = parent::findAll($params, $orders);
        foreach ($listAuto as $key=>$value){
            $model = AutoModels::model()->find($value['model'], true);

            $listAuto[$key]['modelName'] = $model["name"];
        }
        return $listAuto;
    }

    public function findById($id)
    {
        $auto = parent::model()->find($id, true);
        $model = AutoModels::model()->find($auto['model'], true);
        $auto['modelName'] = $model["name"];

        return $auto;
    }

    public static function findBrand($brand){
        $brand = AutoModels::model()->findAll(["name" => $brand]);

        if(sizeof($brand) == 0){
            return false;
        }else{
            $sql = "SELECT models.name as modelName, auto.* 
                FROM models
                right join auto on models.id = auto.model
                WHERE models.id = '".$brand[0]["id"]."'";

            $result = App::$db->select($sql);
            return $result;
        }
        /*
        $sql = "SELECT models.name as modelName, auto.* 
                FROM models
                right join auto on models.id = auto.model
                WHERE models.name = '".$brand."'";
       */

        //$result = App::$db->select($sql);
        //return $result;
    }

    public function getList()
    {
        $listAuto = parent::findAll();
        var_dump($listAuto);
        $result = [];
        foreach ($listAuto as $key=>$value){
            $model = AutoModels::model()->find($value['model'], true);
            $result[] = [
                'id' => $value['id'],
                'brand' => $value['brands'],
                'brand' => $value['brand'],
                'modelName' => $model["name"],
            ];
        }
        return $result;
    }

}
