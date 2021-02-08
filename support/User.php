<?php

use JetBrains\PhpStorm\Pure;

include_once "db_connector.php";

class User
{
    public int $pk = 0;
    public string $firstName = '';
    public string $lastName = '';
    public string $username = '';
    protected string $password = '';

    function __construct($id, $username, $password)
    {
        $this->pk = $id;
        $this->username = $username;
        $this->password = $password;
    }


    static function getUserById($id) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE pk=:pk;");
        $stmt->execute(["pk" => $id]);
        $conn = null;
        $res = $stmt->fetchAll();
        if (count($res) == 1) {
            $user = new User($res[0]["pk"], $res[0]["username"], $res[0]["password"]);
            $user->firstName = $res[0]["firstName"];
            $user->lastName = $res[0]["lastName"];
            return $user;
        }
        return null;
    }

    function save() {
        # Check if the user exists, if so, update, if not, create a new one
        return null;
    }

    function update() {

    }

}