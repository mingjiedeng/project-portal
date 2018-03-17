<?php
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    //Require the autoload file
    require_once('vendor/autoload.php');
    require_once '/home/gsinghgr/config.php';
//    require_once '/home/mdenggre/db-config.php';


    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set devug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    //Define a default route
    $f3->route('GET /', function($f3) {
        $f3->set('login', 'yes');

        $project = new Project();
        $projects = $project->getProjects();
        $f3->set('projects', $projects);

        echo Template::instance() -> render('views/pList.html');
    });

    $f3->route('GET /project/@pid', function($f3, $params) {
        $project = new Project();
        $projects = $project->getProject($params['pid']);
        $classes = $project->getClasses($params['pid']);
        $contacts = $project->getContacts($params['pid']);
        $f3->set("project", $projects);
        $f3->set("classes", $classes);
        $f3->set("contacts", $contacts);
//        $f3->set('login', '$contactsset');
//        $f3->set('edit', 'set');
        echo Template::instance() -> render('views/pSummary.html');
    });

    $f3->route('GET|POST /addProject', function($f3) {
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
            }
        }
        else if(!isset($_POST['submit'])){
            echo Template::instance() -> render('views/add-project.html');
        }
    });

    $f3->route('GET /signIn', function($f3) {

        echo Template::instance() -> render('views/signIn.html');
    });

    $f3->route('GET /admin', function($f3) {
        echo "<p>This page show the account list. </p>
              <p>Administrator can add new faculty account here directly by Ajax.</p>";
        echo Template::instance() -> render('views/admin.html');
    });

    //Run fat free
    $f3->run();