<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    //Require the autoload file
    require_once('vendor/autoload.php');
//    require_once '/home/gsinghgr/config.php';
    require_once '/home/mdenggre/db-config.php';


    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set debug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    //Define a default route
    $f3->route('GET /', function($f3) {
        $f3->set('login', 'yes');

        $project = new Project();
//        $projects = $project->getProjects();
        $projects = $project->getProjectByKeyword("jatt");
        $f3->set('projects', $projects);

        echo Template::instance() -> render('views/pList.html');
    });

    $f3->route('GET /project/@pid', function($f3, $params) {
        $status = array('Pending', 'Active', 'Retired','Maintenance');
        $project = new Project();
        $projects = $project->getProject($params['pid']);
        $classes = $project->getClasses($params['pid']);
        $contacts = $project->getContacts($params['pid']);
        $f3->set("project", $projects);
        $f3->set("classes", $classes);
        $f3->set("contacts", $contacts);
        $f3->set("status", $status);
//        $f3->set('login', '$contactsset');
//        $f3->set('edit', 'set');
        echo Template::instance() -> render('views/pSummary.html');
    });

    $f3->route('GET|POST /addProject', function($f3) {
//        $years = array();
//        $currentYear = date("Y");
//        $year = 2015;
//        while($year <= $currentYear) {
//            array_push($years, $year);
//            $year++;
//        }
//        $f3->set("years",$years);

        if(isset($_POST['submit']))
        {
            $post = $_POST; //variable used in validation.php
            include_once "model/validate-onsubmit.php";
            include_once "model/validate-hiddenfields.php";

            //insert data into database if there is no error
            if($success) {
                $_POST['username'] = $userName; //set username
                $_POST['password'] = $password; //set password

                //add into database
                $project = new Project();
                $project->addNewProject($_POST);
                echo "submitted";
            }
        }
        else if(!isset($_POST['submit'])){
            echo Template::instance() -> render('views/add-project.html');
        }
    });

    $f3->route('GET|POST /signIn', function($f3) {
//        if(isset($_SESSION['login'])) {
//            $f3->reroute("/");
//        }
        include_once "model/login-validation.php";
        echo Template::instance() -> render('views/signIn.html');
    });

    $f3->route('GET /admin', function($f3) {
//        if (!isset($_SESSION['userName']) || $_SESSION['privilege'] != 1) {
//            $f3->reroute('/');
//        }

        $pObject = new Project();
        $users = $pObject->getUsers();
        $f3->set('users', $users);

        echo Template::instance() -> render('views/admin.html');
    });

    $f3->route('GET|POST /addUser', function($f3) {
        include_once 'model/addUser.php';
    });

    $f3->route('GET|POST /updateUser', function($f3) {
        include_once 'model/updateUser.php';
    });

    //Run fat free
    $f3->run();