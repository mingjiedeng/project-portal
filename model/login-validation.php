<?php
    session_start();
    include_once "validation.php";

    //get data with ajax request
    $login = $_POST[login];
    $name = $_POST[input_id];

    //validate login credentials
    validateLogin($name, $login);

    //function for validating the login info
    function validateLogin($name, $login)
    {
        //validate email address
        if($name == "email") {
            if(!validEmail($login)) {
                unset($_SESSION['validEmail']);
                echo json_encode(false);
                return;
            } else {
                $_SESSION['validEmail'] = "set";
                echo json_encode(true);
            }
        }
        else if($name == "password") { //password must be 5 characters long
            if(strlen($login) < 5) {
                unset($_SESSION['validPass']);
                echo json_encode(false);
                return;
            } else {
                $_SESSION['validPass'] = "set";
                echo json_encode(true);
            }
        }
    }


    //set login session if email and password are valid
    if($_POST['submit'] == 'true') {

        if(isset($_SESSION['validEmail']) && isset($_SESSION['validPass'])) {
            echo json_encode("success");
            $_SESSION['login'] = "success";
        }
    }