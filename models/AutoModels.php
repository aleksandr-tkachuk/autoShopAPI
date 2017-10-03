<?php

class AutoModels extends Models{
    
    public $id = 0;
    public $name;

    public function getTableName(){
        return "models";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    
}
