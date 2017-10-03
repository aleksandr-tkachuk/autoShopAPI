<?php
class db {
    private $mysql = null;
    function __construct($param = []) {
        $this->mysql = mysqli_connect(
                $param['host'],
                $param['user'],
                $param['password'],
                $param['d_base']);
        if (mysqli_connect_errno($this->mysql)) {
            echo "Не удалось подключиться к MySQL: " . mysqli_connect_error();
        }
        mysqli_set_charset($this->mysql , "utf8" );
        $er = mysqli_select_db($this->mysql, $param['d_base']) or die("Ошибка в выборе базы");
    }
    public function select($sql, $single = FALSE) {
        if(trim($sql) == "") return [];
        
        $result = mysqli_query($this->mysql, $sql);
        $rows = [];
        if($result){
            while ($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            if($single){
                return (isset($rows[0])) ? $rows[0] : [];
            }
        }
        return $rows;
    }
    
    public function lastInsertId() {
        $result = mysqli_insert_id($this->mysql);
      
        return $result;
    }
    
    public function query($sql) {
        return mysqli_query($this->mysql, $sql);
    }
    
    public function getError() {
        return mysqli_error($this->mysql);
    }
    
}

