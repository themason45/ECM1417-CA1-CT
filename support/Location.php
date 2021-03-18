<?php

class Location
{
    public int $pk = 0;
    public int $x = 0;
    public int $y = 0;
    public float $x_ratio = 0.0;
    public float $y_ratio = 0.0;
    public object|null $user = null;
    public DateTime|null $timeVisited = null;
    public float $duration = 0.0;

    public function save()
    {
        $conn = getConnection();
        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("INSERT INTO location (pk, x, y, duration, userPk, timeVisited, x_ratio, y_ratio) 
VALUES (:pk, :x, :y, :duration, :userPk, :timeVisited, :x_ratio, :y_ratio)");
        $stmt->execute(["pk" => $this->pk, "x" => $this->x, "y" => $this->y, "duration" => $this->duration,
            "userPk" => $this->user->pk, "timeVisited" => date_format($this->timeVisited, "Y-m-d?H:i:s"), "x_ratio" => $this->x_ratio,
            "y_ratio" => $this->y_ratio]);

        $conn = null;
    }

    public function delete()
    {
        print_r("deleting");
        $conn = getConnection();
        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("DELETE FROM location WHERE pk=:pk");
        $stmt->execute(["pk" => $this->pk]);

        $conn = null;
    }

    static function getLocationById($id): ?Location
    {
        include_once "support/db_connector.php";
        $conn = getConnection();
        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("SELECT * FROM location WHERE pk=:pk;");
        $stmt->execute(["pk" => $id]);
        $conn = null;
        $res = $stmt->fetchAll();
        if (count($res) == 1) {
            $location = new Location();
            $location->pk = $res[0]["pk"];
            $location->x = $res[0]["x"];
            $location->y = $res[0]["y"];

            $location->x_ratio = $res[0]["x_ratio"];
            $location->y_ratio = $res[0]["y_ratio"];

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
        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("SELECT * FROM location WHERE userPk=:upk");
        $stmt->execute(["upk" => $id]);

        $outArray = [];
        foreach ($stmt->fetchAll() as $item) {
            array_push($outArray, Location::generateForQueryRes($item));
        }
        $conn = null;

        return $outArray;
    }

    private static function generateForQueryRes($item)
    {
        $location = new Location();
        $location->pk = $item["pk"];
        $location->x = $item["x"];
        $location->y = $item["y"];

        $location->x_ratio = $item["x_ratio"];
        $location->y_ratio = $item["y_ratio"];

        include_once "support/User.php";
        $user = User::getUserById($item["userPk"]);
        $location->user = $user;

        $location->timeVisited = date_create_from_format("Y-m-d?H:i:s", $item["timeVisited"]);
        $location->duration = $item["duration"];

        return $location;
    }

    static function findLocationsInRange($user, $start, $end): array
    {
        $conn = getConnection();

        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("SELECT * FROM location WHERE userPk =:user_pk AND timeVisited BETWEEN :dts AND :dte;");
        $stmt->execute(["user_pk" => $user->pk, "dts" => date_format($start, "Y-m-d?H:i:s"),
            "dte" => date_format($end, "Y-m-d?H:i:s")]);

        $output = [];
        foreach ($stmt->fetchAll() as $item) {
            array_push($output, Location::generateForQueryRes($item));
        }
        $conn = null;

        return $output;
    }

    static function diff($obj_a, $obj_b) {
        return $obj_a->pk - $obj_b->pk;
    }
}