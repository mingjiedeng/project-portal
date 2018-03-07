<?php
/**
 * Created by PhpStorm.
 * User: Mingjie
 * Date: 2018/3/6
 * Time: 18:54
 */

class Project extends DataObject {

    function getProjects()
    {
        $tblName = 'projects';
        $options = array();
        $orderBy = 'pid';
        $order = 'DESC';

        $statement = $this->select($tblName, $options, $orderBy, $order);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    function getProject($pid)
    {
        $tblName = 'projects';
        $options = array('pid' => $pid);

        $statement = $this->select($tblName, $options);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    function addNewProject($data)
    {
        $tblName = 'projects';
        $columns = array(
            'pTitle' => '',
            'description' => '',
            'status' => '',
            'cName' => '',
            'cLocation' => '',
            'cSite' => '',
            'url' => '',
            'trello' => '',
            'login' => '',
            'github' => ''
        );

        $result = $this->insert($tblName, $columns, $data);

        return $result;
    }


    function addClass($data)
    {
        $tblName = 'classes';
        $columns = array(
            'pid' => '',
            'className' => '',
            'quarter' => '',
            'instructor' => '',
            'note' => '',
            'url' => '',
            'trello' => '',
            'login' => '',
            'github' => ''
        );

        $result = $this->insert($tblName, $columns, $data);

        return $result;
    }


    function addContact($data)
    {
        $tblName = 'contacts';
        $columns = array(
            'pid' => '',
            'contactName' => '',
            'title' => '',
            'email' => '',
            'phone' => ''
        );

        $result = $this->insert($tblName, $columns, $data);

        return $result;
    }
}