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

    public static function findOrder(User $user, $orderId){
        $order = self::model()->findAll(["user" => $user->id, "id" => $orderId]);

        if(isset($order[0])){
            $orderObj = new self; //Order
            foreach ($order[0] as $k => $v){
                $orderObj->$k = $v;
            }
            return $orderObj;
        }else{
            return null;
        }
    }

}
