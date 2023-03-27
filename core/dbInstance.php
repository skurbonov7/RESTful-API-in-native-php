<?php

function dbInstance(): PDO
{
    static $db;
    if ($db === null) {
        $db = new PDO('mysql:host=localhost;dbname=api_tester;charset=utf8', 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    return $db;
}

function dbQuery(string $sql, array $params = []): PDOStatement
{
    //die(var_dump($params    ));
    $db = dbInstance();
    $query = $db->prepare($sql);
    $query->execute($params);
    dbCheckError($query);

    return $query;
}

function dbCheckError(PDOStatement $query): bool
{
    $errInfo = $query->errorInfo();

    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[1];
        exit();
    }

    return true;
}
