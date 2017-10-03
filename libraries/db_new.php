<?php
class db_new extends PDO{

	public function __construct($config){
		$dns = $config['driver'] .
			':host=' . $config['host'] .
			((!empty($config['port'])) ? (';port=' . $config['port']) : '') .
			';dbname=' . $config['dbname'] .
			((!empty($config['charset'])) ? (';charset=' . $config['charset']) : '');

		parent::__construct($dns, $config['username'], $config['password']);
	}

	public function select($sql, $single = false){
		if(trim($sql) == "") return [];
//echo $sql;
		$result = $this->query($sql, PDO::FETCH_ASSOC);
		if($result) {
            $rows = [];
            foreach ($result as $row) {
                $rows[] = $row;
            }

            if ($single) {
                return (isset($rows[0])) ? $rows[0] : [];
            }
            return $rows;
        }else{
		    return [];
        }
	}

	public function lastId() {
		return $this->lastInsertId();
	}

	public function sqlQuery($sql) {
		return $this->exec($sql);
	}

	public function getError() {
		return $this->errorInfo();
	}

}

