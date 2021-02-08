<?php
function getConnection() {
    $conn = new PDO('mysql:host=localhost:3306;dbname=public', 'phpbot', "pwd");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
