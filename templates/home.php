<?php
include_once "support/User.php";
include_once "support/Location.php";
include_once "support/Infection.php";
include_once "support/DistComparator.php";

$user = User::getUserById($_SESSION["user_pk"]);

$backdate = new DateTime();
$backdate->modify("-$user->weekWindow week");
$my_locations = Location::findUserLocationsInTimeRange($user, $backdate, new DateTime());

$infections = Infection::findInTimeRange($backdate, new DateTime());
$infected_locations =  call_user_func_array("array_merge", array_map("Infection::mapLocs", $infections));

$base_url = $_ENV["API_URL"];
$ts = 7 * $user->weekWindow;
$json = json_decode(file_get_contents("$base_url/infections?ts=$ts"));
foreach ($json as $value) {
    array_push($infected_locations, Location::fromJson((array) $value));
}

$contact_locations = array_uintersect($my_locations, $infected_locations,
    array(new DistComparator($user->distanceOption), "call"));
?>
<div style="margin-top: 20px">
    <div class="watermark">
        <img src="/static/img/watermark.png" alt="watermark" style="margin-left: 15%">
    </div>
    <div class="content">
        <!--suppress HtmlDeprecatedAttribute -->
        <table style="table-layout: fixed;width: 100%; padding-left: 50px; padding-right: 50px" cellpadding="0"
               cellspacing="0">
            <tr>
                <td colspan="3" style="border-bottom: black solid 2pt"><h2 style="text-align: center">Status</h2></td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding-top: 10px; display: flex">
                    <p>Hi <?php echo $user->username ?>, you may have had a connection with an infected person.</p>
                    <p style="bottom: 0; position: absolute; width: 30%" id="marker-info">Click on the marker to see details about an
                        infection.</p>
                </td>
                <td colspan="2" style="padding-top: 10px">
                    <div style="width: 100%;max-height: 500px; overflow: hidden;"> <?php include_once 'templates/sections/map.php' ?></div>
                </td>
            </tr>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            clickingEnabled = false;
            // Normal locations
            <?php foreach ($infected_locations as $loc): ?>
            addMarker(<?php echo $loc->x_ratio ?>, <?php echo $loc->y_ratio ?>, "<?php echo "Visited at: ".
            date_format($loc->timeVisited, "Y-m-d H:i:s")?>")
            <?php endforeach; ?>

            // Infected locations
            <?php foreach ($contact_locations as $loc): ?>
            addMarker(<?php echo $loc->x_ratio ?>, <?php echo $loc->y_ratio ?>, "<?php echo "Visited at: ".
                date_format($loc->timeVisited, "Y-m-d H:i:s")?>", true)
            <?php endforeach; ?>
        })
    </script>
</div>