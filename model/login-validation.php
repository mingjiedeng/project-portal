<?php
/**
 * Created by PhpStorm.
 * User: Gursimran
 * Date: 2018/3/6
 * Time: 17:54
 */
    session_start(); //start session
    include_once "validation.php";
    require_once '/home/gsinghgr/config.php';
    require_once 'dataObject.php';
    require_once 'project.php';

    /**
     * This php file validates the user login
     * information. It receives the request from
     * sign in page using an ajax and send response
     * with success or failed sign in message.
     */


    //get data with ajax request
    $login = $_POST[login];
    $name = $_POST[input_id];

    //validate login credentials
    validateLogin($name, $login);

    /**
     * This function validates the email and password
     * length.
     *
     * @param $name input type email or password
     * @param $login email or password text
     */
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
                $_SESSION['validEmail'] = $login;
                echo json_encode(true);
            }
        }
        else if($name == "password") { //password must be 5 characters long
            if(strlen($login) < 5) {
                unset($_SESSION['validPass']);
                echo json_encode(false);
                return;
            } else {
                $_SESSION['validPass'] = $login;
                echo json_encode(true);
            }
        }
    }

    //create object of project class
    $project = new Project();

    //set login session if email and password are valid
    if($_POST['submit'] == 'true') {
        $users = $project->getUsers(); //get all users from db

        if(isset($_SESSION['validEmail']) && isset($_SESSION['validPass'])) {

            //match the user
            foreach ($users as $user) {
                if($_SESSION['validEmail'] == $user['email'] &&
                    sha1($_SESSION['validPass']) == $user['password']) {
                    echo json_encode("success");
                    $_SESSION['login'] = "success";
                    return;
                }
            }

            echo json_encode("failed"); //send failed message if email or password is incorrect
        }
    }