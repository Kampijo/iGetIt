<?php

	require_once "model/iGetIt.php";
	session_save_path("sess");
	session_start();
	ini_set('display_errors', 'On');

    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
	$errors=array();
	$view="";

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
		$_SESSION['iGetIt']=new iGetIt();
	}

	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;

			// checks user login, and if exists, then go to landing page
			if($row = $_SESSION['iGetIt']->validateLogin($dbconn,$_REQUEST['user'], $_REQUEST['password'])){
			    if($row["type"]=="instructor"){
                    $_SESSION['state']='instructor_create';
                    $view="instructor_createclass.php";
                } else {
                    $_SESSION['state']='student_join';
                    $view="student_joinclass.php";
                }
                // if does not exist, then go to profile
			} else {
				if($row = $_SESSION['iGetIt']->validateUser($dbconn,$_REQUEST['user'])){
					$errors[]='invalid login';
				} else {
					$_SESSION['state']='profile';
					$view="profile.php";
				}
			}
			break;

		case "profile":
			// the view we display by default
			$view="profile.php";
			
			  // check if submit or not
              if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="Submit"){
                  break;
              }
              if(!empty($errors))break;
  
              // validate and set errors
              if(empty($_REQUEST['user'])) {
                  $errors[] = 'password is required';
              } if(empty($_REQUEST['password'])){
                  $errors[]='password is required';
              } if(empty($_REQUEST['firstName'])){
                $errors[]='first name is required';
              } if (empty($_REQUEST['lastName'])){
                  $errors[]='last name is required';
              } if (empty($_REQUEST['email'])){
                  $errors[]='email is required';
              }

              // check if username taken
            if($row = $_SESSION['iGetIt']->validateUser($dbconn,$_REQUEST['user'])){
                  $errors[]='user already exists';

              // Otherwise, create the user and move to selected landing page (i.e. instructor or student)
            } else {
                $_SESSION['iGetIt']->createUser($dbconn,$_REQUEST['user'],$_REQUEST['password'],$_REQUEST['firstName'],
                    $_REQUEST['lastName'],$_REQUEST['email']);
                if($_REQUEST['type']=="instructor"){
                    $_SESSION['state']='instructor_create';
                    $view="instructor_createclass.php";
                }else{
                    $_SESSION['state']='student_join';
                    $view="student_joinclass.php";
                }
            }
			break;

        case "instructor_create":

            $view="instructor_createclass.php";

            break;

        case "student_join":

            $view="student_joinclass.php";

	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
