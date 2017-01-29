<?php
require_once "validation.php";
class iGetIt {

    public $user="", $firstName="", $lastName="", $email="", $current_course="";
    public $newuser=true;

	public function __construct() {

    }
    public function setInfo($user, $firstName, $lastName, $email){
        $this->user=$user;
        $this->firstName=$firstName;
        $this->lastName=$lastName;
        $this->email=$email;
        $this->newuser=false;
    }
    public function setCurrentCourse($course){
        $this->current_course=$course;
    }
    public function extractInfo($row){
        $this->user=$row['username'];
        $this->firstName=$row['fname'];
        $this->lastName=$row['lname'];
        $this->email=$row['email'];
        $this->newuser=false;
    }
	public function checkLogin($dbconn, $user, $password){
        $user=sanitizeInput($user);
        $password=sanitizeInput($password);
        $result = pg_prepare($dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
        $result = pg_execute($dbconn, "loginQuery", array($user, $password));
        return pg_fetch_array($result);
	}
    public function checkUser($dbconn, $user){
	    $user=sanitizeInput($user);
        $result = pg_prepare($dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
        $result = pg_execute($dbconn, "userQuery", array($user));
        return pg_fetch_array($result);
    }
    public function createUser($dbconn, $user, $password, $fName, $lName, $email, $type){

        $user=sanitizeInput($user);
        $password=sanitizeInput($password);
        $fName=sanitizeInput($fName);
        $lName=sanitizeInput($lName);
        $email=sanitizeInput($email);

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
        $this->current_course=$name . " " . $instructor;
    }
    public function checkClass($dbconn, $name, $code){
        $result = pg_prepare($dbconn, "checkClass", "SELECT * FROM classes where name=$1 and code=$2");
        $result = pg_execute($dbconn, "checkClass", array($name,$code));
        $row = pg_fetch_array($result);
        $this->current_course=$row['name'] . " " . $row['instructor'];
        return $row;
    }
    public function studentResponse($dbconn,$response){
        if($response=="I Get It"){
            $result = pg_prepare($dbconn, "theyGetIt", "UPDATE classes SET igetit=igetit+1 WHERE CONCAT(name, ' ', instructor) = $1");
            $result = pg_execute($dbconn, "theyGetIt", array($this->current_course));
        } else {
            $result = pg_prepare($dbconn, "theyDontGetIt", "UPDATE classes SET idontgetit=idontgetit+1 WHERE CONCAT(name, ' ', instructor) = $1");
            $result = pg_execute($dbconn, "theyDontGetIt", array($this->current_course));
        }
    }
    public function getPositivePercent($dbconn){
        $result = pg_prepare($dbconn, "positiveResponse", "SELECT * from classes WHERE CONCAT(name, ' ', instructor) = $1");
        $result = pg_execute($dbconn, "positiveResponse", array($this->current_course));

        $row=pg_fetch_array($result);
        $positive=$row['igetit'];
        $negative=$row['idontgetit'];

        return $positive/($positive+$negative);
    }
}
?>
