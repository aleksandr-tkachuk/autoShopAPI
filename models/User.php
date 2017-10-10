<?php

class User extends Models{
    
    public $id = 0;
    public $login;
    public $password;
    public $name;
    public $token;

    public function getTableName(){
        return "user";
    }
    
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function findByToken($token){
        $sql = App::$db->prepare("select * from ".$this->getTableName()." where token = ?");
        $sql->execute(array($token));
        $sqlResult = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sqlResult) {
            foreach ($sqlResult as $attr => $value) {
                $this->$attr = $value;
            }

            return $this;
        } else {
            return null;
        }
    }

    public function findByLogin($login){
            $sql = App::$db->prepare("select * from ".$this->getTableName()." where login = ?");
            $sql->execute(array($login));
            $sqlResult = $sql->fetch(PDO::FETCH_ASSOC);

                if ($sqlResult) {
                    foreach ($sqlResult as $attr => $value) {
                        $this->$attr = $value;
                    }

                    return $this;
                } else {
                    return null;
                }
    }

   public function generateToken($length = 15){
       $token = "";
       $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
       $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
       $codeAlphabet.= "0123456789";
       $max = strlen($codeAlphabet); // edited

       for ($i=0; $i < $length; $i++) {
           $token .= $codeAlphabet[$this->cryptoRrandSecure(0, $max-1)];
       }

       return $token;
   }

    private function cryptoRrandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }


}
