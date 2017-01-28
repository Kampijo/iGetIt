<?php

    function sanitizeInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    function validateForm($user, $password, $fName, $lName, $email){
        $user=$this->sanitizeInput($user);
        $password=$this->sanitizeInput($password);
        $fName=$this->sanitizeInput($fName);
        $lName=$this->sanitizeInput($lName);
        $email=$this->sanitizeInput($email);

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
            $errors[] = "invalid email";
        }
        return $errors;
    }
?>