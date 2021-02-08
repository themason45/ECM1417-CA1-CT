<?php


class Location
{
    public int $pk = 0;
    public int $x = 0;
    public int $y = 0;
    public $user = null;
    public $timeVisited = null;
    public $duration = null;

    public function save()
    {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO location (pk, x, y, duration, userPk, timeVisited) VALUES (:pk, :x, :y, :duration, :userPk, :timeVisited)");
        $stmt->execute(["pk" => $this->pk, "x" => $this->x, "y" => $this->y,"duration" => $this->duration,  "userPk" => $this->user->pk, "timeVisited" => $this->timeVisited]);

        $conn = null;
    }

    public function delete()
    {
        print_r("deleting");
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM location WHERE pk=:pk");
        $stmt->execute(["pk" => $this->pk]);

        $conn = null;
    }

    static function getLocationById($id): ?Location
    {
        include_once "support/db_connector.php";
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM location WHERE pk=:pk;");
        $stmt->execute(["pk" => $id]);
        $conn = null;
        $res = $stmt->fetchAll();
        print_r($res);
        if (count($res) == 1) {
            $location = new Location();
            $location->pk = $res[0]["pk"];
            $location->x = $res[0]["x"];
            $location->y = $res[0]["y"];

            include_once "support/User.php";
            $user = User::getUserById($res[0]["userPk"]);
            $location->user = $user;

            $location->timeVisited = date_create_from_format("Y-m-d?H:i:s", $res[0]["timeVisited"]);
            $location->duration = $res[0]["duration"];

            return $location;
        }
        return null;
    }

    public static function queryForUserId($id): array
    {
        include_once "support/db_connector.php";
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM location WHERE userPk=:upk");
        $stmt->execute(["upk" => $id]);

        $outArray = array();
        foreach ($stmt->fetchAll() as $item) {
            $location = new Location();
            $location->pk = $item["pk"];
            $location->x = $item["x"];
            $location->y = $item["y"];

            include_once "support/User.php";
            $user = User::getUserById($item["userPk"]);
            $location->user = $user;

            $location->timeVisited = date_create_from_format("Y-m-d?H:i:s", $item["timeVisited"]);
            $location->duration = $item["duration"];

            array_push($outArray, $location);
        }
        $conn = null;

        return $outArray;
    }

    public function update()
    {

    }
}