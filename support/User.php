<?php

include_once "db_connector.php";

class User
{
    public int $pk = 0;
    public string $firstName = '';
    public string $lastName = '';
    public string $username = '';
    private string $password = '';

    public int $weekWindow = 0;
    public float $distanceOption = 0.0;

    function __construct($id, $username, $password)
    {
        $this->pk = $id;
        $this->username = $username;
        $this->password = $password;
    }

    static function getUserById($id): ?User
    {
        $conn = getConnection();
        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("SELECT * FROM users WHERE pk=:pk;");
        $stmt->execute(["pk" => $id]);
        $conn = null;
        $res = $stmt->fetchAll();
        if (count($res) == 1) {
            $user = new User($res[0]["pk"], $res[0]["username"], $res[0]["password"]);
            $user->firstName = $res[0]["firstName"];
            $user->lastName = $res[0]["lastName"];

            $user->weekWindow = $res[0]["window"];
            $user->distanceOption = $res[0]["distance"];
            return $user;
        }
        return null;
    }

    function save()
    {
        $conn = getConnection();
        /** @noinspection SqlResolve */
        $matching_username = $conn->prepare("SELECT username FROM users WHERE username=:username");
        $matching_username->execute(
            ["username" => $this->username]
        );
        if ($matching_username->rowCount() == 0) {
            /** @noinspection SqlResolve */
            $stmt = $conn->prepare("INSERT INTO users (username, `password`, firstName, lastName, distance, `window`)
VALUES (:username, :password, :firstName, :lastName, :distance, :window);");
            echo $stmt->queryString;

            $stmt->execute(["username" => $this->username, "password" => $this->password,
                "firstName" => $this->firstName, "lastName" => $this->lastName, "distance" => $this->distanceOption,
                "window" => $this->weekWindow]);

            $this->pk = $conn->lastInsertId();
            $conn = null;
            # Check if the user exists, if so, update, if not, create a new one
            return null;
        } else {
            $conn = null;
            echo "Username already exists";
        }
    }

    function update(): bool
    {
        try {
            $conn = getConnection();

            /** @noinspection SqlResolve */
            $stmt = $conn->prepare("UPDATE users SET username= :username, 
                 `password`= :password, firstName= :firstName, lastName= :lastName, distance= :distance, 
                 `window`= :window WHERE pk= :pk;");

            $stmt->execute(["username" => $this->username, "password" => $this->password,
                "firstName" => $this->firstName, "lastName" => $this->lastName, "distance" => $this->distanceOption,
                "window" => $this->weekWindow, "pk" => $this->pk]);

            $conn = null;
            return true;
        } catch (Exception $e) {
            print $e;
            return false;
        }
    }

    function checkPassword($pwd) {
        return password_verify($pwd , $this->password);
    }
}