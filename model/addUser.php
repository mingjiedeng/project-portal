<?php
/**
 * Created by PhpStorm.
 * User: Mingjie
 * Date: 2018/3/18
 * Time: 20:04
 */

$pObject = new Project();
$user_id = $pObject->addUser($_POST);
return $pObject->getUser($user_id);