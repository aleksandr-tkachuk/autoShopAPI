<?php

abstract class Models{
    
    private $db;
    private static  $_models = [];


    abstract public function getTableName();
    
    public function __construct(){
        $this->db = App::$db;
    }
    
    public static function model($className = __CLASS__){
        if(isset(self::$_models[$className])){
            return self::$_models[$className];
        }else{
            self::$_models[$className] = new $className();
            return self::$_models[$className];
        }
    }

        public function findAll($params = [], $orders = []){
        $sql = "select * from ".$this->getTableName();
        
        if(count($params) != 0){
            $where = " where ";
            $ind = 0;
            foreach ($params as $key => $val){
                if($ind != 0){
                    $where .= " and ";
                }
                $where .= $key."='".$val."'";
                $ind++;
            }
            
            $sql .= $where;
        }
        
        if(count($orders) != 0){
            $order = " order by ";
            $ind = 0;
            foreach ($orders as $key => $val){
                if($ind != 0){
                    $order .= ", ";
                }
                $order .= $key." ".$val;
                $ind++;
            }
            $sql .= $order;
        }
        $sqlResult = $this->db->select($sql);
        return $sqlResult;
        
    }
    
    public function find($id, $array = false){
        /*
        $sql = "select * from ".$this->getTableName()." where ".$this->getTableName()."_id = ".$id;
        $sqlResult = $this->db->select($sql, TRUE);
        */
		$sql = $this->db->prepare("select * from ".$this->getTableName()." where id = ?");
		$sql->execute(array($id));
		$sqlResult = $sql->fetch(PDO::FETCH_ASSOC);
		if($array == false) {
            if (sizeof($sqlResult) != 0) {
                foreach ($sqlResult as $attr => $value) {
                    $this->$attr = $value;
                }

                return $this;
            } else {
                return null;
            }
        }else{
            if (sizeof($sqlResult) != 0) {
                return $sqlResult;
            } else {
                return [];
            }
        }
    }
    
    public function save(){
        $id = $this->getTableName()."_id";
        if($this->$id != 0){
            $this->update();
        }else{
            $this->insert();
        }
    }
    
    
    private function update(){
        $sql = "update ".$this->getTableName()." set ";
        $fields = "";
        $comma = 0;
        foreach ($this as $attr => $value){
            if($attr != "db"){
                if($comma != 0){
                    $fields .= ",";
                }
                $fields .= $attr.'="'.$value.'"';
                $comma++;
            }
        }
        $id = $this->getTableName()."_id";
        $sql .= $fields." where ".$this->getTableName()."_id=".$this->$id;
        $this->db->sqlQuery($sql);
    }

    private function insert(){
        $sql = "insert into `".$this->getTableName()."`";
        $fields = "";
        $values = "";
        $comma = 0;
        foreach ($this as $attr => $value){
            if($attr != $this->getTableName()."_id" && $attr != "db"){
                if($comma != 0){
                    $fields .= ",";
                    $values .= ",";
                }
                $fields .= '`'.$attr.'`';
                $values .= "'".$value."'";
                $comma++;
            }
        }
        $sql = $sql." ($fields) values ($values)";
        $this->db->sqlQuery($sql);
        $this->id = $this->db->lastId();
    }
    
    public function delit() {
        $id = $this->getTableName()."_id";
//        $sql = "DELETE FROM ".$this->getTableName()." WHERE ".$this->getTableName()."_id=".$this->$id;
		$sql = $this->db->prepare("DELETE FROM ".$this->getTableName()." where ".$this->getTableName()."_id = ?");
		$sql->execute(array($id));

		$result = $this->db->sqlQuery($sql);
           if($result == TRUE){
               echo '<h1>удален!</h1>';
           }
    }

    
}