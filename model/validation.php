<?php

$input = $_POST[input];
$name = $_POST[name];

//validate alphanumeric field
function validString($str)
{
    return ctype_alnum(str_replace(' ', '', $str));
}

//validate numeric fields
function validDigit($num)
{
    return ctype_digit($num);
}

//validate title, name, and description
function validateAlphaNum($name, $input)
{
    if($name == 'company')
        $name.= ' name';
    if(empty($input))
        echo "Missing $name";
    else if(!validString($input))
        echo "$name not valid";
}

//validate class info
function validateClassInfo($name, $input)
{
    if(empty($input))
        echo "Missing $name";
    else if(!validString($input))
        echo "Invalid $name";
}

//validate url links
function validLink($link)
{
    $regexp = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
    return preg_match($regexp, $link);
}

//validate email
function validEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

//validate project status
$projectStatus = array("Pending", "Active", "Maintenance", "Retired");
//echo json_encode($projectStatus);
if($name == 'status') {
    if(!in_array($input, $projectStatus))
        echo "Please select the project status";
}

//validate titles, names, and description
if($name == 'title' || $name == 'description' || $name == 'company'
    || $name == 'client-title' || $name == 'client-name') {
    validateAlphaNum($name, $input);
}
else if($name == 'note') { //validate project note
    if(!empty($input) && !validString($input))
        echo "Invalid data type";
}
//validate all url links on the form
else if($name == 'project-link' || $name == 'github-link' ||
        $name == 'torelo-link' || $name == 'site-url') {
        if(empty($input))
            echo "Missing $name";
        else if(!validLink($input))
            echo "Invalid $name";
}
else if($name == 'location' && empty($input)) {
    echo "Missing location";
}

//validate email and phone
if($name == 'email') {
    if(empty($input))
        echo "Missing $name";
    else if(!validEmail($input))
        echo "$name is not valid";
}
else if($name == 'phone') {
    if(empty($input))
        echo "Missing $name";
    else if(!ctype_digit($input) || strlen($input) < 9 || strlen($input) > 10)
        echo "Invalid $name";
}

//validate class information
$temp = explode("_", $name);
if($temp[0] == 'classname' || $temp[0] == 'quarter' || $temp[0] == 'instructor') {
    validateClassInfo($temp[0], $input);
}