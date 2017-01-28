<?php

class iGetIt {

	public function __construct() {

    }
    public function validateInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    public function validateForm($user, $password, $fName, $lName, $email){
        $user=$this->validateInput($user);
        $password=$this->validateInput($password);
        $fName=$this->validateInput($fName);
        $lName=$this->validateInput($lName);
        $email=$this->validateInput($email);

        $errors=array();
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $user)) {
            $errors[]='username can only contain letters and numbers';
        }
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $password)) {
            $errors[]='password can only contain letters and numbers';
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $fName)) {
            $errors[]='first name can only contain letters';
        }
        if (!preg_match("/^[a-zA-Z ]*$/", $lName)) {
            $errors[]='last name can only contain letters';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email";
        }
        return $errors;
    }
	public function checkLogin($dbconn, $user, $password){
        $user=$this->validateInput($user);
        $password=$this->validateInput($password);
        $result = pg_prepare($dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
        $result = pg_execute($dbconn, "loginQuery", array($user, $password));
        return pg_fetch_array($result);
	}
    public function checkUser($dbconn, $user){
	    $user=$this->validateInput($user);
        $result = pg_prepare($dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
        $result = pg_execute($dbconn, "userQuery", array($user));
        return pg_fetch_array($result);
    }
    public function createUser($dbconn, $user, $password, $fName, $lName, $email, $type){
        $user=$this->validateInput($user);
        $password=$this->validateInput($password);
        $fName=$this->validateInput($fName);
        $lName=$this->validateInput($lName);
        $email=$this->validateInput($email);
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
