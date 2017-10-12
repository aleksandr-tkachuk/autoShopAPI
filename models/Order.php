<?php

class Order extends Models{
    
    public $id = 0;
    public $user;
    public $auto;
    public $date;


    public function getTableName(){
        return "`order`";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }


    
}
