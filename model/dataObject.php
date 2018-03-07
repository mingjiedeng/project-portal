<?php
/**
 * Created by PhpStorm.
 * User: Mingjie
 * Date: 2018/3/6
 * Time: 17:54
 */

class DataObject {
    protected $dbh;

    public function __construct()
    {
        $this->dbh = $this->connect();
    }

    protected function connect()
    {
        try {
            $dbh = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $dbh->setAttribute( PDO::ATTR_PERSISTENT, true );
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            die("Connection failed: " . $e->getMessage() );
        }
        return $dbh;
    }

    protected function disconnect()
    {
        $this->dbh = null;
    }

    public static function setData( &$data, $inputData )
    {
        foreach ( $inputData as $key => $value ) {
            if ( array_key_exists( $key, $data ) )
                $data[$key] = $value;
        }
    }

    protected function select($tblName, $options = array(), $orderBy = '', $order = 'ASC')
    {
        if(empty($tblName))
            die("Method " . __METHOD__ . ": parameters error.");

        //Concat the options for select query
        foreach ($options as $key => $value) {
            $whereConditions = $key . '=:' . $key . ' AND ';
        }
        $whereConditions = empty($whereConditions) ? '' : ' WHERE ' . rtrim($whereConditions, ' AND ');
        $orderOption = empty($orderBy) ? '' : "ORDER BY {$orderBy} {$order}";

        //Define the query
        $sql = "SELECT * FROM {$tblName} {$whereConditions} {$orderOption}";

        //Prepare the statement
        $statement = $this->dbh->prepare($sql);

        //Bind parameters
        foreach ($options as $key => &$value) {
            $statement->bindParam(':'.$key, $value);
        }

        //Execute the query
        $statement->execute();

        //Return the statement
        return $statement;
    }


    protected function insert($tblName, $columns, $data)
    {
        //Check the parameters
        if(empty($tblName) || empty($columns) || empty($data)
            || !is_array($columns) || !is_array($data))
            die("Method " . __METHOD__ . ": parameters error.");

        //Fetch data from $data array and set that into $columns data
        $this->setData( $columns, $data );

        //Concat the strings for the $sql variable
        $colName = "";
        $placeholder = "";
        foreach ($columns as $key => $value) {
            $colName .= $key . ', ';
            $placeholder .= ':' . $key . ', ';
        }
        $colName = rtrim($colName, ", ");
        $placeholder = rtrim($placeholder, ", ");

        //Define the query
        $sql = "INSERT INTO {$tblName} ({$colName}) VALUES ({$placeholder})";

        //Prepare the statement
        $statement = $this->dbh->prepare($sql);

        //Bind parameters
        foreach ($columns as $key => &$value) {
            $statement->bindParam(':'.$key, $value);
        }

        //Execute the query
        $result = $statement->execute();

        //Return the results
        return $result;
    }
}