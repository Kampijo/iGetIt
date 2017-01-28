<?php

class iGetIt {

	public function __construct() {

    }

	public function validateLogin($dbconn, $user, $password){
        $result = pg_prepare($dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
        $result = pg_execute($dbconn, "loginQuery", array($user, $password));
        return pg_fetch_array($result);
	}
    public function validateUser($dbconn, $user){
        $result = pg_prepare($dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
        $result = pg_execute($dbconn, "userQuery", array($user));
        return pg_fetch_array($result);
    }
    public function createUser($dbconn, $user, $password, $fName, $lName, $email, $type){
        $result = pg_prepare($dbconn, "insertUser", "INSERT INTO appuser values($1,$2,$3,$4,$5,$6)");
        $result = pg_execute($dbconn, "insertUser", array($user, $password, $fName, $lName, $email, $type));
    }
    public function getAvailableClasses($dbconn){
        $result = pg_prepare($dbconn, "getClasses", "SELECT * FROM classes");
        $result = pg_execute($dbconn, "getClasses", array());
        return $result;
    }
    public function createClass($dbconn, $name, $instructor, $code){
        $result = pg_prepare($dbconn, "insertClass", "INSERT INTO classes values($1,$2,$3,$4,$5)");
        $result = pg_execute($dbconn, "insertClass", array($name,$instructor,$code,0,0));
    }
    public function checkClass($dbconn, $name, $code){
        $result = pg_prepare($dbconn, "checkClass", "SELECT * FROM classes where name=$1 and code=$2");
        $result = pg_execute($dbconn, "checkClass", array($name,$code));
        return pg_fetch_array($result);
    }
}
?>
