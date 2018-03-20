<?php
/**
 * Created by PhpStorm.
 * User: Gursimran
 * Date: 2018/3/6
 * Time: 17:54
 */

    /**
     * This file contains some function that validates the data types
     * like valid string, digits, emails, and urls. This file used
     * for checking all input fields data type in addProject method.
     */

    //get data with ajax request
    $input = $_POST[input];
    $name = $_POST[name];

    /**
     * This function validates the string data types.
     * it checks the string only contains alpha and numerics
     * only.
     * @param $str string data
     * @return bool true  or false
     */
    //validate alphanumeric field
    function validString($str)
    {
        return ctype_alnum(str_replace(' ', '', $str));
    }

    /**
     * This is method validates the numeric data types
     *
     * @param $num
     * @return bool
     */
    //validate numeric fields
    function validDigit($num)
    {
        return ctype_digit($num);
    }

    /**
     * This is a method for validating the title, name
     * and description fields in addProject page.
     * @param $name name of the field
     * @param $input data
     */
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

    /**
     * This is a method validating the class info
     *
     * @param $name name of the field
     * @param $input data type
     */
    //validate class info
    function validateClassInfo($name, $input)
    {
        if(empty($input))
            echo "Missing $name";
        else if(!validString($input))
            echo "Invalid $name";
    }

    /**
     * This is method for validating the urls
     *
     * @param $link url
     * @return false|int true or false
     */
    //validate url links
    function validLink($link)
    {
        $regexp = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
        return preg_match($regexp, $link);
    }

    /**
     * This is a method for validating the email address
     *
     * @param $email
     * @return mixed
     */
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
    if($name == 'title' || $name == 'company') {
        validateAlphaNum($name, $input);
    }

    //validate description
    if($name == 'description' && empty($input)) {
        echo "Missing description";
    }

    //validate all url links on the form
    else if($name == 'project-link' || $name == 'torelo-link'
            || $name == 'site-url') {
            if(empty($input))
                echo "Missing $name";
            else if(!validLink($input))
                echo "Invalid $name";
    }
    else if($name == 'github-link') { //validate git hub link
        if(!empty($input) && !validLink($input))
            echo "Invalid github link";
    }

    else if($name == 'location' && empty($input)) {
        echo "Missing location";
    }

    //validate class information
    $temp = explode("_", $name);
    if($temp[0] == 'classname' || $temp[0] == 'quarter' || $temp[0] == 'instructor') {
        validateClassInfo($temp[0], $input);
    }

    //validate contact info
    if($temp[0] == 'clientname' || $temp[0] == 'clienttitle') {
        if(empty($input))
            echo "Missing ".substr($temp[0], 0,6).' '.substr($temp[0], 6,10);
        else if(!validString($input))
            echo "Invalid ".substr($temp[0], 0,6).' '.substr($temp[0], 6,10);
    }

    //validate email and phone
    if($temp[0] == 'email') {
        if(empty($input))
            echo "Missing $temp[0]";
        else if(!validEmail($input))
            echo "$temp[0] is not valid";
    }
    else if($temp[0] == 'phone') {
        if(empty($input))
            echo "Missing $temp[0]";
        else if(!ctype_digit($input) || strlen($input) < 9 || strlen($input) > 10)
            echo "Invalid $temp[0]";
    }

