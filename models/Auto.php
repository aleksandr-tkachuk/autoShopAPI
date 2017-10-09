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

    public function getList()
    {
        $listAuto = parent::findAll();
        var_dump($listAuto);
        $result = [];
        foreach ($listAuto as $key=>$value){
            $model = AutoModels::model()->find($value['model'], true);
            $result[] = [
                'id' => $value['id'],
                'brand' => $value['brand'],
                'modelName' => $model["name"],
            ];
        }
        return $result;
    }

}
