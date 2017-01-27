<?php

	require_once "model/GuessGame.php";
	session_save_path("sess");
	session_start(); 	
	$dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
	ini_set('display_errors', 'On');

	$errors=array();
	$view="";

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
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
			
			$result = pg_prepare($dbconn, "loginQuery", "SELECT * FROM appuser where username=$1 and password=$2");
			$result = pg_execute($dbconn, "loginQuery", array($_REQUEST['user'], $_REQUEST['password']));

			// perform operation, switching state and view if necessary
			if($row = pg_fetch_array($result)){
				$_SESSION['state']='profile';
				$view="profile.php";
			} else {
				$result = pg_prepare($dbconn, "userQuery", "SELECT * FROM appuser where username=$1");
				$result = pg_execute($dbconn, "userQuery", array($_REQUEST['user']));
				
				if($row = pg_fetch_array($result)){
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
  
              // validate and set errors
              if(empty($_REQUEST['password'])){
                  $errors[]='password is required';
              }
			
              if(!empty($errors))break;
			
			
			break;

	}
	require_once "view/view_lib.php";
	require_once "view/$view";
?>
