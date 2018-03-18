<?php
/**
 * Created by PhpStorm.
 * User: Mingjie
 * Date: 2018/3/6
 * Time: 18:54
 */

class Project extends DataObject
{
    //Setting the column names into arrays for each table
    protected $projectsColumns = array(
        'pTitle' => '',
        'description' => '',
        'note' => '',
        'status' => '',
        'cName' => '',
        'cLocation' => '',
        'cSite' => '',
        'url' => '',
        'trello' => '',
        'github' => '',
        'username' => '',
        'password' => ''
    );

    protected $classesColumns = array(
        'pid' => '',
        'className' => '',
        'quarter' => '',
        'instructor' => '',
        'url' => '',
        'trello' => '',
        'login' => '',
        'github' => ''
    );

    protected $contactsColumns = array(
        'pid' => '',
        'contactName' => '',
        'title' => '',
        'email' => '',
        'phone' => ''
    );

    protected $usersColumns = array(
        'user_id' => '',
        'privilege' => '',
        'userName' => '',
        'password' => '',
        'email' => ''
    );


    /**
     * Get a project list from database
     * @return array
     */
    function getProjects()
    {
        $tblName = 'projects';
        $options = array();
        $orderBy = 'pid';
        $order = 'DESC';

        $statement = $this->select($tblName, $options, $orderBy, $order);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @return array
     */
    function getProjectByKeyword($keyword = "")
    {
        $tblName = 'projects';
        $options = array(
            'pTitle' => $keyword,
            'description' => $keyword,
            'note' => $keyword,
            'cName' => $keyword,
            'cLocation' => $keyword,
            'cSite' => $keyword,
            'url' => $keyword,
            'trello' => $keyword,
            'github' => $keyword,
            'username' => $keyword
            );
        $orderBy = 'pid';
        $order = 'DESC';

        $statement = $this->selectLike($tblName, $options, $orderBy, $order);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get the project info from database where pid = $pid
     * @param $pid
     * @return mixed
     */
    function getProject($pid)
    {
        $tblName = 'projects';
        $options = array('pid' => $pid);

        $statement = $this->select($tblName, $options);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * @param $pid
     * @return array
     */
    function getClasses($pid)
    {
        $tblName = 'classes';
        $options = array('pid' => $pid);

        $statement = $this->select($tblName, $options);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param $pid
     * @return array
     */
    function getContacts($pid)
    {
        $tblName = 'contacts';
        $options = array('pid' => $pid);

        $statement = $this->select($tblName, $options);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Add a new project info include classes and contacts info
     * @param $data
     */
    function addNewProject($data)
    {
        //Insert into projects table
        $pid = $this->addProject($data);
        $data['pid'] = $pid;

        //Insert into classes table
        $inputColumn = array('className', 'quarter', 'instructor');
        $newData = $this->rearrangeData($pid, $inputColumn, $data);
        foreach ($newData as $row) {
            $this->addClass($row);
        }

        //Insert into contacts table
        $inputColumn = array('contactName', 'title', 'email', 'phone');
        $newData = $this->rearrangeData($pid, $inputColumn, $data);
        foreach ($newData as $row) {
            $this->addContact($row);
        }
    }

    protected function rearrangeData($pid, $inputColumn, $data)
    {
        $newData[] = array();
        foreach ($inputColumn as $colName) {
            foreach($data[$colName] as $index=>$val) {
                $newData[$index][$colName] = $val;
            }
        }
        foreach ($newData as &$row) {
            $row['pid'] = $pid;
        }
        return $newData;
    }


    /**
     * Add data into projects table
     * @param $data
     * @return int the project id in the database
     */
    protected function addProject($data)
    {
        $tblName = 'projects';
        $columns = $this->projectsColumns;

        return $this->insert($tblName, $columns, $data);
    }


    /**
     * Add data into classes table
     * @param $data
     * @return bool
     */
    protected function addClass($data)
    {
        $tblName = 'classes';
        $columns = $this->classesColumns;

        return $this->insert($tblName, $columns, $data);
    }


    /**
     * Add data into contacts table
     * @param $data
     * @return bool
     */
    protected function addContact($data)
    {
        $tblName = 'contacts';
        $columns = $this->contactsColumns;

        return $this->insert($tblName, $columns, $data);
    }


    /**
     * Update project info in project table
     * @param $data
     * @param $pid
     * @return bool
     */
    function updateProject($data, $pid)
    {
        $tblName = 'projects';
        $columns = $this->projectsColumns;
        $options = array('pid' => $pid);
        return $this->update($tblName, $columns, $data, $options);
    }


    /**
     * Update class info in classes table
     * @param $data
     * @param $cid
     * @return bool
     */
    function updateClass($data, $cid)
    {
        $tblName = 'classes';
        $columns = $this->classesColumns;
        $options = array('cid' => $cid);
        return $this->update($tblName, $columns, $data, $options);
    }


    /**
     * Update contacts info in contacts table
     * @param $data
     * @param $contact_id
     * @return bool
     */
    function updateContacts($data, $contact_id)
    {
        $tblName = 'contacts';
        $columns = $this->contactsColumns;
        $options = array('contact_id' => $contact_id);
        return $this->update($tblName, $columns, $data, $options);
    }


    /**
     * @param $pid
     * @return bool
     */
    function deleteProject($pid)
    {
        $tblNames = array('classes', 'contacts', 'projects');
        $options = array('pid' => $pid);

        foreach ($tblNames as $tblName) {
            $result = $this->delete($tblName, $options);
        }
        return $result;
    }


    /**
     * @return array
     */
    function getUsers()
    {
        $tblName = 'users';
        $options = array();
        $orderBy = 'user_id';
        $order = 'ASC';

        $statement = $this->select($tblName, $options, $orderBy, $order);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @param $data
     * @return bool|int
     */
    protected function addUser($data)
    {
        $tblName = 'users';
        $columns = $this->usersColumns;

        return $this->insert($tblName, $columns, $data);
    }


    /**
     * @param $data
     * @param $contact_id
     * @return bool
     */
    function updateUser($data, $user_id)
    {
        $tblName = 'users';
        $columns = $this->contactsColumns;
        $options = array('user_id' => $user_id);
        return $this->update($tblName, $columns, $data, $options);
    }


    /**
     * @param $pid
     * @return bool
     */
    function deleteUser($user_id)
    {
        $tblName = 'users';
        $options = array('user_id' => $user_id);

        return $this->delete($tblName, $options);
    }
}