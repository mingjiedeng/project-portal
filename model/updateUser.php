<?php
/**
 * Created by PhpStorm.
 * User: Mingjie
 * Date: 2018/3/18
 * Time: 20:07
 */

$pObject = new Project();
$pObject->updateUser($_POST, $_POST['user_id']);
$user = $pObject->getUser($_POST['user_id']);
print_r($user);
return $user;