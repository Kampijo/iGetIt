<?php

require_once "model/iGetIt.php";
require_once "model/validation.php";
session_save_path("sess");
session_start();
ini_set('display_errors', 'On');

$dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
$errors = array();
$view = "";

/* controller code */
if (!isset($_SESSION['state'])) {
    $_SESSION['state'] = 'login';
    $_SESSION['iGetIt'] = new iGetIt();
}

switch ($_SESSION['state']) {
    case "login":
        // the view we display by default
        $view = "login.php";

        // check if submit or not
        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "login" && $_REQUEST['submit'] != "New Member")) {
            break;
        }

        if($_REQUEST['submit']=="login") {

            // validate and set errors
            if (empty($_REQUEST['user'])) {
                $errors[] = 'user is required';
            }
            if (empty($_REQUEST['password'])) {
                $errors[] = 'password is required';
            }

            if (!empty($errors)) break;

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
        $view = "profile.php";

        // check if submit or not
        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "Submit" && $_REQUEST['submit'] != "Class"
                && $_REQUEST['submit'] != "Profile" && $_REQUEST['submit'] != "Logout")
        ) {
            break;
        }
        if ($_REQUEST['submit'] == "Class") {
        }
        if ($_REQUEST['submit'] == "Profile") {
            $_SESSION['state'] = 'profile';
            $view = "profile.php";
        }
        if ($_REQUEST['submit'] == "Logout") {
            session_destroy();
            header("Refresh:0");
        } else {
            if ($_SESSION['iGetIt']->newuser == true) {
                // validate and set errors
                if (empty($_REQUEST['user'])) {
                    $errors[] = 'user is required';
                }
                if (empty($_REQUEST['password'])) {
                    $errors[] = 'password is required';
                }
                if ($row = $_SESSION['iGetIt']->checkUser($dbconn, $_REQUEST['user'])) {
                    $errors[] = 'user already exists';
                }

                // validate user input
                $validation = validateNewProfile($_REQUEST['user'], $_REQUEST['password'], $_REQUEST['firstName'],
                    $_REQUEST['lastName'], $_REQUEST['email']);
                $errors = array_merge($errors, $validation);

                if (!empty($errors)) break;

                // create the user and move to selected landing page (i.e. instructor or student)
                $_SESSION['iGetIt']->createUser($dbconn, $_REQUEST['user'], $_REQUEST['password'], $_REQUEST['firstName'],
                    $_REQUEST['lastName'], $_REQUEST['email'], $_REQUEST['type']);
                if ($_REQUEST['type'] == "instructor") {
                    $_SESSION['state'] = 'instructor_create';
                    $view = "instructor_createclass.php";
                } else {
                    $_SESSION['state'] = 'student_join';
                    $view = "student_joinclass.php";
                }
                $_SESSION['iGetIt']->setInfo($_REQUEST['user'], $_REQUEST['firstName'],
                    $_REQUEST['lastName'], $_REQUEST['email']);
            } else {
                if (empty($_REQUEST['password'])) {
                    $errors[] = 'password is required';
                }
                $validation = validateNewForm($_REQUEST['password']);
                $errors = array_merge($errors, $validation);
                if (!empty($errors)) break;

                $_SESSION['iGetIt']->updateProfile($dbconn, $_REQUEST['password'], $_REQUEST['firstName'],
                    $_REQUEST['lastName'], $_REQUEST['email']);
                if ($_SESSION['iGetIt']->type == "instructor") {
                    $_SESSION['state'] = 'instructor_create';
                    $view = "instructor_createclass.php";
                } else {
                    $_SESSION['state'] = 'student_join';
                    $view = "student_joinclass.php";
                }
            }
        }

        break;

    case "instructor_create":

        $view = "instructor_createclass.php";

        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "create" && $_REQUEST['submit'] != "join" && $_REQUEST['submit'] != "Class"
                && $_REQUEST['submit'] != "Profile" && $_REQUEST['submit'] != "Logout")
        ) {
            break;
        }

        if ($_REQUEST['submit'] == "Class") {
        }
        if ($_REQUEST['submit'] == "Profile") {
            $_SESSION['state'] = 'profile';
            $view = "profile.php";
        }
        if ($_REQUEST['submit'] == "Logout") {
            session_destroy();
            header("Refresh:0");
        }
        // if submission is a create class request
        if ($_REQUEST['submit'] == "create") {
            if (empty($_REQUEST['class'])) {
                $errors[] = 'class name required';
            }
            if (empty($_REQUEST['code'])) {
                $errors[] = 'code required';
            }
            if (!empty($errors)) break;

            $instructor = $_SESSION['firstName'] . " " . $_SESSION['lastName'];
            $_SESSION['iGetIt']->createClass($dbconn, $_REQUEST['class'], $instructor, $_REQUEST['code']);
            $_SESSION['state'] = 'instructor_current';
            $view = "instructor_currentclass.php";

            // if submission is a check class request
        } else {
            if (empty($_REQUEST['code'])) {
                $errors[] = 'code required';
            }
            if ($row = $_SESSION['iGetIt']->checkClass($dbconn, $_REQUEST['courses'], $_REQUEST['code'])) {
                $_SESSION['state'] = 'instructor_current';
                $view = "instructor_currentclass.php";
            } else {
                $errors[] = 'incorrect code';
            }

        }

        break;

    case "student_join":

        $view = "student_joinclass.php";

        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "join" && $_REQUEST['submit'] != "Class"
                && $_REQUEST['submit'] != "Profile" && $_REQUEST['submit'] != "Logout")
        ) {
            break;
        }

        if (!empty($errors)) break;

        if ($_REQUEST['submit'] == "Class") {
        }
        if ($_REQUEST['submit'] == "Profile") {
            $_SESSION['state'] = 'profile';
            $view = "profile.php";
        }
        if ($_REQUEST['submit'] == "Logout") {
            session_destroy();
            header("Refresh:0");
        } else {
            if (empty($_REQUEST['code'])) {
                $errors[] = 'code required';
            }
            if ($row = $_SESSION['iGetIt']->checkClass($dbconn, $_REQUEST['courses'], $_REQUEST['code'])) {
                $_SESSION['state'] = 'student_current';
                $view = "student_currentclass.php";
            } else {
                $errors[] = 'incorrect code';
            }
        }


        break;

    case "instructor_current":

        $view = "instructor_currentclass.php";

        // check if submit or not
        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "Submit" && $_REQUEST['submit'] != "Class"
                && $_REQUEST['submit'] != "Profile" && $_REQUEST['submit'] != "Logout")
        ) {
            break;
        }
        if ($_REQUEST['submit'] == "Class") {
        }
        if ($_REQUEST['submit'] == "Profile") {
            $_SESSION['state'] = 'profile';
            $view = "profile.php";
        }
        if ($_REQUEST['submit'] == "Logout") {
            session_destroy();
            header("Refresh:0");
        }

        break;

    case "student_current":

        $view = "student_currentclass.php";

        // check if submit or not
        if (empty($_REQUEST['submit']) || ($_REQUEST['submit'] != "Submit" && $_REQUEST['submit'] != "Class"
                && $_REQUEST['submit'] != "Profile" && $_REQUEST['submit'] != "Logout")
        ) {
            break;
        }
        if ($_REQUEST['submit'] == "Class") {
        }
        if ($_REQUEST['submit'] == "Profile") {
            $_SESSION['state'] = 'profile';
            $view = "profile.php";
        }
        if ($_REQUEST['submit'] == "Logout") {
            session_destroy();
            header("Refresh:0");
        }

        break;


}
require_once "view/view_lib.php";
require_once "view/$view";
?>
