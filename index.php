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

//        $data = array('pTitle' => 'Project D',
//                    'description' => 'test again',
//                    'cName' => 'Company D');
        $project = new Project();
        $projects = $project->getProjects();
        $f3->set('projects', $projects);

        echo Template::instance() -> render('views/pList.html');
    });

    $f3->route('GET|POST /project', function($f3, $params) { //removed params temporary
//        $project = new Project();
//        $projects = $project->getProject($params['pid']);
//        $f3->set("project", $projects);
//        $f3->set('login', 'set');
//        $f3->set('edit', 'set');
        echo Template::instance() -> render('views/pSummary.html');
    });

    $f3->route('GET /addProject', function($f3) {

        echo Template::instance() -> render('views/add-project.html');
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