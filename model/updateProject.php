<?php
    require_once '/home/gsinghgr/config.php';
    require_once "dataObject.php";
    require_once "project.php";

    $pid = $_POST['pid'];

    echo $pid;
//    $dbh = new DataObject();
    $project = new Project();
    $project->updateProject($_POST, $pid);



