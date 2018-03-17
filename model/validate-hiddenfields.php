<?php
//include validation functions
include_once "model/validation.php";

$post = $_POST; //get post array

//arrays for holding contacts info
$contactName = array();
$title = array();
$phone = array();
$email = array();

//validate credentials after user hit add button
if(isset($post['addCred']))
{
    if(empty($post['username']) || empty($post['password'])) {
        echo "Incorrect username or password";
    } else {
        echo 'success-Username: '.$post['username'].' Password: '.$post['password'];
    }
}
else if(isset($post['remove'])) { //remove login info
    //unset variables
    unset($post['username']);
    unset($post['password']);
}

//validate contacts information
if(isset($post['addContact']))
{
    if(!ctype_alpha($post['contactName1']) || !ctype_alpha($post['title1']) ||
        !ctype_digit($post['phone1']) || !validEmail($post['email1'])) {
        echo "Incorrect contact information";
    } else {
        echo 'success-Name: '.$post['contactName'].' | Title: '.$post['title'];
        array_push($contactName, $post['contactName1']);
        array_push($title, $post['title1']);
        array_push($phone, $post['phone1']);
        array_push($email, $post['email1']);
    }
}

//set username and password
$userName = $post['username'];
$password = $post['password'];