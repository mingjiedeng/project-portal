<?php
//include validation functions
include_once "model/validation.php";

$postArray = $_POST; //get post array

//validate credentials after user hit add button
if(isset($postArray['addCred']))
{
    if(empty($postArray['username']) || empty($postArray['password'])) {
        echo "Incorrect username or password";
    } else {
        echo 'success-Username: '.$postArray['username'].' Password: '.$postArray['password'];
    }
}
else if(isset($postArray['remove'])) { //remove login info
    //unset variables
    unset($postArray['username']);
    unset($postArray['password']);
}

//set username and password
$userName = $postArray['username'];
$password = $postArray['password'];
