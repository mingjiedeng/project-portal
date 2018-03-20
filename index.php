<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    //Require the autoload file
    require_once('vendor/autoload.php');
    require_once '/home/gsinghgr/config.php';
//    require_once '/home/mdenggre/db-config.php';


    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set debug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    //Define a default route
    $f3->route('GET /', function($f3) {
        if(isset($_GET['signout'])) {
            unset($_SESSION['login']); //unset session if signed out
        }

        $f3->set('login', $_SESSION['login']); //get login session

        $project = new Project(); //instance of project class

        //get results from database if user searching
        if(isset($_GET['keyword'])) {
            $searched = $project->getProjectByKeyword($_GET['keyword']);
            echo json_encode($searched);
        }
        else if(!isset($_GET['keyword'])) { //show all the projects
            $projects = $project->getProjects();
            $f3->set('projects', $projects);

            echo Template::instance() -> render('views/pList.html');
        }
    });

    //view project details route
    $f3->route('GET|POST /project/@pid', function($f3, $params) {

        $f3->set('login', $_SESSION['login']); //get login session

        //get all the the info from database
        $status = array('Pending', 'Active', 'Retired','Maintenance');
        $project = new Project();
        $projects = $project->getProject($params['pid']);
        $classes = $project->getClasses($params['pid']);
        $contacts = $project->getContacts($params['pid']);
        $f3->set("project", $projects);
        $f3->set("classes", $classes);
        $f3->set("contacts", $contacts);
        $f3->set("status", $status);

        $post = $_POST;
        include_once "model/updateProject.php";

        //check if form is submitted
        if(isset($_POST['form'])) {
            $project = new Project();

            //if its valid update the project data into the database
            if($valid) {
                if ($_POST['form'] == 'updateProject' || $_POST['form'] == 'updateCompany') {
                    unset($_POST['form']);
                    $project->updateProject($_POST, $params['pid']); //update project info
                } else if ($_POST['form'] == 'updateClass') {
                    unset($_POST['form']);
                    $classNames = $_POST['className'];
                    $quarter = $_POST['quarter'];
                    $instructor = $_POST['instructor'];
                    unset($_POST);
                    $index = 0;
                    foreach ($classes as $class) {
                        $_POST['className'] = $classNames[$index];
                        $_POST['quarter'] = $quarter[$index];
                        $_POST['instructor'] = $instructor[$index];

                        $project->updateClass($_POST, $class['cid']);
                        $index++;
                    }
                } else if ($_POST['form'] == 'updateContact') { //update contact info
                    unset($_POST['form']);
                    $contactNames = $_POST['contactName'];
                    $title = $_POST['title'];
                    $phone = $_POST['phone'];
                    $email = $_POST['email'];

                    unset($_POST);
                    $index = 0;
                    foreach ($contacts as $contact) {
                        $_POST['contactName'] = $contactNames[$index];
                        $_POST['title'] = $title[$index];
                        $_POST['phone'] = $phone[$index];
                        $_POST['email'] = $email[$index];

                        $project->updateContacts($_POST, $contact['contact_id']);
                        $index++;
                    }
                }
                echo "updated";
            }
        }
        else if(!isset($_POST['pid']))
            echo Template::instance() -> render('views/pSummary.html');
    });

    //add new project route
    $f3->route('GET|POST /addProject', function($f3) {
        if(!isset($_SESSION['login']))
            $f3->reroute("/signIn"); //redirect to signIn route if user not signed in

        if(isset($_POST['submit']))
        {
            //get all data into variable
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

    //sign in page route
    $f3->route('GET|POST /signIn', function($f3) {
        if(isset($_SESSION['login'])) {
            $f3->reroute("/"); //redirect to main page if signed in
        }
        include_once "model/login-validation.php";
        echo Template::instance() -> render('views/signIn.html');
    });

    //admin page route
    $f3->route('GET /admin', function($f3) {
        if (!isset($_SESSION['userName']) || $_SESSION['privilege'] != 1) {
            $f3->reroute('/');
        }

        $pObject = new Project();
        $users = $pObject->getUsers();
        $f3->set('users', $users);

        echo Template::instance() -> render('views/admin.html');
    });

    //add user route
    $f3->route('GET|POST /addUser', function($f3) {
        include_once 'model/addUser.php';
    });

    //update user route
    $f3->route('GET|POST /updateUser', function($f3) {
        include_once 'model/updateUser.php';
    });

    //Run fat free
    $f3->run();