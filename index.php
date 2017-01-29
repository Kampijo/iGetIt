<?php

	require_once "model/iGetIt.php";
	require_once "model/validation.php";
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
			if(empty($_REQUEST['submit']) || ($_REQUEST['submit']!="login" && $_REQUEST['submit']!="New Member")){
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

			if($_REQUEST['submit']=="login") {
                // checks user login, and if exists, then go to landing page
                if ($row = $_SESSION['iGetIt']->checkLogin($dbconn, $_REQUEST['user'], $_REQUEST['password'])) {
                    if ($row['type'] == "instructor") {
                        $_SESSION['state'] = 'instructor_create';
                        $view = "instructor_createclass.php";
                    } else {
                        $_SESSION['state'] = 'student_join';
                        $view = "student_joinclass.php";
                    }
                    $_SESSION['iGetIt']->extractInfo($row);

                    // Otherwise, invalid login
                } else {
                    $errors[] = 'invalid login';
                }
            } else {
			    $_SESSION['state'] = 'profile';
			    $view = "profile.php";
            }
			break;

		case "profile":
			// the view we display by default
			$view="profile.php";
			
			  // check if submit or not
              if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="Submit") {
                  break;
              }
              // validate and set errors
              if(empty($_REQUEST['user'])) {
                  $errors[] = 'password is required';
              } if(empty($_REQUEST['password'])){
                  $errors[]='password is required';
              } if(empty($_REQUEST['firstName'])){
                  $errors[]='first name is required';
              } if (empty($_REQUEST['lastName'])){
                  $errors[]='last name is required';
              } if($row = $_SESSION['iGetIt']->checkUser($dbconn,$_REQUEST['user'])){
                  $errors[]='user already exists';
              }

              // validate user input
              $validation=validateForm($_REQUEST['user'],$_REQUEST['password'],$_REQUEST['firstName'],
                  $_REQUEST['lastName'],$_REQUEST['email']);
              $errors=array_merge($errors,$validation);

            if(!empty($errors))break;

            // create the user and move to selected landing page (i.e. instructor or student)
            $_SESSION['iGetIt']->createUser($dbconn,$_REQUEST['user'],$_REQUEST['password'],$_REQUEST['firstName'],
                    $_REQUEST['lastName'],$_REQUEST['email'],$_REQUEST['type']);
            if($_REQUEST['type']=="instructor"){
                $_SESSION['state']='instructor_create';
                $view="instructor_createclass.php";
            }else{
                $_SESSION['state']='student_join';
                $view="student_joinclass.php";
            }
            $_SESSION['iGetIt']->setInfo($_REQUEST['user'],$_REQUEST['firstName'],
                $_REQUEST['lastName'],$_REQUEST['email']);

			break;

        case "instructor_create":

            $view="instructor_createclass.php";

            if(empty($_REQUEST['submit']) || ($_REQUEST['submit']!="create" && $_REQUEST['submit']!="join")){
                break;
            }

            if (empty($_REQUEST['code'])) {
                $errors[] = 'code required';
            }

            if(!empty($errors))break;

            // if submission is a create class request
            if($_REQUEST['submit']=="create"){
                if(empty($_REQUEST['class'])) {
                    $errors[] = 'class name required';
                    break;
                }
                $instructor=$_SESSION['firstName'] . " " . $_SESSION['lastName'];
                $_SESSION['iGetIt']->createClass($dbconn,$_REQUEST['class'], $instructor, $_REQUEST['code']);
                $_SESSION['state']='instructor_current';
                $view="instructor_currentclass.php";

                // if submission is a check class request
            } else {
                if($row = $_SESSION['iGetIt']->checkClass($dbconn,$_REQUEST['courses'],$_REQUEST['code'])){
                    $_SESSION['state']='instructor_current';
                    $view="instructor_currentclass.php";
                } else {
                    $errors[]= 'incorrect code';
                }

            }

            break;

        case "student_join":

            $view="student_joinclass.php";

            if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="join"){
                break;
            }

            if (empty($_REQUEST['code'])) {
                $errors[] = 'code required';
            }

            if(!empty($errors))break;

            if($row = $_SESSION['iGetIt']->checkClass($dbconn,$_REQUEST['courses'],$_REQUEST['code'])){
                $_SESSION['state']='student_current';
                $view="student_currentclass.php";
            } else {
                $errors[]= 'incorrect code';
            }


            break;

        case "instructor_current":

            $view="instructor_currentclass.php";

            break;

        case "student_current":

            $view="student_currentclass.php";

            break;


	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
