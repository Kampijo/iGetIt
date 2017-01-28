<?php

class iGetIt {

    public $dbconn;
	public function __construct($dbconn) {
        $this->dbconn=$dbconn;
    }

	public function validateLogin($user, $password){
        $result = pg_prepare($this->dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
        $result = pg_execute($this->dbconn, "loginQuery", array($user, $password));
        return pg_fetch_array($result);
	}
    public function validateUser($user){
        $result = pg_prepare($this->dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
        $result = pg_execute($this->dbconn, "userQuery", array($user));
        return pg_fetch_array($result);
    }
    public function createUser($user, $password, $fName, $lName, $email, $type){
        $result = pg_prepare($this->dbconn, "insertUser", "INSERT INTO appuser values($1,$2,$3,$4,$5,$6)");
        $result = pg_execute($this->dbconn, "insertUser", array($user, $password, $fName, $lName, $email, $type));
    }
    public function getAvailableClasses(){
        $result = pg_prepare($this->dbconn, "getClasses", "SELECT * FROM classes");
        $result = pg_execute($this->dbconn, "getClasses", array());
        return $result;
    }
    public function createClass(){}
}
?>
