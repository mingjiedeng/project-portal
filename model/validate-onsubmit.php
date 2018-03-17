<?php

//include validation functions
include_once "model/validation.php";

if(isset($post))
{
    //array for collecting errors
    $errors = array();

    //push errors into the array based on the input error
    if(!validString($post['pTitle'])) {
        array_push($errors, "title:Missing title");
    }
    if(empty($post['description'])){
        array_push($errors, "description:Missing description field");
    }
    if(!validLink($post['url'])) {
        array_push($errors, "project-link:Missing project link");
    }
    if(!validLink($post['trello'])) {
        array_push($errors, "torelo-link:Missing trello link");
    }
    if(!empty($post['github']) && !validLink($post['github'])) {
        array_push($errors, "github-link:Missing github link");
    }
    if(!validString($post['cName'])) {
        array_push($errors, "company:Missing company name");
    }
    if(!validString($post['cLocation'])) {
        array_push($errors, "location:Missing location field");
    }
    if(!validLink($post['cSite'])) {
        array_push($errors, "site-url:Missing site url");
    }
    if($post['status'] == 'none') {
        array_push($errors, "status:Please select the project status");
    }

    //validate class information
    $classIndex = 1; $quarterIndex = 1; $instructorIndex = 1;
    while($classIndex < sizeof($post['className']) + 1) {
        if(empty($post['className'][$classIndex - 1]))
            array_push($errors, 'classname_'. $classIndex .':Missing class name');
        if(empty($post['quarter'][$quarterIndex - 1]))
            array_push($errors, 'quarter_'. $quarterIndex .':Missing quarter');
        if(empty($post['instructor'][$instructorIndex - 1]))
            array_push($errors, 'instructor_'. $instructorIndex .':Missing instructor');

        $classIndex++; $quarterIndex++; $instructorIndex++;
    }

    //validate contact information
    $cNameIndex = 1; $cTitleIndex = 1; $cPhone = 1; $cEmail = 1;
    while($cNameIndex < sizeof($post['contactName']) + 1) {
        if(empty($post['contactName'][$cNameIndex - 1]))
            array_push($errors, 'clientname_'. $cNameIndex .':Missing client name');
        if(empty($post['title'][$cTitleIndex - 1]))
            array_push($errors, 'clienttitle_'. $cTitleIndex .':Missing client title');
        if(empty($post['phone'][$cPhone - 1]))
            array_push($errors, 'phone_'. $cPhone .':Missing phone');
        if(empty($post['email'][$cEmail - 1]))
            array_push($errors, 'email_'. $cEmail .':Missing email');

        $cNameIndex++; $cTitleIndex++; $cPhone++; $cEmail++;
    }

    echo json_encode($errors); //send errors data to ajax request in json form


    //make sure we have no errors
    $success = sizeof($errors) == 0;
}