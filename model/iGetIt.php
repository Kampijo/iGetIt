<?php

class iGetIt {

	public $dbconn;
    public $result;

	public function __construct() {
        	$this->dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
    	}

	public function validateLogin($user, $password){
        $this->result = pg_prepare($this->dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
        $this->result = pg_execute($this->dbconn, "loginQuery", array($user, $password));
        return pg_fetch_array($this->result);
	}
    public function validateUser($user){
        $this->result = pg_prepare($this->dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
        $this->result = pg_execute($this->dbconn, "userQuery", array($user));
        return pg_fetch_array($this->result);
    }
    public function createUser($user, $password, $fName, $lName, $email){
        $this->result = pg_prepare($this->dbconn, "insertUser", "INSERT INTO appuser values($1,$2,$3,$4,$5)");
        $this->result = pg_execute($this->dbconn, "insertUser", array($user, $password, $fName, $lName, $email));
    }
    public function getAvailableClasses(){}
    public function createClass(){}
}
?>
