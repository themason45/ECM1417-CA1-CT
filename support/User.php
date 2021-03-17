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

    static function getUserById($id)
    {
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

    function save()
    {
        $conn = getConnection();
        $matching_username = $conn->prepare("SELECT username FROM users WHERE username=:username");
        $matching_username->execute(
            ["username" => $this->username]
        );
        if ($matching_username->rowCount() == 0) {
            $stmt = $conn->prepare("INSERT INTO users (username, password, firstName, lastName)
VALUES (:username, :password, :firstName, :lastName);");

            $stmt->execute(["username" => $this->username, "password" => $this->password,
                "firstName" => $this->firstName, "lastName" => $this->lastName]);

            $this->pk = $conn->lastInsertId();
            # Check if the user exists, if so, update, if not, create a new one
            return null;
        } else {
            echo "Username already exists";
        }
    }

    function update()
    {

    }

}