<?php
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);

    //Require the autoload file
    require_once('vendor/autoload.php');
//    require_once '/home/mdenggre/db-config.php';
//    require_once 'model/db-functions.php';

    //Create an instance of the Base class
    $f3 = Base::instance();

    //Set devug level
    $f3->set('DEBUG', 3); //3 is higher than 0, will present more info

    //Connect to database
//    $dbh = connect();

    //Define a default route
    $f3->route('GET /', function($f3) {
        $f3->set('login', 'yes');
//        echo "<p>This page show the project list, click the <a href='project/123'>project</a> will go to project summary page.</p>
//              <p>This page also has <a href='signIn'>signIn</a> button.
//                 If user already sign in, an <a href='addProject'>Add Project</a> button will show up.<br>
//                 If a supper administrator sign in, an <a href='admin'>admin</a> button will show up.</p>";

//        $projects = getProjects();
//        $f3->set("projects", $projects);
        echo Template::instance() -> render('views/pList.html');
    });

    $f3->route('GET /project/@pid', function($f3, $params) {
        echo "<p>This is the summary page for a project, and also for the info modification.</p>
              <p>The project info is divided by zone like client info, class info and so on. <br>
                 The input fields are disable(can't be modify) by default.<br>
                 If the user already sign in, when the cursor move on the zone, <br>
                 the zone will high light or show up a frame around the zone, and an edit button will show up.<br>
                 If the user click the edit button, the fields will change to enable, <br>
                 then user can modify and submit the final change using Ajax, <br>
                 after that the info has been refresh and the fields return to disable.
                 </p>";

        $project = getProject($params['pid']);
        $f3->set("project", $project);

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