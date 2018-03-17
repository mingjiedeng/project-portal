<?php

function connect()
{
    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD );
//        echo "Connected to database!!!";
        return $dbh;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }
}

function getProjects()
{
    global $dbh;

    $sql = "SELECT * FROM projects ORDER BY pid DESC";
    $statement = $dbh->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function getProject($pid)
{
    global $dbh;

    //1. Define the query
    $sql = "SELECT * FROM projects WHERE pid = :pid";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':pid', $pid, PDO::PARAM_INT);

    //4. Execute the query
    $statement->execute();

    //5. Get the results
    return $statement->fetch(PDO::FETCH_ASSOC);
}


function addNewProject($pTitle, $description, $cName, $cLocation, $cSite)
{
    global $dbh;

    //1. Define the query
    $sql = "INSERT INTO projects (pTitle, description, cName, cLocation, cSite) 
            VALUES (:pTitle, :description, :cName, :cLocation, :cSite)";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':pTitle', $pTitle, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':cName', $cName, PDO::PARAM_STR);
    $statement->bindParam(':cLocation', $cLocation, PDO::PARAM_STR);
    $statement->bindParam(':cSite', $cSite, PDO::PARAM_STR);

    //4. Execute the query
    $result = $statement->execute();

    //5. Return the result
    return $result;
}


function addClass($pid, $className, $quarter, $instructor, $note, $url, $trello, $login, $github)
{
    global $dbh;

    //1. Define the query
    $sql = "INSERT INTO classes (pid, className, quarter, instructor, note, url, trello, login, github) 
            VALUES (:pid, :className, :quarter, :instructor, :note, :url, :trello, :login, :github)";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':pid', $pid, PDO::PARAM_INT);
    $statement->bindParam(':className', $className, PDO::PARAM_STR);
    $statement->bindParam(':quarter', $quarter, PDO::PARAM_STR);
    $statement->bindParam(':instructor', $instructor, PDO::PARAM_STR);
    $statement->bindParam(':note', $note, PDO::PARAM_STR);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':trello', $trello, PDO::PARAM_STR);
    $statement->bindParam(':login', $login, PDO::PARAM_STR);
    $statement->bindParam(':github', $github, PDO::PARAM_STR);

    //4. Execute the query
    $result = $statement->execute();

    //5. Return the result
    return $result;
}



function addContact($pid, $contactName, $title, $email, $phone)
{
    global $dbh;

    //1. Define the query
    $sql = "INSERT INTO contacts (pid, contactName, title, email, phone) 
            VALUES (:pid, :contactName, :title, :email, :phone)";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':pid', $pid, PDO::PARAM_INT);
    $statement->bindParam(':contactName', $contactName, PDO::PARAM_STR);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

    //4. Execute the query
    $result = $statement->execute();

    //5. Return the result
    return $result;
}



/*
function updateLinks($pid)
{
    global $dbh;

    //1. Define the query
    $sql = "UPDATE projects a set a.url=b.url, a.trello=b.trello, a.login=b.login, a.github=b.github
            WHERE a.pid=:pid (SELECT * FROM classes b WHERE b.pid=:pid and b.quarter=MAX(b.quarter))";

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind parameters
    $statement->bindParam(':pid', $pid, PDO::PARAM_INT);
    $statement->bindParam(':contactName', $contactName, PDO::PARAM_STR);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

    //4. Execute the query
    $result = $statement->execute();

    //5. Return the result
    return $result;
}
*/