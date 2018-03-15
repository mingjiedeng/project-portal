<?php
//include validation functions
include_once "model/validation.php";

$post = $_POST;

if(isset($post['submit']))
{
    if(empty($post['username']) || empty($post['password'])) {
        echo "Incorrect username or password";
    } else {
        echo "success";
    }
}