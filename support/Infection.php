<?php


class Infection
{
    public object|null $user = null;
    public DateTime|null $datetime = null;
    public array $locations = [];

    public function __construct($user, $datetime) {
        $this->datetime = $datetime;
        $this->user = $user;
    }

    public function save() {
        $conn = getConnection();

        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("INSERT INTO infection (user_pk, infection_dt) VALUES (:user_pk, :datetime)");
        $stmt->execute(["user_pk" => $this->user->pk, "datetime" => date_format($this->datetime, "Y-m-d?H:i:s")]);
        $conn = null;
    }

    public static function queryForUser($id, $start, $end): array
    {
        $conn = getConnection();
        $user = User::getUserById($id);

        /** @noinspection SqlResolve */
        $stmt = $conn->prepare("SELECT * FROM infection WHERE user_pk =:user_pk AND `infection_dt` BETWEEN :dts AND :dte");
        $stmt->execute(["user_pk" => $id, "dts" => date_format($start, "Y-m-d?H:i:s"),
            "dte" => date_format($end, "Y-m-d?H:i:s")]);

        $res = $stmt->fetchAll();
        $output = [];
        foreach ($res as $data) {
            $infection = new Infection($user, date_create_from_format("Y-m-d?H:i:s", $data["infection_dt"]));
            $infection->locations = Location::findLocationsInRange($user, $start, $end);
            array_push($output, $infection);
        }
        $conn = null;

        return $output;
    }
}