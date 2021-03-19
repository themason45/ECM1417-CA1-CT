<?php

function getConnection(): PDO
{
    $config = include "config.php";
    $port = $config["DB_PORT"];
    if (isset($config["DB_ADDRESS"])) {
        $conn = new PDO(getenv("DB_ADDRESS"), 'phpbot', "pwd");
    } else {
        $conn = new PDO('mysql:host=localhost:' . $port . ';dbname=public',
            'phpbot', "pwd");
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
