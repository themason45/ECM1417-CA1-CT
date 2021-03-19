<?php

function getConnection(): PDO
{
    $port = $_ENV["DB_PORT"];
    if (getenv("DB_ADDRESS")) {
        $conn = new PDO(getenv("DB_ADDRESS"), 'phpbot', "pwd");
    } else {
        $conn = new PDO('mysql:host=localhost:' . $port . ';dbname=public',
            'phpbot', "pwd");
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
