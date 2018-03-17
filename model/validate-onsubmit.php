<?php

//include validation functions
include_once "model/validation.php";

if(isset($post))
{
    //array for collecting errors
    $errors = array();

    //push errors into the array based on the input error
    if(!validString($post['pTitle'])) {
        array_push($errors, "title:Title is not valid");
    }
    if(!validString($post['description'])){
        array_push($errors, "description:Description is not valid");
    }
    if(!validLink($post['url'])) {
        array_push($errors, "project-link:Project link is not valid");
    }
    if(!validLink($post['trello'])) {
        array_push($errors, "torelo-link:Trello link is not valid");
    }
    if(!empty($post['github']) && !validLink($post['github'])) {
        array_push($errors, "github-link:Github link is not valid");
    }
    if(!validString($post['cName'])) {
        array_push($errors, "company:Company name is not valid");
    }
    if(!validString($post['cLocation'])) {
        array_push($errors, "location:location is not valid");
    }
    if(!validLink($post['cSite'])) {
        array_push($errors, "site-url:Site url is not valid");
    }
    if(!validString($post['contactName'])) {
        array_push($errors, "client-name:Client name is not valid");
    }
    if(!validString($post['title'])) {
        array_push($errors, "client-title:Title is not valid");
    }
    if(!ctype_digit($post['phone']) || strlen($post['phone']) < 9 || strlen($post['phone']) > 10) {
        array_push($errors, "phone:Invalid Phone");
    }
    if(!validEmail($post['email'])) {
        array_push($errors, "email:Invalid email");
    }
    if($post['status'] == 'none') {
        array_push($errors, "status:Please select the project status");
    }

    //validate class fields
    $classes = array_merge($post['className'], $post['quarter'], $post['instructor']);
    $classErr = false;
    foreach ($classes as $class) {
        if(empty($class)) {
            array_push($errors, 'classname_0:Missing class fields');
            $classErr = true;
        }
    }
    if(!$classErr) //set class fields 'no error' message
        array_push($errors, 'classname_0:');

    echo json_encode($errors); //send errors data to ajax request in json form

    if(!$classErr) { //unset class field 'no error' message after sending data
        $index = array_search("classname_0:", $errors);
        unset($errors[$index]);
    }

    //make sure we have no errors
    $success = sizeof($errors) == 0;
}